<div class="mptitle"><!-- BEGIN if_artist -->
{ARTIST_NAME} <!-- END if_artist -->
Albums list
</div>
<div class="mpcontent">
Alphabetic jump: <a href="{DOK}?display=list_albums&alpha=-&artist={ARTIST_ID}">1-9</a> |
<a href="{DOK}?display=list_albums&alpha=a&artist={ARTIST_ID}">a-d</a> |
<a href="{DOK}?display=list_albums&alpha=e&artist={ARTIST_ID}">e-h</a> |
<a href="{DOK}?display=list_albums&alpha=i&artist={ARTIST_ID}">i-l</a> |
<a href="{DOK}?display=list_albums&alpha=m&artist={ARTIST_ID}">m-p</a> |
<a href="{DOK}?display=list_albums&alpha=q&artist={ARTIST_ID}">q-t</a> |
<a href="{DOK}?display=list_albums&alpha=u&artist={ARTIST_ID}">u-z</a> ,
 sort by <a href="{DOK}?display=list_albums&sort=hits&artist={ARTIST_ID}">hits</a> or by <a href="{DOK}?display=list_albums&sort=length&artist={ARTIST_ID}">album total length</a>
</div><P>
<table border=0 cellpadding=0>
<!-- BEGIN album -->
<tr class="list"><td>
<a href="{ALBUM_LINK}">{ALBUM_NAME}</a></td><td> {ALBUM_LENGTH} </td><td> {ALBUM_SONGS} song(s) <!-- BEGIN if_artist_2 -->
({ARTIST_SONG_NB} from {ARTIST_NAME})<!-- END if_artist_2 --></td><td> {ALBUM_HITS} hits
</td></tr>
<!-- END album -->
</table>
<!-- BEGIN next_page -->
<P><div class="mpcontent"><a href="{NEXT_PAGE_LINK}" class="mplink">&gt;&gt; next page</a></div>
<!-- END next_page -->
<div class="fulllist">
<a class="mplink" href="{DOK}?display=list_full&element=album&artist_id={ARTIST_ID}">&gt;&gt; full listing</a>
</div>
