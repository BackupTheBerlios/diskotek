<?
function dok_create_song_link() {
	global $VARS, $GENRES, $USER;
	if ( !isset($VARS['id']) || !strlen(trim($VARS['id'])) || !is_numeric(trim($VARS['id'])) || trim($VARS['id']) < 1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
		return false;
	}

	if ( !isset($VARS['other_id']) || !strlen(trim($VARS['other_id'])) || !is_numeric(trim($VARS['other_id'])) || trim($VARS['other_id']) < 1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
		return false;
	}

	$options = dok_songs_links_array();
	if ( !in_array($VARS['link'],array_keys($options)) ) {
		dok_msg(MSG_ERR_SONG_NO_LINK_NAME,'dok_create_song_link','e');
		return false;
	}

	$VARS['other_id']=trim($VARS['other_id']);
	$VARS['id']=trim($VARS['id']);



	$res = mysql_query('select name from '.dok_tn('song').' where id = '.$VARS['id'].' or id = '.$VARS['other_id']);
	if ( mysql_numrows($res) != 2 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND,'dok_create_song_link','e');
                return false;
	}

	$relation = explode('-',$VARS['link']);
	$query = 'insert into '.dok_tn('rel_songs').' (song_id1, song_id2, link) values (';
	if ( sizeof($relation) == 2 ) {
		if ( $relation[1] )	$query.=$VARS['id'].', '.$VARS['other_id'].', ';
		else			$query.=$VARS['other_id'].', '.$VARS['id'].', ';
		$query.=$relation[0];
	} elseif ( sizeof($relation) == 1 ) {
		$query.=$VARS['id'].', '.$VARS['other_id'].', '.$relation[0];
	} else {
		dok_msg(MSG_ERR_SONG_NO_LINK_NAME,'dok_create_song_link','e');
		return false;
	}
	$query.=')';

	//here I don't use dok_uquery because I delete just before updating
	//	so I will call dok_uquery when updating stuff
	$res = mysql_query('delete from '.dok_tn('rel_songs').' where link = '.$relation[0].' and ( (song_id1 = '.$VARS['id'].' and song_id2 = '.$VARS['other_id'].') OR (song_id1 = '.$VARS['other_id'].' and song_id2 = '.$VARS['id'].') )');
	if ( !$res ) {
		echo mysql_error();
		return false;
	}

	$res = dok_uquery($query);

	//add
	if ( !$res ) {
		echo mysql_error();
		return false;
	}
	return 'view_song';
}


?>
