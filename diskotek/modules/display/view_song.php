<?PHP


function dok_view_song($VARS, $update, $theme_path) {
	global $THEME_DATE;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
        $res = mysql_query('select id, name, creation, length, release, comment, hits, genre from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
	$row = mysql_fetch_array($res);
	$t = new template($theme_path);
	$t->set_file('page','song_display.tpl');
	$t->set_block('page','duplicate','duplicate_block');
	$t->set_block('page','if_duplicate','if_duplicate_block');
	$t->set_block('page','if_songeditor','songeditor_block');

	if ( DOK_ENABLE_USER && ( !$USER->editor || !$USER->admin) ) {
                $t->set_var('songeditor_block','');
	} else {
		$t->parse('songeditor_block','if_songeditor');
		$t->set_var('SONG_EDIT_LINK',$_SERVER['PHP_SELF'].'?display=edit_song&id='.$row['id']);
	}

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

	$res = mysql_query('select * from '.dok_tn('song').' where id != '.$row['id'].' and name = \''.mysql_real_escape_string($row['name']).'\'');
	if ( mysql_numrows($res) ) {
		while ( $dup_row = mysql_fetch_array($res) ) {
			$t->set_var(dok_song_format($dup_row));
			$t->parse('duplicate_block','duplicate','true');
		}
		$t->parse('if_duplicate_block','if_duplicate');
	} else {
		$t->set_var('if_duplicate_block','');
	}
	$t->set_var(dok_song_format($row));
	$res = mysql_query('update '.dok_tn('song').' set hits = hits + 1 where id = '.$VARS['id']);
	return array($t, sprintf(MSG_TITLE_DISPLAY_SONG,$row['name']));
}


?>
