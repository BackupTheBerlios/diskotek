<?PHP
function dok_edit_user ($VARS,$update_module,$theme_path) {
	global $USER;
        if ( !$VARS['id'] || !is_numeric($VARS['id']) || $VARS['id']<1 )        {
                $t = dok_error_template(MSG_ERR_USER_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_USER,MSG_UNKNOWN));
        }
        $res = mysql_query('select * from '.dok_tn('user').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_USER_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_USER,MSG_UNKNOWN));
        }
        $row = mysql_fetch_array($res);

	if ( DOK_ENABLE_USER && ( !$USER->admin && $USER->id != $row['id'] ) ) {
		$t = dok_error_template(MSG_ERR_USER_EDITION_NOT_ALLOWED);
                return array($t, sprintf(MSG_TITLE_EDIT_USER,MSG_UNKNOWN));
	}


	$t = new template($theme_path);
	$editor_cb = '<input type="checkbox" name="editor" value="1"';
	if ( $row['editor'] )	$editor_cb.=' CHECKED';
	$editor_cb.='>';
	$admin_cb = '<input type="checkbox" name="admin" value="1"';
        if ( $row['admin'] )   $admin_cb.=' CHECKED';
        $admin_cb.='>';
	$disabled_cb = '<input type="checkbox" name="disabled" value="1"';
        if ( $row['disabled'] )   $disabled_cb.=' CHECKED';
        $disabled_cb.='>';

	$t->set_file('page','user_edit.tpl');
	$t->set_block('page','if_admin','if_admin_block');
	if ( !DOK_ENABLE_USER || $USER->admin ) {
		$t->parse('if_admin_block','if_admin');
	} else {
		$t->set_var('if_admin_block','');
	}
	$t->set_var(array(	'USER_ID'=>$row['id'],
				'USER_NAME'=>$row['name'],
				'USER_NAME_TF'=>str_replace( '"','&quot;',$row['name'] ),
				'USER_EDITOR_CB' => $editor_cb,
				'USER_DISABLED_CB' => $disabled_cb,
				'USER_ADMIN_CB'  => $admin_cb   ));
	return array($t, sprintf(MSG_TITLE_EDIT_USER,$row['name']));
}

?>
