<div class="mptitle">Album: {ALBUM_NAME}
<!-- BEGIN if_albumeditor -->
 <a class="buttonedit" href="{ALBUM_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_albumeditor -->
</div>
Total listening time: {ALBUM_LENGTH}
<div class="mpsubtitle">
Track listing:
</div>
<!-- BEGIN album_songs -->
{SONG_TRACK}. {SONG_ARTIST} - <i><a href="{SONG_LINK}">{SONG_NAME}</a></i> {SONG_LENGTH}<BR>
<!-- END album_songs -->
<P>
<div class="recorded">recorded in db on {ALBUM_DB_CREATION}</span>
