<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<META HTTP-EQUIV="DESCRIPTION" CONTENT="disk'o'tek Homepage">
<META HTTP-EQUIV="KEYWORDS" CONTENT="disk disc management php4 mysql">
<META HTTP-EQUIV="AUTHOR" CONTENT="Dready">
<META NAME="GENERATOR" CONTENT="VI">
<LINK rel="stylesheet" type="text/css" href="{DOK}?display=css">
<TITLE>{TITLE} - My disKoteK</TITLE>
</HEAD>
<BODY>
<div class="sidebar">
<div class="boxitem"><A HREF="{DOK}" class="boxlink">Homepage</a></div>
{LOGIN_STATE}


{ACTION_BOX}

<div class="boxitem">
Lists<BR>
<a class="boxlink" href="{DOK}?display=list_albums">Albums
</a><BR>
<a class="boxlink" href="{DOK}?display=list_artists">Artists
</a><BR>
<a class="boxlink" href="{DOK}?display=list_songs">Songs
</a><br>
{LIST_USER}
</div>

{BOXES}

<div class="boxitem">
<form method="post" action="{DOK}">
Music search:
<input type=hidden name="display" value="search">
<input type=text name="query" size="10">
</form>
</div>

</div>
<div class="main">
{SYSTEM_MESSAGE}
