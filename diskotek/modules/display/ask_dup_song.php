<?PHP


function dok_ask_dup_song ( $VARS, $update, $theme_path ) {
	if ( !is_array($VARS['duplicates']) || !sizeof($VARS['duplicates']) ) {
		$t = dok_error_template(MSG_ERR_NO_DUP_SONG);
                return array($t,sprintf(MSG_TITLE_DUP_SONG,''));
	}
	/*
	*find related songs
	*
	*/
	//$res = dok_oquery('select * from '.dok_tn('rel_songs').' where song_id1 = 
	$t = new template($theme_path);
	$t->set_file('page','song_dup.tpl');
	$t->set_block('page','duplicate','dup_block');
	$query = 'select * from '.dok_tn('song').' where id in('.implode(',',$VARS['duplicates']).')';
	$res = mysql_query($query);
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var(dok_song_format($row));
		$t->parse('dup_block','duplicate','true');
	}
	if ( $update == 'create_song' ) {
		$res = mysql_query('select name from '.dok_tn('album').' where id = '.$VARS['album']);
		if ( !mysql_numrows($res) )	$album = MSG_UNKNOWN;
		else				$album = mysql_result($res,0,'name');
		$res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist']);
		if ( !mysql_numrows($res) )      $artist = MSG_UNKNOWN;
		else                            $artist = mysql_result($res,0,'name');

		$t->set_var(array(	'NEW_SONG_NAME' => $VARS['name'],
					'NEW_SONG_COMMENT' => dok_textarea_2_db($VARS['comment']),
					'NEW_SONG_TRACK' => $VARS['track'],
					'NEW_SONG_LENGTH' => $VARS['length'],
					'NEW_SONG_ARTIST' => $artist,
					'NEW_SONG_ALBUM' => $album,
					'NEW_SONG_GENRE' => dok_genre_name($VARS['genre']),
					'NEW_SONG_RELEASE'=> dok_year2str($VARS['release']) ) );
	} else {
		$t->set_var(array(      'NEW_SONG_NAME' => $VARS['name'],
                                        'NEW_SONG_COMMENT' => dok_textarea_2_db($VARS['comment']),
                                        'NEW_SONG_TRACK' => $VARS['track'],
                                        'NEW_SONG_LENGTH' => $VARS['length'],
					'NEW_SONG_GENRE' => dok_genre_name($VARS['genre']),
                                        'NEW_SONG_ARTIST' => '',
                                        'NEW_SONG_ALBUM' => '',
                                        'NEW_SONG_RELEASE'=> dok_year2str($VARS['release']) ) );
	}
	$yes_form = '<form method="post" action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name="update" value="'.$update.'">';
	$yes_form.= '<input type=hidden name="dup_checked" value="1">';
	if ( $update == 'update_song' )	$yes_form.= '<input type=hidden name="id" value="'.$VARS['id'].'">';
	$yes_form.= '<input type=hidden name="artist" value="'.$VARS['artist'].'">';
	$yes_form.= '<input type=hidden name="album" value="'.$VARS['album'].'">';
	$yes_form.= '<input type=hidden name="track" value="'.str_replace('"','&quot;',$VARS['track']).'">';
	$yes_form.= '<input type=hidden name="name" value="'.str_replace('"','&quot;',$VARS['name']).'">';
	$yes_form.= '<input type=hidden name="length" value="'.str_replace('"','&quot;',$VARS['length']).'">';
	$yes_form.= '<input type=hidden name="release" value="'.str_replace('"','&quot;',$VARS['release']).'">';
	$yes_form.= '<input type=hidden name="comment" value="'.str_replace('"','&quot;',$VARS['comment']).'">';
	$yes_form.= '<input type=hidden name="genre" value="'.$VARS['genre'].'">';
	$t->set_var('SONG_RECORD_FORM',$yes_form);
	return array ($t, MSG_TITLE_DUP_SONG);
}

?>
