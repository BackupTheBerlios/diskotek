<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<META HTTP-EQUIV="DESCRIPTION" CONTENT="disk'o'tek Homepage">
<META HTTP-EQUIV="KEYWORDS" CONTENT="disk disc management php4 mysql">
<META HTTP-EQUIV="AUTHOR" CONTENT="Dready">
<META NAME="GENERATOR" CONTENT="VI">
<LINK rel="stylesheet" type="text/css" href="style.css">
<TITLE>{TITLE} - My disKoteK</TITLE>
</HEAD>
<BODY>

<div class="top">
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr><td align=left><img src="images/dok.png" border=0></td>
<td align="left" valign="bottom">
<form method="post" action="{DOK}">
Music search:
<input type=hidden name="display" value="search">
<input type=text name="query" size="10"> <input type=submit value="go" class="search">
</form>
</td>
<td align="left" valign="bottom">{LOGIN_STATE}</td>
</tr>
</table>
</div>

<div class="sidebar">
{ACTION_BOX}
<div class="box">
<div class="boxtitle">
Lists
</div>
<div class="boxcontent">
<a class="boxlink" href="{DOK}?display=list_albums">
<div class="boxlink">Albums</div>
</a>
<a class="boxlink" href="{DOK}?display=list_artists">
<div class="boxlink">Artists</div>
</a>
<a class="boxlink" href="{DOK}?display=list_songs">
<div class="boxlink">Songs</div>
</a>
{LIST_USER}
</div>
</div>
{BOXES}

</div>

<div class="mainpage">
{SYSTEM_MESSAGE}
