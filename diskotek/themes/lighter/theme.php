<?PHP

$THEME_DATE = 'd/m/Y h:i';

$THEME_MESSAGE_BEGIN = '<center><div class="sysmsg">System messages:<P>';
$THEME_MESSAGE_SEPARATOR = '<BR>';
$THEME_MESSAGE_END = '</div></center><P></p>';
$THEME_LIST_USER = "<a class=\"boxlink\" href=\"{DOK}?display=list_users\">Users</a><BR>";

/*
*set how columns ( keys ) should be set in full lists view, depending of number of items to display ( values )
* for example array(2=>30,3=>90); will display 1 column for <=30 items to display, 2 columns for 30 to 90 elements to display,
* and 3 columns for more than 90 items
*/
$THEME_FULL_LIST_COLUMN = array(2=>12,3=>90,4=>200,5=>300);

/*
* see config.php for more infos
*/
$THEME_SONG_LABEL = ' ::- {SONG_LABEL} -::';

/*
*number of items displayed in a list context
*/
define ('DOK_LIST_EPP',30);

//number of songs to display in 'artist view'
define ('DOK_SONGS_ON_ARTIST_PAGE',15);

//number of albums to display in 'artist view'
define ('DOK_ALBUMS_ON_ARTIST_PAGE',10);

// set type of pager : 'template' for use own template, 'block' for a phpblock 'pager' , 'tags' for phplib tags
$THEME_PAGER_TYPE='block';

?>
