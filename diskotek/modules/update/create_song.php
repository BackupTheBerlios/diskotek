<?PHP

function dok_create_song() {
	global $VARS;
	if ( !isset($VARS['name']) || !strlen(trim($VARS['name'])) ) {
		dok_msg(MSG_ERR_SONG_NO_NAME,'dok_create_song','e');
		return false;
	}
	$song_name = substr($VARS['name'],0,255);
	$res = mysql_query('select id from '.dok_tn('song').' where name = \''.addslashes($song_name).'\'');
	if ( mysql_numrows($res) ) {
		dok_msg(MSG_ERR_SONG_DUP_NAME,'dok_create_song','e');
                return false;
	}

	if ( !is_numeric($VARS['album']) || $VARS['album'] < 1 )	$VARS['album'] = 0;
	$res = mysql_query('select name from '.dok_tn('album').' where id = '.$VARS['album']);
	if ( !mysql_numrows($res) ) {
		dok_msg(MSG_ERR_NO_ALBUM_NAME,'dok_create_song','e');
                return false;
	}
	$album_name = mysql_result($res,0,'name');
	
	if ( !is_numeric($VARS['artist']) || $VARS['artist'] < 1 )        $VARS['artist'] = 0;
	$res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_NO_ARTIST_NAME,'dok_create_song','e');
                return false;
        }
        $artist_name = mysql_result($res,0,'name');


	if ( !is_numeric($VARS['track']) || $VARS['track'] < 1 ) {
		dok_msg(MSG_ERR_NO_TRACK,'dok_create_song','e');
                return false;
	}
	$res = mysql_query('select song_id from '.dok_tn('rel_song_album').' where album_id = '.$VARS['album'].' and track = '.$VARS['track']);
	if ( mysql_numrows($res) ) {
		$dup_song_id = mysql_result($res, 0,'song_id');
		$res = mysql_query('select name from '.dok_tn('song').' where id = '.$dup_song_id);
		$dup_song_name = mysql_result($res,0,'name');
		dok_msg(sprintf(MSG_ERR_SONG_TRACK_DUP,$dup_song_name, $VARS['track']) ,'dok_create_song', 'e');
                return false;
	}

	//check comment
	$comment = dok_textarea_2_db ( $VARS['comment']);

	if ( !isset($VARS['release']) || !is_numeric($VARS['release']) || $VARS['release']<1901 || $VARS['release'] > 2155 ) {
		$VARS['release'] = 0;
	}

	$length = 0;
	if ( isset($VARS['length']) ) {
		if ( preg_match('/:/',$VARS['length']) ) {
			$test = explode(':',$VARS['length']);
			if ( sizeof($test) > 1 ) {
				$sec = 0;
				if ( is_numeric($test[0]) )	$sec = $test[0] * 60;
				if ( is_numeric($test[1]) )	$sec += $test[1];
				$length = $sec;
			}
		} elseif ( is_numeric($VARS['length']) && $VARS['length'] > 0 )	$length = $VARS['length'];
	}

	//add
	$res = mysql_query('insert into '.dok_tn('song').' (name, length, creation,release, comment) values (\''.addslashes($song_name).'\', '.$length.', '.time().','.$VARS['release'].',\''.addslashes($comment).'\')');
	if ( !$res ) {
		echo mysql_error();
		return false;
	}
	$my_id = mysql_insert_id();
	$res = mysql_query('insert into rel_song_artist (song_id, artist_id) values ('.$my_id.','.$VARS['artist'].')');
	if ( !$res ) {
                echo mysql_error();
                return false;
        }
	$res = mysql_query('insert into rel_song_album (song_id, album_id,track ) values ('.$my_id.','.$VARS['album'].','.$VARS['track'].')');
        if ( !$res ) {
                echo mysql_error();
                return false;
        }
	$VARS['id'] = $my_id;
	return 'view_song';
}


?>
