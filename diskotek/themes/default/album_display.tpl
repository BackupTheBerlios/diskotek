<div class="mptitle">Album: {ALBUM_NAME}
<!-- BEGIN if_albumeditor -->
 <a class="buttonedit" href="{ALBUM_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_albumeditor -->
</div>
Total listening time: <B>{ALBUM_LENGTH}</B> in {ALBUM_SONGS} songs.
<div class="mpsubtitle">
Track listing:
</div>
<table border=0>
<tr><td>#</td><td>Artist(s)</td><td>Name</td><td>Length</td></tr>
<!-- BEGIN album_songs -->
<tr><td>{SONG_TRACK}</td>
<td>{SONG_ARTIST}</td><td><i><a href="{SONG_LINK}">{SONG_NAME}</a></i></td><td>{SONG_LENGTH}</td></tr>
<!-- END album_songs -->
</table>
<P>
<div class="recorded">recorded in db on {ALBUM_DB_CREATION}</span>
