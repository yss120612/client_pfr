<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=isset($_REQUEST['raion'])?isset($_REQUEST['raion']):0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;
$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
$scrol=isset($_REQUEST['scrol'])?$_REQUEST['scrol']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$fname=isset($_REQUEST['fname'])?$_REQUEST['fname']:"";
$f1=isset($_REQUEST['f1'])?$_REQUEST['f1']:"";
$pre_include="../..";



include($pre_include."/inc/head.php");
echo "<link rel=\"stylesheet\" href=\"/css/styles_info.css\" type=\"text/css\">\n";
echo "</head>\n";
include($pre_include."/inc/body.php");
include_once($pre_include."/loginI.php");
switch ($action)
{
	case 4:
	$sql="insert into group_types_obr (full_name) values('{$fname}')";
	$result=mysqli_query($dbI,$sql)	or die("insert failed : " . mysqli_error());
	break;
	case 5:
	$sql="update group_types_obr set full_name='{$fname}' where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("update failed : " . mysqli_error());
	break;
	case 6:
	$sql="delete from group_types_obr where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("delete failed : " . mysqli_error());
	break;
}
$str_title="Администрирование ПК \"Клиент ПФР\"<br>Справочник групп тем обращений";
$show_home=true;
include("adm_header.php");

echo "<div class=\"container-fluid content\">\n";
$sql="select * from group_types_obr".($f1!=''?" where full_name like('%{$f1}%')":""). " order by id";
$result=mysqli_query($dbI,$sql)	or die("Query failed : " . mysqli_error());
echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\" class=\"form\" id=\"raion_form\">\n";
echo "<table class=\"table table-bordered\">\n";
echo "<tr>\n";
echo "<th width=\"10%\">ID</th>\n";
echo "<th  width=\"80%\">Наименование";
if ($action!=101)
{
if ($f1!='')	
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"clickForm(101,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
else
{
	echo "&nbsp;<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(101,0)\"><span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span></button>\n";
}
echo "<input type=\"hidden\" name=\"f1\" id=\"f1\" value=\"{$f1}\">\n";
}
else
{
	echo "<input class=\"form-control col-xs-1\" name=\"f1\" id=\"f1\" value=\"{$f1}\">\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(-101,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
}
echo "</th>\n";
echo "<th  width=\"10%\">Действие</th>\n";
echo "</tr>\n";
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
	}
	else
	{
		echo "<td>".$R[1]."</td>\n";
	}
	echo "<td>\n";
	if ($action==1 || $action==2)
	{
	if ($id==$R[0])	
	{
		echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(".($action==1?"5":"6").",".$R[0].")\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
		echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
	}
	else
	{
		echo "<button type=\"button\" class=\"btn btn-default  btn-sm disabled\"><span class=\"glyphicon glyphicon-paperclip\" aria-hidden=\"true\"></span></button>\n";
	}
	}
	
	if ($action==0 || $action>=100)
	{
		echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(1,".$R[0].")\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button>\n";
		echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(2,".$R[0].")\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}

if ($action==3)
{
	echo "<tr class=\"danger\">\n";
	echo "<td>+</td>\n";
	echo "<td><input class=\"form-control\" name=\"fname\" id=\"fname\" value=\"\"></td>\n";
	echo "<td>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(4,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
	echo "</td></tr>\n";
}

echo "</table>\n";
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