<?PHP

function dok_edit_song ($VARS,$update_module,$theme_path) {
	global $SONGS_LINKS;
	if ( !$VARS['id'] || !is_numeric($VARS['id']) || $VARS['id']<1 )	{
		$t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_SONG,MSG_UNKNOWN));
	}
	$res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		$t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_SONG,MSG_UNKNOWN));
	}
	$row = mysql_fetch_assoc($res);

	$t = new template($theme_path);
	$t->set_file('page','song_edit.tpl');
	$t->set_var(dok_song_format($row));
	$t->set_var('SONG_ID',$VARS['id']);
	$t->set_var('SONG_NAME_TF',str_replace('"','&quot;',$row['name']));
	$t->set_var('SONG_LENGTH_TF',str_replace('"','&quot;',$row['length']));
	$t->set_var('SONG_RELEASE_TF',str_replace('"','&quot;',$row['release']));
	$t->set_var('SONG_COMMENT_TF',dok_db_2_textarea($row['comment']));
	$t->set_var('SONG_GENRE_SELECT',dok_get_genre_select('genre',$row['genre']));

	$t->set_block('page','artist_remove','artist_remove_block');
	$t->set_block('page','artist','artist_block');
	$t->set_block('page','relation','relation_block');
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
			//echo "parsing ".$a_row['name'].' ( '.$a_row['id'].' )';
			$t->set_var('ALBUM_REMOVE_LINK',$_SERVER['PHP_SELF'].'?update=unlink_song_album&album='.$a_row['id'].'&id='.$row['id']);
                        $t->parse('album_remove_block','album_remove');
                        $t->set_var('ALBUM_NAME',$a_row['name']);
			$t->set_var('ALBUM_TRACK_FORM','<form method=post action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name=update value="song_track"><input type="hidden" name="album_id" value="'.$a_row['id'].'"><input type="hidden" name="song_id" value="'.$row['id'].'">');
	                $t->set_var('ALBUM_TRACK',$a_row['track']);
                        $t->parse('album_block','album','true');
                }
        }
        $t->set_var('ALBUM_ADD_LINK',$_SERVER['PHP_SELF'].'?display=link_song_album&id='.$row['id']);

	$fields = array_keys($row);
	$query = 'select ';
	foreach ( $fields as $field ) {
		$query.=' s1.'.$field.' as s1'.$field.', s2.'.$field.' as s2'.$field.',';
	}
	$query .= 'r.link from '.dok_tn('rel_songs').' as r left join '.dok_tn('song').' as s1 on r.song_id1=s1.id left join '.dok_tn('song').' as s2 on r.song_id2=s2.id where song_id1='.$row['id'].' or song_id2='.$row['id'].' order by link';
	//echo $query;
	$res = mysql_query($query);
	$link = false;
	$relations = array();
	while ( $subrow = mysql_fetch_assoc($res) ) {
		if ( $subrow['s1id'] == $row['id'] ) {
			if ( is_array($SONGS_LINKS[$subrow['link']]) && $SONGS_LINKS[$subrow['link']][0] ) {
				$good_song = 's2';
				$good_link = $subrow['link'].'-'.'2';
			} else {
				unset($good_song);
				unset($good_link);
			}
		} else {
			if ( is_array($SONGS_LINKS[$subrow['link']]) && $SONGS_LINKS[$subrow['link']][1] ) {
				$good_song = 's1';
				$good_link = $subrow['link'].'-'.'1';
			} else {
				unset($good_song);
				unset($good_link);
			}
		}
		if ( isset($good_song) ) {
			$myrow = array();
			foreach ( $fields as $field ) {
				$myrow[$field] = $subrow[$good_song.$field];
			}
			$relations[$good_link] = $myrow;
		}
	}
	if ( sizeof($relations) ) {
		$link_array = dok_songs_links_array();
		foreach ( $relations as $selected => $other_song ) {
			//print_r($other_song);
			$t->set_var('RELATION_FORM','<form method=post action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name=update value="song_links"><input type="hidden" name="linked_song_id" value="'.$other_song['id'].'"><input type="hidden" name="song_id" value="'.$row['id'].'">');
			$sel = '';
			foreach ( $link_array as $key => $val ) {
				$sel.='<option value="'.$key.'"';
				if ( $key == $selected || $key == preg_replace('/-.*$/','',$selected) )	$sel.=' SELECTED';
				$sel.='>'.$val.'</option>'."\n";
			}
			$t->set_var('RELATION_OPTIONS',$sel);
			$t->set_var('RELATION_REMOVE_LINK', $_SERVER['PHP_SELF'].'?update=unlink_song_link&link='.$selected.'&id='.$row['id'].'&other_id='.$other_song['id']);
			$al = $SONGS_LINKS[preg_replace('/-.*$/','',$selected)];
			if ( preg_replace('/^[^-]+-/','',$selected) == 1 )	$t->set_var('RELATION_NAME',$al[1]);
			else							$t->set_var('RELATION_NAME',$al[0]);
			$t->set_var(dok_song_format($other_song));
			$t->parse('relation_block','relation','true');
		}
	} else {
		$t->set_var('relation_block','');
	}
	$t->set_var('RELATION_ADD_LINK',$_SERVER['PHP_SELF'].'?display=link_songs&id='.$row['id'].'&alpha=a');

	return array ($t, sprintf(MSG_TITLE_EDIT_SONG, $row['name']));
}

?>
