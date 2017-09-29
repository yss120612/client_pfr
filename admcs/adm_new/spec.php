<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=isset($_REQUEST['raion'])?isset($_REQUEST['raion']):0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;
$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$scrol=isset($_REQUEST['scrol'])?$_REQUEST['scrol']:0;


$fname=isset($_REQUEST['fname'])?$_REQUEST['fname']:"";
$kab=isset($_REQUEST['kab'])?$_REQUEST['kab']:0;
$priem=isset($_REQUEST['priem'])?"1":"0";
$login=isset($_REQUEST['login'])?$_REQUEST['login']:"";
$password=isset($_REQUEST['password'])?$_REQUEST['password']:"";
$rang=isset($_REQUEST['rang'])?$_REQUEST['rang']:0;
$office=isset($_REQUEST['office'])?$_REQUEST['office']:0;
$reg=isset($_REQUEST['reg'])?$_REQUEST['reg']:0;

$f1=isset($_REQUEST['f1'])?$_REQUEST['f1']:"";
$f2=isset($_REQUEST['f2'])?$_REQUEST['f2']:0;
$f3=isset($_REQUEST['f3'])?$_REQUEST['f3']:0;
$pre_include="../..";



include($pre_include."/inc/head.php");
echo "<link rel=\"stylesheet\" href=\"/css/styles_info.css\" type=\"text/css\">\n";
echo "<script src=\"/js/jquery.validate.min.js\" charset=\"utf-8\"></script>\n";
echo "</head>\n";
include($pre_include."/inc/body.php");
include_once($pre_include."/loginI.php");


switch ($action)
{
	case 4:
	$sql="insert into specialict (FIO,kab,priem,flogin,fpassword,frang,active,reg,office) values('{$fname}',{$kab},'{$priem}','{$login}',PASSWORD('{$password}'),{$rang},'1',{$reg},{$office})";
	$result=mysqli_query($dbI,$sql)	or die("insert failed : " .$sql. mysqli_error());
	break;
	case 5:
	if ($password!='***')
	{
		$sql="update specialict set FIO='{$fname}',kab={$kab},priem='{$priem}',flogin='{$login}',fpassword=PASSWORD('{$password}'),frang={$rang},reg={$reg},office={$office} where id={$id}";
	}
	else
	{
		$sql="update specialict set FIO='{$fname}',kab={$kab},priem='{$priem}',flogin='{$login}',frang={$rang},reg={$reg},office={$office} where id={$id}";	
	}
	$result=mysqli_query($dbI,$sql)	or die("update failed : " . mysqli_error());
	break;
	case 6:
	$sql="delete from specialict where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("delete failed : " . mysqli_error());
	break;
}


$str_title="Администрирование ПК \"Клиент ПФР\"<br>Специалисты КС";
$show_home=true;
include("adm_header.php");

echo "<div class=\"container-fluid content\">\n";

$part='';
if ($f1!='')
{
	$part=" and FIO like('%{$f1}%')";
}
if ($f2!=0)
{
$part=$part." and s.reg={$f2}";
}
if ($f3!=0)
{
$part=$part." and s.office={$f3}";
}



$sql="select s.id,s.FIO,s.kab,s.priem,s.flogin,s.fpassword,s.frang,s.reg,s.office,t.dist_name,t.office_name,r.name
from specialict s 
left join title t on t.office=s.office and t.dist=s.reg 
left join spec_rules r on s.frang=r.rang
where s.id_damask=0 {$part} order by s.reg,s.office,s.kab";
$result=mysqli_query($dbI,$sql)	or die("Query 1 failed : " . mysqli_error());



//формирование комбобокса должностей
$selector1="";
if ($action==1 || $action==3)
{
$sql="select rang,name from spec_rules order by rang";
$result2=mysqli_query($dbI,$sql)	or die("Query 2 failed : " . mysqli_error());
$sel=-1;

if ($action==1)
{
 $sql="select frang from specialict where id=".$id;
 $result3=mysqli_query($dbI,$sql)	or die("Query 3 failed : " . mysqli_error());
 if (mysqli_num_rows($result3)>0)
 {
  $t_sql=mysqli_fetch_row($result3);
  $sel=$t_sql[0];	
 }
 mysqli_free_result($result3);
}

$selector1="<select name=\"rang\"  id=\"rang\" class=\"form-control\">\n";
$og=-1;
while($tab_sql=mysqli_fetch_row($result2)) 
{ 
 $selector1=$selector1."<option value=\"".$tab_sql[0]."\" ".($sel==$tab_sql[0]?"selected=\"selected\"":"").">".$tab_sql[1]."</option>\n";
}
 $selector1=$selector1."</select>\n";
mysqli_free_result($result2);
}



echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\" class=\"form\" id=\"raion_form\">\n";
echo "<table class=\"table table-striped table-bordered\">\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th width=\"5%\">ID</th>\n";
echo "<th  width=\"20%\">ФИО";
if ($action!=101)
{
if ($f1!='')	
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-success\" onclick=\"clickForm(101,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
else
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(101,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
echo "<input type=\"hidden\" name=\"f1\" id=\"f1\" value=\"{$f1}\">\n";
}
else
{
	echo "<input class=\"form-control col-xs-1\" name=\"f1\" id=\"f1\" value=\"{$f1}\"></td>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(-101,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
}
echo "</th>\n";
echo "<th width=\"10%\">Район";
if ($action!=102)
{
if ($f2!=0)	
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-success\" onclick=\"clickForm(102,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
else
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(102,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
echo "<input type=\"hidden\" name=\"f2\" id=\"f2\" value=\"{$f2}\">\n";
}
else
{
	echo "<input class=\"form-control col-xs-1\" name=\"f2\" id=\"f2\" value=\"{$f2}\"></td>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(-102,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
}
echo "</th>\n";
echo "<th width=\"10%\">Офис";
if ($action!=103)
{
if ($f3!=0)	
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-success\" onclick=\"clickForm(103,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
else
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(103,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
echo "<input type=\"hidden\" name=\"f3\" id=\"f3\" value=\"{$f3}\">\n";
}
else
{
	echo "<input class=\"form-control col-xs-1\" name=\"f3\" id=\"f3\" value=\"{$f3}\"></td>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(-103,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
}
echo "</th>\n";

echo "<th width=\"5%\">Кабинка</th>\n";
echo "<th width=\"5%\">Прием</th>\n";
echo "<th  width=\"12%\">Логин</th>\n";
echo "<th  width=\"12%\">Пароль</th>\n";
echo "<th  width=\"12%\">Роль</th>\n";
echo "<th>Действие</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

while ($R=mysqli_fetch_row($result))
{
	if ($id==$R[0])
	{
	 echo "<tr class=\"danger\">\n";
	}
	else
	{
	 echo "<tr>\n";
	}
	
	echo "<td>".$R[0]."</td>\n";
	
	if ($action==1 && $id==$R[0])
	{
		echo "<td><input class=\"form-control\" name=\"fname\" id=\"fname\" value=\"".$R[1]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"reg\" id=\"reg\" value=\"".$R[7]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"office\" id=\"office\" value=\"".$R[8]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"kab\" id=\"kab\" value=\"".$R[2]."\"></td>\n";
		echo "<td><input type=\"checkbox\" ".($R[3]=='1'?"checked":"")." name=\"priem\" id=\"priem\" class=\"form-control checkbox\"/><label for=\"priem\"></label></td>\n";
		echo "<td><input class=\"form-control\" name=\"login\" id=\"login\" value=\"".$R[4]."\"></td>\n";
		echo "<td><input type=\"password\" class=\"form-control\" name=\"password\" id=\"password\" value=\"***\"></td>\n";
		echo "<td>".$selector1."</td>\n";
	}
	else
	{
		echo "<td>".$R[1]."</td>\n";
		echo "<td>".$R[7]."</td>\n";
		echo "<td>".$R[8]."</td>\n";
		echo "<td>".$R[2]."</td>\n";
		echo "<td>".($R[3]=='1'?"ДА":"НЕТ")."</td>\n";
		echo "<td>".$R[4]."</td>\n";
		echo "<td>".((isset($R[5]) && $R[5]!='')?"Установлен":"Не присвоен")."</td>\n";
		echo "<td>".$R[11]."</td>\n";
	}
	
		
	
	
	echo "<td>\n";
	if ($action==1 || $action==2)
	{
	if ($id==$R[0])	
	{
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm\" onclick=\"clickForm(".($action==1?"5":"6").",".$R[0].")\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
	}
	else
	{
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm disabled\"><span class=\"glyphicon glyphicon-paperclip\" aria-hidden=\"true\"></span></button>\n";
	}
	}
	
	if ($action==0 || $action>=100)
	{
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm\" onclick=\"clickForm(1,".$R[0].")\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button>\n";
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm\" onclick=\"clickForm(2,".$R[0].")\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}

if ($action==3)
{
	echo "<tr class=\"danger\">\n";
	echo "<td>+</td>\n";
	echo "<td><input class=\"form-control\" name=\"fname\" id=\"fname\" value=\"\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"reg\" id=\"reg\" value=\"0\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"office\" id=\"office\" value=\"0\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"kab\" id=\"kab\" value=\"0\"></td>\n";
		echo "<td><input type=\"checkbox\" name=\"priem\" id=\"priem\" class=\"form-control checkbox\"/><label for=\"priem\"></label></td>\n";
		echo "<td><input class=\"form-control\" name=\"login\" id=\"login\" value=\"\"></td>\n";
		echo "<td><input type=\"password\" class=\"form-control\" name=\"password\" id=\"password\" value=\"\"></td>\n";
		echo "<td>".$selector1."</td>\n";
	echo "<td>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(4,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
	echo "</td></tr>\n";
}

echo "</tbody></table>\n";
if ($action==0 || $action>=100)
{
	echo "<button type=\"button\" class=\"btn btn-default\" onclick=\"clickForm(3,0)\"><span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span></button>\n";
}

echo "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"0\">\n";
echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"0\">\n";
echo "<input type=\"hidden\" id=\"scrol\" name=\"scrol\" value=\"0\">\n";
echo "</form>\n";
echo "</div>\n";
mysqli_free_result($result);
include("adm_footer.php");
?>

<script type="text/javascript">


function checkForm(a,v)
{
	var send_data={'action':a,'id':v,'raion':$('#reg').val(),'sub_raion':$('#office').val(),'kab':$('#kab').val(),'login':$('#login').val(),'password':$('#password').val()};
	
	$.getJSON('ch_form_spec.php', send_data,function(data) { 
	$.each(data, function(key, val) {   
				 
				if (key=='check')
				{
				if (val!='OK')	
				{
				  alert(val);
				}
				else
				{
				 $("#action").val(a);
				 $("#id").val(v);
				 $("#scrol").val($(window).scrollTop());
				 $("#raion_form").submit();
				}
				}});  
            });
	return 0;
}

$("#raion_form").validate({
			rules: {
				fname:{
					required: true,
					minlength: 2
				},
				login:{
					required: true,
					minlength: 2
				},
				office:{
					required: true,
					number: true,
					min:1,
				},
				kab:{
					required: true,
					number: true,
					min:1,
				},
				reg:{
					required: true,
					number: true,
					min:1,
				},
							
			},
			messages: {
				fname:{
					required: "Введите ФИО",
					minlength: "Имя должно содержать 2 и более букв"
				},
				login: {
					required: "Введите логина",
					minlength: "Логин содержать 2 и более букв"
				},
				office: {
					required: "Номер офиса",
					min: "Дложна быть цифра > 0!",
					number: "Дложна быть цифра от 1!"
				},
				reg: {
					required: "Номер района",
					min: "Дложна быть цифра > 0!",
					number: "Дложна быть цифра от 1!"
				},
				kab: {
					required: "Номер кабинки",
					min: "Дложна быть цифра > 0!",
					number: "Дложна быть цифра от 1!"
				},
				
			}
		});
</script>	
</body>
</html>