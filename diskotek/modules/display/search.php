<?PHP

function dok_search ( $VARS, $update, $theme_path ) {
	$t = new template ($theme_path);
	$t->set_file('page','search.tpl');
	$t->set_block('page','song_result','song_block');
	$t->set_block('page','artist_result','artist_block');
	$t->set_block('page','album_result','album_block');

	$query = mysql_real_escape_string($VARS['query']);
	$query = str_replace(array('%','_'),array('\%','\_'),$query);

	$target = $VARS['target'];

	$total = 0;

	if ( $target != 'album' && $target != 'artist' && $target != 'song' )	$target = 'all';

	if ( $target == 'all' || $target == 'song' ) {
		$matching = dok_search_song($query);
		if ( !sizeof($matching) ) {
			$t->set_var('song_block',MSG_SEARCH_NO_RESULT_SONG);
		} else {
			$total += sizeof($matching);
			foreach ( $matching as $vars ) {
				$t->set_var($vars);
				$t->parse('song_block','song_result','true');
			}
		}
	} else {
		$t->set_var('song_block','');
	}

        if ( $target == 'all' || $target == 'album' ) {
                $matching = dok_search_album($query);
                if ( !sizeof($matching) ) {
                        $t->set_var('album_block',MSG_SEARCH_NO_RESULT_ALBUM);
                } else {
			$total += sizeof($matching);
                        foreach ( $matching as $vars ) {
                                $t->set_var($vars);
                                $t->parse('album_block','album_result','true');
                        }
                }
        } else {
                $t->set_var('album_block','');
        }

        if ( $target == 'all' || $target == 'artist' ) {
                $matching = dok_search_artist($query);
                if ( !sizeof($matching) ) {
                        $t->set_var('artist_block',MSG_SEARCH_NO_RESULT_ARTIST);
                } else {
			$total += sizeof($matching);
                        foreach ( $matching as $vars ) {
                                $t->set_var($vars);
                                $t->parse('artist_block','artist_result','true');
                        }
                }
        } else {
                $t->set_var('artist_block','');
        }
	$t->set_var('SEARCH_RESULTS',$total);
	$t->set_var('SEARCH_QUERY',str_replace('"','&quot;',$VARS['query']));

	return array($t, sprintf(MSG_TITLE_SEARCH,$VARS['query']));
}

function dok_search_song ( $query ) {
	$return = array();
	$sql_query = 'select *, MATCH (name, comment) AGAINST (\''.$query.'\') as score from '.dok_tn('song').' as s where MATCH (name, comment) AGAINST (\''.$query.'\')';
	$res = mysql_query($sql_query);
	while ( $row = mysql_fetch_array($res) ) {
		$vars = dok_song_format($row);
		$vars['SONG_SCORE'] = sprintf('%2f',$row['score']);
		$return[] = $vars;
	}
	return $return ;

}

function dok_search_album ( $query ) {
        $return = array();
        $sql_query = 'select *, MATCH (name) AGAINST (\''.$query.'\') as score from '.dok_tn('album').' as s where MATCH (name) AGAINST (\''.$query.'\')';
        $res = mysql_query($sql_query);
        while ( $row = mysql_fetch_array($res) ) {
		$vars['ALBUM_NAME'] = $row['name'];
		$vars['ALBUM_LINK'] = $_SERVER['PHP_SELF'].'?display=view_album&id='.$row['id'];
                $vars['ALBUM_SCORE'] = sprintf('%2f',$row['score']);
                $return[] = $vars;
        }
        return $return ;

}

function dok_search_artist ( $query ) {
        $return = array();
        $sql_query = 'select *, MATCH (name) AGAINST (\''.$query.'\') as score from '.dok_tn('artist').' as s where MATCH (name) AGAINST (\''.$query.'\')';
        $res = mysql_query($sql_query);
        while ( $row = mysql_fetch_array($res) ) {
		$vars['ARTIST_NAME'] = $row['name'];
                $vars['ARTIST_LINK'] = $_SERVER['PHP_SELF'].'?display=view_artist&id='.$row['id'];
                $vars['ARTIST_SCORE'] = sprintf('%2f',$row['score']);
                $return[] = $vars;
        }
        return $return ;

}

?>
