<?PHP


function dok_homepage($vars,$update_mod,$theme_path) {
	$t = new template($theme_path);
	$t->set_file('page','homepage.tpl');
	$res = mysql_query('select count(*) as c from '.dok_tn('song'));
	$t_song = mysql_result($res,0,'c');
	$res = mysql_query('select count(*) as c from '.dok_tn('artist'));
        $t_artist = mysql_result($res,0,'c');
	$res = mysql_query('select count(*) as c from '.dok_tn('album'));
        $t_album = mysql_result($res,0,'c');

	$t->set_var(array(
		'TOTAL_SONGS' => $t_song,
		'TOTAL_ARTISTS' => $t_artist,
		'TOTAL_ALBUMS' => $t_album));

	return array($t, 'Homepage');
}

?>
