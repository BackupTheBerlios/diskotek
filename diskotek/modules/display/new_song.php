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
        foreach ( $artists as $id => $vars ) {
                $artist_select .= '<option value="'.$id.'"';
		if ( $_SESSION['song_select_artist'] == $id )    $artist_select .= ' selected';
		$artist_select .= '>'.$vars['name'].'</option>'."\n";
        }
	$t = new template($theme_path);
	$t->set_file('page','song_new.tpl');
	$t->set_var( array( 'ARTISTS_SELECT' => $artist_select,
				'ALBUMS_SELECT' => $album_select) );
	return array($t,MSG_TITLE_NEW_SONG);

}


?>
