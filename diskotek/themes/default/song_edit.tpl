<div class="mptitle">
Edit song {SONG_NAME}
</div>
<form method=post action="{DOK}">
<input type=hidden name="update" value="update_song">
<input type="hidden" name="id" value="{SONG_ID}">
<table border=0>
<tr><td>Song name (REQUIRED, 255 chars. max)</td>
<td><input type=text name="name" value="{SONG_NAME_TF}" size=25></td></tr>
<tr><td>Song length (in seconds '340' or minutes:seconds '1:45')</td>
<td><input type=text name="length" value="{SONG_LENGTH_TF}" size=6></td></tr>
<tr><td>Release year (if known, 4-digits year)</td>
<td><input type=text name="release" value="{SONG_RELEASE_TF}" size=6></td></tr>
<tr><td colspan=2><center>comments on this song<BR>
<textarea name="comment" rows=7 cols=50>{SONG_COMMENT_TF}</textarea>
<tr><td></td><td><input type=submit value="update"></td></tr></table>
</form>

<div class="mpsubtitle">
{SONG_NAME} artists
</div>
<a href="{ARTIST_ADD_LINK}"><span class="buttonedit">add an artist</span></a><P>
<!-- BEGIN artist -->
{ARTIST_NAME} <!-- BEGIN artist_remove -->
<a href="{ARTIST_REMOVE_LINK}"><span class="buttonedit">remove</span></a>
<!-- END artist_remove -->

<BR>
<!-- END artist -->

<div class="mpsubtitle">
{SONG_NAME} albums
</div>
<a href="{ALBUM_ADD_LINK}"><span class="buttonedit">add an album</span></a><BR>
<!-- BEGIN album -->
{ALBUM_TRACK_FORM}
<table width=100%><tr><td>
{ALBUM_NAME} <!-- BEGIN album_remove -->
<a href="{ALBUM_REMOVE_LINK}"><span class="buttonedit">remove</a>
<!-- END album_remove -->
</td><td>
<table border=0><tr><td>
Track:</td><td><input type=text size="3" name="track" value="{ALBUM_TRACK}"></td><td><input type=submit value="update track"></td></tr></table>
</td></tr></table>
</form>
<!-- END album -->

