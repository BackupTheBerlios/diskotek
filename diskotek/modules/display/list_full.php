<?PHP

function dok_list_full ( $VARS, $up, $theme_path ) {
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
	$query = 'select id, name, substring(name from 1 for 1) as letter from '.dok_tn($VARS['element']).' order by name';
	//echo $query;
	$res = dok_oquery($query);

	if ( $res->numrows() ) {
		$letter = false;
		$count = -1;
		$el_per_block = ceil($res->numrows() /3);
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


