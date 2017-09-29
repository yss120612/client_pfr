<?php session_start(); 

$raion=$_REQUEST['rajon'];
$sub_raion=$_REQUEST['sub_rajon'];

//include_once $_SERVER['DOCUMENT_ROOT'].'/view/head_old_page.php';
include("../inc/head.php");
echo "</head>\n";
include("../inc/body.php");
include_once("../loginI.php");
$PHP_SELF=$_SERVER['PHP_SELF'];
$action=0;

echo "<form action=\"add_type_kab.php\" method=\"post\">\n";

echo "<table class=\"table table-striped table-hover  table-bordered\">\n";
echo "<tr>\n";
echo "<td>\n</td>\n";

$result0 = mysqli_query($dbI,"SELECT FIO,id,vid_Name FROM specialict Where reg={$raion} AND office={$sub_raion} order by kab"); 
$MaxKab=mysqli_num_rows($result0);
while($tab_sql=mysqli_fetch_array($result0))
{
$kabs[]=$tab_sql[1];
echo "<th class='text-center'>{$tab_sql[0]}<BR>({$tab_sql[2]})</th>";
}
mysqli_free_result($result0);

echo "</tr>\n";
echo "<tr>\n";

$result = mysqli_query($dbI,"Select full_name,id from types_obr where actual='1' order by full_name");
$MaxQuest=mysqli_num_rows($result);

while($tmp=mysqli_fetch_array($result))
{
$cell=$tmp[1];
// вывод названия типа обращения
echo "<tr> <td> $tmp[0]  </td>";

//$kol_box = $MaxKab * $MaxQuest;
for ($g=0; $g<=$MaxKab-1; $g++)
{ 
$result0 = mysqli_query($dbI,"SELECT id_spec FROM spec_vopr Where (id_spec=".$kabs[$g].") and (id_vopr={$cell})"); 
$tmp=mysqli_num_rows($result0);  

$st="cb".$kabs[$g]."_".$cell;

if ($tmp==0) 
	{echo "<td class='text-center'><input type=\"checkbox\" id=\"$st\" name=\"$st\" value='0'> </td>";}
else 
	{echo "<td class='text-center'><input type=\"checkbox\" id=\"$st\" name=\"$st\" checked value='1'></td>";}
mysqli_free_result($result0);
}
echo "</tr>\n";
}
echo "<tr>\n";
echo "<td>действия</td>";
for ($g=0; $g<=$MaxKab-1; $g++)
{
echo "<td>\n";
echo "<button type=\"button\" class=\"btn btn-default btn-xs\" title=\"пометить все\" onclick=\"checkAll({$kabs[$g]})\" name=\"selall{$kabs[$g]}\"><span class=\"glyphicon glyphicon-ok\"></span></button>\n";
echo "<button type=\"button\" class=\"btn btn-default btn-xs\" title=\"снять пометку всем\" onclick=\"uncheckAll({$kabs[$g]})\" name=\"unselall{$kabs[$g]}\"><span class=\"glyphicon glyphicon-remove\"></span></button>\n";
echo "<button type=\"button\" class=\"btn btn-default btn-xs\" title=\"обратить пометку всем\" onclick=\"invertAll({$kabs[$g]})\" name=\"invertall{$kabs[$g]}\"><span class=\"glyphicon glyphicon-retweet\"></span></button>\n";
echo "</td>\n";
}
echo "</tr>\n";
mysqli_free_result($result);

echo "</table>\n";

echo "<input type=\"hidden\" name=\"rajon\" value=\"{$raion}\">\n";
echo "<input type=\"hidden\" name=\"sub_rajon\" value=\"{$sub_raion}\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"{$action}\">\n";
echo "<p class=\"text-center\"><input type=\"submit\" name=\"sok\" value=\"Применить\" class=\"btn btn-default\"></p>\n";
echo "</form>\n";



include_once("../inc/home.php");
?>
<script type="text/javascript">

 
	 $(document).ready(function(){  
		
    });  
	
 
 function uncheckAll(id)
 {
	 var s="[id*=cb"+id+"_]";
	// alert(s);
	 $(s).prop("checked",false);
 }
 
 function checkAll(id)
 {
		 var s="[id*=cb"+id+"_]";
	 $(s).prop("checked",true);
 }
 
 function invertAll(id)
 {
	 var s="[id*=cb"+id+"_]";
	 $(s).each(function( i ){$(this).prop("checked",!$(this).prop("checked"))});
 }
 
 function submitForm(a)
 {
	 $('#action').val(a);
	 if (a==8 && ($('#a').val()=='' || $('#b').val()==''))
	 {
		 alert("Заполните имя и фамилию");
		 return;
	 }
		 
	 $('#kabForm').submit();
	 
 }
 
 </script>
</body>
</html>
