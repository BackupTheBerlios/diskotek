<!-- BEGIN pager -->
<div class="pager">
<a href="{PAGER_PREV_LINK}">previous song</a> ( {PAGER_PREV_NAME} ) 
&lt;&lt; <a href="{PAGER_RELATED_LINK}">{PAGER_RELATED_NAME}</a> songs
&gt;&gt; <a href="{PAGER_NEXT_LINK}">next song</a> ( {PAGER_NEXT_NAME} )
</div>
<!-- END pager -->
<div class="mptitle">{SONG_NAME} <span class="mpsongcomment">{SONG_COMMENT} 
<!-- BEGIN if_songeditor --><a class="buttonedit" href="{SONG_EDIT_LINK}">&gt;&gt; edit this song</a>
<!-- END if_songeditor --></span></div>
<div class="mpsubtitle">{SONG_ARTIST} ({SONG_LENGTH})</div>
<div class="mpcontent">
Release date: {SONG_RELEASE}
<BR>
Genre: {SONG_GENRE}
<!-- BEGIN if_label -->
<BR>
<span class="label" style="background-color: {SONG_TAG}">&nbsp;</span> {SONG_LABEL}
<!-- END if_label -->
</div>
<div class="subtitle">
Appearing in albums:
</div>
<div class="mpcontent">
<!-- BEGIN song_albums -->
<a href="{ALBUM_LINK}">{ALBUM_NAME}</a> (track #{ALBUM_TRACK})<BR>
<!-- END song_albums -->
</div>
<!-- BEGIN if_relation -->
<div class="subtitle">
{SONG_RELATIONS} related songs:
</div>
<!-- BEGIN relation -->
<div class="mpsongrel">{SONG_RELATION}</div>
<div class="mpcontent">
<!-- BEGIN song -->
<a href="{SONG_LINK}">{SONG_NAME}</a>, {SONG_ARTIST} ({SONG_LENGTH})
 <span class="mpsongcomment">{SONG_COMMENT}</span><BR>
<!-- END song -->
</div>
<!-- END relation -->
<!-- END if_relation -->
<P>
<div class="recorded">recorded in database on {SONG_DB_CREATION}</div>
