<?PHP

function dok_list_artists ($VARS, $up, $theme_path) {
	$orders = array('count','length');
	$t = new template($theme_path);
        $t->set_file('page','artist_list.tpl');
        $t->set_block('page','artist','artist_block');
	$t->set_block('page','next_page','next_page_block');
	if( !isset($VARS['alpha']) )	{
		$VARS['alpha'] = '-';
	}
	if ( isset($VARS['sort']) && !in_array($VARS['sort'],$orders) ) {
		unset($VARS['sort']);
	}
	if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )	$VARS['offset'] = '0';
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);
	$query = 'select a.id, a.name, count(r.artist_id) as count, sum(s.length) as length from '.dok_tn('artist').' as a left join '.dok_tn('rel_song_artist').' as r on a.id=r.artist_id left join '.dok_tn('song').' as s on r.song_id=s.id';
	if ( !isset($VARS['sort']) ) {
		$query.=' where substring(a.name from 1 for 1) >= \''.$VARS['alpha'].'\'';
		$sort = 'a.name';
	} else {
		$sort = $VARS['sort'].' desc';
	}

	$query.= ' group by r.artist_id order by '.$sort.' limit '.$VARS['offset'].', '.DOK_LIST_EPP;;
	//if ( $VARS['sort'] == 'songs' ) {
	//	$query = 'select a.name, a.id, count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id group by r.artist_id order by c desc limit '.$VARS['offset'].', '.DOK_LIST_EPP;
	//} else {
	//	$query = 'select a.name, a.id, count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where substring(a.name from 1 for 1) >= \''.$VARS['alpha'].'\' group by r.artist_id order by a.name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
	//}
	$res = mysql_query($query);
	if ( mysql_numrows($res) ) {
		$display_first = $VARS['offset'] + 1;
		$display_last = $display_first - 1;
		while ( $row = mysql_fetch_array($res) ) {
			$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF'].'?display=view_artist&id='.$row['id']);
                	$t->set_var('ARTIST_NAME',$row['name']);
       		        $t->set_var('ARTIST_SONGS',$row['count']);
			$t->set_var('ARTIST_LENGTH',dok_sec2str($row['length']));
	                $t->parse('artist_block','artist','true');
			$display_last++;
		}
		if ( $VARS['sort'] == 'songs' ) {
			$t_query ='select count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id group by r.artist_id';
		} else {
			$t_query='select count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where substring(a.name from 1 for 1) >= \''.$VARS['alpha'].'\' group by r.artist_id';
		}
		$res = mysql_query($t_query);
		$total = mysql_numrows($res);
		if ( $total > ( $VARS['offset'] + DOK_LIST_EPP ) ) {
			$t->set_var('NEXT_PAGE_LINK',$_SERVER['PHP_SELF'].'?display=list_artists&alpha='.$VARS['alpha'].'&offset='.($VARS['offset']+DOK_LIST_EPP).'&sort='.$VARS['sort']);
			$t->parse('next_page_block','next_page');
		} else {
			$t->set_var('next_page_block','');
		}
	} else {
		$t->set_var('artist_block',MSG_NO_ARTIST);
		$t->set_var('next_page_block','');
	}
	return array($t, MSG_TITLE_LIST_ARTIST);
}

