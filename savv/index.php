<?php
//session_start();
// ����� ������ �� �����
// session_register ������������ �� ���������� !!!!
//session_register("vLogin");
//session_register("vPassword");
//session_register("db");
// print_r($_SESSION);
//phpinfo()
header('Content-type: text/html; charset=windows-1251');

include("/inc/head.php");


echo "</head>";

include("/inc/body.php");
?> 


<div class="text-center" style=" position: fixed;top: 0;left: 0;width: 100%;height: 100%; text-align:center">
<div class="panel panel-default col-xs-6 hide">
  <div class="panel-heading">����������� � �������</div>
  <div class="panel-body">

<form >
<div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">�����:</label>
    <div class="col-sm-4">
      <input type="email" class="form-control" id="inputEmail3" placeholder="������� �����">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">������:</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" id="inputPassword3" placeholder="������� ������">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>
</div>
</div>

<div>
<table>
  <tr>
    <td align="center" valign="middle"><table width="280px" border="0" cellpadding="5" cellspacing="1" id="login_form" style="border: 1px solid #000000">
      <tr>
        <th align="center" valign="top" scope="col" bgcolor = #336699><FONT SIZE = 3 COLOR = #FFFFFF>����������� � �������</FONT></th>
      </tr>
      <tr>
        <td align="left" valign="top" style="background: #FAFAFA no-repeat left bottom;">
			<form name="submitForm" method="POST" action="main.php">
			<table cellspacing="0" cellpadding="2" border="0" height="150" valign="top">
				<tr>
					<td><span class="txt"><font size = 3>�����:</font></span>&nbsp;&nbsp;</td> 
					<td><input type="text" name="j_username"  class="txt inpt" style="width:200"/></td>
				</tr>
				<tr>
					<td><span class="txt"><font size = 3>�a����:</font></span>&nbsp;&nbsp;</td> 
					<td><input type="password" name="j_password"  class="txt inpt" style="width:200"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="OK" class="dlgButton"  style="width:70px;height:22px;">
						&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE = "Reset" VALUE = "������" <BR><BR><BR>
						<img src="image/pfr.jpg" width="203" height="52" alt="" border="0">
					</td>
				</tr>
			</table>
			</form>
		</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
</div>
</body>
</html>

