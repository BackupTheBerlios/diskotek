<?PHP

function dok_create_artist () {
	global $VARS, $USER;
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

	//test for soundex
	if ( DOK_USE_SOUNDEX && !$VARS['soundex_checked'] ) {
		$query = 'select id, name from '.dok_tn('artist').' where substring(soundex(name) from 2) = substring(soundex(\''.addslashes($artist_name).'\') from 2)';
		$res = dok_oquery($query);
		if ( $res->numrows() ) {
			$VARS['soundex'] = $res->fetch_col_array('name','id');
			return 'ask_sound_artist';
		}
	}

	if ( DOK_ENABLE_USER )  $creation_uid = $USER->id;
        else                    $creation_uid = 0;

	//add artist
	$res = dok_uquery('insert into '.dok_tn('artist').' (name,creation,creation_uid) values (\''.addslashes($artist_name).'\','.time().','.$creation_uid.')');
	if ( !$res ) {
		dok_msg(mysql_error(),'dok_create_artist','e');
                return false;
	}
	$VARS['id'] = mysql_insert_id();
	$_SESSION['song_select_artist'] = $VARS['id'];
	return 'view_artist';
}





?>
