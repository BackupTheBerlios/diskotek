<div class="mptitle">{TITLE}
</div>
Use the following form to create a new user. If you don't give any special right to this user, he won't be able to create or update songs, artists, albums and user.
<UL><LI>If you set <b>edition rights</b>, this user will be able to add and update songs, artists, albums.
<LI>If you set <b>admin rights</b>, this user will have edition rights plus the right to create and update users.
</UL>
<form method="post" action="{DOK}">
<input type=hidden name="update" value="create_user">
<table border=0>
<tr>
<td>User login (max 255 chars)</td>
<td><input type=text name="name"></td></tr>
<tr>
<td>password (max 255 chars)</td>
<td><input type=password name="password"></td></tr>
<tr>
<td>password (again)</td>
<td><input type=password name="password_again"></td></tr>
<tr>
<td>Edition rights ?</td>
<td><input type=checkbox name="editor" value="1"></td></tr>
<tr>
<td>Admin rights (includes edition rights)?</td>
<td><input type=checkbox name="admin" value="1"></td></tr>

<tr><td></td><td><input type=submit value="create"></td>
</tr></table>
</form>
