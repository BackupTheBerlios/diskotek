<?PHP

function dok_list_artists ($VARS, $up, $theme_path) {
	$orders = array('count','length','albums');
	$t = new template($theme_path);
        $t->set_file('page','artist_list.tpl');
        $t->set_block('page','artist','artist_block');
	$t->set_block('page','next_page','next_page_block');
	if( !isset($VARS['alpha']) )	{
		$VARS['alpha'] = '-';
	}
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);

	if ( isset($VARS['sort']) && !in_array($VARS['sort'],$orders) ) {
		unset($VARS['sort']);
	}
	if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )	$VARS['offset'] = '0';

	$display = array();

	// here we do 2 queries: it's better than 1 for mysql
	if ( isset($VARS['sort']) ) {
		$my_display = array();
		$query = "select r.artist_id as id, count(distinct r.song_id) as count, sum(s.length) as length, count(distinct al.album_id) as albums from ".dok_tn("rel_song_artist").' as r left join '.dok_tn('song').' as s on r.song_id=s.id left join '.dok_tn('rel_song_album').' as al on r.song_id=al.song_id group by r.artist_id order by '.$VARS['sort'].' desc limit '.$VARS['offset'].', '.DOK_LIST_EPP;
		//echo $query;
		$res = dok_oquery($query);
		while ( $row = $res->fetch_array() ) {
			$my_display[$row['id']] = array('id' => $row['id'], 'count'=>$row['count'], 'length'=>$row['length'], 'albums' => $row['albums']);
		}
		if ( sizeof($my_display) ) {
			$query = 'select name,id from '.dok_tn('artist').' where id in('.implode(', ',array_keys($my_display)).')';
			$res = dok_oquery($query);
			while ( $row = $res->fetch_array() ) {
				$my_display[$row['id']]['name'] = $row['name'];
			}
			foreach ( $my_display as $one ) {
				$display[] = $one;
			}
		}
	} else {
		$my_display = array();
		$query = 'select name,id from '.dok_tn('artist').' where LEFT(name,1) >= \''.$VARS['alpha'].'\' order by name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
		$res = dok_oquery($query);
		while ( $row = $res->fetch_array() ) {
			$my_display[$row['id']] = array('name' => $row['name'],'id' => $row['id']);
		}
		if ( sizeof($my_display) ) {
			$query = "select r.artist_id as id, count(DISTINCT r.song_id) as count, sum(s.length) as length, count(distinct al.album_id) as albums  from ".dok_tn("rel_song_artist").' as r left join '.dok_tn('song').' as s on r.song_id=s.id left join '.dok_tn('rel_song_album').' as al on r.song_id=al.song_id where r.artist_id in('.implode(', ',array_keys($my_display)).') group by r.artist_id';
			$res = dok_oquery($query);
			while ( $row = $res->fetch_array() ) {
				$my_display[$row['id']]['count'] = $row['count'];
				$my_display[$row['id']]['length'] = $row['length'];
				$my_display[$row['id']]['albums'] = $row['albums'];
			}
			foreach ( $my_display as $one ) {
				$display[] = $one;
			}
		}
	}



	if ( sizeof($display) ) {
		$display_first = $VARS['offset'] + 1;
		$display_last = $display_first - 1;
		foreach ( $display as $row ) {
			$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF'].'?display=view_artist&id='.$row['id']);
                	$t->set_var('ARTIST_NAME',$row['name']);
       		        $t->set_var('ARTIST_SONGS',$row['count']);
			$t->set_var('ARTIST_ALBUMS',$row['count']);
			$t->set_var('ARTIST_LENGTH',dok_sec2str($row['length']));
	                $t->parse('artist_block','artist','true');
			$display_last++;
		}
		if ( isset($VARS['sort']) ) {
			$t_query ='select count(*) as c from '.dok_tn('rel_song_artist').' as r group by r.artist_id';
		} else {
			$t_query = 'select id from '.dok_tn('artist').' where LEFT(name,1) >= \''.$VARS['alpha'].'\'';
			//$t_query='select count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where substring(a.name from 1 for 1) >= \''.$VARS['alpha'].'\' group by r.artist_id';
			//echo $t_query;
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

