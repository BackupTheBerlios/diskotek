<?PHP

function dok_new_album($VARS, $update_module,$theme_path) {
	$t = new template($theme_path);
	$t->set_file('page','album_new.tpl');
	return array($t,MSG_TITLE_NEW_ALBUM);
}

?>
