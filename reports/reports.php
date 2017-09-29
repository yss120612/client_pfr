<?php
session_start(); 
header('Content-type: text/html; charset=windows-1251');
$raion=$_SESSION['rajon'];
$sub_rajon=$_SESSION['sub_raion'];

include('../loginI.php');
include("../inc/head.php");

//<!DOCTYPE html>
//<html>
//<head>
//<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
//<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
//<!--<link type="text/css" href="../jQuery/css/smoothness.datepick.css" rel="stylesheet"  media="screen" />-->
//<!--<script type="text/javascript" src="../jQuery/jquery.js"></script>-->
 
// <link rel="stylesheet" type="text/css" href="/css/bootstrap-3.3.5.min.css"  />
//  <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css"  />
//  
echo "<script type=\"text/javascript\" src=\"/js/moment-with-locales.min.js\"></script>";
 
 //<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
 
 //<script type="text/javascript" src="/js/bootstrap-3.3.5.min.js"></script> 
        
 
 
 
 //<title>ПТК Клиент ПФР</title>
 
?> 
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/>
<script src="/js/jquery.datetimepicker.full.min.js" charset="utf-8"></script>
<script type="text/javascript">
$(function() {
	$.datetimepicker.setLocale('ru');
	
	$("#datetimepicker1,#datetimepicker2,#datetimepicker3,#datetimepicker5").datetimepicker({
		timepicker:false,
		format:'d.m.Y',
		dayOfWeekStart:1,
		disabledWeekDays:[0,6]
		});
	
	$('#datetimepicker3a').datetimepicker({
		dayOfWeekStart:1,
		disabledWeekDays:[0,6],
		allowTimes:['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00']
		
		});		
	$('#datetimepicker3b').datetimepicker({
		datepicker:false,
		format:'H:i',
		allowTimes:['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00']
		});		
	$('#datetimepicker4').datetimepicker({
		dayOfWeekStart:1,
		disabledWeekDays:[0,6],
		allowTimes:['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00']
		
		});			
	allDay();		
});

function allDay()
{
	
	if ($('#full_day').prop("checked"))
	{
		$('#datetimepicker3').removeClass("hidden");
		$('#datetimepicker3a').addClass("hidden");
		$('[id *= "datetimepicker3b"]').addClass("hidden");
	}
	else{
		$('#datetimepicker3').addClass("hidden");
		$('#datetimepicker3a').removeClass("hidden");
		$('[id *= "datetimepicker3b"]').removeClass("hidden");
	}
}
</script>

</head>
<?php 
include("../inc/body.php");
?>

<div class="container-fluid">
  <div class="row">

<h3 class="text-center">Выберите отчетный период</h3>
<div class="text-center">
<form action="view_count.php"  target="_blank" method="post">

<div class="form-group form-inline">
<label for="datetimepicker1">C</label>
<Input Type="text" id="datetimepicker1" class="form-control" Name="date1" Size="10"/>
<label for="datetimepicker2">ПО</label>
<Input Type="text" id="datetimepicker2" class="form-control" Name="date2" Size="10"/>
</div>


<INPUT TYPE="submit" name="report1" VALUE="Отчет по принятым посетителям с разбивкой по специалистам"
 class="btn btn-default" style="width:550px;"/> <br>
<INPUT TYPE="submit" name="report2"   VALUE="Отчет по принятым посетителям с разбивкой по дням"
class="btn btn-default" style="width:550px;"/> <br>
<INPUT TYPE="submit" name="report3" VALUE="Отчет по принятым посетителям с разбивкой по месяцам"
class="btn btn-default" style="width:550px;"/> <br>
<INPUT TYPE="submit" name="report4" VALUE="Отчет по принятым по записи посетителям с разбивкой по специалистам"
class="btn btn-default" style="width:550px;"/> <br>
<INPUT TYPE="submit" name="report5"   VALUE="Отчет по принятым по записи посетителям с разбивкой по дням"
class="btn btn-default" style="width:550px;"/> 
<input type="hidden"  name="forma" value="new"/>
<input type="hidden"  name="rajon" value="<?php echo $raion;?>"/>
<input type="hidden"  name="sub_rajon" value="<?php echo $sub_raion;?>"/>
<HR>
</form>


<form action="svod1.php"  target="_blank" method="post">
<INPUT TYPE="submit" name="report2" VALUE="Сводный отчет по принятым посетителям" class="btn btn-default" style="width:550px;">
</form>
<form action="svod2.php"  target="_blank" method="post">
<INPUT TYPE="submit" name="report2" VALUE="Отчет о количестве принятых посетителей (в среднем за 1 день)" class="btn btn-default" style="width:550px;">
</form>

<hr>

<p class="h4">Анализ интенсивности потока</p>
<form action="intent.php"  target="_blank" method="post">

 <div class="form-group form-inline">
 <input type="checkbox" id="full_day" name="full_day"  class="form-control" value="1" onchange="allDay()"/>
 <label for="full_day" >&nbsp;Почасовой анализ за весь день</label>
</div>

 <div class="form-group  form-inline">
 <label for="datetimepicker3">На дату &nbsp;</label>
 <input Type="text" id="datetimepicker3"  class="form-control hidden" Name="date3" Size="10"/>
 <input Type="text" id="datetimepicker3a"  class="form-control" Name="date3a" Size="16"/>
 <label id="datetimepicker3bL" for="datetimepicker3b">по &nbsp;</label>
 <Input Type="text" id="datetimepicker3b"  class="form-control" Name="date3b" Size="7"/>
 </div>



 <div class="form-group form-inline">
<label>Фильтровать по кабинке</label>
<?php 

//if ($sub_rajon==999){
	$querystr="select * from pensk.specialict where priem=2 and reg={$raion} order by office, kab;";	
//}
//else{
//	$querystr="select * from pensk.specialict where priem=2 and reg=".$rajon." and office=".$sub_rajon." order by kab;";
//}


$resulta=mysqli_query($dbI,$querystr);

echo '<select name="kabina"  class="form-control">';
echo '<option selected value="">Все</option>';
while ($kab=mysqli_fetch_array($resulta))
{
	echo "<option value=\"".$kab[kab]."\">[".$kab[office]."]".$kab[FIO]." - ".$kab[FIO]."</option>";
}
mysqli_free_result($resulta);
?>
<input TYPE="submit" VALUE="Анализировать поток" class="btn btn-default" style="width:200px;"/>
</div>
</form>

<hr>



<h4>Оперативный отчет</h4>
<form action="oper_view.php"  target="_blank" method="post">
<div class="form-group form-inline">
<label for="datetimepicker4">На дату, время</label>
<input type="text" id="datetimepicker4" Name="date4" class="form-control" Size="16"/>
<input type="submit" name="report2" VALUE="Оперативный отчет" class="btn btn-default"  style="width:200px;"/>
</div>
</form>

<HR>

<h4>Принятые посетители за день</h4>
<form action="view_table_all.php" target="_blank" method="post">
<div class="form-group form-inline">
<input Type="text" id="datetimepicker5" class="form-control" Name="date5" Size="10"/>
<input TYPE="submit" name="submit" VALUE="Просмотреть посетителей" class="btn btn-default" style="width:250px;"/>
</div>
</form>
<HR>


<form action="find_posetit.php" method="post" target="_blank">
<input TYPE="submit" name="submit2" VALUE="Поиск посетителей по реквизитам" class="btn btn-default" style="width:500px;"/>
</form>

<HR>

<form action="rep_limit_priem.php" method="post" target="_blank">
<input TYPE="submit" name="submit2" VALUE="Отчет по превышению среднего времени на прием" class="btn btn-default" style="width:500px;"/>
</form>

<!--<h4>Просмотр информации с web-камер</h4>
<form action="cam.php" target="_blank">
<INPUT TYPE="submit" VALUE="Камера" class="btn btn-default" style="width:250;">
</form>-->


<?php
include_once("../inc/home.php");
echo "<br>{$message}\n";
?>

</div>
</div>
</div>
</body>
</html>