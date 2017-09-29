<?php
include_once('/loginI.php');
$raion=$_REQUEST['raion'];
$sub_raion=$_REQUEST['sub_raion'];
$nomer_kab=$_REQUEST['nomer_kab'];

$req="select id,CONCAT(family,' ',SUBSTRING(name,1,1),'.',SUBSTRING(father,1,1),'.'),type_obr,otrab from posetit where kab={$nomer_kab} and date_comin=CURRENT_DATE and (otrab=7 or otrab=8) and rajon={$raion} and sub_rajon={$sub_raion} order by otrab limit 1";
$result = mysqli_query($dbI,$req) or die("Query failed4 : " . mysqli_error(). $req); 
$N=mysqli_num_rows($result);

if ($N>0)
{
$row=mysqli_fetch_row($result);
echo "<div class=\"container-fluid\">\n";	
if ($row[3]==7)
{
	echo "<h2 class=\"text-center text-danger\">Âûחûגאועסÿ ןמסועטעוכü ".$row[1]."</h2>";
}
else
{
	echo "<h2 class=\"text-center text-success\">Èהוע ןנטול ןמסועטעוכÿ...</h2>";
}
echo "</div>\n";
}
mysqli_free_result($result);
?>