<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=isset($_REQUEST['raion'])?isset($_REQUEST['raion']):0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;
$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
$scrol=isset($_REQUEST['scrol'])?$_REQUEST['scrol']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$office=isset($_REQUEST['office'])?$_REQUEST['office']:"";
$client=isset($_REQUEST['client'])?"1":"0";
$noffice=isset($_REQUEST['noffice'])?$_REQUEST['noffice']:0;
$rname=isset($_REQUEST['rname'])?$_REQUEST['rname']:"";
$rnumber=isset($_REQUEST['rnumber'])?$_REQUEST['rnumber']:0;
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
	$sql="insert into title (dist,dist_name,office,office_name,ismy) values({$rnumber},'{$rname}',{$noffice},'{$office}','{$client}')";
	$result=mysqli_query($dbI,$sql)	or die("insert failed : " . mysqli_error());
	break;
	case 5:
	$sql="update title set dist={$rnumber},dist_name='{$rname}',office={$noffice},office_name='{$office}',ismy='{$client}' where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("update failed : " . mysqli_error());
	break;
	case 6:
	$sql="delete from title where id={$id}";
	$result=mysqli_query($dbI,$sql)	or die("delete failed : " . mysqli_error());
	break;
}

$str_title="Администрирование ПК \"Клиент ПФР\"<br>Справочник подразделений";
$show_home=true;
include("adm_header.php");


echo "<div class=\"container-fluid content\">\n";
$sql="select * from title".($f1!=''?" where dist_name like('%{$f1}%')":"").($f2>0?($f1!=''?" and ":" where ")."dist={$f2}":""). " order by dist,office";
$result=mysqli_query($dbI,$sql)	or die("Query failed : " . mysqli_error());
echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\" class=\"form\" id=\"raion_form\">\n";
echo "<table class=\"table table-bordered\">\n";
echo "<tr>\n";
echo "<th width=\"10%\">ID</th>\n";
echo "<th  width=\"10%\">Код района";
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
	echo "<input class=\"form-control col-xs-1\" name=\"f2\" id=\"f2\" value=\"{$f2}\"></td>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(0,0)\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></button>\n";
	echo "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"clickForm(-102,0)\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>\n";
}
echo "</th>\n";
echo "<th  width=\"30%\">Район";
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

echo "<th  width=\"10%\">Код офиса</th>\n";
echo "<th  width=\"20%\">Офис</th>\n";
echo "<th  width=\"10%\">Клиент ПФР</th>\n";
echo "<th>Действие</th>\n";
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
		echo "<td><input class=\"form-control\" name=\"rnumber\" id=\"rnumber\" value=\"".$R[1]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"rname\" id=\"rname\" value=\"".$R[2]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"noffice\" id=\"noffice\" value=\"".$R[3]."\"></td>\n";
		echo "<td><input class=\"form-control\" name=\"office\" id=\"office\" value=\"".$R[4]."\"></td>\n";
		echo "<td><input type=\"checkbox\" ".($R[5]=='1'?"checked":"")." name=\"client\" id=\"client\" class=\"form-control checkbox\"/><label for=\"client\"></label></td>\n";
	}
	else
	{
		echo "<td>".$R[1]."</td>\n";
		echo "<td>".$R[2]."</td>\n";
		echo "<td>".$R[3]."</td>\n";
		echo "<td>".$R[4]."</td>\n";
		echo "<td>".($R[5]=='1'?"ДА":"НЕТ")."</td>\n";
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
	echo "<td><input class=\"form-control\" name=\"rnumber\" id=\"rnumber\" value=\"0\"></td>\n";
	echo "<td><input class=\"form-control\" name=\"rname\" id=\"rname\" value=\"\"></td>\n";
	echo "<td><input class=\"form-control\" name=\"noffice\" id=\"noffice\" value=\"0\"></td>\n";
	echo "<td><input class=\"form-control\" name=\"office\" id=\"office\" value=\"\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"client\" id=\"client\" class=\"form-control checkbox\"/><label for=\"client\"></label></td>\n";
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