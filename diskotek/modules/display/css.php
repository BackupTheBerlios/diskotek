<?PHP

function dok_css ( $VARS,$update_module,$theme_path ) {
	if ( !is_file($theme_path.'/style.css') ) {
		echo MSG_ERR_NO_CSS;
		exit ;
	}
	header("Content-type: text/css");
	readfile($theme_path.'/style.css');
}
?>