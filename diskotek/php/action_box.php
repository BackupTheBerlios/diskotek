<?PHP

$link_tpl = new template($DOK_THEME_PATH);
$link_tpl->set_file('page','box/links.tpl');
$link_tpl->set_block('page','if_editor','editor_block');
$link_tpl->set_block('page','if_admin','admin_block');
$link_tpl->set_block('page','if_logged','logged_block');

if ( !DOK_ENABLE_USER || $USER->admin ) {
	$link_tpl->parse('admin_block','if_admin');
	$link_tpl->parse('editor_block','if_editor');
	dok_add_tpl_var('LIST_USER',$THEME_LIST_USER);
} elseif ( $USER->editor ) {
	$link_tpl->parse('editor_block','if_editor');
	$link_tpl->set_var('admin_block','');
	dok_add_tpl_var('LIST_USER','');
} else {
	$link_tpl->set_var('admin_block','');
	$link_tpl->set_var('editor_block','');
	dok_add_tpl_var('LIST_USER','');
}

if ( !DOK_ENABLE_USER || $USER->id < 1 ) {
	$link_tpl->set_var('logged_block','');
} else {
	$link_tpl->set_var('USER_ID',$USER->id);
	$link_tpl->parse('logged_block','if_logged');
}

$link_tpl->set_var('DOK',$_SERVER['PHP_SELF']);

dok_add_tpl_var('ACTION_BOX',$link_tpl->parse('out','page'));

?>
