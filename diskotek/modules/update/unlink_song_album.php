<?PHP

function dok_unlink_song_album () {
	global $VARS;

	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_unlink_song_album','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_unlink_song_album','e');
                return false;
        }
        $song = mysql_fetch_array($res);

	if ( !isset($VARS['album']) || !is_numeric($VARS['album']) || $VARS['album']<1 ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_unlink_song_album','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('album').' where id = '.$VARS['album']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_unlink_song_album','e');
                return false;
        }
        $album = mysql_fetch_array($res);

	$res = mysql_query('select album_id from '.dok_tn('rel_song_album').' where song_id = '.$VARS['id'].' AND album_id != '.$album['id']);
	if ( !mysql_numrows($res) ){
		dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_album_link','e');
                return false;
	}

	$res = dok_uquery('delete from '.dok_tn('rel_song_album').' where song_id = '.$song['id'].' and album_id = '.$album['id']);

	if ( $res ) {
                return 'edit_song';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_album_link','e');
                return false;
        }

}


?>
