<?php
header('Content-Type: application/x-javascript; charset=utf8');  

$raion=$_REQUEST['raion'];
$sub_raion=$_REQUEST['sub_raion'];
$id_spec=$_REQUEST['id_spec'];

include_once('../loginI.php');
$sql="select count(*) from posetit Where otrab=0 and date_comin=current_date and rajon={$raion} and sub_rajon={$sub_raion} and type_obr in (select id_vopr from spec_vopr where id_spec={$id_spec})";
$result = mysqli_query($dbI,$sql) or die("Query failed select no que 1: " . mysqli_error());
$myrow=mysqli_fetch_row($result);
$queue_count=$myrow[0];
mysqli_free_result($result);
$n = array("qcount" => $queue_count);  
echo json_encode($n);  
?>