<?PHP


function dok_view_song($VARS, $update, $theme_path) {
	global $THEME_DATE, $USER, $SONGS_LINKS;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id'] < 1 ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_SONG_DISPLAY);
                return array($t,sprintf(MSG_TITLE_DISPLAY_SONG,''));
        }
	$row = mysql_fetch_assoc($res);
	$fields = array_keys($row);
	$t = new template($theme_path);
	$t->set_file('page','song_display.tpl');
	$t->set_block('page','song','song_block');
	$t->set_block('page','relation','relation_block');
	$t->set_block('page','if_relation','if_relation_block');
	$t->set_block('page','if_songeditor','songeditor_block');
	$t->set_block('page','if_label','label_block');

	if ( DOK_ENABLE_USER &&  !$USER->editor && !$USER->admin ) {
                $t->set_var('songeditor_block','');
	} else {
		$t->parse('songeditor_block','if_songeditor');
		$t->set_var('SONG_EDIT_LINK',$_SERVER['PHP_SELF'].'?display=edit_song&id='.$row['id']);
	}

	$t->set_block('page','song_albums','albums_block');
	$query = 'select a.name, a.creation, a.id, r.track from '.dok_tn('rel_song_album').' as r left join '.dok_tn('album').' as a on r.album_id = a.id where r.song_id = '.$VARS['id'].' order by a.name';
	$res = mysql_query($query);
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

	// song relations
	$rel = 0;

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
				$good_link = $SONGS_LINKS[$subrow['link']][0];
			} else {
				unset($good_song);
				unset($good_link);
			}
		} else {
			if ( is_array($SONGS_LINKS[$subrow['link']]) && $SONGS_LINKS[$subrow['link']][1] ) {
				$good_song = 's1';
				$good_link = $SONGS_LINKS[$subrow['link']][1];
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
			$relations[$good_link][] = $myrow;
		}
	}

	$related_ids = array($row['id']);

	if ( sizeof($relations) ) {
		foreach ( $relations as $relation => $songs ) {
			$t->set_var('song_block','');
			$t->set_var('SONG_RELATION',$relation);
			foreach($songs as $song ) {
				$rel++;
				$t->set_var(dok_song_format($song));
				$t->parse('song_block','song','true');
				$related_ids[] = $song['id'];
			}
			$t->parse('relation_block','relation','true');

		}
	}

	//same title
	$res = mysql_query('select * from '.dok_tn('song').' where id not in('.implode(', ',$related_ids).') and name = \''.mysql_real_escape_string($row['name']).'\'');
	if ( mysql_numrows($res) ) {
		$t->set_var('song_block','');
		$t->set_var('SONG_RELATION',MSG_SONG_LINK_SAME_TITLE);
		while ( $dup_row = mysql_fetch_array($res) ) {
			$rel++;
			$t->set_var(dok_song_format($dup_row));
			$t->parse('song_block','song','true');
		}
		$t->parse('relation_block','relation', 'true');
	}

	if ( $rel ) {
		$t->parse('if_relation_block','if_relation');
	} else {
		$t->set_var('if_relation_block','');
	}

	$t->set_var('SONG_RELATIONS',$rel);
	$t->set_var(dok_song_format($row));
	if ( $row['label'] > 0 ) {
		$t->parse('label_block','if_label');
	} else {
		$t->set_var('label_block','');
	}
	
	//pager related
	if ( DOK_ENABLE_PAGER ) {
		global $THEME_PAGER_TYPE;
		if ( isset($VARS['pager_related']) ) {
			if ( $VARS['pager_related'] == 'artist' )	include_once 'php/pager_song_artist.php';
			elseif ( $VARS['pager_related'] == 'album' )	include_once 'php/pager_song_album.php';
			else $t=dok_pager_clean($t);
		} else {
			$t=dok_pager_clean($t);
		}
	} else {
		$t=dok_pager_clean($t);
	}
	
	if ( ! isset($VARS['nohit']) ) $res = mysql_query('update '.dok_tn('song').' set hits = hits + 1 where id = '.$VARS['id']);
	return array($t, sprintf(MSG_TITLE_DISPLAY_SONG,$row['name']));
}


?>
