<?PHP

function dok_list_songs ( $VARS, $up, $theme_path ) {
        $t = new template($theme_path);
        $t->set_file('page','song_list.tpl');
        $t->set_block('page','song','song_block');
	$t->set_block('page','next_page','next_page_block');
	$t->set_block('page','if_artist','if_artist_block');
	if( !isset($VARS['alpha']) )    {
                $VARS['alpha'] = '-';
        }
        if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )   $VARS['offset'] = '0';
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);

	if ( isset($VARS['artist']) && is_numeric($VARS['artist']) && $VARS['artist'] > 0 ) {
		$query = 'select s.* from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('song').' as s on r.song_id = s.id where substring(s.name from 1 for 1) >= \''.$VARS['alpha'].'\' and r.artist_id = '.$VARS['artist'].' order by s.name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
		$total_query = 'select count(*) as c from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('song').' as s on r.song_id = s.id where substring(s.name from 1 for 1) >= \''.$VARS['alpha'].'\' and r.artist_id = '.$VARS['artist'];
		$res = mysql_query('select name from '.dok_tn('artist').' where id = '.$VARS['artist']);
		if ( !mysql_numrows($res) ) {
			$t->set_var('ARTIST_NAME','');
			$t->set_var('ARTIST_LINK','');
			$t->set_var('ARTIST_ID','');
		} else {
			$t->set_var('ARTIST_NAME',mysql_result($res,0,'name'));
			$t->set_var('ARTIST_LINK',$_SERVER['PHP_SELF'].'?display=view_artist&id='.$VARS['artist']);
			$t->set_var('ARTIST_ID',$VARS['artist']);
		}
		$t->parse('if_artist_block','if_artist');
	} else {
		$query = 'select * from '.dok_tn('song').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\' order by name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
		$total_query = 'select count(*) as c from '.dok_tn('song').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\'';
		$t->set_var('if_artist_block','');
		$t->set_var('ARTIST_ID','');
	}
	$res = dok_oquery($query);
	if ( $res->numrows() ) {
		$ids = $res->fetch_col_array('id');
		while ( $row = $res->fetch_array() ) {
			$t->set_var(dok_song_format($row));
	                $t->parse('song_block','song','true');
		}
		$res = mysql_query($total_query);
		$total = mysql_result($res,0,'c');
		if ( $total > ( $VARS['offset'] + DOK_LIST_EPP ) ) {
			$lnk = $_SERVER['PHP_SELF'].'?display=list_songs&alpha='.$VARS['alpha'].'&offset='.($VARS['offset']+DOK_LIST_EPP)
			if ( $t->get_var('ARTIST_ID') ) {
				$lnk .= '&artist='.$t->get_var('ARTIST_ID');
			}
			$t->set_var('NEXT_PAGE_LINK',$lnk);
			$t->parse('next_page_block','next_page');
		} else {
			$t->set_var('next_page_block','');
                }
	} else {
		$t->set_var('song_block',MSG_NO_SONG);
		$t->set_var('next_page_block','');
	}
	return array($t, MSG_TITLE_LIST_ALBUM);
}


