<div class="mptitle">Search results.
</div>
"<i>{SEARCH_QUERY}</i>": {SEARCH_RESULTS} result(s).
<div class="mpsubtitle">songs:</div>
<!-- BEGIN song_result -->
<a href="{SONG_LINK}">{SONG_NAME}</a>, {SONG_ARTIST} ({SONG_LENGTH}) <span class="relevance">Relevance: {SONG_SCORE}</span>
<BR>
<!-- END song_result -->
<div class="mpsubtitle">albums:</div>
<!-- BEGIN album_result -->
<a href="{ALBUM_LINK}">{ALBUM_NAME}</a> <span class="relevance">Relevance: {ALBUM_SCORE}</span>
<BR>
<!-- END album_result -->
<div class="mpsubtitle">artists:</div>
<!-- BEGIN artist_result -->
<a href="{ARTIST_LINK}">{ARTIST_NAME}</a> <span class="relevance">Relevance: {ARTIST_SCORE}</span>
<BR>
<!-- END artist_result -->
<center>
<form method=post action="{DOK}" class="searchform">
<fieldset><legend>Search again</legend>
<input type="hidden" name="display" value="search">
search for <input type="text" name="query" value="{SEARCH_QUERY}">
<BR>
 in <input type=radio name="target" value="song">songs | <input type=radio name="target" value="artist">artists | <input type=radio name="target" value="album">albums | <input type=radio name="target" value="all" checked>all
<BR><input type="submit" value="Search!">
</fieldset>
</form>
</center>

