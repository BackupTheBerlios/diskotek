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
define ('DOK_ENABLE_USER',false);
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
define ('DOK_THEME_DEFAULT','lighter');
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

// when a new user is created, shake in database for a user with a name that sounds identical
define ('DOK_USE_SOUNDEX', true);

//enable use of extra forms features of HTML 4
define ('DOK_USE_HTML4',true);

// defines root directory of CACHE : if it's not writeable cache is disabled automatically
//define ('DOK_CACHE_PATH','/tmp/diskocache');
define ('DOK_CACHE_PATH','/tmp/cache');
// defines prefix of cache files (you SHOULD have a prefix)
define ('DOK_CACHE_PREFIX','DOK_');

// defines time to live of cache files in seconds
define ('DOK_CACHE_TTL',1800);

// Pager related functions //

// enable/disable pager
define ('DOK_ENABLE_PAGER',true);

/*
*define relations between artists and songs: you could add relations by choosing a unused indice,
*and a clear relation name. Ex: 25 => 'producer', 43 => 'guitarist' ...
*/
$ARTIST_SONG_LINKS = array (	0 => 'by',
				20 => 'featuring ',
				25 => 'produced by ',
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
			8 => array('instrumental','original'),
			9 => array('a capella','original'),
			10 => array('complete version'),
			13 => array('in another style','in another style'));


/*
*song labels are label you can associate to a song ( one label per song)
*in the template 'song_display.tpl' you'll have in the 'if_label' block the templates variables
* {SONG_LABEL} : value of 'label' key
* {SONG_TAG} : value of 'tag' key
* {SONG_TAG2} : value of 'tag2' key
*
* In addition the theme file 'theme.php' should contain a variable $THEME_SONG_LABEL that is a part of line that could
* contain template variables described just before. This parsed will appear as {SONG_LABEL_LINE} in a song display
*/
$SONGS_LABELS = array (	1 => array('label'=>'club bang (R&B)', 'tag' => '#FF0000', 'tag2' => ''),
			2 => array('label'=>'club bang (HipHop)', 'tag' => '#FF0000', 'tag2' => ''),
			3 => array('label'=>'5 stars hiphop beat', 'tag' => '#0000FF', 'tag2' => ''),
			4 => array('label'=>'hot & wet', 'tag' => '#00FF00', 'tag2' => '')
			);
?>
