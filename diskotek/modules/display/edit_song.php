<?PHP

function dok_edit_song ($VARS,$update_module,$theme_path) {
	if ( !$VARS['id'] || !is_numeric($VARS['id']) || $VARS['id']<1 )	{
		$t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_SONG,MSG_UNKNOWN));
	}
	$res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		$t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_SONG,MSG_UNKNOWN));
	}
	$row = mysql_fetch_array($res);

	$t = new template($theme_path);
	$t->set_file('page','song_edit.tpl');
	$t->set_var(dok_song_format($row));
	$t->set_var('SONG_ID',$VARS['id']);
	$t->set_var('SONG_NAME_TF',str_replace('"','&quot;',$row['name']));
	$t->set_var('SONG_LENGTH_TF',str_replace('"','&quot;',$row['length']));
	$t->set_var('SONG_RELEASE_TF',str_replace('"','&quot;',$row['release']));
	$t->set_var('SONG_COMMENT_TF',dok_db_2_textarea($row['comment']));

	$t->set_block('page','artist_remove','artist_remove_block');
	$t->set_block('page','artist','artist_block');
	$res = mysql_query('select a.name, a.id from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where r.song_id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		$t->set_var('artist_block','');
	} elseif ( mysql_numrows($res) == 1 ) {
		$a_row = mysql_fetch_array($res);
		$t->set_var('ARTIST_NAME',$a_row['name']);
		$t->parse('artist_block','artist');
		$t->set_var('artist_remove_block','');
	} else {
		while ( $a_row = mysql_fetch_array($res) ) {
			$t->set_var('ARTIST_REMOVE_LINK',$_SERVER['PHP_SELF'].'?update=unlink_song_artist&artist='.$a_row['id'].'&id='.$row['id']);
                        $t->parse('artist_remove_block','artist_remove');
			$t->set_var('ARTIST_NAME',$a_row['name']);
			$t->parse('artist_block','artist','true');
		}
	}
	$t->set_var('ARTIST_ADD_LINK',$_SERVER['PHP_SELF'].'?display=link_song_artist&id='.$row['id']);

	$t->set_block('page','album_remove','album_remove_block');
        $t->set_block('page','album','album_block');
        $res = mysql_query('select a.name, a.id, r.track from '.dok_tn('rel_song_album').' as r left join '.dok_tn('album').' as a on r.album_id = a.id where r.song_id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t->set_var('album_block','');
        } elseif ( mysql_numrows($res) == 1 ) {
                $a_row = mysql_fetch_array($res);
                $t->set_var('ALBUM_NAME',$a_row['name']);
		$t->set_var('ALBUM_TRACK_FORM','<form method=post action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name=update value="song_track"><input type="hidden" name="album_id" value="'.$a_row['id'].'"><input type="hidden" name="song_id" value="'.$row['id'].'">');
		$t->set_var('ALBUM_TRACK',$a_row['track']);
                $t->parse('album_block','album');
                $t->set_var('album_remove_block','');
        } else {
                while ( $a_row = mysql_fetch_array($res) ) {
			echo "parsing ".$a_row['name'].' ( '.$a_row['id'].' )';
			$t->set_var('ALBUM_REMOVE_LINK',$_SERVER['PHP_SELF'].'?update=unlink_song_album&album='.$a_row['id'].'&id='.$row['id']);
                        $t->parse('album_remove_block','album_remove');
                        $t->set_var('ALBUM_NAME',$a_row['name']);
			$t->set_var('ALBUM_TRACK_FORM','<form method=post action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name=update value="song_track"><input type="hidden" name="album_id" value="'.$a_row['id'].'"><input type="hidden" name="song_id" value="'.$row['id'].'">');
	                $t->set_var('ALBUM_TRACK',$a_row['track']);
                        $t->parse('album_block','album','true');
                }
        }
        $t->set_var('ALBUM_ADD_LINK',$_SERVER['PHP_SELF'].'?display=link_song_album&id='.$row['id']);




	return array ($t, sprintf(MSG_TITLE_EDIT_SONG, $row['name']));
}




?>
