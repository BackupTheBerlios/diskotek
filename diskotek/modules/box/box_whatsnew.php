<?PHP


function dok_box_whatsnew($display_module, $theme_path) {
	$res = mysql_query('select name, id from '.dok_tn('song').' order by creation desc limit 10');
	echo mysql_error();
	if ( !mysql_numrows($res) ) {
		return ;
	}
	$t = new template ($theme_path);
	$t->set_file('page','box_default.tpl');
	$t->set_var('BOXTITLE',MSG_TITLE_BOX_LAST_SONG);
	$content = '';
	while ( $row = mysql_fetch_array($res) ) {
		$content .= '<a class="boxlink" href="'.$_SERVER['PHP_SELF'].'?display=view_song&id='.$row['id'].'">
		<div class="boxlink">'.$row['name'].'</div></a>';
	}
	$t->set_var('BOXCONTENT',$content);
	return $t->parse('out','page');
}


?>
