<?PHP

function dok_view_album ($VARS, $update_module, $tpl_path) {
	global $THEME_DATE;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
		$t = dok_error_template(MSG_ERR_ALBUM_DISPLAY);
		return array($t,sprintf(MSG_TITLE_DISPLAY_ALBUM,''));
	}
	$res = mysql_query('select name, creation from '.dok_tn('album').' where id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		$t = dok_error_template(MSG_ERR_ALBUM_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_ALBUM,''));
	}
	$row = mysql_fetch_assoc($res);
	$t = new template($tpl_path);
	$t->set_file('page','album_display.tpl');
	$t->set_block('page','album_songs','songs_block');
	$t->set_var(array(	'ALBUM_NAME'=>$row['name'],
				'ALBUM_DB_CREATION'=>date($THEME_DATE,$row['creation']) ));
	$query = 'select s.id, s.name, s.creation, s.length, r.track from '.dok_tn('rel_song_album').' as r left join '.dok_tn('song').' as s on r.song_id = s.id where r.album_id = '.$VARS['id'].' order by r.track';
	$songs = dok_oquery($query);
	echo mysql_error();
	if ( !$songs->numrows() ) {
		$t->set_var('songs_block',MSG_NO_SONG);
	} else {
		while ( $song = $songs->fetch_array() ) {
			$sl = dok_sec2min($song['length']);
			if ( !$sl['minut'] )	$length = $sl['second'].' '.MSG_SECONDS;
			else			$length = $sl['minut'].' '.MSG_MINUTS.' '.$sl['second'].' '.MSG_SECONDS;
			$t->set_var(array('SONG_LINK'  => $PHP_SELF.'?display=view_song&id='.$song['id'],
					'SONG_NAME'    => $song['name'],
					'SONG_LENGTH'  => $length,
					'SONG_TRACK'   => $song['track'],
					'SONG_DB_CREATION' => date($THEME_DATE,$song['creation']),
					'SONG_ARTIST' => dok_get_artists_string($song['id']) ));
			
			$t->parse('songs_block','album_songs','true');
		}
	}
	return array($t,sprintf(MSG_TITLE_DISPLAY_ALBUM,$row['name']));
	
}



?>
