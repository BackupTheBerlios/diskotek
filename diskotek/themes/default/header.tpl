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
<tr><td align=left><img src="images/dok.png" border=0></td></tr>
</table>
</div>

<div class="sidebar">
<div class="box">
<div class="boxtitle">
Actions
</div>
<div class="boxcontent">
<a class="boxlink" href="{DOK}">
<div class="boxlink">home page</div>
</a>
<a class="boxlink" href="{DOK}?display=new_song">
<div class="boxlink">Add new song</div>
</a>
<a class="boxlink" href="{DOK}?display=new_artist">
<div class="boxlink">Add new artist</div>
</a>
<a class="boxlink" href="{DOK}?display=new_album">
<div class="boxlink">Add new album</div>
</a>
</div>
</div>

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
</div>
</div>
{BOXES}
<div class="box">
<div class="boxtitle">
Search
</div>
<div class="boxcontent">
<center>
<form method="post" action="{DOK}">
<input type=hidden name="display" value="search">
<input type=text name="query" size="10"> <input type="submit" value="search">
</form>
</center>
</div>
</div>


</div>

<div class="mainpage">
{SYSTEM_MESSAGE}
