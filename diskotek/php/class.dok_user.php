<?PHP

class dok_user {

	var $id = 0;
	var $name = DOK_ANONYMOUS_USER_NAME;
	var $editor = 0;
	var $admin = 0;
	var $lang = '';
	var $theme = '';

	/**
	*restore a logged user (from PHP session vars)
	*
	*/
	function check_login() {
		$id = $_SESSION['user_id'];
		if ( $id ) {
			$res = mysql_query('select * from '.dok_tn('user').' where id = '.$_SESSION['user_id'].' AND md5(password) = \''.$_SESSION['user_password'].'\'');
			if ( mysql_numrows($res) ) {
				$row = mysql_fetch_array($res);
				$this->name	= $row['name'];
				$this->id	= $row['id'];
				$this->editor	= $row['editor'];
				$this->admin	= $row['admin'];
				$this->lang	= $row['lang'];
				$this->theme	= $row['theme'];
			}
		}
	}

	function login($user, $password) {
		$res = mysql_query('select * from '.dok_tn('user').' where name = \''.addslashes($user).'\' and password = \''.md5($password).'\'');
		if ( mysql_numrows($res) ) {
			$row = mysql_fetch_array($res);
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['user_password'] = $row['password'];
			$this->name     = $row['name'];
                        $this->id       = $row['id'];
                        $this->editor   = $row['editor'];
                        $this->admin    = $row['admin'];
                        $this->lang     = $row['lang'];
                        $this->theme    = $row['theme'];
		}
		return true;
	}

	function logout() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_password']);
		return true;
	}
}




?>
