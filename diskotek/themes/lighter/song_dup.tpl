<div class="mptitle">{TITLE}</div>
It seems that the database already knows one or several songs with the title "{NEW_SONG_NAME}". Of course, you can enter distinct songs with the same name, but this page is here to let you check if the song you post is REALLY a new song.
<div class="mpsubtitle">New song informations</div>
<table width="100%"><tr><td>
Name: {NEW_SONG_NAME}<BR></td><td>
Artist: {NEW_SONG_ARTIST}<BR></TD></TR><tr><td>
Album: {NEW_SONG_ALBUM}<BR></td><td>
Album track: {NEW_SONG_TRACK}<BR></td></tr><tr><td>
Length: {NEW_SONG_LENGTH}<BR></td><td>
Label: {NEW_SONG_LABEL}</td></tr><tr><td>
Comments: {NEW_SONG_COMMENT}<BR></td><td>
Release year: {NEW_SONG_RELEASE}</td></tr></table><BR>
<div class="mpsubtitle">Songs having already the same name, in the database
</div>
{SONG_RECORD_FORM}
<!-- BEGIN duplicate -->
<A HREF="{SONG_LINK}" target="_blank">{SONG_NAME}</a>, {SONG_ARTIST}, released on year {SONG_RELEASE}. duration {SONG_LENGTH}, genre {SONG_GENRE}.
<div class="mpsongcomment">{SONG_COMMENT}</div>
special relation type: {SONG_RELATION_SELECT}<P>
<!-- END duplicate -->
<P>
Please click on the following button if you still want to record your song in the database:

<center><input type=submit value="Record my new song"></center>
</form>
