<div class="mptitle">
Link '{SONG_NAME}' with another song
</div>
<center>First letter: <BR>
<!-- BEGIN alphalink --><a href="{ALPHALINK_LINK}">{ALPHALINK_LETTER}</a><!-- END alphalink -->
</center>
<form method=post action="{DOK}">
<input type=hidden name="update" value="create_song_link">
<input type=hidden name="id" value="{SONG_ID}">
Song:<P>
<!-- BEGIN song -->
<div class="songchoose">
{SONG_CB} <a href="{SONG_LINK}">{SONG_NAME}</A>, {SONG_ARTIST} ({SONG_LENGTH})</div>
<!-- END song -->
<P>
relation type: <select name="link">{RELATION_OPTIONS}</select>
</p>
<p>
<input type=submit value="record">
</form>
