<?PHP

function dok_link_songs ($VARS, $update, $theme_path) {
	if ( !is_numeric($VARS['id']) || $VARS['id'] < 1 )        $VARS['id'] = 0;
        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t,MSG_TITLE_ADD_SONG_ALBUM);
        }
	$song = mysql_fetch_array($res);
	if ( !isset($VARS['alpha']) ) {
		$VARS['alpha'] = ' ';
	}

	if ( !isset($VARS['alpha']) ) {
			$VARS['alpha'] = 'a'; //could change again later with $letters array
	}

/**	$res = dok_oquery('select distinct(album_id) as aid from '.dok_tn('rel_song_album').' where song_id = '.$song['id']);
	$current_albums = $res->fetch_col_array('aid');
	$where = '';
	if ( sizeof($current_albums) )	$where = ' where id not in('.implode(',',$current_albums).')';*/
	$t = new template($theme_path);
	$t->set_file('page','song_song_link.tpl');
	$t->set_block('page','alphalink','alphalink_block');
	$t->set_block('page','song','song_block');
	//make alphalinks
	$letters = dok_letter_array('song');
	if( !sizeof($letters) ) {
		$t->set_var('alphalink_block','');
	} else {
		if ( !isset($VARS['alpha']) ) {
			$VARS['alpha'] = reset($letters);
		}
		foreach( $letters as $letter ) {
			$lnk = $_SERVER['PHP_SELF'].'?display=link_songs&id='.$VARS['id'];
			if ( $VARS['link'] ) {
				$lnk.='&link='.urlencode($VARS['link']);
			}
			$lnk .= '&alpha='.urlencode($letter);
			$t->set_var('ALPHALINK_LINK', $lnk);
			$t->set_var('ALPHALINK_LETTER', $letter);
			$t->parse('alphalink_block','alphalink','true');
		}
	}

	$where = ' where substring(name from 1 for 1) = \''.addslashes($VARS['alpha']).'\' and id != '.$VARS['id'];
	$res = mysql_query('select * from '.dok_tn('song').$where.' order by name');
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var('SONG_CB','<input type=radio name="other_id" value="'.$row['id'].'">');
		$t->set_var(dok_song_format($row));
		$t->parse('song_block','song','true');
	}
	$la = dok_songs_links_array();
	$options = '';
	foreach ( $la as $value => $legend ) {
		$options .= '<option value="'.str_replace('"','&quot;',$value).'">'.$legend.'</option>'."\n";
	}
	$t->set_var('RELATION_OPTIONS',$options);

	$t->set_var(dok_song_format($song));
	$t->set_var('ALBUM_SELECT',$a_select);
	$t->set_var('SONG_ID',$song['id']);
	return array($t, MSG_TITLE_ADD_SONG_LINK);
}



?>
