<?PHP

class mysql_result {
	var $resultset = array();
	var $offset = 0;
	var $query = '';

	function mysql_result( &$res, $query ) {
		while ( $row = mysql_fetch_array($res,MYSQL_ASSOC) ) {
			$this->resultset[] = $row;
		}
		mysql_free_result($res);
		$this->query = $query;
	}

	function numrows() {
		return sizeof($this->resultset);
	}


	function fetch_array() {
		if ( isset($this->resultset[$this->offset]) )	{
			$this->offset+=1;
			return $this->resultset[($this->offset-1)];
		} else {
			return null;
		}
	}
	
	function fetch_last_array() {
		if ( !sizeof($this->resultset) ) {
			return null;
		}
		return $this->resultset[(sizeof($this->resultset)-1)];
	}
	
	function fetch_first_array() {
		if ( !sizeof($this->resultset) ) {
			return null;
		}
		return $this->resultset[0];
	}
	
	function reset() {
		$this->offset=0;
	}

	function fetch_col_array($value, $key = '') {
		$back = array();
		reset($this->resultset);
		foreach ( $this->resultset as $val ) {
			if ( $key )	$back[$val[$key]] = $val[$value];
			else		$back[]		  = $val[$value];
		}
		return $back;
	}


}



?>
