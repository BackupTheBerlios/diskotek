<?PHP

/*
*
* Disk'o'tek configuration file
*
*
*/

/* MySQL infos */
define ('DOK_MYSQL_HOST','localhost');
define ('DOK_MYSQL_USER','root');
define ('DOK_MYSQL_PASS','');
define ('DOK_MYSQL_DATABASE','diskotek');
define ('DOK_MYSQL_TABLES_PREFIX','dok_');

/*
*set DOK_ENABLE_USER to 'true' if you want multiuser support
*
*to create your first user, first set DOK_ENABLE_USER to 'false', then create the user
*and then set DOK_ENABLE_USER to 'true'
*/
define ('DOK_ENABLE_USER',true);
/*
*folder containing theme folders
*
*/
define ('DOK_THEMES_PATH','themes');
/*
*folder containing language folders
*/
define ('DOK_LANGUAGE_PATH','language');
/*
*default theme (should match theme folder)
*/
define ('DOK_THEME_DEFAULT','default');
/*
*default language (should match language folder)
*/
define ('DOK_LANGUAGE_DEFAULT','eng');
/*
*default module to be called
*/
define ('DOK_DISPLAY_DEFAULT','homepage');
/*
*name of anonymous user
*/
define ('DOK_ANONYMOUS_USER_NAME','Anonymous');
/*
*number of items displayed in a list context
*/
define ('DOK_LIST_EPP',25);

//number of songs to display in 'artist view'
define ('DOK_SONGS_ON_ARTIST_PAGE',15);

// when a new user is created, shake in database for a user with a name that sounds identical
define ('DOK_USE_SOUNDEX', true); 

define ('DOK_USE_HTML4','true');

// defines root directory of CACHE : if it's not writeable cache is disabled automatically
//define ('DOK_CACHE_PATH','/tmp/diskocache');
define ('DOK_CACHE_PATH','/');
// defines prefix of cache files (you SHOULD have a prefix)
define ('DOK_CACHE_PREFIX','DOK_');

// defines time to live of cache files in seconds
define ('DOK_CACHE_TTL',1800);


/*
*define relations between artists and songs: you could add relations by choosing a unused indice,
*and a clear relation name. Ex: 25 => 'producer', 43 => 'guitarist' ...
*/
$ARTIST_SONG_LINKS = array (	0 => 'by',
				20 => 'featuring ',
				30 => 'remix by ');

/*
*define relations between two songs. As relations of song A => song B isn't nessessary the same as relations
*of song B => song A , each indice got two relation: the first to describe song A => song B , the second for the
*reverse (song B => song A)
*Take for example the remix: if song B is the remix of song A, song A isn't the remix of song B, but the original !
*A type of relation where A=>B == B=>A could have been "same title", but Disk'o'tek deals automagically with this relation
*
*to add relations, choose an unused indice and two clear relation names.
*If one of the two relation names is empty, relation won't appear. This other still will
*/
$SONGS_LINKS = array ( 1 => array('same lyrics','same lyrics'),
			4 => array('same beat','same beat'),
			7 => array('remix','original'),
			10 => array('complete version'),
			13 => array('in another style','in another style'));
?>
