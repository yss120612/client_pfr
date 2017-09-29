<?php
//$sql_time="SELECT TIME_TO_SEC(TIMEDIFF(current_time,time_nach_p)) from posetit WHERE id={$id_posetit}";
if ($_REQUEST['$id_posetit']>0)
{
$sql_time="SELECT TIME_TO_SEC(TIMEDIFF(current_time,time_nach_p)) from posetit WHERE id=".$_REQUEST['$id_posetit'];
$res_time=mysqli_query($dbI,$sql_time) or die("Query failed get time : " . mysqli_error($dbI)); 
$time_diff = mysqli_fetch_row($res_time);
echo "<H2 class=\"h2 text-center text-danger\">Время приёма: <span>". intdiv($time_diff[0]/60) ."</span> минут</H2>\n";
mysqli_free_result($res_time);
}
?>