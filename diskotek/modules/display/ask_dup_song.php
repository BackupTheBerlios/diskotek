<?PHP


function dok_ask_dup_song ( $VARS, $update, $theme_path ) {
	if ( !is_array($VARS['duplicates']) || !sizeof($VARS['duplicates']) ) {
		$t = dok_error_template(MSG_ERR_NO_DUP_SONG);
                return array($t,sprintf(MSG_TITLE_DUP_SONG,''));
	}
	$t = new template($theme_path);
	$t->set_file('page','song_dup.tpl');
	$t->set_block('page','duplicate','dup_block');
	$query = 'select id, name, length, release, comment from '.dok_tn('song').' where id in('.implode(',',$VARS['duplicates']).')';
	$res = mysql_query($query);
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var(	array(	'SONG_NAME' => $row['name'],
					'SONG_LINK' => $_SERVER['PHP_SELF'].'?display=view_song&id='.$row['id'],
					'SONG_LENGTH' => dok_sec2str($row['length']),
					'SONG_RELEASE' => dok_year2str($row['release']),
					'SONG_COMMENT' => $row['comment'],
					'SONG_ARTIST' => dok_get_artists_string($row['id']) ) );
		$t->parse('dup_block','duplicate','true');
	}
	$res = mysql_query('select name from '.dok_tn('album').' where id = '.$VARS['album']);
	if ( !mysql_numrows($res) )	$album = MSG_UNKNOWN;
	else				$album = mysql_result($res,0,'name');
        $res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist']);
        if ( !mysql_numrows($res) )      $artist = MSG_UNKNOWN;
        else                            $artist = mysql_result($res,0,'name');

	$t->set_var(array(	'NEW_SONG_NAME' => $VARS['name'],
				'NEW_SONG_COMMENT' => dok_textarea_2_db($VARS['comment']),
				'NEW_SONG_TRACK' => $VARS['track'],
				'NEW_SONG_LENGTH' => dok_sec2str($VARS['length']),
				'NEW_SONG_ARTIST' => $artist,
				'NEW_SONG_ALBUM' => $album,
				'NEW_SONG_RELEASE'=> dok_year2str($VARS['release']) ) );
	$yes_form = '<form method="post" action="'.$_SERVER['PHP_SELF'].'"><input type=hidden name="update" value="create_song">';
	$yes_form.= '<input type=hidden name="dup_checked" value="1">';
	$yes_form.= '<input type=hidden name="artist" value="'.$VARS['artist'].'">';
	$yes_form.= '<input type=hidden name="album" value="'.$VARS['album'].'">';
	$yes_form.= '<input type=hidden name="track" value="'.str_replace('"','&quot;',$VARS['track']).'">';
	$yes_form.= '<input type=hidden name="name" value="'.str_replace('"','&quot;',$VARS['name']).'">';
	$yes_form.= '<input type=hidden name="length" value="'.str_replace('"','&quot;',$VARS['length']).'">';
	$yes_form.= '<input type=hidden name="release" value="'.str_replace('"','&quot;',$VARS['release']).'">';
	$yes_form.= '<input type=hidden name="comment" value="'.str_replace('"','&quot;',$VARS['comment']).'">';
	$t->set_var('SONG_RECORD_FORM',$yes_form);
	return array ($t, MSG_TITLE_DUP_SONG);
}

?>