<div class="mptitle">{SONG_NAME}, <span class="titlefont">{SONG_ARTIST}</span> ({SONG_LENGTH})
<!-- BEGIN if_songeditor -->
 <a class="buttonedit" href="{SONG_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_songeditor -->

</div>
Release date: {SONG_RELEASE}
<BR>
Genre: {SONG_GENRE}
<div class="mpsongcomment">{SONG_COMMENT}</div>
<div class="mpsubtitle">
Appearing in albums:
</div>
<!-- BEGIN song_albums -->
<a href="{ALBUM_LINK}">{ALBUM_NAME}</a> (track #{ALBUM_TRACK})<BR>
<!-- END song_albums -->
<!-- BEGIN if_relation -->
<div class="mpsubtitle">
{SONG_RELATIONS} related songs:
</div>
<!-- BEGIN relation -->
<p>{SONG_RELATION}</p>
<!-- BEGIN song -->
<a href="{SONG_LINK}">{SONG_NAME}</a>, {SONG_ARTIST} ({SONG_LENGTH})<BR>
<div class="mpsongcomment">{SONG_COMMENT}</div>
<!-- END song -->
<!-- END relation -->
<!-- END if_relation -->
<P>
<div class="recorded">recorded in database on {SONG_DB_CREATION}</div>
