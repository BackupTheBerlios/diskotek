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
define ('DOK_MYSQL_TABLES_PREFIX','');

define ('DOK_ENABLE_USER',false);

define ('DOK_THEMES_PATH','themes');
define ('DOK_LANGUAGE_PATH','language');

define ('DOK_THEME_DEFAULT','default');
define ('DOK_LANGUAGE_DEFAULT','eng');
define ('DOK_DISPLAY_DEFAULT','homepage');

define ('DOK_ANONYMOUS_USER_NAME','Anonymous');

define ('DOK_LIST_EPP',25);

//number of songs to display in 'artist view'
define ('DOK_SONGS_ON_ARTIST_PAGE',15);

// when a new user is created, shake in database for a user with a name that sounds identical
define ('DOK_USE_SOUNDEX', true); 

$ARTIST_SONG_LINKS = array (	0 => 'by',
				20 => 'featuring ',
				30 => 'remix by ');
?>
