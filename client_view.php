<?php 
$PHP_SELF=$_SERVER['PHP_SELF'];
$nomer_kab=$_REQUEST['nomer_kab'];
$sub_raion=$_REQUEST['sub_raion'];
$raion=$_REQUEST['raion'];

//echo '<meta http-equiv="Refresh" content="20"; URL="' . $PHP_SELF . '?nomer_kab=' . $nomer_kab .'">'."\n";
//echo '<meta http-equiv="Content-Type" content="text/html">'."\n";
//echo '<link rel="stylesheet" href="../styles.css" type="text/css" >'."\n";
//echo '<body background="image/glabkgnd.jpg" >'."\n";
//include_once("/inc/");
include_once("/inc/head.php");
?>
</head>
<?php 
include_once("/inc/body.php");

include_once("loginI.php");
include_once("obj.php");

//делаем объект кабинка
$result = mysqli_query($dbI,"SELECT kab,priem,priem_po_zap,FIO,time_nach_p FROM specialict Where kab={$nomer_kab} and office={$sub_raion}") or die("Query1 failed : " . mysqli_error($dbI)); 
$myrow=mysqli_fetch_row($result);
$spec_name=$myrow[3];
//$KBN=new K($myrow[0],$myrow[1],$myrow[2],$myrow[3],strtotime($myrow[4]),$myrow[5],$myrow[6]);
$Ttime1=date( "H:i:s" );
mysqli_free_result($result);

//достаем время начала, конца работы кабинки
// $DayWeek=date("w");
// $result = mysqli_query($dbI,"SELECT t1,t2 FROM calen3 Where kab=". $nomer_kab ." and day_of_week=". $DayWeek ." limit 1") or die("Query failed2 : " . mysqli_error($dbI)); 
// $WorkTime=mysqli_fetch_row($result);
// $KBN->t_nach=$WorkTime[0];
// $KBN->t_fin=$WorkTime[1];
// mysqli_free_result($result);

echo "<div class=\"header\">\n";
echo "<h2 class=\"text-center\">Кабинка № ". $nomer_kab ."</h2>\n";
echo "<h2 class=\"text-center\">Прием ведет: ". $spec_name ."</h2>\n";
echo "</div>\n";

$parametrs=array("raion" => $raion,"sub_raion" => $sub_raion,"nomer_kab"=>$nomer_kab);
echo "<div id=\"que_kab\"></div>\n";
?>

<script type="text/javascript">
	 $(document).ready(function(){  
		mode();  
		setInterval('mode()',5000);  
	 });
function mode() {
	 $('#que_kab').load('queue_kab.php',<?php echo json_encode($parametrs)?>);
}
</script>	 
</body>
</html>