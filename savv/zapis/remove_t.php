<?php
session_start();
header("Cache-Control: no-store");
header("Expires: " .  date("r"));

echo '<html>'."\n";


$PHP_SELF=$_SERVER['PHP_SELF'];
$ip = $_SERVER["REMOTE_ADDR"];
$lll = $_SESSION['s_login'] ;
$dat=isset($_REQUEST['dat'])?$_REQUEST['dat']:"";

$del=isset($_REQUEST['del'])?$_REQUEST['del']:"";
$sav=isset($_REQUEST['sav'])?$_REQUEST['sav']:"";
$family=isset($_REQUEST['family'])?$_REQUEST['family']:"";
$name=isset($_REQUEST['name'])?$_REQUEST['name']:"";
$father=isset($_REQUEST['father'])?$_REQUEST['father']:"";

$pers_num=isset($_REQUEST['pers_num'])?$_REQUEST['pers_num']:"";
$lchet=isset($_REQUEST['lchet'])?$_REQUEST['lchet']:"";
$telefon=isset($_REQUEST['telefon'])?$_REQUEST['telefon']:"";
$dopinfo=isset($_REQUEST['dopinfo'])?$_REQUEST['dopinfo']:"";
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:"";

$mess=isset($_REQUEST['mess'])?$_REQUEST['mess']:"";
$old_kab=$_REQUEST['old_kab'];
$old_id=$_REQUEST['id'];
date_default_timezone_set ('Asia/Irkutsk');

$srv_name=isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:"";
$home='http://'.$srv_name.'/zapis/main.php';
$loc="location: " . $home;

echo '<meta http-equiv="Content-Type" content="text/html">'."\n";
echo '<link rel="stylesheet" href="../styles1.css" type="text/css" >'."\n";
?>
<script type="text/javascript" src="../jQuery/jquery.js"></script>
<script type="text/javascript" src="../jQuery/showHide.js"></script>
<script src="../jQuery/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="../jQuery/jquery.alerts.js" type="text/javascript"></script>
<link href="../jQuery/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">			
			$(document).ready( function() {							
				$("#confirm_button").click( function() {
					jConfirm('Вы уверены?', 'Подтверждение действия', function(r) {
						if( r ){
  						 document.forms["confirmform"].del.value="1111";
						 document.forms["confirmform"].submit();						 
						}
					});
				});				
			});			
		</script>
<?
echo '<body background="../image/glabkgnd.jpg" >'."\n";
include_once('../login.php');
include_once("../obj.php");

if($del<>'')
{
 mysql_query("delete from posetit where id=".$old_id,$db) or die("error delete: " . mysql_error());
 //if (!headers_sent()) {header ("location: main.php?dat=".$dat);}
if (!headers_sent()) { header ($loc."?dat=".$dat);exit;}
}

if($sav<>'')
{
	$sql="update posetit set ip='" .$ip."' ,user='".$lll."', family='".$family."', name='".$name."', father='".$father."'
	, pers_num='".$pers_num."', lchet='".$lchet."', telefon='".$telefon."', dopinfo='".$dopinfo."', type_obr='".$type_obr."'

	where id=".$old_id;

 mysql_query($sql,$db) or die ("error save: " . mysql_error());
 if (!headers_sent()) {header ("location: main.php?dat=".$dat); exit;}
}


$sql="select family,a.name,father,pers_num,lchet,predvar,b.name, date_comin,time_comin,a.time_nach_p as p10,
					a.time_end_p, ipzap,vid_name,telefon,dopinfo,datepredvar,userzap,a.kab,ip,user,a.type_obr
	FROM posetit a left join types_obr b on b.id=a.type_obr left join specialict c on a.kab=c.kab
	where a.id=". $old_id;
$result = mysql_query($sql ,$db) or die("Query failed 2: " . mysql_error());
$oldfio=mysql_fetch_row($result);

echo "<form action=$PHP_SELF?id=".$old_id."&dat=".$dat." method='POST' onSubmit='return confirm(\"Вы уверены?\")'  >";
echo "<H2><center> Информация о посетителе "  ."&nbsp;"."</center></H2>\n";
echo "<TABLE class=\"manage\" WIDTH=\"100%\">\n";
echo '<TD>Фамилия <Input Type="text" Name="family" Size="20" MAXLENGTH="40" Value="' . $oldfio[0] . '"></TD>';
echo '<TD>Имя <Input Type="text" Name="name" Size="15" MAXLENGTH="40" Value="' .$oldfio[1].'"></TD>' ;
echo '<TD>Отчество <Input Type="text" Name="father" Size="20" MAXLENGTH="40" Value="'. $oldfio[2].'"></TD>'; 
echo '<TD>СНИЛС <Input Type="text" Name="pers_num" Size="20" MAXLENGTH="40" Value="'.$oldfio[3] .'"></TD></TR>';
echo '<TR><TD>Номер пенсионного дела <Input Type="text" Name="lchet" Size="10" MAXLENGTH="6" Value="'. $oldfio[4].'"></TD>';
echo '<TD>Телефон<Input Type="text" Name="telefon" Size="10" MAXLENGTH="6" Value="'. $oldfio[13].'"></TD>';


echo '<TD>Вопрос <SELECT name="type_obr"><OPTION selected VALUE='.$oldfio[20].'> '.$oldfio[6].'</OPTION>';
$result = mysql_query("select t.full_name name, t.id, g.full_name gname 
	from types_obr t left join group_types_obr g on (t.group_id=g.id) 
	where actual='1' order by COALESCE(g.id,9999),t.orders",$db) or die("Query failed : " . mysql_error());
$tab_sql=mysql_fetch_row($result);
$group=$tab_sql[2];
echo "<OPTGROUP LABEL='" . $tab_sql[2] . "'>";
while($tab_sql) 
{ 
	if(!($group==$tab_sql[2]))
	{	//
	echo "</OPTGROUP>";
	if($tab_sql[2]){echo "<OPTGROUP LABEL='".$tab_sql[2]."'>";}
	$group=$tab_sql[2];}
	echo "<OPTION VALUE=$tab_sql[1]>$tab_sql[0] </OPTION>";// 
	$tab_sql=mysql_fetch_row($result);//$group=$tab_sql[2];
}
echo "</SELECT></TD></TR>";
echo '<TR><TD COLSPAN=3>Дополнительные сведения <Input Type="text" Name="dopinfo" Size="50" MAXLENGTH="30" Value="'. $oldfio[14].'"><TD></TR>';

echo '<TR><TD COLSPAN=4 ><center><Input Type="submit"  Name="sav" Value="Сохранить изменения">';
echo '<input type="hidden" name="del1" value="">';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<Input Type="submit" name="del" Value=" Удалить посетителя "></center><TD></TR><br>';
echo "</table></Form> ";
 

$lll = $_SESSION['s_login'] ;
$ppp = $_SESSION['s_pass'] ;

echo "<form action='../main.php'  method='POST'>";
echo " <input type='hidden' name='j_username' value=". $lll  ." >" ;
echo " <input type='hidden' name='j_password' value=". $ppp  ." >" ;
$old_kab=$oldfio[17];
echo "<center>Предварительно записался  ".  date("d-m-Y",strtotime($oldfio[15])). ". Записан в кабинку<font color=blue> ".$oldfio[12] ." </font>&nbsp;". $tim ."&nbsp;".
		"дата приема ".date("d-m-Y",strtotime($oldfio[7])). " время приема c " .date("H:i", strtotime($oldfio[9]))." по ".date("H:i", strtotime($oldfio[10]))."</center>\n";
echo '<center> ip адрес ПК, с которого сделана запись '.$oldfio[11]. ' пользователь '.$oldfio[16].'</center>';
if ($oldfio[19]<>'')
  {echo '<center> ip адрес ПК, с которого сделаны обновления записи '.$oldfio[18]. ' пользователь '.$oldfio[19].'</center>';}

//echo $mess;
$dat=date("d-m-Y",strtotime($oldfio[7]));
mysql_close($db);	           
echo "<br> $message \n";
echo '</body>'."\n";
echo '</html>'."\n";
?>

