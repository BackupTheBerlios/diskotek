<?PHP

function dok_update_song() {
	global $VARS, $SONGS_LABELS;
	if ( !isset($VARS['id']) || !is_numeric($VARS['id']) || $VARS['id']<1 ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song','e');
                return false;
	}

	$res = mysql_query('select * from '.dok_tn('song').' where id = '.$VARS['id']);
	if ( !mysql_numrows($res) ) {
		dok_msg(MSG_ERR_SONG_NOT_FOUND_UPDATE,'dok_update_song','e');
                return false;
	}
	$song = mysql_fetch_array($res);

	$set = array();
	$name = ucwords(trim($VARS['name']));
	if ( is_string($name) && strlen($name) && $name != $song['name'] ) {
		if ( !$VARS['dup_checked'] ) {
			//check if name is already known
			$res = dok_oquery('select id from '.dok_tn('song').' where name = \''.addslashes($name).'\' and id != '.$VARS['id']);
			if ( $res->numrows() ) {
				$VARS['duplicates'] = $res->fetch_col_array('id');
				return 'ask_dup_song';
			}
		}
		$set[] = 'name = \''.addslashes($name).'\'';
	}

	$comment = dok_textarea_2_db ( $VARS['comment']);
	if ( $comment != $song['comment'] ) {
		$set[] = 'comment = \''.addslashes($VARS['comment']).'\'';
	}

        if ( !isset($VARS['release']) || !is_numeric($VARS['release']) || $VARS['release']<1901 || $VARS['release'] > 2155 ) {
                $VARS['release'] = 0;
        }
	if( $VARS['release'] != $song['release'] ) {
		$set[] = 'release = '.$VARS['release'];
	}

        $length = 0;
        if ( isset($VARS['length']) ) {
                if ( preg_match('/:/',$VARS['length']) ) {
                        $test = explode(':',$VARS['length']);
                        if ( sizeof($test) > 1 ) {
                                $sec = 0;
                                if ( is_numeric($test[0]) )     $sec = $test[0] * 60;
                                if ( is_numeric($test[1]) )     $sec += $test[1];
                                $length = $sec;
                        }
                } elseif ( is_numeric($VARS['length']) && $VARS['length'] > 0 ) $length = $VARS['length'];
        }
	if ( $length != $song['length'] ) {
		$set[] = 'length = '.$length;
	}

	if ( is_numeric($VARS['genre']) && $VARS['genre'] >= 0 && $VARS['genre'] != $song['genre'] ) {
		$set[] = 'genre = '.$VARS['genre'];
	}

	if ( is_numeric($VARS['label']) && $VARS['label'] != $song['label'] && ( in_array($VARS['label'],array_keys($SONGS_LABELS)) && strlen($SONGS_LABELS[$VARS['label']]['label']) || $VARS['label'] == 0 ) ) {
		$set[] = 'label = '.$VARS['label'];
	}

//	print_r($set);

	if ( sizeof($set) ) {
		$res = dok_uquery('update '.dok_tn('song').' set '.implode(',',$set).' where id = '.$VARS['id']);
	}

	if ( $res ) {
		$VARS['nohit']=1;
		return 'view_song';
	} else {
		dok_msg(MSG_ERR_DB_UPDATE_FAILED,'dok_update_song','e');
		return false;
	}

}

?>
