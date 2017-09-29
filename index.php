<?php
//session_start();
// здесь сессии не нужны
// session_register пользоваться не желательно !!!!
//session_register("vLogin");
//session_register("vPassword");
//session_register("db");
// print_r($_SESSION);
//phpinfo()
session_start();
header('Content-type: text/html; charset=windows-1251');

include("/inc/head.php");
$err=isset($_SESSION['err'])?$_SESSION['err']:0;

echo "</head>";

include("/inc/body.php");
if ($err>0)
{
	echo "<h3 class=\"text-center\"><span class=\"label label-danger\">Ошибка авторизации. Повторите ввод.</span></h3>";
}
	
?> 

<div style="position: fixed;top: 0;left: 0;width: 100%;height: 100%; text-align:center">
<div class="panel panel-default col-sm-6" style="position:absolute;top:50%;left:30%;margin:-200px 0 0 -200px;">
  <div class="panel-heading"><h3>Авторизация в системе</h3></div>
  <div class="panel-body">
	<form class="form-horizontal" name="submitForm" method="POST" action="main.php">
	<div class="form-group">
    <label for="j_username" class="col-sm-2 control-label">Логин:</label>
    <div class="col-sm-offset-2">
      <input type="text" class="form-control" name="j_username" id="j_username" placeholder="Введите логин">
    </div>
  </div>
  
  <div class="form-group">
    <label for="j_password" class="col-sm-2 control-label">Пароль:</label>
    <div class="col-sm-offset-2">
      <input type="password" class="form-control" name="j_password" id="j_password" placeholder="Введите пароль">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2">
      <button type="submit" class="btn btn-default">Вход</button>
    </div>
  </div>
  
  <div class="form-group">
   <div class="col-sm-4">
   <img src="image/pfr.jpg" width="203" height="52" alt="" border="0">
   </div>
  </div>
  
</form>
</div>
</div>

</div>
</body>
</html>

