Enter a new song in the database
<P>
<form method=post action="{DOK}">
<table border=0>
<tr><td>Artist name <br>(only one, you can add more artists later)</td>
<td><select name="artist">{ARTISTS_SELECT}</select></td></tr>
<tr><td>Related album<br>If this song appear in more than one album, you can set it later.</td>
<td><select name="album">{ALBUMS_SELECT}</select></td></tr>
<tr><td>track number</td>
<td><input type="text" name="track"></td></tr>
<tr><td>Song name (REQUIRED, 255 chars. max)</td>
<td><input type=text name="name" value=""></td></tr>
<tr><td>Song length (in seconds '340' or minutes:seconds '1:45')</td>
<td><input type=text name="length"></td></tr>

<tr><td></td><td><input type=submit value="record"></td></tr></table>
</form>
