<?PHP

function dok_song_track () {
	global $VARS;
	//check input
	if ( !isset($VARS['song_id']) || !is_numeric($VARS['song_id']) || $VARS['song_id']  < 1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_song_track','e');
		return false;
	}

	$res = mysql_query('select name from '.dok_tn('song').' where id = '.$VARS['song_id']);
	if ( !mysql_numrows($res) )	{
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_song_track','e');
                return false;
	}
	$song_name = mysql_result($res,0,'name');

	if ( !isset($VARS['album_id']) || !is_numeric($VARS['album_id']) || $VARS['album_id']  < 1 ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_song_track','e');
                return false;
        }

        $res = mysql_query('select name from '.dok_tn('album').' where id = '.$VARS['album_id']);
        if ( !mysql_numrows($res) )     {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_song_track','e');
                return false;
        }

	if ( !isset($VARS['track']) || !is_numeric($VARS['track']) || $VARS['track']  < 1 ) {
                dok_msg(MSG_ERR_NO_TRACK,'dok_song_track','e');
                return false;
        }

	$res = mysql_query('select song_id from '.dok_tn('rel_song_album').' where album_id = '.$VARS['album_id'].' and track = '.$VARS['track'].' and song_id != '.$VARS['song_id']);
	if ( mysql_numrows($res) ) {
		dok_msg(sprintf(MSG_ERR_ALBUM_TRACK_ASSIGNED,$VARS['track']),'dok_song_track','e');
		return false;
	}

	$res = dok_uquery('delete from '.dok_tn('rel_song_album').' where song_id = '.$VARS['song_id'].' and album_id = '.$VARS['album_id']);
	if ( !$res ) {
		echo mysql_error();
                return false;
	}
	$res = dok_uquery('insert into '.dok_tn('rel_song_album').' (song_id, album_id, track) values ('.$VARS['song_id'].','.$VARS['album_id'].','.$VARS['track'].')');
	if ( !$res ) {
                echo mysql_error();
                return false;
        }
	$VARS['id'] = $VARS['album_id'];
	return 'view_album';
}

?>
