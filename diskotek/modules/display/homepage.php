<?PHP


function dok_homepage($vars,$update_mod,$theme_path) {
	$t = new template($theme_path);
	$t->set_file('page','homepage.tpl');
	$t->set_var(array(
		'TOTAL_SONGS' => dok_songs_nb(),
		'TOTAL_ARTISTS' => dok_artists_nb(),
		'TOTAL_ALBUMS' => dok_albums_nb()));

	return array($t, 'Homepage');
}

?>
