<div class="mptitle">artist {ARTIST_NAME}
<!-- BEGIN if_artisteditor -->
<a class="buttonedit" href="{ARTIST_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_artisteditor -->
</div>
Entered in the database on {ARTIST_DB_CREATION}.<P>
<div class="mpsubtitle">
Artist albums:
</div>
<!-- BEGIN artist_albums -->
<A HREF="{ALBUM_LINK}">{ALBUM_NAME}</a> ({ALBUM_DB_CREATION})<BR>
<!-- END artist_albums -->
<P>
<div class="mpsubtitle">
Artist songs:
</div>
<!-- BEGIN artist_songs -->
<A HREF="{SONG_LINK}">{SONG_NAME}</a> {SONG_LENGTH} ({SONG_DB_CREATION})<BR>
<!-- END artist_songs -->

