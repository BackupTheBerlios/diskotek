<?PHP

function dok_update_song_album_link () {
	global $VARS;

	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song_album_link','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song_album_link','e');
                return false;
        }
        $song = mysql_fetch_array($res);

	if ( !isset($VARS['album']) || !is_numeric($VARS['album']) || $VARS['album']<1 ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_update_song_album_link','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('album').' where id = '.$VARS['album']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ALBUM_NOT_FOUND,'dok_update_song_album_link','e');
                return false;
        }
        $album = mysql_fetch_array($res);

	if ( !isset($VARS['track']) || !is_numeric($VARS['track']) || $VARS['track']<1 )	$VARS['track'] = 1;

	$res = mysql_query('select r.song_id, s.name from '.dok_tn('rel_song_album').' as r left join '.dok_tn('song').' as s on r.song_id = s.id  where r.album_id = '.$album['id'].' and r.track = '.$VARS['track']);
	if ( mysql_numrows($res) ) {
		dok_msg(sprintf(MSG_ERR_SONG_TRACK_DUP,mysql_result($res,0,'name'),$VARS['track']),'dok_update_song_album_link','e');
                return false;
	}

	//cool we could update
	$res = dok_uquery('insert into '.dok_tn('rel_song_album').' (song_id, album_id, track) values ('.$song['id'].','.$album['id'].','.$VARS['track'].')');
	
	if ( $res ) {
		$VARS['id'] = $album['id'];
                return 'view_album';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_album_link','e');
                return false;
        }

}


?>
