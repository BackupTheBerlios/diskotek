<?PHP
function dok_update_album() {
        global $VARS;
        if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_update_album','e');
                return false;
        }

	if ( !isset($VARS['name']) || !strlen(trim($VARS['name'])) ) {
		return 'view_album';
	}
	$name = substr(trim($VARS['name']),0,255);

        $res = mysql_query('select * from '.dok_tn('album').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_update_album','e');
                return false;
        }
        $artist = mysql_fetch_array($res);
	if ( strtolower($artist['name']) == strtolower($name) ) {
		return 'view_album';
	}

	$res = mysql_query('update '.dok_tn('album').' set name = \''.addslashes(ucwords($name)).'\' where id = '.$VARS['id']);
	if ( $res ) {
                return 'view_album';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_album','e');
                return false;
        }
}



?>
