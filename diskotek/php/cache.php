<?PHP

$CACHE_RULES = array (
	'list_songs' => array('user'=>0,'artist','alpha','offset'),
	'list_albums' => array('user'=>0,'alpha','offset','sort'),
	'list_artists' => array('user'=>0,'alpha','offset','sort'),
	'view_song' => array('user'=>1,'id'),
	'view_album' => array('user'=>1,'id'),
	'list_full' => array('user'=>0,'element'),
	'view_artist' => array('user'=>1,'id'));


/**
*returns cache name of display $display with HTML variables $VARS
*
* If caching is not possible for this display returns null
*
*@param string $display display wanted
*@param array $vars HTML variables
*@return string cache filename, or null if caching is impossible for this display
*/
function dok_c_filename($display,$VARS) {
	global $CACHE_RULES,$USER,$DOK_THEME;
	if ( !isset($CACHE_RULES[$display]) || !is_array($CACHE_RULES[$display]) )	return null;
	$filename = DOK_CACHE_PREFIX.$display;
	$filename .= 'theme'.$DOK_THEME;
	$cr = $CACHE_RULES[$display];
	if ( isset($cr['user']) ) {
		if ( DOK_ENABLE_USER ) {
			$filename .= 'U'.$USER->id.'_';
		}
		unset($cr['user']);
	}
	foreach ( $cr as $key ) {
		$val=str_replace('/','',$VARS[$key]);
		$val=str_replace('.','',$val);
		$val=str_replace("\\",'',$val);
		$filename.="$key=$val".'_';
	}
	return $filename;
}


/**
*give filename for box caches
*
*@param string $box_name name of the box
*@param string $display display module
*@return string cache filename for this box
*/
function dok_c_box_filename ( $box_name, $display )  {
	global $DOK_THEME;
	$filename = DOK_CACHE_PREFIX.'box_'.$box_name;
	$filename .= '_display'.$display.'_'.$DOK_THEME;
	return $filename;
}

/**
*returns contents of cache file $filename if $filename exists and is still valid,
*in regards to the time to live set in DOK_CACHE_TTL constant (in seconds)
*
*@parma string $filename cache filename
*@return string cahe content if available, or false
*/
function dok_c_get ( $filename ) {
	$filename = DOK_CACHE_PATH.'/'.$filename;

	//if ( !( (filemtime($filename)+DOK_CACHE_TTL) > time() ) )  {
	//	echo "Cache expired ! ";
	//}

	if ( file_exists($filename) && ( (filemtime($filename)+DOK_CACHE_TTL) > time() ) ) {
		return implode(file($filename));
	}
	return false;
}

/**
*writes new cache file
*
*@param string $filename name of the cache file
*@param string $data cached data
*/
function dok_c_write ( $filename, $data ) {
	if ( !is_string($data) )	return;
	$ok = fopen(DOK_CACHE_PATH.'/'.$filename,'w');
	fwrite($ok,$data);
	fclose($ok);
}



/**
*delete all cache files
*
*
*/
function dok_c_delete() {
	$d = dir(DOK_CACHE_PATH);
	while (false !== ($entry = $d->read())) {
		//echo '<BR>'.$entry;
    		if ( is_file(DOK_CACHE_PATH.'/'.$entry) && preg_match('/^'.DOK_CACHE_PREFIX.'/',$entry) ) {
			//echo " delete<BR>";
			if ( ! unlink(DOK_CACHE_PATH.'/'.$entry) ) {
				//echo "failed !! <BR>";
			}
		}
	}
	$d->close();
}

?>