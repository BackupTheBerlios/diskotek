<?PHP

function dok_list_users ( $VARS, $up, $theme_path ) {
        $t = new template($theme_path);
        $t->set_file('page','user_list.tpl');
        $t->set_block('page','user','user_block');
	$t->set_block('page','next_page','next_page_block');
	if( !isset($VARS['alpha']) )    {
                $VARS['alpha'] = '-';
        }
        if( !strlen($VARS['offset']) || $VARS['offset'] < 0 )   $VARS['offset'] = '0';
	$VARS['alpha'] = mysql_real_escape_string($VARS['alpha']);
	$query = 'select id, name, editor, admin, disabled, creation, last_login from '.dok_tn('user').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\' order by name limit '.$VARS['offset'].', '.DOK_LIST_EPP;
	$res = dok_oquery($query);
	if ( $res->numrows() ) {
		//$ids = $res->fetch_col_array('id');
		//$n_res = dok_oquery('select album_id, count(*) as c from '.dok_tn('rel_song_album').' where album_id in('.implode(',',$ids).') group by album_id');
		//$n_array = $n_res->fetch_col_array('c','album_id');
		while ( $user = $res->fetch_array() ) {
			if ( $user['admin'] )		$admin = MSG_YES;
			else				$admin = MSG_NO;
			if ( $user['editor'] )		$editor = MSG_YES;
			else				$editor = MSG_NO;
			if ( $user['disabled'] )	$disabled = MSG_YES;
			else				$disabled = MSG_NO;
			if ( $user['last_login'] == 0 )	$last_login = MSG_USER_NEVER_LOGGED;
			else				$last_login = date($THEME_DATE, $user['last_login']);
			$t->set_var('USER_LINK',$_SERVER['PHP_SELF'].'?display=view_user&id='.$user['id']);
	                $t->set_var(array (	'USER_NAME' => $user['name'],
						'USER_DB_CREATION' => date($THEME_DATE, $user['creation']),
						'USER_LAST_LOGIN'  => $last_login,
						'USER_ADMIN'	   => $admin,
						'USER_EDITOR'	   => $editor,
						'USER_DISABLED'	   => $disabled) );
	                $t->parse('user_block','user','true');
		}
		$res = mysql_query('select count(*) as c from '.dok_tn('user').' where substring(name from 1 for 1) >= \''.$VARS['alpha'].'\'');
		$total = mysql_result($res,0,'c');
		if ( $total > ( $VARS['offset'] + DOK_LIST_EPP ) ) {
			$t->set_var('NEXT_PAGE_LINK',$_SERVER['PHP_SELF'].'?display=list_users&alpha='.$VARS['alpha'].'&offset='.($VARS['offset']+DOK_LIST_EPP));
			$t->parse('next_page_block','next_page');
		} else {
			$t->set_var('next_page_block','');
                }
	} else {
		$t->set_var('user_block',MSG_NO_USER);
		$t->set_var('next_page_block','');
	}
	return array($t, MSG_TITLE_LIST_USER);
}


