<div class="mptitle">edit user {USER_NAME}
</div>
Use this page to update user settings:
<form method=post action="{DOK}">
<input type=hidden name="update" value="update_user">
<input type=hidden name="id" value="{USER_ID}">
<table border=0>
<tr><td>User password: (set it only if you want to update it)</td>
<td><input type=password name="password" value=""></td></tr>
<!-- BEGIN if_admin -->
<tr><td>User name:</td>
<td><input type=text name="name" value="{USER_NAME_TF}"></td></tr>
<tr><td>Edition rights ?</td>
<td>{USER_EDITOR_CB}</td></tr>
<tr><td>Admin rights (includes edition rights) ?</td>
<td>{USER_ADMIN_CB}</td></tr>
<tr><td>User login disabled ?</td>
<td>{USER_DISABLED_CB}</td></tr>
<!-- END if_admin -->
</table>
<input type=submit value="update">
</form>
