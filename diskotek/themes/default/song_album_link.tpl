<div class="mptitle">
Link an album with song {SONG_NAME}
</div>
Use this form to make the song appear in a new album tracklisting. You should choose the appropriate album from the selection list, and set the song track number in this album.<P>
<form method=post action="{DOK}">
<input type=hidden name="update" value="update_song_album_link">
<input type="hidden" name="id" value="{SONG_ID}">
album: <select name="album">{ALBUM_SELECT}</select><BR>
Track number: <input type=text size=3 name="track"><BR>
<input type=submit value="link">
</form>
