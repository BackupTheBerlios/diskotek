<div class="mptitle">
<!-- BEGIN if_artist -->
{ARTIST_NAME} <!-- END if_artist -->
Songs list
</div>
Alphabetic jump: <a href="{DOK}?display=list_songs&alpha=-&artist={ARTIST_ID}">1-9</a> |
<a href="{DOK}?display=list_songs&alpha=a&artist={ARTIST_ID}">a-d</a> |
<a href="{DOK}?display=list_songs&alpha=e&artist={ARTIST_ID}">e-h</a> |
<a href="{DOK}?display=list_songs&alpha=i&artist={ARTIST_ID}">i-l</a> |
<a href="{DOK}?display=list_songs&alpha=m&artist={ARTIST_ID}">m-p</a> |
<a href="{DOK}?display=list_songs&alpha=q&artist={ARTIST_ID}">q-t</a> |
<a href="{DOK}?display=list_songs&alpha=u&artist={ARTIST_ID}">u-z</a>
<P>
<table border=0 cellpadding=0>
<!-- BEGIN song -->
<tr class="list"><td>
<a href="{SONG_LINK}">{SONG_NAME}</a></td>
<td>{SONG_ARTIST}</td>
<td>{SONG_LENGTH}</td>
<td>{SONG_GENRE}</td><td> {SONG_LABEL_LINE}</td>
</tr>
<!-- END song -->
</table>
<!-- BEGIN next_page -->
<P><a href="{NEXT_PAGE_LINK}" class="mplink">&gt;&gt; next page</a>
<!-- END next_page -->
<div class="fulllist">
<a class="mplink" href="{DOK}?display=list_full&element=song&artist_id={ARTIST_ID}">&gt;&gt; full listing</a>
</div>
