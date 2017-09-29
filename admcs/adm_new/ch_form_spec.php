<?php
 header('Content-Type: application/x-javascript; charset=utf8');  

$action=$_REQUEST['action'];
$raion=$_REQUEST['raion'];
$sub_raion=$_REQUEST['sub_raion'];
$kab=$_REQUEST['kab'];
$login=$_REQUEST['login'];
$password=$_REQUEST['password'];
$id=$_REQUEST['id'];

 include_once('../../loginI.php');
$err="";
$sql="select count(id) from specialict where flogin='{$login}' and id<>{$id} and id_damask=0";
$result=mysqli_query($dbI,$sql)	or die("unique login failed : " . mysqli_error());
$qty=mysqli_fetch_row($result);

if ($qty[0]>0)
{
	$err="Логин {$login} уже существует.";
}	
mysqli_free_result($result);
	
$sql="select count(id) from specialict where reg={$raion} and office={$sub_raion} and kab={$kab} and id<>{$id} and  id_damask=0";
$result=mysqli_query($dbI,$sql)	or die("unique kabin failed : " . mysqli_error());
$qty=mysqli_fetch_row($result);

if ($qty[0]>0)
{
	$err=((isset($err) && !empty($err))?$err."\n":"")."Кабинка {$kab} занята.";
}	
mysqli_free_result($result);	

if (!isset($err) || empty($err)) 
{
	$err="OK";
}

$n = array("check" => $err);  
//$n = array("check" => $kab);  
echo json_encode($n);  
?>