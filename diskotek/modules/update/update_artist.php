<?PHP
function dok_update_artist() {
        global $VARS;
        if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_update_artist','e');
                return false;
        }

	if ( !isset($VARS['name']) || !strlen(trim($VARS['name'])) ) {
		return 'view_artist';
	}
	$name = substr(trim($VARS['name']),0,255);

        $res = mysql_query('select * from '.dok_tn('artist').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_update_artist','e');
                return false;
        }
        $artist = mysql_fetch_array($res);
	if ( strtolower($artist['name']) == strtolower($name) ) {
		return 'view_artist';
	}

	$res = dok_uquery('update '.dok_tn('artist').' set name = \''.addslashes(ucwords($name)).'\' where id = '.$VARS['id']);
	if ( $res ) {
                return 'view_artist';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_artist','e');
                return false;
        }
}



?>
