<?PHP

function dok_create_artist () {
	global $VARS;
	if ( !isset($VARS['name']) ) {
		dok_msg(MSG_ERR_NO_ARTIST_NAME,'dok_create_artist','e');
		return false;
	}
	if ( !strlen(trim($VARS['name'])) ) {
                dok_msg(MSG_ERR_NO_ARTIST_NAME,'dok_create_artist','e');
                return false;
        }
	$artist_name = ucwords(substr($VARS['name'],0,255));
	$res = mysql_query('select id from '.dok_tn('artist').' where name = \''.addslashes($artist_name).'\'');
	if ( mysql_numrows($res) ) {
		dok_msg(sprintf(MSG_ERR_DUP_ARTIST_NAME,$artist_name),'dok_create_artist','e');
                return false;
	}
	//add artist
	$res = mysql_query('insert into '.dok_tn('artist').' (name,creation) values (\''.addslashes($artist_name).'\','.time().')');
	if ( !$res ) {
		dok_msg(mysql_error(),'dok_create_artist','e');
                return false;
	}
	$VARS['id'] = mysql_insert_id();
	$_SESSION['song_select_artist'] = $VARS['id'];
	return 'view_artist';
}





?>
