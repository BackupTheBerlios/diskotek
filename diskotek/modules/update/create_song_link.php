<?
function dok_create_song_link() {
	global $VARS, $GENRES, $USER;
	if ( !isset($VARS['id']) || !strlen(trim($VARS['id'])) || !is_numeric(trim($VARS['id'])) || trim($VARS['id']) < 1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
		return false;
	}

	if ( !isset($VARS['other_id']) || !strlen(trim($VARS['other_id'])) || !is_numeric(trim($VARS['other_id'])) || trim($VARS['other_id']) < 1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
		return false;
	}

	$options = dok_songs_links_array();
	if ( !in_array($VARS['link'],array_keys($options)) ) {
		dok_msg(MSG_ERR_SONG_NO_LINK_NAME,'dok_create_song_link','e');
		return false;
	}

	$VARS['other_id']=trim($VARS['other_id']);
	$VARS['id']=trim($VARS['id']);

	if ( !$VARS['old_link'] || !is_numeric($VARS['old_link']) )	$VARS['old_link'] = 0;

	$res = mysql_query('select name from '.dok_tn('song').' where id = '.$VARS['id'].' or id = '.$VARS['other_id']);
	if ( mysql_numrows($res) != 2 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
                return false;
	}

	$ok = dok_song_link_add($VARS['id'],$VARS['other_id'],$VARS['link'],$VARS['old_link']);

	if ( !$ok ) {
		echo mysql_error();
		return false;
	}
	return 'view_song';
}


?>
