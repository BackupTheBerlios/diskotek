<?PHP

function dok_ask_sound_artist ( $VARS, $update, $theme_path ) {
	if ( !is_array($VARS['soundex']) || !sizeof($VARS['soundex']) ) {
		$t = dok_error_template(MSG_ERR_ARTIST_NOT_FOUND);
                return array($t,MSG_TITLE_SOUNDEX_TEST);
	}

	$t = new template($theme_path);
	$t->set_file('page','artist_soundex.tpl');
	$t->set_block('page','artists','artists_block');

	$t->set_var('NEW_ARTIST_NAME',$VARS['name']);
	$t->set_var('ARTIST_CREATE_FORM','<form method="post" action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name="update" value="create_artist"><input type=hidden name="soundex_checked" value="1"><input type=hidden name="name" value="'.str_replace('"','&quot;',$VARS['name']).'">');
	foreach ( $VARS['soundex'] as $id => $name ) {
		$t->set_var('ARTIST_NAME',$name);
		$t->parse('artists_block','artists','true');
	}

	return array($t, MSG_TITLE_SOUNDEX_TEST);
}


?>
