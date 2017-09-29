<?php 
$PHP_SELF=$_SERVER['PHP_SELF'];
$nomer_kab=$_REQUEST['nomer_kab'];
$sub_raion=$_REQUEST['sub_raion'];
$raion=$_REQUEST['raion'];

//echo '<meta http-equiv="Refresh" content="20"; URL="' . $PHP_SELF . '?nomer_kab=' . $nomer_kab .'">'."\n";
//echo '<meta http-equiv="Content-Type" content="text/html">'."\n";
//echo '<link rel="stylesheet" href="../styles.css" type="text/css" >'."\n";
//echo '<body background="image/glabkgnd.jpg" >'."\n";
include_once("/inc/");
include("/inc/head.php");
?>
</head>
<?php 
include("/inc/body.php");

include_once("loginI.php");
include_once("obj.php");

//делаем объект кабинка
$result = mysqli_query($dbI,"SELECT kab,priem,priem_po_zap,FIO,time_nach_p,vid_name,time_osv FROM specialict Where kab={$nomer_kab} and office={$sub_raion}") or die("Query1 failed : " . mysqli_error($dbI)); 
$myrow=mysqli_fetch_row($result);
$KBN=new K($myrow[0],$myrow[1],$myrow[2],$myrow[3],strtotime($myrow[4]),$myrow[5],$myrow[6]);
$Ttime1=date( "H:i:s" );


//достаем время начала, конца работы кабинки
$DayWeek=date("w");
$result = mysqli_query($dbI,"SELECT t1,t2 FROM calen3 Where kab=". $nomer_kab ." and day_of_week=". $DayWeek ." limit 1") or die("Query failed2 : " . mysqli_error($dbI)); 
$WorkTime=mysqli_fetch_row($result);
$KBN->t_nach=$WorkTime[0];
$KBN->t_fin=$WorkTime[1];
//делаем посетителей кабинки
$result = mysqli_query($dbI,"call CreateKabList") or die("Query failed3 : " . mysqli_error($dbI)); 
//достаем их
$result = mysqli_query($dbI,"select * from QueueKab where kab=". $nomer_kab ." order by time_s") or die("Query failed4 : " . mysqli_error()); 

// рисуем
$ColWidth=array(250,350,150);//размер колоночег
echo "<table border='0' width='100%' cellspacing='10' cellpadding='5' id='table1' style='border-collapse:collapse;'>" ;
echo "<tr><td colspan='2'></td><td colspan='2'><b>	<font size='55px'>Прием ведет: ". $KBN->spec_name . "</font></b></td></tr>";
echo "<tr><td colspan='2'></td><td  bgcolor='#B5B5B5' width='1%'><p align='center'>&nbsp;</td>" .
"<td bgcolor='#B5B5B5' width='90%'>	<b><font size='55px'>Ф.И.О. клиента</font></b></td></tr>";
while ($R=mysqli_fetch_row($result))
{
if ($R[5]<'2') //человек
{
//<font size='55px' >" .
//date("H:i",strtotime(date("Y-m-d ") . $R[3])) ." - ". date("H:i",strtotime(date("Y-m-d ") . $R[4]))  ."</font>
echo "<tr><td colspan='2'><td align='center' width='1%'></td><td width='90%'>" .
"<font size='55px'>". $R[1] ."</font></td></tr>" ;
}
else
{
/*
if ($R[4] > date("H:i:s:")) {

//$R[4]) > CURRENT_TIME
echo "<tr><td colspan='2'><td align='center' width='25%'><font size='55px' color='" .$R[10]. "'>" .
date("H:i",strtotime(date("Y-m-d ") . $R[3])) ." - ". date("H:i",strtotime(date("Y-m-d ") . $R[4]))  ."</font></td><td width='70%'>" .
"<font size='55px' color='" .$R[10]. "'>". $R[1] ."</font></td></tr>" ;
	}
	*/
}
}
echo "</table>";
//закончили с табличкой
 
//mysql_close($db);

echo '<BR>';

?>