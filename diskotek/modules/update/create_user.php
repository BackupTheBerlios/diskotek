<?PHP

function dok_create_user () {
	global $VARS, $USER;

	if ( !isset($VARS['name']) ) {
		dok_msg(MSG_ERR_NO_USER_NAME,'dok_create_user','e');
		return false;
	}
	$VARS['name'] = substr($VARS['name'],0,255);

	if ( !isset($VARS['password']) || !strlen($VARS['password']) ) {
                dok_msg(MSG_ERR_NO_USER_PASSWORD,'dok_create_user','e');
                return false;
        }

	if ( $VARS['password'] != $VARS['password_again'] ) {
		dok_msg(MSG_ERR_PASSWORD_MISMATCH,'dok_create_user','e');
                return false;
	}
	$VARS['password'] = substr($VARS['password'],0,255);

	$res = mysql_query('select id from '.dok_tn('user').' where name = \''.addslashes($VARS['name']).'\'');
	if ( mysql_numrows($res) ) {
		dok_msg(sprintf(MSG_ERR_USER_NAME_EXISTS,$VARS['name']),'dok_create_user','e');
                return false;
	}

	if ( $VARS['editor'] != '1' )	$VARS['editor'] = 0;
	if ( $VARS['admin'] != '1' )    $VARS['admin'] = 0;

	$res = dok_uquery('insert into '.dok_tn('user').' (name, password, editor, admin, creation) values (\''.addslashes($VARS['name']).'\', \''.md5($VARS['password']).'\', \''.$VARS['editor'].'\', \''.$VARS['admin'].'\', '.time().')');
	if ( !$res ) {
		dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_create_user','e');
		return false;
	}

	$VARS['id'] = mysql_insert_id();
	return 'view_user';
}





?>
