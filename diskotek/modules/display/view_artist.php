<?PHP

function dok_view_artist ($VARS, $update_module, $tpl_path) {
	global $THEME_DATE, $USER;
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
	$t->set_block('page','all_albums','all_albums_block');
	$t->set_block('page','all_songs','all_songs_block');
	$t->set_block('page','if_artisteditor','editor_block');
	$t->set_block('page','artist_albums','albums_block');
	$t->set_block('page','artist_songs','songs_block');
	$t->set_block('page','related_artists','related_artists_block');
	$t->set_var(array(	'ARTIST_NAME'=>$row['name'],
				'ARTIST_DB_CREATION'=>date($THEME_DATE,$row['creation']) ));

	if ( DOK_ENABLE_USER && !$USER->editor && !$USER->admin ) {
                $t->set_var('if_artisteditor','');
	} else {
		$t->set_var('ARTIST_EDIT_LINK',$_SERVER['PHP_SELF'].'?display=edit_artist&id='.$VARS['id']);
		$t->parse('editor_block','if_artisteditor');
	}

	$songs =& dok_rel_song_artist(array(),array($VARS['id']));
	$display_songs = array();
	echo mysql_error();
	if ( !$songs->numrows() ) {
		$t->set_var('songs_block',MSG_NO_SONG);
		$t->set_var('albums_block',MSG_NO_ALBUM);
		$t->set_var('related_artists_block',MSG_NO_RELATED_ARTIST);
		$t->set_var('all_songs_block','');
		$t->set_var('all_albums_block','');
	} else {
		$all_songs = $songs->fetch_col_array('song_id');
		$t->set_var('ARTIST_SONGS',sizeof($all_songs));
		if ( sizeof($all_songs) > DOK_SONGS_ON_ARTIST_PAGE ) {
			$t->set_var('ALL_SONGS_LINK',$_SERVER['PHP_SELF'].'?display=list_songs&artist='.$VARS['id']);
			$t->set_var('ARTIST_REMAINING_SONGS',(sizeof($all_songs) - DOK_SONGS_ON_ARTIST_PAGE));
			$t->parse('all_songs_block','all_songs');
			$display_songs = array_slice($all_songs,0,DOK_SONGS_ON_ARTIST_PAGE);
		} else {
			$display_songs = $all_songs;
			$t->set_var('all_songs_block','');
		}


		$query = 'select * from '.dok_tn('song').' where id in('.implode(',',$display_songs).') order by hits desc,name, creation desc';
		unset($songs);
		$songs = dok_oquery($query);
		while ( $song = $songs->fetch_array() ) {
			//$sl = dok_sec2min($song['length']);
			$song['ignore_artist'] = $VARS['id'];
			$t->set_var(dok_song_format($song));

			$t->parse('songs_block','artist_songs','true');
		}
		//$all_songs = $songs->fetch_col_array('id');
		unset($songs);
		$query = 'select distinct(album_id) from '.dok_tn('rel_song_album').' where song_id in('.implode(',',$all_songs).')';
		$albums = dok_oquery($query);
		$t->set_var('ARTIST_ALBUMS',$albums->numrows());
		if ( !$albums->numrows() ) {
			$t->set_var('albums_block',MSG_NO_ALBUM);
			$t->set_var('all_albums_block','');
		} else {
			$albums_display = array();
			$albums_id = $albums->fetch_col_array('album_id');
			unset($albums);
			if ( sizeof($albums_id) > DOK_ALBUMS_ON_ARTIST_PAGE ) {
				$albums_display = array_slice($albums_id,DOK_ALBUMS_ON_ARTIST_PAGE);
				$t->set_var('ALL_ALBUMS_LINK',$_SERVER['PHP_SELF'].'?display=list_albums&artist='.$VARS['id']);
				$t->set_var('ARTIST_REMAINING_ALBUMS',(sizeof($albums_id) - DOK_ALBUMS_ON_ARTIST_PAGE));
				$t->parse('all_albums_block','all_albums');
			} else {
				$albums_display = $albums_id;
				$t->set_var('all_albums_block','');
			}
			$albums = dok_oquery('select a.id, a.name, a.creation, count(s.id) as count, sum(s.length) as length from '.dok_tn('album').' as a left join '.dok_tn('rel_song_album').' as r on a.id=r.album_id left join '.dok_tn('song').' as s on r.song_id=s.id where a.id in ('.implode(',',$albums_display).') group by r.album_id order by a.name');
			while ( $album = $albums->fetch_array() ) {
				$t->set_var(array('ALBUM_LINK' => $_SERVER['PHP_SELF'].'?display=view_album&id='.$album['id'],
						'ALBUM_NAME'   => $album['name'],
						'ALBUM_LENGTH'   => dok_sec2str($album['length']),
						'ALBUM_SONGS'   => $album['count'],
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
