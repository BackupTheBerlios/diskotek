<?PHP

$pager_where = 'where a.id='.$VARS['pager_related_id'];
$pager_query = 'select r.artist_id, r.song_id, a.name as artist, s.name as song from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('song').' as s on r.song_id = s.id left join '.dok_tn('artist').' as a on r.artist_id = a.id '.$pager_where.' order by s.name';

$pager_res = dok_oquery($pager_query);
if ( $pager_res->numrows() < 2 ) {
	$t=dok_pager_clean($t);
} else {
	$pager_prev='';
	$pager_next='';
	while ( $tmp = $pager_res->fetch_array() ) {
		if ( $tmp['song_id'] == $row['id'] ) {
			if ( $tmp = $pager_res->fetch_array() ) {
				$pager_next = $tmp;
			}
			break;
		}
		$pager_prev=$tmp;
	}
	if ( $pager_prev == '' && $pager_next == '' ) {
		$t=dok_pager_clean($t);
	} else {
		if ( $pager_prev == '' ) {
			$pager_prev = $pager_res->fetch_last_array();
		} 
		if( $pager_next == '' ) {
			$pager_next = $pager_res->fetch_first_array();
		}
		
		$t->set_block('page','pager','pager_block');
		$t->set_var(array ('PAGER_PREV_LINK' => $_SERVER['PHP_SELF'].'?display=view_song&id='.$pager_prev['song_id'].'&pager_related='.$VARS['pager_related'].'&pager_related_id='.$VARS['pager_related_id'],
				'PAGER_PREV_NAME' => $pager_prev['song'],
				'PAGER_NEXT_LINK' => $_SERVER['PHP_SELF'].'?display=view_song&id='.$pager_next['song_id'].'&pager_related='.$VARS['pager_related'].'&pager_related_id='.$VARS['pager_related_id'],
				'PAGER_NEXT_NAME' => $pager_next['song'],
				'PAGER_RELATED_LINK' => $_SERVER['PHP_SELF'].'?display=list_songs&artist='.$pager_next['artist_id'],
				'PAGER_RELATED_NAME' => $pager_next['artist']
				));
		$t->parse('pager_block','pager');
	}
}

?>