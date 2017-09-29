<?php
//<head>
//        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
//       <meta http-equiv="refresh" CONTENT="300;url=index.php">
header('Content-type: text/html; charset=windows-1251');

include("../inc/head.php");
echo "<link rel=\"stylesheet\" href=\"../css/styles_info.css\" type=\"text/css\">\n";
echo "<title>Информационный киоск</title>\n";
		
//action=0 головная страница
//action=1 выбор (предварительно или на сегодня)
//action=2 выбор документа при себе
//action=3 набиральшик номера
//action=4 выберите тему обращения
//action=5 выбор даты (предварительная запись)
//action=6 проверка возможности записи на сегодня, формирование подтверждения
//action=7 выбор времени (предварительная запись)
//action=8 проверка возможности предв. записи, формирование подтверждения
//action=9 подтверждение предв. записи
$raion=isset($_REQUEST['raion'])?$_REQUEST['raion']:0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:1;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$today=isset($_REQUEST['today'])?$_REQUEST['today']:0;
$ident=isset($_REQUEST['ident'])?$_REQUEST['ident']:0;
$inumber=isset($_REQUEST['inumber'])?$_REQUEST['inumber']:0;
$kabinka=isset($_REQUEST['kabinka'])?$_REQUEST['kabinka']:0;
$vopros=isset($_REQUEST['vopros'])?$_REQUEST['vopros']:0;
$PHP_SELF=$_SERVER['PHP_SELF']."?raion={$raion}&sub_raion={$sub_raion}";
$m1=(isset($_REQUEST['m1']))?$_REQUEST['m1']:date('n');
$y1=(isset($_REQUEST['y1']))?$_REQUEST['y1']:date('Y');
$d1=(isset($_REQUEST['d1']))?$_REQUEST['d1']:0;
$dat1=(isset($_REQUEST['dat1']))?$_REQUEST['dat1']:"";
$dat2=(isset($_REQUEST['dat2']))?$_REQUEST['dat2']:"";
$fio=(isset($_REQUEST['fio']))?$_REQUEST['fio']:"";


if ($action>0)
{
	echo "<meta http-equiv=\"refresh\" CONTENT=\"120;url=index.php?raion={$raion}&sub_raion={$sub_raion}\">";
}

include_once('../loginI.php');
//include_once('../function/fncDat.php');

$sql="select dist_name,office_name,ismy from title where dist={$raion} and office={$sub_raion}";
$result=mysqli_query($dbI,$sql)	or die("Query failed : " . mysqli_error());
$R=mysqli_fetch_row($result);
$client=($R[2]=='1');

if (is_null($R[0]) || $R[0]=='') {$ti0='НЕТ В СПРАВОЧНИКЕ';} else {$ti0= $R[0]."<br>".$R[1];}
switch ($action)
{
case 0: $ti1="Выберите нужный пункт";
		break;
case 3: $ti1="Введите через пробел<br>ФАМИЛИЮ ИМЯ ОТЧЕСТВО";
        break;
case 23:$ti1="Выберите тему обращения";
		break;
case 24:$ti1="Запись в очередь...";
		break;		
default:
    	$ti1="Выберите нужное действие";	
}
	
?>
<script type="text/javascript">

$(document).ready(function(){  
	draw_time();
	draw_calendar();
    setInterval('draw_time()',1000);  
	setInterval('draw_calendar()',1000*60*60);  
});

function clickForm(a,v)
	{
		$("#action").val(a);
		$("#vopros").val(v);
		$("#raion").val(<?php echo $raion?>);
		$("#sub_raion").val(<?php echo $sub_raion?>);
		$("#frm_type").attr("action",'<?php echo $PHP_SELF ?>');
		$("#frm_type").submit();
	}
	
function clickForm2(v)
                    {
					$("#raion").val(<?php echo $raion?>);
					$("#sub_raion").val(<?php echo $sub_raion?>);
					$("#frm_type").attr("action",v);
					$("#frm_type").submit();
                    }
					
function draw_time() {
	var time=new Date();
	var strTime=time.toTimeString();
	$("#clock").html("<h3><span class=\"label label-primary\">"+strTime.slice(0,strTime.indexOf("GMT")-1)+"</span></h3>");
	}	
	
function draw_calendar()
{
calendar = new Date();	
var smonth=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
var sday=["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"];
var ca="<table style=\"{margin:0px;padding:0px;}\">\n";
var day = calendar.getDay();

if (day == 0 || day==6) {
ca=ca+"<tr>\n<td><h4 class=\"cld_red\">"+sday[day]+"</h4></td></tr>\n";
}else
{
ca=ca+"<tr>\n<td><h5 class=\"cld\">"+sday[day]+"</h5></td></tr>\n";
}
ca=ca+"<tr>\n<td><h2 class=\"cld\">"+calendar.getDate()+"</h2></td></tr>\n";
ca=ca+"<tr>\n<td><h5 class=\"cld\">"+smonth[calendar.getMonth()]+"</h5></td></tr>\n";
ca=ca+"<tr>\n<td><h5 class=\"cld\">"+calendar.getFullYear()+"</h5></td></tr>\n";
ca=ca+"</table>\n";
$("#calendar").html(ca);	
}	
</script>

</head>
<?php
include("../inc/body.php");
?>
<div class="wrapper infomat">
<div class="container-fluid header">
<div class="row">
<div class="col-xs-2 text-center"><img border="0" src="images/pfr.gif" width="103" height="104"></div>
<div class="col-xs-8 main_title text-center"><h3><?php echo $ti0 ."<br>Информационный киоск";?></h3></div>
<div class="col-xs-2 text-center" id="calendar"></div>
</div>
</div>

<div class="container-fluid content">
<?php
//переключение режимов

include_once 'action/'.$action.'.php';
mysqli_close($dbI);
echo "</div>\n";
echo "<div class=\"container-fluid footer\">\n";
echo "<div class=\"row\">\n";

if ($action>0)
{
echo "<div class=\"text-left col-xs-2\">\n";	
echo "<input class=\"btn btn-lg btn-block infobtn\" type=\"button\" value=\"Главное меню\" onclick=\"javascript:document.location.href='{$PHP_SELF}'\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-8\"></div>\n";
}
else
{
	echo "<div class=\"text-left col-xs-2\">\n";
	echo "<h5 class=\"cld\">Вышестояшие организации</h5>\n";
	echo "</div>\n";
	echo "<div class=\"text-left col-xs-3\">\n";
	echo "<h5 class=\"cld\">Отделение ПФР по Иркутской области<br>Адрес: 664007, г. Иркутск, ул.Декабрьских событий, 92, ГСП-46.<br>Телефон горячей линии:(3952) 47-00-00</h5>\n";
	echo "</div>\n";
	echo "<div class=\"text-left col-xs-3\">\n";
	echo "<h5 class=\"cld\">Пенсионный Фонд Российской Федерации<br>Адрес: 119991 г. Москва, ул. Шаболовка, д. 4, ГСП-1<br>Телефон горячей линии:(495) 987-89-07</h5>\n";
	echo "</div>\n";
	echo "<div class=\"text-left col-xs-2\">\n";
	echo "<h5 class=\"cld\">Адрес официального<br>сайта ПФР: www.pfrf.ru</h5>\n";
	echo "</div>\n";
}
?>
<div class="col-xs-2"></div>
<div id="clock" class="text-right col-xs-2"></div>
</div>
</div>

</div>


</body>
</html>
