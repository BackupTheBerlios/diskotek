<?PHP

function dok_get_html_vars() {
	$VARS = array();
	if ( $_SERVER["REQUEST_METHOD"] == 'GET' ) {
	        foreach ( $_GET as $var => $val ) {
	                if ( ini_get('magic_quotes_gpc') && !is_array($val) ) {
	                        $VARS[$var] = stripslashes($val);
	                } else {
	                        $VARS[$var] = $val;
	                }
	        }
	} elseif (  $_SERVER["REQUEST_METHOD"] == 'POST' ) {
	        foreach ( $_POST as $var => $val ) {
	                if ( ini_get('magic_quotes_gpc') && !is_array($val) ) {
	                        $VARS[$var] = stripslashes($val);
	                } else {
	                        $VARS[$var] = $val;
	                }
	        }
	}
	return $VARS;
}

/**
*returns name of mysql table $table_name, prefixed with tables prefix (if any)
*
*@param string $table_name sql table name (without prefix)
*@return string mysql tabke name, prefixed if a prefix was defined in the sonfiguration file
*/
function dok_tn($table_name) {
	return DOK_MYSQL_TABLES_PREFIX.$table_name;
}

/**
*includes all php files contained in path $path, and returns file names (without '.php')
*
*@param string $path path where files are
*@return array all included files names (without '.php')
*/
function dok_module_table($path) {
	$table = array();
	$d = dir($path);
	while (false !== ($entry = $d->read())) {
		if ( preg_match('/(.*)\.php$/',$entry,$regs) ) {
			require_once($path.'/'.$entry);
			$table[] = $regs[1];
		}
	}
	$d->close();
	return $table;
}

/**
*loads only specified module
*
*this function checks for file existence and will return false if file does not exists
*
*@param string $name name of the file to load
*@param string $action module action scope ('display','update' or 'box')
*/
function dok_module_load($name, $action) {
	if ( $action != 'display' && $action != 'update' && $action != 'box' ) {
		echo "Unknown action '$action'.";
		return false;
	}
	$name = preg_replace('/\W/','',$name);
	$file = 'modules/'.$action.'/'.$name.'.php';
	if ( !file_exists($file) )	{
		echo "File does not exists: '$file'.";
		return false;
	}
	require_once($file);
	return true;
}

/**
*add a phplib template variable
*
*@param mixed $var if array, array keys are variable names and array values are variables values. If string value should be set in $val
*@param string $val if set, value of variable name $var
*@param bool $send if true, sends the template vars
*@return mixed true/false or array
*/
function dok_add_tpl_var($var,$val = null,$send = false) {
	static $tplvars = array();
	if ( $send == true )	return $tplvars;
	if ( is_array($var) ) {
		foreach ( $var as $name => $value ) {
			$tplvars[$name] =  $value;
		}
		return true;
	} elseif ( is_string($var) && strlen($var) ) {
		$tplvars[$var] = $val;
		return true;
	}
	return false;
}

/**
*adds a system message
*
*@param string $message message to display
*@param string $sender sender of this message
*@param string $scope could be 'i' (info), 'd' (debug) or 'e' (error)
*/
function dok_msg($message, $sender = 'core', $scope = 'i') {
	global $DOK_SYSTEM_MESSAGES;
	if ( strtolower(substr($scope,0,1)) == 'i' )	$DOK_SYSTEM_MESSAGES['i'][] = $message;
	elseif ( strtolower(substr($scope,0,1)) == 'e' )    $DOK_SYSTEM_MESSAGES['e'][] = $message;
	else						$DOK_SYSTEM_MESSAGES['d'][] = $message;
}

/**
*returns the list of all artists contained in the database
*
*
*@return array keys are artist id, vars is an array ('name','creation')
*/
function dok_artists_list () {
	$back = array();
	$query = 'select id, name, creation from '.dok_tn('artist').' order by name';
	$res = dok_oquery($query);
        while ( $row = $res->fetch_array() ) {
                $back[$row['id']] = array('name'=>$row['name'], 'creation'=>$row['creation']);
        }
        return $back;
}

/**
*returns the list of all albums contained in the database
*
*
*@return array keys are album id, vars is an array ('name','creation')
*/
function dok_albums_list() {
	$back = array();
        $query = 'select id, name, creation from '.dok_tn('album').' order by name';
        $res = dok_oquery($query);
	while ( $row = $res->fetch_array() ) {
		$back[$row['id']] = array('name'=>$row['name'], 'creation'=>$row['creation']);
	}
	return $back;
}

function dok_db_open() {
	$ok = mysql_connect(DOK_MYSQL_HOST,DOK_MYSQL_USER,DOK_MYSQL_PASS);
	if ( !$ok )	{
		echo "Can't create database link... aborting.";
		exit ;
	}
	$ok = mysql_select_db(DOK_MYSQL_DATABASE);
	if ( !$ok ) {
		echo "Can't select database '".DOK_MYSQL_DATABASE."', aborting.";
		exit ;
	}
}

/**
*execute query $query on mysql server, and returns resultset under
*a 'mysql_result' object
*
*only to use with SELECT queries!!
*
*@param string $query query to execute
*@return mysql_result query results
*/
function dok_oquery($query) {
	$res = mysql_query($query);
	if ( !$res )	return false;
	return new mysql_result($res, $query);
}

/**
*returns a temlate object filled with the default error page
*
*@param string $error_message the message to display on the error page
*@return template error template
*/
function dok_error_template($error_message) {
	global $DOK_THEME_PATH;
	$t = new template($DOK_THEME_PATH);
	$t->set_file('page','error.tpl');
	$t->set_var('ERROR_MESSAGE',$error_message);
	return $t;
}

/**
*lookups the songs-artists relation db and fetch infos
*
*@param array $songs if set, only get data for songs id included in $song array
*@param array $artists if set, only get data for artists id included in $artists array
*@return mysql_result a filled mysql_result object
*/
function &dok_rel_song_artist($songs = array(), $artists = array() ) {
	$where = 'where ';
	if ( sizeof($songs) )	{
		$where .= 'r.song_id in ('.implode(',',$songs).')';
	} elseif ( sizeof($artists) ) {
	   $where .= 'r.artist_id in ('.implode(',',$artists).')';
	}
	$query = 'select r.artist_id, r.song_id from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('song').' as s on r.song_id = s.id '.$where.' order by s.hits desc, s.name';
	return dok_oquery($query);
}

/**
*converts seconds into an array with keys 'minut' and 'second'
*
*@param int $seconds seconds to split
*@return array array with keys 'minut' and 'second'
*/
function dok_sec2min ( $seconds ) {
	$min = intval($seconds / 60);
	if ( $min == 0 )	{
		return array('minut'=>0,'second'=>sprintf('%02d',$seconds));
	}
	return array('minut'=>sprintf('%02d',$min),'second'=> sprintf('%02d',($seconds%60)) );
}

/**
*turns a number of seconds into a string 'minuts:seconds'
*
*@param int $seconds number of seconds
*@return string time
*/
function dok_sec2str ( $seconds ) {
	$a = dok_sec2min($seconds);
	$ret = '';
	if ( $a['minut'] == 0 && $a['second'] == 0 )	return MSG_UNKNOWN;
	if ( $a['minut'] > 0 )	$ret=$a['minut'].MSG_MINUTS.$a['second'].MSG_SECONDS;
	else			$ret=$a['second'].MSG_SECONDS;
	return $ret;
}

function dok_str2sec ( $str ) {
	$length = 0;
        if ( isset($str) ) {
                if ( preg_match('/:/',$str) ) {
                        $test = explode(':',$str);
                        if ( sizeof($test) > 1 ) {
                                $sec = 0;
                                if ( is_numeric($test[0]) )     $sec = $test[0] * 60;
                                if ( is_numeric($test[1]) )     $sec += $test[1];
                                $length = $sec;
                        }
                } elseif ( is_numeric($str) && $str > 0 ) $length = $str;
        }
	return $length;
}

/**
*returns the year if set, a string 'year unknown' if not set
*
*@param int $year 
*@return string
*/
function dok_year2str ( $year ) {
	if ( $year == 0 )	return MSG_UNKNOWN;
	return $year;
}

/**
*returns a well formatted string for artists related to a song
*
*
*@param int $song_id id of the song to display artists
*@param int $ignore_artist if set this artist won't appear in the returned string
*@return string formatted artists
*/
function dok_get_artists_string ( $song_id, $ignore_artist = null ) {
	global $ARTIST_SONG_LINKS;
	if ( $ignore_artist > 0 ) {
		$where = ' and a.id != '.$ignore_artist.' ';
	}
	$res = dok_oquery('select a.name,a.id, r.link from '.dok_tn('rel_song_artist').' as r left join '.dok_tn('artist').' as a on r.artist_id = a.id where r.song_id = '.$song_id.' '.$where.' order by r.link, a.name');
	if ( !$res->numrows() )	return MSG_NO_ARTIST;
	$good_nb = array_keys($ARTIST_SONG_LINKS);
	$data = array();
	while ( $row = $res->fetch_array() ) {
		if ( !in_array($row['link'], $good_nb) ) {
			$data[0][$row['id']] = $row['name'];
		} else {
			$data[$row['link']][$row['id']] = $row['name'];
		}
	}
	ksort($data,SORT_NUMERIC);
	$data_index = 0;
	$data_size = sizeof($data);
	foreach ( $data as $link => $artists ) {
		$artists_index = 0;
		$artists_size = sizeof($artists);
		$ret.=$ARTIST_SONG_LINKS[$link].' ';
		foreach ( $artists as $id => $artist ) {
			$ret.='<a href="'.$_SERVER['PHP_SELF'].'?display=view_artist&id='.$id.'">'.$artist.'</a>';
			if ( $artists_index == ( $artists_size -1 ) && $data_index < ($data_size-1) )	$ret.=', ';
			elseif ( $artists_index == ( $artists_size -2 ) )				$ret.=' & ';
			elseif ( $artists_index < ( $artists_size -2 ) )				$ret.=', ';
			$artists_index++;
		}
		$data_index++;
	}
	return trim($ret);
}

function dok_textarea_2_db ($text) {
	$text = htmlentities(trim($text));
	$text = ucfirst(wordwrap($text,75,"<BR>\n",1));
	return $text;
}

function dok_db_2_textarea ($text) {
	return str_replace('<BR>','',$text);
}

/**
*get PHPlib variables for a song
*
*
*/
function dok_song_format ( $data ) {
	global $THEME_DATE;
	$ret = array();
	$ret['SONG_NAME'] = $data['name'];
	$ret['SONG_ID']   = $data['id'];
	$ret['SONG_HITS'] = $data['hits'];
	$ret['SONG_LINK'] = $_SERVER['PHP_SELF'].'?display=view_song&id='.$data['id'];
	$ret['SONG_ARTIST'] = dok_get_artists_string($data['id'], $data['ignore_artist']);
	$ret['SONG_LENGTH'] = dok_sec2str($data['length']);
	$ret['SONG_RELEASE'] = dok_year2str($data['release']);
	$ret['SONG_COMMENT'] = $data['comment'];
	$ret['SONG_DB_CREATION'] = date($THEME_DATE,$data['creation']);
	$ret['SONG_GENRE'] = dok_genre_name($data['genre']);
	return $ret;
}

function dok_get_genre_select ( $varname = 'genre', $selected = null ) {
	global $GENRES;
	$ret = '<select name="'.$varname.'">';
	foreach ( $GENRES as $id => $name ) {
		$ret.='<option value="'.$id.'"';
		if ( $selected !== null && $selected == $id ) {
			$ret.=' selected';
		}
		$ret.='>'.$name.'</option>';
	}
	$ret.= '</select>';
	return $ret;
}

function dok_genre_name($id) {
	global $GENRES;
	return $GENRES[$id];
}

$GENRES =  Array(
'Blues',
'Classic Rock',
'Country',
'Dance',
'Disco',
'Funk',
'Grunge',
'Hip-Hop',
'Jazz',
'Metal',
'New Age',
'Oldies',
'Other',
'Pop',
'R&B',
'Rap',
'Reggae',
'Rock',
'Techno',
'Industrial',
'Alternative',
'Ska',
'Death Metal',
'Pranks',
'Soundtrack',
'Euro-Techno',
'Ambient',
'Trip-Hop',
'Vocal',
'Jazz+Funk',
'Fusion',
'Trance',
'Classical',
'Instrumental',
'Acid',
'House',
'Game',
'Sound Clip',
'Gospel',
'Noise',
'AlternRock',
'Bass',
'Soul',
'Punk',
'Space',
'Meditative',
'Instrumental Pop',
'Instrumental Rock',
'Ethnic',
'Gothic','Darkwave',
'Techno-Industrial',
'Electronic',
'Pop-Folk',
'Eurodance',
'Dream',
'Southern Rock',
'Comedy',
'Cult',
'Gangsta',
'Top 40',
'Christian Rap',
'Pop/Funk',
'Jungle',
'Native American',
'Cabaret',
'New Wave',
'Psychadelic',
'Rave',
'Showtunes',
'Trailer',
'Lo-Fi',
'Tribal',
'Acid Punk',
'Acid Jazz',
'Polka',
'Retro',
'Musical',
'Rock & Roll',
'Hard Rock',
'Folk',
'Folk-Rock',
'National Folk',
'Swing',
'Fast Fusion',
'Bebob',
'Latin',
'Revival',
'Celtic',
'Bluegrass',
'Avantgarde',
'Gothic Rock',
'Progressive Rock',
'Psychedelic Rock',
'Symphonic Rock',
'Slow Rock',
'Big Band',
'Chorus',
'Easy Listening',
'Acoustic',
'Humour',
'Speech',
'Chanson',
'Opera',
'Chamber Music',
'Sonata',
'Symphony',
'Booty Bass',
'Primus',
'Porn Groove',
'Satire',
'Slow Jam',
'Club',
'Tango',
'Samba',
'Folklore',
'Ballad',
'Power Ballad',
'Rhythmic Soul',
'Freestyle',
'Duet',
'Punk Rock',
'Drum Solo',
'Acapella',
'Euro-House',
'Dance Hall'
);


?>
