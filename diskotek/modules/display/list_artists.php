<?PHP

function dok_list_artists ($VARS, $up, $theme_path) {
	
	$t = new template($theme_path);
	$t->set_file('page','artist_list.tpl');
	$t->set_block('page','artist','artist_block');
	$res = mysql_query('select a.name, a.id, count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id group by r.artist_id order by a.name');
	echo mysql_error();
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF'].'?display=view_artist&id='.$row['id']);
		$t->set_var('ARTIST_NAME',$row['name']);
		$t->set_var('ARTIST_SONGS',$row['c']);
		$t->parse('artist_block','artist','true');
	}

	return array($t, MSG_TITLE_LIST_ARTIST);
}
