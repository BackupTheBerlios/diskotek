<?PHP

function dok_list_full ( $VARS, $up, $theme_path ) {
	global $THEME_FULL_LIST_COLUMN;
        $t = new template($theme_path);
        $t->set_file('page','full_list.tpl');
        $t->set_block('page','element_letter','element_letter_block');
	$t->set_block('page','element','element_block');
	$t->set_block('page','next_block','next_block_block');
	$t->set_var('element_letter_block','');
	$t->set_var('next_block_block','');
	if( !isset($VARS['element']) || !in_array($VARS['element'],array('artist','song','album','user')) )    {
                $VARS['element'] = 'song';
        }
	if ( $VARS['element'] == 'album' )	{
		$msg = MSG_NO_ALBUM;
		$element_name = MSG_ALBUMS;
	} elseif ( $VARS['element'] == 'artist' ) {
		$msg = MSG_NO_ARTIST;
		$element_name = MSG_ARTISTS;
	} elseif ( $VARS['element'] == 'user' ) {
		$msg = MSG_NO_USER;
		$element_name = MSG_USERS;
	} else {
		$msg = MSG_NO_SONG;
		$element_name = MSG_SONGS;
	}
	$t->set_var('LIST_ELEMENT_NAME',$element_name);

	$where = '';
	if ( ($VARS['element'] == 'album' || $VARS['element'] == 'song') && isset($VARS['artist_id']) && is_numeric($VARS['artist_id']) && $VARS['artist_id'] > 0 ) {
		$res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist_id']);
		if ( mysql_numrows($res) ) {
			$row = mysql_fetch_array($res);
			$t->set_var('ARTIST_NAME',$row['name']);
			$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF'].'?display=view_artist&id='.$VARS['artist_id']);
			if( $VARS['element'] == 'song' ) {
				$where = 'left join '.dok_tn('rel_song_artist').' as r on a.id=r.song_id where r.artist_id = '.$VARS['artist_id'];
			} else {
				$where = 'left join '.dok_tn('rel_song_album').' as r on a.id=r.album_id left join '.dok_tn('rel_song_artist').' as r2 on r.song_id=r2.song_id  where r2.artist_id = '.$VARS['artist_id'].' group by a.id';
			}
		}
	} else {
		$t->set_var('ARTIST_NAME','');
		$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF']);
	}

	$query = 'select a.id, a.name, substring(a.name from 1 for 1) as letter from '.dok_tn($VARS['element']).' as a '.$where.' order by a.name';
	//echo $query.'<BR>';
	$res = dok_oquery($query);
	//echo mysql_error();
	if ( $res->numrows() ) {
		$letter = false;
		$count = -1;
		$div=1;
		if ( $res->numrows() <= reset($THEME_FULL_LIST_COLUMN) ) {
			$el_per_block = $res->numrows();
			$div = 1;
		} elseif ( $res->numrows() >= end($THEME_FULL_LIST_COLUMN) )  {
			$div =key($THEME_FULL_LIST_COLUMN);
			$el_per_block = ceil($res->numrows() / $div);
		} else {
			$ak = array_keys($THEME_FULL_LIST_COLUMN);
			$i=1;
			foreach ($THEME_FULL_LIST_COLUMN as $key => $val ) {
				if ($res->numrows() >= $val && $res->numrows() <= $THEME_FULL_LIST_COLUMN[$ak[$i]]) {
					$div = $key;
					$el_per_block = ceil($res->numrows() / $key);
					break;
				}
				$i++;
			}
		}
		$t->set_var('BLOCK_PERCENT',((int)(100/$div)));
		//if ( $res->numrows() < $THEME_FULL_LIST_COLUMN[0] && $res->numrows() < $THEME_FULL_LIST_COLUMN[0]
		//$el_per_block = ceil($res->numrows() /3);
		while ( $row = $res->fetch_array() ) {
			$count++;
			if ( $count && ! ($count % $el_per_block) ) {
				$t->parse('element_block','next_block','true');
			}
			if ( !$letter || $letter != $row['letter'] ) {
				$letter = $row['letter'];
				$t->set_var('LIST_LETTER',strtoupper($letter));
				$t->parse('element_block','element_letter','true');
			}
			$t->set_var('LIST_LINK',$_SERVER['PHP_SELF'].'?display=view_'.$VARS['element'].'&id='.$row['id']);
	                $t->set_var('LIST_NAME',$row['name']);
	                $t->parse('element_block','element','true');
		}
	} else {
		$t->set_var('element_block',$msg);
	}
	return array($t, $element_name.MSG_TITLE_LIST_FULL);
}


