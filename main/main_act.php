<?php
session_start();

$PHP_SELF=$_SERVER['PHP_SELF'];


$name=isset($_REQUEST['name'])?$_REQUEST['name']:"";
$family=isset($_REQUEST['family'])?$_REQUEST['family']:"";
$father=isset($_REQUEST['father'])?$_REQUEST['father']:"";
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:"";
$srv_name=isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:"";
$user = $_SESSION['s_login'] ;
$RADD=$_SERVER['REMOTE_ADDR'];
$ref= $_SERVER['HTTP_REFERER'];
//$home='http://'.$srv_name.':'.$_SERVER['SERVER_PORT'].'/main/main.php';
$loc="location: " . $ref;


$submit_kind=isset($_REQUEST['sub_kind'])?$_REQUEST['sub_kind']:"";
$raion=isset($_REQUEST['rajon'])?$_REQUEST['rajon']:"";
$sub_raion=isset($_REQUEST['sub_rajon'])?$_REQUEST['sub_rajon']:"";
$predv_date=isset($_REQUEST['predv_date'])?$_REQUEST['predv_date']:"now";
$dopinfo="Dispatcher";
$work_date= new DateTime(($submit_kind==1)?$predv_date:"now");


include_once('../loginI.php');

	$sql="insert Into posetit 
		(family,type_obr,name,father, date_comin, time_comin, predvar, ipzap,dopinfo,userzap,rajon,sub_rajon) 
	  Values (UPPER('{$family}'),{$type_obr},UPPER('{$name}'),UPPER('{$father}'), '".$work_date->format('Y-m-d')."','".$work_date->format('H:i:s')."','{$submit_kind}', 
		  '{$RADD}','{$dopinfo}','{$user}',{$raion},{$sub_raion})";

$result = mysqli_query($dbI,$sql) or die("Query2 failed : " . mysql_error()); 
mysqli_free_result($result);

 if (!headers_sent()) {
 header ($loc ,FALSE);
 }
 else
 {
    echo "Заголовки уже отправлены. Редирект невозможен, пожалуйста нажмите <a href=\"{$ref}\">здесь</a> самостоятельно\n";
 }
exit;
?>

