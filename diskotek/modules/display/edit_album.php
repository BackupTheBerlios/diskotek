<?PHP
function dok_edit_album ($VARS,$update_module,$theme_path) {
        if ( !$VARS['id'] || !is_numeric($VARS['id']) || $VARS['id']<1 )        {
                $t = dok_error_template(MSG_ERR_ALBUM_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_ALBUM,MSG_UNKNOWN));
        }
        $res = mysql_query('select * from '.dok_tn('album').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_ALBUM_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_ALBUM,MSG_UNKNOWN));
        }
        $row = mysql_fetch_array($res);
	$t = new template($theme_path);
	$t->set_file('page','album_edit.tpl');
	$t->set_var(array(	'ALBUM_ID'=>$row['id'],
				'ALBUM_NAME'=>$row['name'],
				'ALBUM_NAME_TF'=>str_replace( '"','&quot;',$row['name'] ) ));
	return array($t, sprintf(MSG_TITLE_EDIT_ALBUM,$row['name']));
}




?>
