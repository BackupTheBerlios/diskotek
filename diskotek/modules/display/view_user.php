<?PHP


function dok_view_user ($VARS, $update, $theme_path) {
	global $USER, $THEME_DATE;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
                $t = dok_error_template(MSG_ERR_USER_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISLAY_USER,''));
        }
        $res = mysql_query('select * from '.dok_tn('user').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_USER_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_USER,''));
        }
	$user = mysql_fetch_array($res);

	$t = new template($theme_path);
	$t->set_file('page','user_display.tpl');
	$t->set_block('page','if_admin','if_admin_block');
	
	if ( DOK_ENABLE_USER && $USER->admin || !DOK_ENABLE_USER ) {
		$t->parse('if_admin_block','if_admin');
	} else {
		$t->set_var('if_admin_block','');
	}

	$t->set_var(array (	'USER_NAME' => $user['name'],
				'USER_DB_CREATION' => date($THEME_DATE, $user['creation']),
				'USER_LAST_LOGIN'  => date($THEME_DATE, $user['last_login']),
				'USER_EDIT_LINK'   => $_SERVER['PHP_SELF'].'?display=edit_user&id='.$user['id'] ) );
	return array($t, sprintf(MSG_TITLE_DISPLAY_USER,$user['name']));
}


?>
