<div class="mptitle">
Enter a new song in the database
</div>
<form method=post action="{DOK}">
<input type=hidden name="update" value="create_song">
<table border=0>
<tr><td>Artist name <br>(only one, you can add more artists later)</td>
<td><select name="artist">{ARTISTS_SELECT}</select></td></tr>
<tr><td>Related album<br>If this song appear in more than one album, you can set it later.</td>
<td><select name="album">{ALBUMS_SELECT}</select></td></tr>
<tr><td>track number</td>
<td>

<table border=0><tr><td>{TRACK_NEXT_RADIO} Next album track</td>
<td>{TRACK_TEXT_RADIO} specify track: <input type="text" name="track" size=3>
</td></tr></table>

</td></tr>
<tr><td>Song name (REQUIRED, 255 chars. max)</td>
<td><input type=text name="name" value="" size=25></td></tr>
<tr><td>Song genre:</td>
<td>{GENRES_SELECT}</td></tr>
<tr><td>Song length (in seconds '340' or minutes:seconds '1:45')</td>
<td><input type=text name="length" size=6></td></tr>
<tr><td>Release year (if known, 4-digits year)</td>
<td><input type=text name="release" size=6></td></tr>
<tr><td colspan=2><center>comments on this song<BR>
<textarea name="comment" rows=7 cols=50></textarea>
<tr><td></td><td><input type=submit value="record"></td></tr></table>
</form>
