<?PHP
define ('MSG_ERR_NO_ALBUM','Each song require to be linked to an album. Please create an album before creating songs.');
define ('MSG_ERR_NO_ARTIST','Each song requires to be linked with at least one artist. Please create an artist first.');
define ('MSG_ERR_NO_ARTIST_NAME','data \'artiste name\' missing.');
define ('MSG_ERR_NO_ALBUM_NAME','data \'album name\' missing.');
define ('MSG_ERR_DUP_ALBUM_NAME','The album \'%s\' is already in the database.');
define ('MSG_ERR_DUP_ARTIST_NAME','The artist \'%s\' is already in the database.');
define ('MSG_ERR_ALBUM_DISPLAY','Unable to find the artist you asked for.');
define ('MSG_ERR_ALBUM_NOT_FOUND','Unable to find the album.');
define ('MSG_ERR_ALBUM_TRACK_ASSIGNED','Track %s is already taken in this album');
define ('MSG_ERR_ARTIST_DISPLAY','Unable to find the artist you asked for.');
define ('MSG_ERR_ARTIST_NOT_FOUND','Unable to find artist.');
define ('MSG_ERR_SONG_NO_NAME','Please set song name');
define ('MSG_ERR_SONG_DUP_NAME','the song \'%s\' is already in the database');
define ('MSG_ERR_SONG_TRACK_DUP','the album got already song \'%s\' as song track %s. Change track number.');
define ('MSG_ERR_SONG_DISPLAY','Unable to find the song you asked for.');
define ('MSG_ERR_SONG_NOT_FOUND','Unable to find the song you asked for.');
define ('MSG_ERR_SONG_NOT_FOUND_UPDATE','Unable to update the song you asked for.');
define ('MSG_ERR_NO_TRACK','invalid track number');
define ('MSG_ERR_NO_DUP_SONG','Can\'t find duplicates for this new song');
define ('MSG_ERR_DB_UPDATE_FAILED','Error in database update.');
define ('MSG_ERR_NO_USER_NAME','You didn\'t set user login.');
define ('MSG_ERR_NO_USER_PASSWORD','You didn\'t set user password.');
define ('MSG_ERR_PASSWORD_MISMATCH','You didn\'t entered the same password in the two passwords fields.');
define ('MSG_ERR_USER_NAME_EXISTS','Another user \'%s\' is already known in the database');
define ('MSG_ERR_USER_DISPLAY','Unable to find the user you asked for.');
define ('MSG_ERR_USER_NOT_FOUND','Unable to find user.');
define ('MSG_ERR_USER_EDITION_NOT_ALLOWED','You are not allowed to edit this user settings.');
define ('MSG_ERR_USER_UPDATE_NOT_ALLOWED','You are not allowed to update this user settings.');

define ('MSG_TITLE_NEW_SONG','Enter a new song in the database');
define ('MSG_TITLE_NEW_ARTIST','Enter a new artist');
define ('MSG_TITLE_NEW_ALBUM','Enter a new album');
define ('MSG_TITLE_DISPLAY_ARTIST','artist %s');
define ('MSG_TITLE_DISPLAY_ALBUM','album %s');
define ('MSG_TITLE_DISPLAY_SONG','song %s');
define ('MSG_TITLE_DISPLAY_USER','user %s');
define ('MSG_TITLE_EDIT_SONG','edit song %s');
define ('MSG_TITLE_EDIT_ARTIST','edit artist %s');
define ('MSG_TITLE_EDIT_ALBUM','edit album %s');
define ('MSG_TITLE_DUP_SONG','Check for duplicates');
define ('MSG_TITLE_BOX_LAST_SONG','Last ten songs');
define ('MSG_TITLE_BOX_RANKED_SONG','Most seen');
define ('MSG_TITLE_ADD_SONG_ALBUM','link song to an album');
define ('MSG_TITLE_ADD_SONG_ARTIST','link song to an artist');
define ('MSG_TITLE_LIST_ARTIST','All artists listing');
define ('MSG_TITLE_LIST_ALBUM','All albums listing');
define ('MSG_TITLE_LIST_USER','All users listing');
define ('MSG_TITLE_SOUNDEX_TEST','artists similar names');
define ('MSG_TITLE_SEARCH','Search results: \'%s\'');
define ('MSG_TITLE_NEW_USER','Create a new user');
define ('MSG_TITLE_EDIT_USER','edit user %s ');
define ('MSG_TITLE_LOGIN','Log in');


define ('MSG_SYS_INFO','Information: %s');
define ('MSG_SYS_DEBUG','<font size=-2>%s</font>');
define ('MSG_SYS_ERROR','<font color=red>Error: %s</font>');

define ('MSG_NO_SONG','No song');
define ('MSG_NO_ALBUM','No album');
define ('MSG_NO_ARTIST','No artist');
define ('MSG_NO_USER','No user');
define ('MSG_NO_RELATED_ARTIST','No related artist');
define ('MSG_NO','No');
define ('MSG_YES','Yes');
define ('MSG_MINUTS',':');
define ('MSG_SECONDS','');
define ('MSG_UNKNOWN','unknown');
define ('MSG_LOGIN_NOT_LOGGED','not logged in. [<a href="%s">login</a>]');
define ('MSG_LOGIN_LOGGED','logged in as %s. [<a href="%s">logout</a>]');

define ('MSG_SEARCH_NO_RESULT_SONG','No matching song');
define ('MSG_SEARCH_NO_RESULT_ALBUM','No matching album');
define ('MSG_SEARCH_NO_RESULT_ARTIST','No matching artist');

?>
