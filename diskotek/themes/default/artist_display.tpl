<div class="mptitle">artist {ARTIST_NAME}
<!-- BEGIN if_artisteditor -->
<a class="buttonedit" href="{ARTIST_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_artisteditor -->
</div>
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
<A HREF="{SONG_LINK}">{SONG_NAME}</a>  {SONG_LENGTH} ({SONG_ARTIST})<BR>
<!-- END artist_songs -->
<!-- BEGIN all_songs -->
<A HREF="{ALL_SONGS_LINK}" class="mplink">View all songs</a>
<!-- END all_songs -->
<P>
<div class="mpsubtitle">
related artists:
</div>
<!-- BEGIN related_artists -->
<A HREF="{RELATED_ARTIST_LINK}">{RELATED_ARTIST_NAME}</a>, 
<!-- END related_artists -->
...
<div class="recorded">recorded in the database on {ARTIST_DB_CREATION}.</div>


