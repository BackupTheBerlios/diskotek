<div class="mptitle">{SONG_NAME}, <span class="titlefont">{SONG_ARTIST}</span> ({SONG_LENGTH})
<!-- BEGIN if_songeditor -->
 <a class="buttonedit" href="{SONG_EDIT_LINK}"><span class="buttonedit">edit</span></a>
<!-- END if_songeditor -->
</div>
<div class="songinfos">
Release date: {SONG_RELEASE}
<BR>
Genre: {SONG_GENRE}
<!-- BEGIN if_label -->
<BR>
<span class="label" style="background-color: {SONG_TAG}">&nbsp;</span> {SONG_LABEL}
<!-- END if_label -->
</div>
<!-- BEGIN pager -->
<div class="pager">
&lt;&lt; <a href="{PAGER_PREV_LINK}">previous song</a><br>{PAGER_PREV_NAME}<br>
<a href="{PAGER_RELATED_LINK}">{PAGER_RELATED_NAME}<br>
&gt;&gt; <a href="{PAGER_NEXT_LINK}">next song</a><br>{PAGER_NEXT_NAME}</div>
<!-- END pager -->
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
