<?PHP

function dok_update_song_artist_link () {
	global $VARS, $ARTIST_SONG_LINKS;

	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song_artist_link','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song_artist_link','e');
                return false;
        }
        $song = mysql_fetch_array($res);

	if ( !isset($VARS['artist']) || !is_numeric($VARS['artist']) || $VARS['artist']<1 ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_update_song_artist_link','e');
                return false;
        }

        $res = mysql_query('select * from '.dok_tn('artist').' where id = '.$VARS['artist']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_ARTIST_NOT_FOUND,'dok_update_song_artist_link','e');
                return false;
        }
        $artist = mysql_fetch_array($res);

	if ( !in_array($VARS['link'],array_keys($ARTIST_SONG_LINKS)) )	$VARS['link'] = 0;

	//cool we could update
	$res = dok_uquery('insert into '.dok_tn('rel_song_artist').' (song_id, artist_id, link) values ('.$song['id'].','.$artist['id'].','.$VARS['link'].')');
	
	if ( $res ) {
		$VARS['nohit']=1;
		if ( isset($VARS['back2edit']) ) {
			return 'link_song_artist';
		} else {
                	return 'view_song';
		}
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song_artist_link','e');
                return false;
        }

}


?>
