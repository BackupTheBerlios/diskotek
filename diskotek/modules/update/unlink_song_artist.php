<?PHP

function dok_unlink_song_artist () {
	global $VARS;

	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_unlink_song_artist','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_unlink_song_artist','e');
                return false;
        }
        $song = mysql_fetch_array($res);

	if ( !isset($VARS['artist']) || !is_numeric($VARS['artist']) || $VARS['artist']<1 ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_unlink_song_artist','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('artist').' where id = '.$VARS['artist']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_unlink_song_artist','e');
                return false;
        }
        $artist = mysql_fetch_array($res);

	$res = mysql_query('select artist_id from '.dok_tn('rel_song_artist').' where song_id = '.$VARS['id'].' AND artist_id != '.$artist['id']);
	if ( !mysql_numrows($res) ){
		dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_artist_link','e');
                return false;
	}

	$res = mysql_query('delete from '.dok_tn('rel_song_artist').' where song_id = '.$song['id'].' and artist_id = '.$artist['id']);

	if ( $res ) {
                return 'edit_song';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_artist_link','e');
                return false;
        }

}


?>
