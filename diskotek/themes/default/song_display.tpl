<div class="mptitle">{SONG_NAME}, <span class="titlefont">by {SONG_ARTIST}</span> ({SONG_LENGTH})
<!-- BEGIN if_songeditor -->
 <a class="buttonedit" href="{SONG_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_songeditor -->

</div>
Release date: {SONG_RELEASE}
<div class="mpsongcomment">{SONG_COMMENT}</div>
<div class="mpsubtitle">
Appearing in albums:
</div>
<!-- BEGIN song_albums -->
<a href="{ALBUM_LINK}">{ALBUM_NAME}</a> (track #{ALBUM_TRACK})<BR>
<!-- END song_albums -->
<P>
<div class="recorded">recorded in database on {SONG_DB_CREATION}</div>
