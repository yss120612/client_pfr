<?php
include_once('/loginI.php');
$raion=$_REQUEST['raion'];
$sub_raion=$_REQUEST['sub_raion'];
$sql= "SELECT a.FIO,a.kab,CONCAT (b.family,' ',SUBSTRING(b.name,1,1),'.',SUBSTRING(b.father,1,1),'.'),b.otrab FROM specialict a left join posetit b on a.kab=b.kab 
	where b.rajon={$raion} and b.sub_rajon={$sub_raion} and date_comin=current_date  and otrab>6  AND a.reg=b.rajon AND a.office=b.sub_rajon order by a.kab desc";
$result_kab = mysqli_query($dbI,$sql) or die("Query failed 1: " . mysqli_error());
$ColKab=mysqli_num_rows($result_kab);
$i=1;
while ($R[$i]=mysqli_fetch_row($result_kab))
{  //Вызван 'На приеме'
	if($R[$i][3]==7){$R[$i][3]='Вызван';} else {$R[$i][3]='На приеме';}
	$i=$i+1;
	
}
mysqli_free_result($result_kab);

$ColWidth=array(100,350,150);//размер колоночег

echo '<div align="center">
<TABLE class="table table-striped table-bordered">';
echo "<TR style='background:#e8e8e8;'>";
echo "<TH width='$ColWidth[0]' class='text-center h2'>  Кабинка </TH>\n";
//echo "<TH class='text-center h2'>  Специалист </TH>\n";

echo "<TH class='text-center h2'>  Посетитель </TH>\n";
echo "<TH class='text-center h2'>  Статус </TH>\n";
echo "</TR>";

while ($i){	
if(is_array($R[$i])){
	
	switch ($R[$i][3]) {
    case 'Вызван': $color="success";break;
	case 'На приеме': $color="";break;
	case ' &nbsp': $color="warning";break;
	default:$color="info";
}
	echo "<tr align='center' class='".$color."'>\n"; 
	echo "<td  width='$ColWidth[0]' class='text-center h1'>". $R[$i][1] ."</td>\n";
	//echo "<td class='h1'>". $R[$i][0] ."</td>\n";	
	
	echo "<td class='h1'>". $R[$i][2]."</td>\n";	
	echo "<td class='text-center h1'>". $R[$i][3] ."</td>\n";
	echo "</tr>";  
		}
	$i=$i-1;
}
echo "</table>\n";
?>