<?PHP

function dok_view_artist ($VARS, $update_module, $tpl_path) {
	global $THEME_DATE;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
		$t = dok_error_template(MSG_ERR_ARTIST_DISPLAY);
		return array($t,sprintf(MSG_TITLE_DISPLAY_ARTIST,''));
	}
	$res = mysql_query('select name, creation from '.dok_tn('artist').' where id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		$t = dok_error_template(MSG_ERR_ARTIST_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_ARTIST,''));
	}
	$row = mysql_fetch_assoc($res);
	$t = new template($tpl_path);
	$t->set_file('page','artist_display.tpl');
	$t->set_block('page','artist_albums','albums_block');
	$t->set_block('page','artist_songs','songs_block');
	$t->set_var(array(	'ARTIST_NAME'=>$row['name'],
				'ARTIST_DB_CREATION'=>date($THEME_DATE,$row['creation']) ));
	$songs =& dok_rel_song_artist(array(),array($VARS['id']));
	echo mysql_error();
	if ( !$songs->numrows() ) {
		$t->set_var('songs_block',MSG_NO_SONG);
		$t->set_var('albums_block',MSG_NO_ALBUM);
	} else {
		$query = 'select id, name, creation, length from '.dok_tn('song').' where id in('.implode(',',$songs->fetch_col_array('song_id')).') order by name, creation';
		unset($songs);
		$songs = dok_oquery($query);
		while ( $song = $songs->fetch_array() ) {
			$sl = dok_sec2min($song['length']);
			if ( !$sl['minut'] )	$length = $sl['second'].' '.MSG_SECONDS;
			else			$length = $sl['minut'].' '.MSG_MINUTS.' '.$sl['second'].' '.MSG_SECONDS;
			$t->set_var(array('SONG_LINK'  => $PHP_SELF.'?display=view_song&id='.$song['id'],
					'SONG_NAME'    => $song['name'],
					'SONG_LENGTH'  => $length,
					'SONG_DB_CREATION' => date($THEME_DATE,$song['creation']) ));
			$t->parse('songs_block','artist_songs','true');
		}
		$all_songs = $songs->fetch_col_array('id');
		unset($songs);
		$query = 'select distinct(album_id) from '.dok_tn('rel_song_album').' where song_id in('.implode(',',$all_songs).')';
		$albums = dok_oquery($query);
		if ( !$albums->numrows() ) {
			$t->set_var('albums_block',MSG_NO_ALBUM);
		} else {
			$albums_id = $albums->fetch_col_array('album_id');
			unset($albums);
			$albums = dok_oquery('select id, name, creation from '.dok_tn('album').' where id in ('.implode(',',$albums_id).') order by name');
			while ( $album = $albums->fetch_array() ) {
				$t->set_var(array('ALBUM_LINK' => $PHP_SELF.'?display=view_album&id='.$album['id'],
						'ALBUM_NAME'   => $album['name'],
						'ALBUM_DB_CREATION' => date($THEME_DATE,$album['creation']) ));
				$t->parse('albums_block','artist_albums','true');
			}
		}
	}
	return array($t,sprintf(MSG_TITLE_DISPLAY_ARTIST,$row['name']));
	
}



?>
