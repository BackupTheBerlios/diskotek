<?PHP


function dok_view_song($VARS, $update, $theme_path) {
	global $THEME_DATE;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
        $res = mysql_query('select name, creation, length, release, comment from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
	$row = mysql_fetch_array($res);
	$t = new template($theme_path);
	$t->set_file('page','song_display.tpl');
	$t->set_var( array('SONG_NAME'=>$row['name'],
				'SONG_ARTIST' => dok_get_artists_string($VARS['id']),
				'SONG_LENGTH' => dok_sec2str($row['length']),
				'SONG_RELEASE' => dok_year2str($row['release']),
				'SONG_COMMENT' => $row['comment'],
				'SONG_DB_CREATION' => date($THEME_DATE,$row['creation']) ) );
	$t->set_block('page','song_albums','albums_block');
	$res = mysql_query('select a.name, a.creation, a.id, r.track from '.dok_tn('rel_song_album').' as r left join '.dok_tn('album').' as a on r.album_id = a.id where r.song_id = '.$VARS['id'].' order by a.name');
	if ( !mysql_numrows($res) ) {
		$t->set_var('albums_block',MSG_NO_ALBUM);
	} else {
		while ( $a_row = mysql_fetch_array($res) ) {
			$t->set_var( array('ALBUM_LINK' => $_SERVER['PHP_SELF'].'?display=view_album&id='.$a_row['id'],
						'ALBUM_NAME' => $a_row['name'],
						'ALBUM_TRACK' => $a_row['track']) );
			$t->parse('albums_block','song_albums','true');
		}
	}
	return array($t, sprintf(MSG_TITLE_DISPLAY_SONG,$row['name']));
}


?>
