<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=isset($_REQUEST['raion'])?isset($_REQUEST['raion']):0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;
$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;

$scrol=isset($_REQUEST['scrol'])?$_REQUEST['scrol']:0;
$fname=isset($_REQUEST['fname'])?$_REQUEST['fname']:"";
$groups_obr=isset($_REQUEST['groups_obr'])?$_REQUEST['groups_obr']:0;
$actual=isset($_REQUEST['actual'])?"1":"0";
$time=isset($_REQUEST['time'])?$_REQUEST['time']:0;
$order=isset($_REQUEST['order'])?$_REQUEST['order']:0;
$f1=isset($_REQUEST['f1'])?$_REQUEST['f1']:"";
$f2=isset($_REQUEST['f2'])?$_REQUEST['f2']:0;
$pre_include="../..";



include($pre_include."/inc/head.php");
echo "<link rel=\"stylesheet\" href=\"/css/styles_info.css\" type=\"text/css\">\n";
echo "</head>\n";
include($pre_include."/inc/body.php");
include_once($pre_include."/loginI.php");
switch ($action)
{
	case 4:
	$sql="insert into types_obr (full_name,group_id,zatrat,actual,orders,name) values('{$fname}',{$groups_obr},{$time},'{$actual}',{$order},'')";
	$result=mysqli_query($dbI,$sql)	or die("insert failed : " . mysqli_error());
	break;
	case 5:
	$sql="update types_obr set full_name='{$fname}', group_id={$groups_obr}, zatrat={$time}, actual='{$actual}', orders={$order} where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("update failed : " . mysqli_error());
	break;
	case 6:
	$sql="delete from types_obr where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("delete failed : " . mysqli_error());
	break;
}
$str_title="Администрирование ПК \"Клиент ПФР\"<br>Справочник тем обращений";
$show_home=true;
include("adm_header.php");

echo "<div class=\"container-fluid content\">\n";
$sql="select tob.id,tob.full_name,tob.group_id,tob.zatrat,tob.actual,tob.orders,tob.color, gto.full_name from types_obr tob left join group_types_obr gto on gto.id=tob.group_id ".($f1!=''?" where tob.full_name like('%{$f1}%')":"").($f2!=0?($f1!=''?" and group_id={$f2}":" where group_id={$f2}"):"")." order by group_id,orders";
$result=mysqli_query($dbI,$sql)	or die("Query 1 failed : " . mysqli_error());
$selector="";


if ($action==1 || $action==3 || $action==102)
{
$sql="select * from group_types_obr order by id";
$result2=mysqli_query($dbI,$sql)	or die("Query 2 failed : " . mysqli_error());
$sel=-1;

if ($action==1)
{
 $sql="select group_id from types_obr where id=".$id;
 $result3=mysqli_query($dbI,$sql)	or die("Query 3 failed : " . mysqli_error());
 if (mysqli_num_rows($result3)>0)
 {
  $t_sql=mysqli_fetch_row($result3);
  $sel=$action!=102?$t_sql[0]:$f2;	
 }
 mysqli_free_result($result3);
}

$selector="<select name=\"".($action!=102?"groups_obr":"f2")."\" id=\"".($action!=102?"groups_obr":"f2")."\" class=\"form-control\">\n";
$og=-1;
while($tab_sql=mysqli_fetch_row($result2)) 
{ 
 $selector=$selector."<option value=\"".($tab_sql[0])."\" ".($sel==$tab_sql[0]?"selected=\"selected\"":"")." >".$tab_sql[1]."</option>\n";
}
 $selector=$selector."</select>\n";
mysqli_free_result($result2);
}



echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\" class=\"form\" id=\"raion_form\">\n";
echo "<table class=\"table table-striped table-bordered\">\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th width=\"5%\">ID</th>\n";
echo "<th  width=\"40%\">Наименование";
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
echo "<th width=\"30%\">Группа";
if ($action!=102)
{
 if ($f2!=0)	
 {
	echo "&nbsp;<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"clickForm(102,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
 }
 else
 {
	echo "&nbsp;<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(102,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
 }
echo "<input type=\"hidden\" name=\"f2\" id=\"f2\" value=\"{$f2}\">\n"; 
}
else
{
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(-102,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
	echo $selector;
}
echo "</th>\n";
echo "<th width=\"5%\">Время</th>\n";
echo "<th width=\"5%\">Актуально</th>\n";
echo "<th  width=\"5%\">Порядок</th>\n";
echo "<th  width=\"10%\">Действие</th>\n";
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
		echo "<td>".$selector."</td>\n";
		echo "<td><input class=\"form-control\" name=\"time\" id=\"time\" value=\"".$R[3]."\"></td>\n";
		echo "<td><input type=\"checkbox\" ".($R[4]==1?"checked":"")." name=\"actual\" id=\"actual\" class=\"form-control checkbox\"/><label for=\"actual\"></label></td>\n";
		echo "<td><input class=\"form-control\" name=\"order\" id=\"order\" value=\"".$R[5]."\"></td>\n";
	}
	else
	{
		echo "<td>".$R[1]."</td>\n";
		echo "<td>".(isset($R[7])?$R[7]:"Не присвоена")."</td>\n";
		echo "<td>".$R[3]."</td>\n";
		echo "<td>".($R[4]=='1'?"ДА":"НЕТ")."</td>\n";
		echo "<td>".$R[5]."</td>\n";
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
	echo "<td>".$selector."</td>\n";
	echo "<td><input class=\"form-control\" name=\"time\" id=\"time\" value=\"\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"actual\" id=\"actual\" class=\"form-control checkbox\"/><label for=\"actual\"></label></td>\n";
	echo "<td><input class=\"form-control\" name=\"order\" id=\"order\" value=\"0\"></td>\n";
		
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
	return 1;
}

</script>
</body>
</html>