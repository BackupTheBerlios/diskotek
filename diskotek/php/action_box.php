<?PHP

$link_tpl = new template($DOK_THEME_PATH);
$link_tpl->set_file('page','box/links.tpl');
$link_tpl->set_block('page','if_editor','editor_block');
$link_tpl->set_block('page','if_admin','admin_block');

if ( !DOK_ENABLE_USER || $USER->admin ) {
	$link_tpl->parse('admin_block','if_admin');
	$link_tpl->parse('editor_block','if_editor');
} elseif ( $USER->editor ) {
	$link_tpl->parse('editor_block','if_editor');
	$link_tpl->set_var('admin_block','');
} else {
	$link_tpl->set_var('admin_block','');
	$link_tpl->set_var('editor_block','');
}

$link_tpl->set_var('DOK',$_SERVER['PHP_SELF']);

dok_add_tpl_var('ACTION_BOX',$link_tpl->parse('out','page'));

?>
