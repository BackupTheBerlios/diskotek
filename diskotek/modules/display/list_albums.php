<?PHP

function dok_list_albums2 ($VARS, $up, $theme_path) {
	
	$t = new template($theme_path);
	$t->set_file('page','album_list.tpl');
	$t->set_block('page','album','album_block');

	$res = dok_oquery('select album_id,count(*) as c from '.dok_tn('rel_song_album').' group by album_id');

	$songs = $res->fetch_col_array('c','album_id');

	$res = mysql_query('select id, name from '.dok_tn('album').' order by name');
	echo mysql_error();
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var('ALBUM_LINK',$_SERVER['PHP_SELF'].'?display=view_album&id='.$row['id']);
		$t->set_var('ALBUM_NAME',$row['name']);
		if ( $songs[$row['id']] > 0 )	$t->set_var('ALBUM_SONGS',$songs[$row['id']]);
		else				$t->set_var('ALBUM_SONGS',0);
		$t->parse('album_block','album','true');
	}

	return array($t, MSG_TITLE_LIST_ALBUM);
}

function dok_list_albums ( $VARS, $up, $theme_path ) {
        $t = new template($theme_path);
        $t->set_file('page','album_list.tpl');
        $t->set_block('page','album','album_block');
	$t->set_block('page','next_page','next_page_block');
	if( !isset($VARS['alpha']) )    {
                $VARS['alpha'] = '-';
        }
        if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )   $VARS['offset'] = '0';
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);
	$query = 'select id, name from '.dok_tn('album').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\' order by name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
	$res = dok_oquery($query);
	if ( $res->numrows() ) {
		$ids = $res->fetch_col_array('id');
		$n_res = dok_oquery('select album_id, count(*) as c from '.dok_tn('rel_song_album').' where album_id in('.implode(',',$ids).') group by album_id');
		$n_array = $n_res->fetch_col_array('c','album_id');
		while ( $row = $res->fetch_array() ) {
			$t->set_var('ALBUM_LINK',$_SERVER['PHP_SELF'].'?display=view_album&id='.$row['id']);
	                $t->set_var('ALBUM_NAME',$row['name']);
	                if ( $n_array[$row['id']] > 0 )   $t->set_var('ALBUM_SONGS',$n_array[$row['id']]);
	                else                            $t->set_var('ALBUM_SONGS',0);
	                $t->parse('album_block','album','true');
		}
		$res = mysql_query('select count(*) as c from '.dok_tn('album').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\'');
		$total = mysql_result($res,0,'c');
		if ( $total > ( $VARS['offset'] + DOK_LIST_EPP ) ) {
			$t->set_var('NEXT_PAGE_LINK',$_SERVER['PHP_SELF'].'?display=list_albums&alpha='.$VARS['alpha'].'&offset='.($VARS['offset']+DOK_LIST_EPP));
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


