<?PHP


function dok_homepage($vars,$update_mod,$theme_path) {
	$t = new template($theme_path);
	$t->set_file('page','homepage.tpl');
	return array($t, 'Homepage');
}

?>
