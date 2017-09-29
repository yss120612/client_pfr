<?php
$raion=$_REQUEST['rajon'];
$sub_raion=$_REQUEST['sub_rajon'];

include_once("../loginI.php");
$result0 = mysqli_query($dbI,"SELECT id FROM specialict Where reg=".$raion." AND office=".$sub_raion." order by kab"); 
while($tab_sql=mysqli_fetch_array($result0)){
	$kabs[]=$tab_sql[0];
}
mysqli_free_result($result0);

$result33 = mysqli_query($dbI,"Select id from types_obr where actual='1' order by id");
while($tmp=mysqli_fetch_array($result33)){
$cell=$tmp[0];
foreach ($kabs as $value)
{ 
$st="cb{$value}_{$cell}";
if (isset($_REQUEST[$st])) 
	{
	unset ($_REQUEST[$st]);
	 mysqli_query($dbI,"INSERT INTO spec_vopr (id_spec,id_vopr) VALUES ({$value},{$cell})"); 
	} //if
	else
	{
	 mysqli_query($dbI,"DELETE FROM spec_vopr WHERE id_spec={$value} and id_vopr={$cell}"); 	
	}
} //for
} //while
mysqli_free_result($result33);
header ("Location: ".$_SERVER['HTTP_REFERER'] ,FALSE);
?> 


