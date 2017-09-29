<?php 
header('Content-type: text/html; charset=windows-1251');

$rajon=$_REQUEST['rajon'];
$sub_rajon=$_REQUEST['sub_rajon'];

//include_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT').'/view/head_old_page.php';

?> 

<!DOCTYPE html>
<html>
    <head>        
        <meta http-equiv="Refresh" content="60">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link href="/styles1.css" rel="stylesheet" type="text/css"/>
        <link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>        
        <link href="/css/validationEngine.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-3.3.5.min.css"  />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css"  />        
        
        <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
        <script  src="/js/showHide.js" type="text/javascript"></script>
        <script src="/js/jquery.ui.draggable.js" type="text/javascript"></script>
        <script src="/js/jquery.alerts.js" type="text/javascript"></script>        
        <script type="text/javascript" src="/js/bootstrap-3.3.5.min.js"></script>  
        
        <title>ПТК Клиент ПФР</title>
    </head>
    <body background="/image/glabkgnd.jpg" >   

<?php


include_once ('loginI.php');

$sql= "SELECT a.FIO,a.kab,CONCAT (b.family,' ',SUBSTRING(b.name,1,1),'.',SUBSTRING(b.father,1,1),'.'),b.otrab FROM specialict a left join posetit b on a.kab=b.kab 
	where b.rajon=".$rajon." and b.sub_rajon=".$sub_rajon." and date_comin=current_date  and otrab>6  AND a.reg=b.rajon AND a.office=b.sub_rajon order by a.kab ";
$result_kab = mysqli_query($dbI,$sql) or die("Query failed 1: " . mysqli_error());
$ColKab=mysqli_num_rows($result_kab);
$i=1;
while ($R[$i]=mysqli_fetch_row($result_kab))
{  //Вызван 'На приеме'
	if($R[$i][3]==7){$R[$i][3]='Вызван';} else {$R[$i][3]='На приеме';}
	$i=$i+1;
	
}

//var_dump($R);

$sql= "SELECT a.FIO,a.kab FROM specialict a 	where  active=0 AND a.reg=".$rajon." AND a.office=".$sub_rajon ;
$result_kab = mysqli_query($dbI,$sql) or die("Query failed : " . mysqli_error());
$ColKab1=mysqli_num_rows($result_kab);
while ($R[$i]=mysqli_fetch_row($result_kab))
{  //'Перерыв'
	$R[$i][2]='Перерыв';$R[$i][3]=' &nbsp';
	$i=$i+1;
}



$sql= "SELECT a.FIO,a.kab,CONCAT (b.family,b.name,b.father),b.time_nach_p FROM specialict a left join posetit b on a.kab=b.kab 
	where  date_comin=current_date  and predvar='1' and otrab=0  AND b.rajon=".$rajon." AND b.sub_rajon=".$sub_rajon." order by a.kab limit 10";
$result_kab3 = mysqli_query($dbI,$sql) or die("Query failed : " . mysqli_error());
$ColKab1=mysqli_num_rows($result_kab3);
while ($R[$i]=mysqli_fetch_row($result_kab3))
{  //По записи
	$R[$i][3]='По записи '.$R[$i][3];
	$i=$i+1;
}
//echo $sql ;

//var_dump ($R);

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
//закончили с табличкой
?>



</body>
</html> 
