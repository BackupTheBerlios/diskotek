<?PHP


function dok_box_ranked($display_module, $theme_path) {
	$res = mysql_query('select name, id from '.dok_tn('song').' order by hits desc limit 10');
	echo mysql_error();
	if ( !mysql_numrows($res) ) {
		return ;
	}
	$t = new template ($theme_path);
	$t->set_file('page','box_default.tpl');
	$t->set_var('BOXTITLE',MSG_TITLE_BOX_RANKED_SONG);
	$t->set_block('page','boxlink','boxlinktag');
	$t->set_var('boxlinktag','');
	if ( !mysql_numrows($res) ) {
		$t->set_var('BOXCONTENT','');
	}
	while ( $row = mysql_fetch_array($res) ) {
		$t->set_var('LINK',$_SERVER['PHP_SELF'].'?display=view_song&id='.$row['id']);
		$t->set_var('LABEL',$row['name']);
		$t->parse('BOXCONTENT','boxlink','true');
	}
	return $t->parse('out','page');
}


?>
