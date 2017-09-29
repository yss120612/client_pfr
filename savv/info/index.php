<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <meta http-equiv="refresh" CONTENT="300;url=index.php">
        <link rel="stylesheet" href="../css/styles_info.css" type="text/css">   
        <link rel="shortcut icon" href="images/pfr.gif" />
        <title>Информационный киоск</title>
<?php
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
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$today=isset($_REQUEST['today'])?$_REQUEST['today']:0;
$ident=isset($_REQUEST['ident'])?$_REQUEST['ident']:0;
$inumber=isset($_REQUEST['inumber'])?$_REQUEST['inumber']:0;
$rajon=isset($_REQUEST['rajon'])?$_REQUEST['rajon']:0;
$kabinka=isset($_REQUEST['kabinka'])?$_REQUEST['kabinka']:0;
$vopros=isset($_REQUEST['vopros'])?$_REQUEST['vopros']:0;
$PHP_SELF=$_SERVER['PHP_SELF'];
$m1=(isset($_REQUEST['m1']))?$_REQUEST['m1']:date('n');
$y1=(isset($_REQUEST['y1']))?$_REQUEST['y1']:date('Y');
$d1=(isset($_REQUEST['d1']))?$_REQUEST['d1']:0;
$dat1=(isset($_REQUEST['dat1']))?$_REQUEST['dat1']:"";
$dat2=(isset($_REQUEST['dat2']))?$_REQUEST['dat2']:"";
$DY=array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
$MY=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
date_default_timezone_set ('Asia/Irkutsk');

$fio=(isset($_REQUEST['fio']))?$_REQUEST['fio']:"";

include_once('../loginI.php');
include_once('../function/fncDat.php');

$sql="select * from title";
$result=mysqli_query($dbI,$sql)	or die("Query failed : " . mysqli_error());
$R=mysqli_fetch_row($result);
if (is_null($R[0]) ) {$ti0='НЕТ В СПРАВОЧНИКЕ';} else {$ti0=$R[2];}
switch ($action)
{
case 0: $ti1="Выберите нужный пункт, нажав на него пальцем!";break;
case 1: $ti1="Запись в очередь на прием";break;
case 2: $ti1="Запись по ФИО<br>или<br>номеру страхового свидетельства";break;
case 3:if ($vopros==0) {
        if($ident==1){$ti1="Введите через пробел<br>ФАМИЛИЮ ИМЯ ОТЧЕСТВО";}
        if($ident==2){$ti1="Введите номер страхового свидетельства";}    
}
    elseif ($vopros==1 || $vopros==2){
        if($ident==1){$ti1="Введите через пробел<br>ФАМИЛИЮ ИМЯ ОТЧЕСТВО";}
        if($ident==2){$ti1="Введите номер страхового свидетельства";}    
    }
    elseif ($vopros==10){
        if($ident==1){$ti1="Введите через пробел<br>ФАМИЛИЮ ИМЯ ОТЧЕСТВО";}
        if($ident==2){$ti1="Введите номер страхового свидетельства";}    
    }break; 
    //$ti1="Введите номер страхового свидетельства";break;
case 4: if ($vopros==0) {$ti1="Выберите тему обращения";}
    elseif ($vopros==1){$ti1="Печать справки";}
	elseif ($vopros==3 || $vopros==2){$ti1="Выберите период";}
	elseif ($vopros==10){$ti1="Оценка обслуживания";};break;
case 5: $ti1="Выберите дату приема";break;
case 6: $ti1="";break;
case 7: $ti1="Выберите время приема";break;
//case 4: $ti1="Информационный киоск";break;
case 4: $ti1="Информационный киоск";break;
case 11: $ti1="Получение справки";break;
case 12: $ti1="Раздел 12";break;
case 13: if ($vopros==0) 
		  {$ti1="Право на трудову пенсию<br>(Федеральный закон от 17.12.2001 года № 173-ФЗ)";}
		 elseif ($vopros==2)
		  {
		  $ti1="Право на досрочное назначение трудовых пенсий<br>(Федеральный закон от 17.12.2001 года № 173-ФЗ)";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="Право на государственное пенсионное обеспечение<br>(Федеральный закон от 15.12.2001 года № 166-ФЗ)";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="Страховой стаж<br>(Федеральный закон от 17.12.2001 года № 173-ФЗ)";
		  }
		  elseif ($vopros==5)
		  {
		  $ti1="Сроки назначения, перерасчетов, индексаций и корректировок трудовых пенсий<br>(Федеральный закон от 17.12.2001 года № 173-ФЗ)";
		  }
		  elseif ($vopros==6)
		  {
		  $ti1="Выплата и доставка пенсии, удержания из пенсии";
		  }
		  elseif ($vopros==7)
		  {
		  $ti1="Обязательное пенсионное страхование<br>(Федеральный закон от 15.12.2001 года № 167-ФЗ)";
		  }
		  elseif ($vopros==8)
		  {
		  $ti1="Дополнительное материальное обеспечение<br>(Федеральный закон от 04.03.2002 года № 21-ФЗ)";
		  }
		  elseif ($vopros==9)
		  {
		  $ti1="Набор социальных услуг (соц. пакет)";
		  }
		  elseif ($vopros==10)
		  {
		  $ti1="Уплата страховых взносов. Часть 1";
		  }
		  elseif ($vopros==11)
		  {
		  $ti1="Уплата страховых взносов. Часть 2";
		  }
	break;
case 14: $ti1="Вопросы и ответы";break;
case 15: $ti1="Оценка обслуживания";break;
case 16: if ($vopros==1)
		  {
		  $ti1="Введенный номер отсутствует";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="Пенсия не назначена";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="Принтер не готов";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="Справку получить <br>у руководителя клиентской службы<br> в кабинете №16 <br>при предъявлении документа, <br> удостоверяющего личность";
		  }
		break;
case 17: $ti1="Законодательство"; break;
case 18: if ($vopros==1)
		  {
		  $ti1="Нормативные акты по пенсионному обеспечению";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="Перечень документов для назначения трудовой пенсии по старости";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="Перечень документов для назначения&nbsp;трудовой пенсии по инвалидности";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="Перечень документов для назначения трудовой пенсии по по случаю потери кормильца";
		  }
		  elseif ($vopros==5)
		  {
		  $ti1="Перечень документов для назначения социальной пенсии";
		  }
		break;
		
case 19: $ti1="Информационные ролики"; break;
case 20: if ($vopros==1)
		  {
		  $ti1="Работай. Участвуй. Управляй.";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="Моя будущая пенсия зависит от меня";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="Материнский капитал";
		  }
		elseif ($vopros==4)
		  {
		  $ti1="Как увеличить будущую пенсию?";
		  }
		elseif ($vopros==5)
		  {
		  $ti1="Ролик 5";
		  }
		elseif ($vopros==6)
		  {
		  $ti1="Программа государственного софинансирования пенсии";
		  }
		elseif ($vopros==7)
		  {
		  $ti1="Ролик 7";
		  }
		elseif ($vopros==8)
		  {
		  $ti1="Ролик 8";
		  }
		elseif ($vopros==9)
		  {
		  $ti1="Ролик 9";
		  }
		elseif ($vopros==10)
		  {
		  $ti1="Будьте бдительны! ч.1";
		  }
		elseif ($vopros==11)
		  {
		  $ti1="Будьте бдительны! ч.2";
		  }
		elseif ($vopros==12)
		  {
		  $ti1="Будьте бдительны! ч.3";
		  }
		break;
		
case 21: if ($vopros==2)
		  {
		  $ti1="Получение справки за период с $dat1 по $dat2.";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="Получение справки за период с $dat1 по $dat2.";
		  }
		  
		break;		
case 23: $ti1="Выберите тему обращения";break;
case 24: $ti1="";break;
case 25: $ti1="Выберите дату приема";break;
case 26: $ti1="Выберите время приема";break;
    		
}


		
?>
<script type="text/javascript">
<!--
function FP_swapImg() {//v1.0
 var doc=document,args=arguments,elm,n; doc.$imgSwaps=new Array(); for(n=2; n<args.length;
 n+=2) { elm=FP_getObjectByID(args[n]); if(elm) { doc.$imgSwaps[doc.$imgSwaps.length]=elm;
 elm.$src=elm.src; elm.src=args[n+1]; } }
}

function FP_preloadImgs() {//v1.0
 var d=document,a=arguments; if(!d.FP_imgs) d.FP_imgs=new Array();
 for(var i=0; i<a.length; i++) { d.FP_imgs[i]=new Image; d.FP_imgs[i].src=a[i]; }
}

function FP_getObjectByID(id,o) {//v1.0
 var c,el,els,f,m,n; if(!o)o=document;
 if(o.getElementById) el=o.getElementById(id);
 else if(o.layers) c=o.layers; 
 else if(o.all) el=o.all[id]; 
 if(el) return el;
 if(o.id==id || o.name==id) return o; 
 if(o.childNodes) c=o.childNodes; if(c)
 for(n=0; n<c.length; n++) { el=FP_getObjectByID(id,c[n]); if(el) return el; }
 f=o.forms; if(f) for(n=0; n<f.length; n++) { els=f[n].elements;
 for(m=0; m<els.length; m++){ el=FP_getObjectByID(id,els[n]); if(el) return el; } }
 return null;
}
// -->
</script>
<!--<script type="text/javascript" src="jwplayer.js"></script>-->

</head>
<body onselectstart="return false">
<table id="table1">
	<tr>
		<td width="104">
                    <img border="0" src="images/pfr.gif" width="103" height="104">
		</td>
		<td >
                    <p id="baner"><?php echo $ti0 ."<br>Информационный киоск";?></p>
		</td>
<td>
<script type="text/javascript">
<!--//
var smonth=[<?php for ($i=0;$i<12;$i++){echo "\"".($MY[$i])."\"";if ($i<11) {echo ",";}}; ?>];

function fulltime() {
var time=new Date();
hours = time.getHours();
mins = time.getMinutes();
secs = time.getSeconds();
if (hours < 10) {hours = "0" + hours }
if (mins < 10) {mins = "0" + mins }
if (secs < 10) {secs = "0" + secs }
datastr = ( hours + ":" + mins + ":" + secs )
document.clock.full.value=datastr;
setTimeout('fulltime()',500)
};

calendar = new Date();

day = calendar.getDay();
document.write("<table id=top_calen>");
document.write("<tr><td><center>");
var sday=["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"];
if (day == 0 || day==6) {
document.write("<font color=#ff0000>"+sday[day]+"</font>")
}else
{
document.write("<font color=#FFFFFF>"+sday[day]+"</font>")
}
document.write("</center></td></tr><tr><td><center><font size=2>")
document.write("<font color=#FFFFFF>"+smonth[calendar.getMonth()]+"</font>")
document.write("</font></center></td></tr><tr><td><center><font size=6  color=#FFFFFF>")
document.write(calendar.getDate())
document.write("</font></center></td></tr><tr><td><center><font size=2 color=#FFFFFF>")
document.write(calendar.getFullYear())
document.write("</font></center></td></tr></table>")
//-->
</script>


		</td>
	</tr>
</table>
<table class="mn" id="table2">

<?php

//переключение режимов
if ($action>=0 && $action<=27){include_once 'action/'.$action.'.php';}

mysqli_close($dbI);
?>		

<tr><td class="mnbd">&nbsp;
<?php
if ($action>100 && $action<99)
{
?>
<FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=1">
    <input class="inp_home" type="submit" value="< Запись сначала" onMouseOver="window.status=''; return null;">
</FORM>
<?php
}
if ($action>0)
{
?>
<FORM class="frm_button_home" action="<?php echo $PHP_SELF ?>">
    <input class="inp_home" type="submit" value="< Главное меню" onMouseOver="window.status=''; return null;">
</FORM>
<?php
}
?>
<form class="clc" name=clock>
    <input type=text class="input-time" name="full">
<script type="text/javascript">
fulltime();
</script>
</form>
</td></tr>
</table>
</body>
</html>
