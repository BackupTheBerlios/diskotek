<?PHP

function dok_unlink_song_link() {
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

	$relation = explode('-',$VARS['link']);

	$query = 'delete from '.dok_tn('rel_songs').' where link = '.$relation[0].' ';
	if ( sizeof($relation) ) {
		if ( $relation[1] ) {
			$query.= 'AND song_id1='.$VARS['other_id'].' AND song_id2='.$VARS['id'].' ';
		} else {
			$query.= 'AND song_id1='.$VARS['id'].' AND song_id2='.$VARS['other_id'].' ';
		}
	} else {
		if  ( $VARS['id'] <= $VARS['other_id'] ) {
			$query.= 'AND song_id1='.$VARS['id'].' AND song_id2='.$VARS['other_id'].' ';
		} else {
			$query.= 'AND song_id1='.$VARS['other_id'].' AND song_id2='.$VARS['id'].' ';
		}
	}
	$res = dok_uquery($query);
	if ( $res ) {
                return 'view_song';
        } else {
                dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_unlink_song_link','e');
                return false;
        }
}
?>