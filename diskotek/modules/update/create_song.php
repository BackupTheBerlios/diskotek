<?PHP

function dok_create_song() {
	global $VARS, $GENRES, $USER, $SONGS_LABELS;
	if ( !isset($VARS['name']) || !strlen(trim($VARS['name'])) ) {
		dok_msg(MSG_ERR_SONG_NO_NAME,'dok_create_song','e');
		return false;
	}

	if ( !is_numeric($VARS['album']) || $VARS['album'] < 1 )	$VARS['album'] = 0;
	$res = mysql_query('select name from '.dok_tn('album').' where id = '.$VARS['album']);
	if ( !mysql_numrows($res) ) {
		dok_msg(MSG_ERR_NO_ALBUM_NAME,'dok_create_song','e');
                return false;
	}
	$album_name = mysql_result($res,0,'name');

	$_SESSION['song_select_album'] = $VARS['album'];

	if ( !is_numeric($VARS['artist']) || $VARS['artist'] < 1 )        $VARS['artist'] = 0;
	$res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist']);
        if ( !mysql_numrows($res) ) {
                dok_msg(MSG_ERR_NO_ARTIST_NAME,'dok_create_song','e');
                return false;
        }
        $artist_name = mysql_result($res,0,'name');

	$_SESSION['song_select_artist'] = $VARS['artist'];

        $song_name = substr($VARS['name'],0,255);
        if ( !$VARS['dup_checked'] ) {
                $res = dok_oquery('select id from '.dok_tn('song').' where name = \''.addslashes($song_name).'\'');
                if ( $res->numrows() ) {
                        //dok_msg(MSG_ERR_SONG_DUP_NAME,'dok_create_song','e');
                        $VARS['duplicates'] = $res->fetch_col_array('id');
                        return 'ask_dup_song';
                }
        }
        $song_name = ucwords($song_name);


	if ( $VARS['album_track'] != 'text' ) {
		$t_res = mysql_query('select max(track) as m from '.dok_tn('rel_song_album').' where album_id = '.$VARS['album']);
		$VARS['track'] = mysql_result($t_res,0,'m') + 1 ;
		$_SESSION['album_track'] = 'next';
	} else {
		if ( !is_numeric($VARS['track']) || $VARS['track'] < 1 ) {
			dok_msg(MSG_ERR_NO_TRACK,'dok_create_song','e');
	                return false;
		}
		$_SESSION['album_track'] = 'text';
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

	$length = dok_str2sec($VARS['length']);

	if ( $VARS['genre'] >= sizeof($GENRES) ) {
		$genre=0;
	} else {
		$genre = $VARS['genre'];
		$_SESSION['song_select_genre'] = $genre;
	}

	if ( $VARS['label'] && $VARS['label'] > 0 && in_array($VARS['label'],array_keys($SONGS_LABELS)) && strlen($SONGS_LABELS[$VARS['label']]['label']) ) {
		$label = $VARS['label'];
	} else {
		$label = 0;
	}

	if ( DOK_ENABLE_USER )	$creation_uid = $USER->id;
	else			$creation_uid = 0;

	//add
	$res = dok_uquery('insert into '.dok_tn('song').' (name, length, creation, creation_uid, release, comment, genre, label) values (\''.addslashes($song_name).'\', '.$length.', '.time().','.$creation_uid.','.$VARS['release'].',\''.addslashes($comment).'\','.$genre.', '.$label.')');
	if ( !$res ) {
		echo mysql_error();
		return false;
	}
	$my_id = mysql_insert_id();
	$res = dok_uquery('insert into '.dok_tn('rel_song_artist').' (song_id, artist_id) values ('.$my_id.','.$VARS['artist'].')');
	if ( !$res ) {
                echo mysql_error();
                return false;
        }
	$res = dok_uquery('insert into '.dok_tn('rel_song_album').' (song_id, album_id,track ) values ('.$my_id.','.$VARS['album'].','.$VARS['track'].')');
        if ( !$res ) {
                echo mysql_error();
                return false;
        }
	$VARS['id'] = $my_id;
	$VARS['nohit'] = 1;
	if ( sizeof($VARS['link']) ) {
		$links = array_keys(dok_songs_links_array());
		foreach ( $VARS['link'] as $key => $val ) {
			if ( is_numeric($key) && $key > 0 && strlen($val) && in_array($val,$links) ) {
				$res = mysql_query('select name from '.dok_tn('song').' where id = '.$key);
				if ( mysql_numrows($res) ) {
					$res = dok_song_link_add($VARS['id'],$key,$val);
				}
			}
		}
	}


	return 'view_song';
}


?>
