<?PHP

function dok_list_albums ( $VARS, $up, $theme_path ) {
	$orders = array('hits','length');
        $t = new template($theme_path);
        $t->set_file('page','album_list.tpl');
	$t->set_block('page','if_artist','artist_block');
        $t->set_block('page','album','album_block');
	$t->set_block('page','next_page','next_page_block');
	if( !isset($VARS['alpha']) )    {
                $VARS['alpha'] = '-';
        }
        if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )   $VARS['offset'] = '0';
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);
	//$query = 'select id, name from '.dok_tn('album').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\' order by name limit  '.$VARS['offset'].', '.DOK_LIST_EPP;

	$query='select sum(s.length) as length, count(s.id) as c, sum(s.hits) as hits, a.id, a.name from '.dok_tn('song').' as s left join '.dok_tn('rel_song_album').' as r on s.id=r.song_id left join '.dok_tn('album').' as a on r.album_id=a.id ';

	$where = array();

	if ( isset($VARS['sort']) && !in_array($VARS['sort'],$orders) || !isset($VARS['sort']) ) {
		unset($VARS['sort']);
		$where[] = 'substring(a.name from 1 for 1) >= \''.$VARS['alpha'].'\' ';
	}
	if ( isset($VARS['artist']) && is_numeric($VARS['artist']) && $VARS['artist'] > 0 ) {
		$res = mysql_query('select * from '.dok_tn('artist').' where id = '.$VARS['artist']);
		if ( mysql_numrows($res) ) {
			$row = mysql_fetch_assoc($res);
			$t->set_var('ARTIST_NAME',$row['name']);
			$t->set_var('ARTIST_ID',$row['id']);
			$t->parse('artist_block','if_artist');
			$res = dok_oquery('select distinct(r.album_id) from '.dok_tn('rel_song_album').' as r left join '.dok_tn('rel_song_artist').' as r2 on r.song_id=r2.song_id where r2.artist_id = '.$VARS['artist']);
			$al_ids = $res->fetch_col_array('album_id');
			if ( sizeof($al_ids) ) {
				$where[] = 'a.id in('.implode(', ',$al_ids).')';
			}
		} else {
			unset($VARS['artist']);
			$t->set_var('artist_block','');
		}
	} else {
		unset($VARS['artist']);
		$t->set_var('artist_block','');
	}
	if ( sizeof($where) ) {
		$query.=' where '.implode(' AND ',$where);
	}
	$query.='group by r.album_id ';
	if ( isset($VARS['sort']) ) {
		$query.='order by '.$VARS['sort'].' desc ';
	} else {
		$query.='order by a.name ';
	}
	$query.='limit '.$VARS['offset'].', '.DOK_LIST_EPP;;

	$res = dok_oquery($query);
	echo mysql_error();
	if ( $res->numrows() ) {
		//$ids = $res->fetch_col_array('id');
		//$n_res = dok_oquery('select album_id, count(*) as c from '.dok_tn('rel_song_album').' where album_id in('.implode(',',$ids).') group by album_id');
		//$n_array = $n_res->fetch_col_array('c','album_id');
		while ( $row = $res->fetch_array() ) {
			$t->set_var('ALBUM_LINK',$_SERVER['PHP_SELF'].'?display=view_album&id='.$row['id']);
	                $t->set_var('ALBUM_NAME',$row['name']);
			$t->set_var('ALBUM_HITS',$row['hits']);
			$t->set_var('ALBUM_LENGTH',dok_sec2str($row['length']));
	                if ( $row['c'] > 0 )   $t->set_var('ALBUM_SONGS',$row['c']);
	                else                            $t->set_var('ALBUM_SONGS',0);
	                $t->parse('album_block','album','true');
		}
		$t_query ='select count(*) as c from '.dok_tn('album').' as a';
		if ( sizeof($where) ) {
			$t_query.=' where '.implode(' AND ',$where);
		}
		$res = mysql_query($t_query);

		$total = mysql_result($res,0,'c');
		if ( $total > ( $VARS['offset'] + DOK_LIST_EPP ) ) {
			$link = $_SERVER['PHP_SELF'].'?display=list_albums&alpha='.$VARS['alpha'].'&offset='.($VARS['offset']+DOK_LIST_EPP.'&artist='.$VARS['artist']);
			if ( isset($VARS['sort']) )	$link.='&sort='.$VARS['sort'];
			$t->set_var('NEXT_PAGE_LINK',$link);
			$t->parse('next_page_block','next_page');
		} else {
			$t->set_var('next_page_block','');
                }
	} else {
		$t->set_var('album_block',MSG_NO_ALBUM);
		$t->set_var('next_page_block','');
	}
	return array($t, MSG_TITLE_LIST_ALBUM);
}


