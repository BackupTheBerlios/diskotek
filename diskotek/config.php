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

define ('DOK_THEMES_PATH','themes');
define ('DOK_THEME_DEFAULT','default');
define ('DOK_DISPLAY_DEFAULT','homepage');

define ('DOK_LIST_EPP',25);

// when a new user is created, shake in database for a user with a name that sounds identical
define ('DOK_USE_SOUNDEX', true); 

$ARTIST_SONG_LINKS = array (	0 => 'by',
				20 => 'featuring ',
				30 => 'remix by ');
?>
