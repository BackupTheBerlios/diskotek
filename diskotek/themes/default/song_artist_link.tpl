<div class="mptitle">
Link an artist with song {SONG_NAME}
</div>
Use this form to add artists to this song. You should choose the appropriate artist from the selection list.<P>
<form method=post action="{DOK}">
<input type=hidden name="update" value="update_song_artist_link">
<input type="hidden" name="id" value="{SONG_ID}">
artist: <select name="artist">{ARTIST_SELECT}</select><BR>
<input type=submit value="link">
</form>
