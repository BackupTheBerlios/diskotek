<?PHP

function dok_link_song_artist ($VARS, $update, $theme_path) {
	if ( !is_numeric($VARS['id']) || $VARS['id'] < 1 )        $VARS['id'] = 0;
        $res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_SONG_NOT_FOUND);
                return array($t,MSG_TITLE_ADD_SONG_ARTIST);
        }
	$song = mysql_fetch_array($res);

	$res = dok_oquery('select distinct(artist_id) as aid from '.dok_tn('rel_song_artist').' where song_id = '.$song['id']);
	$current_artists = $res->fetch_col_array('aid');
	$where = '';
	if ( sizeof($current_artists) )	$where = ' where id not in('.implode(',',$current_artists).')';
	$res = mysql_query('select id, name from '.dok_tn('artist').$where.' order by name desc');
	
	$a_select = '';
	while ( $row = mysql_fetch_array($res) ) {
		$a_select.='<option value="'.$row['id'].'"';
		if ( $_SESSION['song_select_artist'] == $row['id'] )    $a_select .= ' selected';
		$a_select.='>'.$row['name'].'</option>';
	}

	$t = new template($theme_path);
	$t->set_file('page','song_artist_link.tpl');
	$t->set_var(dok_song_format($song));
	$t->set_var('ARTIST_SELECT',$a_select);
	$t->set_var('SONG_ID',$song['id']);
	return array($t, MSG_TITLE_ADD_SONG_ARTIST);
}



?>
