<?PHP

function dok_login ( $a, $b, $theme_path ) {
	$t = new template($theme_path);
	$t->set_file('page','login.tpl');
	return array($t, MSG_TITLE_LOGIN);
}


?>
