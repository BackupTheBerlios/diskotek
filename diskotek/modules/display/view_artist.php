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
	$t->set_block('page','if_artisteditor','editor_block');
	$t->set_block('page','artist_albums','albums_block');
	$t->set_block('page','artist_songs','songs_block');
	$t->set_block('page','related_artists','related_artists_block');
	$t->set_var(array(	'ARTIST_NAME'=>$row['name'],
				'ARTIST_DB_CREATION'=>date($THEME_DATE,$row['creation']) ));

	$t->set_var('ARTIST_EDIT_LINK',$_SERVER['PHP_SELF'].'?display=edit_artist&id='.$VARS['id']);
	$t->parse('editor_block','if_artisteditor');

	$songs =& dok_rel_song_artist(array(),array($VARS['id']));
	echo mysql_error();
	if ( !$songs->numrows() ) {
		$t->set_var('songs_block',MSG_NO_SONG);
		$t->set_var('albums_block',MSG_NO_ALBUM);
		$t->set_var('related_artists_block',MSG_NO_RELATED_ARTIST);
	} else {
		$all_songs = $songs->fetch_col_array('song_id');
		$query = 'select id, name, creation, length, release, comment from '.dok_tn('song').' where id in('.implode(',',$all_songs).') order by name, creation';
		unset($songs);
		$songs = dok_oquery($query);
		while ( $song = $songs->fetch_array() ) {
			$sl = dok_sec2min($song['length']);
			$t->set_var(dok_song_format($song));
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
				$t->set_var(array('ALBUM_LINK' => $_SERVER['PHP_SELF'].'?display=view_album&id='.$album['id'],
						'ALBUM_NAME'   => $album['name'],
						'ALBUM_DB_CREATION' => date($THEME_DATE,$album['creation']) ));
				$t->parse('albums_block','artist_albums','true');
			}
		}
		$query = 'select a.name, a.id, count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where r.song_id in('.implode(',',$all_songs).') and artist_id != '.$VARS['id'].' group by r.artist_id order by c desc limit 7';
		//echo $query;
		$res = mysql_query($query);
		if ( !mysql_numrows($res) ) {
			$t->set_var('related_artists_block',MSG_NO_RELATED_ARTIST);
		} else {
			while ($row = mysql_fetch_array($res) ) {
				$t->set_var(array('RELATED_ARTIST_LINK'=>$_SERVER['PHP_SELF'].'?display=view_artist&id='.$row['id'],
						'RELATED_ARTIST_NAME'=>$row['name']));
				$t->parse('related_artists_block','related_artists','true');
			}
		}
	}
	return array($t,sprintf(MSG_TITLE_DISPLAY_ARTIST,$row['name']));
	
}



?>
