<?PHP
function dok_edit_artist ($VARS,$update_module,$theme_path) {
        if ( !$VARS['id'] || !is_numeric($VARS['id']) || $VARS['id']<1 )        {
                $t = dok_error_template(MSG_ERR_ARTIST_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_ARTIST,MSG_UNKNOWN));
        }
        $res = mysql_query('select * from '.dok_tn('artist').' where id = '.$VARS['id']);
        if ( !mysql_numrows($res) ) {
                $t = dok_error_template(MSG_ERR_ARTIST_NOT_FOUND);
                return array($t, sprintf(MSG_TITLE_EDIT_ARTIST,MSG_UNKNOWN));
        }
        $row = mysql_fetch_array($res);
	$t = new template($theme_path);
	$t->set_file('page','artist_edit.tpl');
	$t->set_var(array(	'ARTIST_ID'=>$row['id'],
				'ARTIST_NAME'=>$row['name'],
				'ARTIST_NAME_TF'=>str_replace( '"','&quot;',$row['name'] ) ));
	return array($t, sprintf(MSG_TITLE_EDIT_ARTIST,$row['name']));
}




?>
