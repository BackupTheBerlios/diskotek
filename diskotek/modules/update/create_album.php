<?PHP

function dok_create_album () {
	global $VARS, $USER;
	if ( !isset($VARS['name']) ) {
		dok_msg(MSG_ERR_NO_ALBUM_NAME,'dok_create_album','e');
		return false;
	}
	if ( !strlen(trim($VARS['name'])) ) {
                dok_msg(MSG_ERR_NO_ALBUM_NAME,'dok_create_album','e');
                return false;
        }
	$album_name = ucwords(substr($VARS['name'],0,255));
	$res = mysql_query('select id from '.dok_tn('album').' where name = \''.addslashes($album_name).'\'');
	if ( mysql_numrows($res) ) {
		dok_msg(sprintf(MSG_ERR_DUP_ALBUM_NAME,$album_name),'dok_create_album','e');
                return false;
	}

	if ( DOK_ENABLE_USER )  $creation_uid = $USER->id;
        else                    $creation_uid = 0;

	//add artist
	$res = mysql_query('insert into '.dok_tn('album').' (name,creation,creation_uid) values (\''.addslashes($album_name).'\','.time().','.$creation_uid.')');
	if ( !$res ) {
		dok_msg(mysql_error(),'dok_create_album','e');
                return false;
	}
	$VARS['id'] = mysql_insert_id();
	return 'view_album';
}





?>
