<?PHP
function dok_update_user() {
        global $VARS,$USER;
        if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_USER_NOT_FOUND,'dok_update_user','e');
                return false;
        }

	$res = mysql_query('select * from '.dok_tn('user').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_USER_NOT_FOUND,'dok_update_user','e');
                return false;
        }

	$user = mysql_fetch_array($res);

	if ( DOK_ENABLE_USER && !$USER->admin && $USER->id != $user['id'] ) {
		dok_msg(MSG_ERR_USER_UPDATE_NOT_ALLOWED,'dok_update_user','e');
		return false;
	}

	$set = array();

	if ( isset($VARS['password']) && strlen(trim($VARS['password'])) > 0 ) {
		$VARS['password'] = substr($VARS['password'],0,255);
		$set[] = 'password = \''.md5($VARS['password']).'\'';
	}

	if ( !DOK_ENABLE_USER || $USER->admin ) {
		if ( $VARS['editor'] != '1' )	$VARS['editor'] = 0;
		if ( $VARS['admin'] != '1' )	$VARS['admin'] = 0;
		if ( $VARS['disabled'] != '1' )	$VARS['disabled'] = 0;
		if ( isset($VARS['name']) && trim($VARS['name']) != $user['name'] ) {
			$VARS['name'] = substr($VARS['name'],0,255);
			$res = mysql_query('select id from '.dok_tn('user').' where name = \''.addslashes($VARS['name']).'\'');
			if ( !mysql_numrows($res) ) {
				$set[] = 'name = \''.addslashes($VARS['name']).'\'';
			}
		}
		if ( $VARS['editor'] XOR $user['editor'] ) {
			$set[] = 'editor = \''.$VARS['editor'].'\'';
		}
		if ( $VARS['admin'] XOR $user['admin'] ) {
                        $set[] = 'admin = \''.$VARS['admin'].'\'';
                }
		if ( $VARS['disabled'] XOR $user['disabled'] ) {
                        $set[] = 'disabled = \''.$VARS['disabled'].'\'';
                }

	}

	if ( sizeof($set) ) {
		$query = 'update '.dok_tn('user').' set '.implode(', ',$set).' where id = '.$VARS['id'];
		$res = dok_uquery($query);
		if ( !$res ) {
			dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_user','e');
		}
	}

	return 'view_user';
}



?>
