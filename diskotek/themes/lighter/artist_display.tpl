<div class="mptitle">Artist: {ARTIST_NAME}
<!-- BEGIN if_artisteditor -->
<span class="mpsongcomment"><a class="buttonedit" href="{ARTIST_EDIT_LINK}">&gt;&gt; edit</a></span>
<!-- END if_artisteditor -->
</div>
<div class="mpsubtitle">
Artist albums:
</div>
<!-- BEGIN artist_albums -->
<A HREF="{ALBUM_LINK}">{ALBUM_NAME}</a> {ALBUM_LENGTH} in {ALBUM_SONGS} songs. ({ALBUM_DB_CREATION})<BR>
<!-- END artist_albums -->
<!-- BEGIN all_albums -->
<A HREF="{ALL_ALBUMS_LINK}" class="mplink">&gt;&gt; View all albums</a> ({ARTIST_ALBUMS} in database)
<!-- END all_albums -->
<P>
<div class="mpsubtitle">
Artist songs:
</div>
<!-- BEGIN artist_songs -->
<A HREF="{SONG_LINK}">{SONG_NAME}</a>  {SONG_LENGTH} ({SONG_ARTIST}) {SONG_LABEL_LINE}<BR>
<!-- END artist_songs -->
<!-- BEGIN all_songs -->
<A HREF="{ALL_SONGS_LINK}" class="mplink">&gt;&gt; View all songs</a> ({ARTIST_SONGS} in database)
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


