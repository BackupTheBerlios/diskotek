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
	$query = 'select s.id, s.name, s.creation, s.length, s.release, s.comment, r.track from '.dok_tn('rel_song_album').' as r left join '.dok_tn('song').' as s on r.song_id = s.id where r.album_id = '.$VARS['id'].' order by r.track';
	$songs = dok_oquery($query);

	$album_length = 0;

	if ( !$songs->numrows() ) {
		$t->set_var('songs_block',MSG_NO_SONG);
	} else {
		while ( $song = $songs->fetch_array() ) {
			$t->set_var(dok_song_format($song));
			$t->set_var('SONG_TRACK',$song['track']);
			
			$t->parse('songs_block','album_songs','true');
			$album_length += $song['length'];
		}
	}
	$t->set_var('ALBUM_LENGTH',dok_sec2str($album_length));
	return array($t,sprintf(MSG_TITLE_DISPLAY_ALBUM,$row['name']));
	
}



?>
