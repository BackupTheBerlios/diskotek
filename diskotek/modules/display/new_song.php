<?PHP

function dok_new_song ($VARS,$update_module,$theme_path) {

	$albums = dok_albums_list();
	if( !sizeof($albums) ) {
		$t = dok_error_template(MSG_ERR_NO_ALBUM);
		return array($t, MSG_TITLE_NEW_SONG);
	}
	$artists = dok_artists_list();
	if( !sizeof($artists) ) {
                $t = dok_error_template(MSG_ERR_NO_ARTIST);
                return array($t, MSG_TITLE_NEW_SONG);
        }
	$album_select = '';
	foreach ( $albums as $id => $vars ) {
		$album_select .= '<option value="'.$id.'"';
		if ( $_SESSION['song_select_album'] == $id )	$album_select .= ' selected';
		$album_select .= '>'.$vars['name'].'</option>'."\n";
	}

	$artist_select = '';
	if ( !DOK_USE_HTML4 ) {
	        foreach ( $artists as $id => $vars ) {
	                $artist_select .= '<option value="'.$id.'"';
			if ( $_SESSION['song_select_artist'] == $id )    $artist_select .= ' selected';
			$artist_select .= '>'.$vars['name'].'</option>'."\n";
	        }
	} else {
		$current_letter = '';
		foreach ( $artists as $id => $vars ) {
			$c_letter = substr($vars['name'],0,1);
			if ( $c_letter != $current_letter ) {
				if ( strlen($current_letter) ) {
					$artist_select .= '</optgroup>';
				}
				$artist_select .= '<OPTGROUP label="'.$c_letter.'">';
				$current_letter = $c_letter;
			}
                        $artist_select .= '<option value="'.$id.'"';
                        if ( $_SESSION['song_select_artist'] == $id )    $artist_select .= ' selected';
                        $artist_select .= '>'.$vars['name'].'</option>'."\n";
                }
		if ( strlen($current_letter) )	$artist_select .= '</optgroup>';
	}

	if ( isset($_SESSION['song_select_genre']) && is_numeric($_SESSION['song_select_genre']) && $_SESSION['song_select_genre'] >= 0 ) {
		$genre_select = dok_get_genre_select('genre',$_SESSION['song_select_genre']);
	} else {
		$genre_select = dok_get_genre_select('genre');
	}

	$next_radio = '<input type=radio name="album_track" value="next"';
	if ( $_SESSION['album_track'] != 'text' )	$next_radio.='checked';
	$next_radio.='>';

	$text_radio = '<input type=radio name="album_track" value="text"';
        if ( $_SESSION['album_track'] == 'text' )   $text_radio.='checked';
        $text_radio.='>';

	$t = new template($theme_path);
	$t->set_file('page','song_new.tpl');
	$t->set_var( array( 'ARTISTS_SELECT' => $artist_select,
				'ALBUMS_SELECT' => $album_select,
				'GENRES_SELECT' => $genre_select,
				'TRACK_NEXT_RADIO' => $next_radio,
				'TRACK_TEXT_RADIO' => $text_radio) );
	return array($t,MSG_TITLE_NEW_SONG);

}


?>
