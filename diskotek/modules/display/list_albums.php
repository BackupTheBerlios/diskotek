<?PHP

function dok_list_albums ($VARS, $up, $theme_path) {
	
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
