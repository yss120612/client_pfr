<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="../styles.css" type="text/css" >
</head> 
<body background="../image/glabkgnd.jpg">

 <?php

//$view_=(isset($_REQUEST['view']))?$_REQUEST['view']:'';
//$f_=(isset($_REQUEST['fa']))?TRIM($_REQUEST['fa']):'';
//$n_=(isset($_REQUEST['na']))?TRIM($_REQUEST['na']):'';
//$p_=(isset($_REQUEST['pa']))?TRIM($_REQUEST['pa']):'';
//$ins_=(isset($_REQUEST['sn']))?TRIM($_REQUEST['sn']):'';
//$lch_=(isset($_REQUEST['pd']))?TRIM($_REQUEST['pd']):'';
//$f_ = STRTR( $f_, 'йцукенгшщзхъфывапролджэячсмитьбюё', 'ЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ'); 
//$n_ = STRTR( $n_, 'йцукенгшщзхъфывапролджэячсмитьбюё', 'ЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ');
//$n__ = $n_[0];
//$p_ = STRTR( $p_, 'йцукенгшщзхъфывапролджэячсмитьбюё', 'ЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ');
//$p__ = $p_[0];
//$t_=(isset($_REQUEST['tel']))?TRIM($_REQUEST['tel']):'';
//$di_=(isset($_REQUEST['dop']))?TRIM($_REQUEST['dop']):'';

//if ($f_<>"")
 //  {$href_="vopros.php";
//     $href_home="fio_predvar.php";
//     $param ="?fa=".$f_. "&na=".$n_."&pa=". $p_ ."&sn=". $ins_ ."&pd=". $lch_ ."&tel=" . $t_."&dop=" . $di_;
//     echo "<h2 align=center>Ф.И.О. посетителя: " . $f_.  " " . $n__ . "." . $p__ . ".,  СНИЛС: " .  $ins_ .  ",  Пенс. дело: " . $lch_ . ". </h2>";
//     echo "<h2 align=center>Телефон: " . $t_. ",  Дополнительные сведения: " .  $di_ . ". </h2>";
  //  }
//else
//    {
    $href_="main.php";
     $href_home="../main.php";
     $param="?view_=123";
	// }    
echo "<body>\n<h2 align=center>Выберите день.</h2>";
date_default_timezone_set ('Asia/Irkutsk');
$DY=array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
$MY=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
$m1=(isset($_REQUEST['m1']))?$_REQUEST['m1']:date('n');
$y1=(isset($_REQUEST['y1']))?$_REQUEST['y1']:date('Y');
$d1=(isset($_REQUEST['d1']))?$_REQUEST['d1']:0;

$PHP_SELF=$_SERVER['PHP_SELF'];
  // Счётчик для дней месяца
$m0=($m1>1)?($m1-1):12;
$m2=($m1<12)?($m1+1):1;
$y0=($m1>1)?$y1:$y1-1;
$y2=($m1<12)?$y1:$y1+1;

$day_count = 1;
$dayofmonth = date('t',mktime(0, 0, 0, $m1,1,$y1));
$dayofweek = date('w', mktime(0, 0, 0, $m1,1,$y1))-1;
if($dayofweek <0) $dayofweek = 6; 
$shft=$dayofweek;
echo "<table class=\"tcdr\" align=center>";
echo "<tr>\n<td class=\"cdrn\"> <a class=\"cdr\" href=".$PHP_SELF. $param . "&m1=". $m1 ."&y1=". ($y1-1) .
 	"> год- </a> </td> <td class=\"cdrn\"><a href=".$PHP_SELF. $param . "&m1=". $m0 ."&y1=". $y0 ."> мес.- </a></td>\n";
echo "<td colspan=\"3\" class=\"cdrn\" align=\"right\">". $MY[$m1-1] ." ". $y1 ."</td>\n";
echo "<td class=\"cdrn\"><a href=".$PHP_SELF. $param . "&m1=". $m2 ."&y1=". $y2 ."> мес.+ </a></td> <td class=\"cdrn\"><a href=".$PHP_SELF. $param. "&m1=". $m1 ."&y1=".($y1+1)."> год+ </a></td>\n</tr>\n";

for($j = -1; $j < (($shft+$dayofmonth>35)?6:(($shft+$dayofmonth<29)?4:5)); $j++)
  {
  echo "<tr>\n";
  for($i = 0; $i < 7; $i++)
  {
   $dc=$j*7+$i;
   if ($dc<$shft || $dc>$dayofmonth+$shft-1) 
   {
   if ($dc<0) {echo "<td class=\"cdrn\">".$DY[$i]."</td>\n";} else {echo "<td td class=\"" . (($i<5)?'cdr':'cdrv') ."\">-</td>\n";}
   }
   else
   {
   if ($i<5 and time()<mktime(0, 0, 0, $m1, $day_count, $y1))
   {//рабочий
   echo "<td class=\"" . (($i<5)?'cdr':'cdrv') ."\"><a href=". $href_ . $param . "&m1=". $m1 ."&y1=". $y1 ."&d1=". $day_count .">". $day_count ."</a></td>\n";
   }
   else
   {//выходной
   echo "<td class=\"" . (($i<5)?'cdr':'cdrv') ."\">". $day_count ."</a></td>\n";
   }
   $day_count++;
   }
  }//for i
  echo "</tr>\n";
}//for j  
echo "</table>\n</body>\n</html>";
if ($f_<>"")
	{
	echo "<h2 align=center><a href=". $href_home . $param .">< Назад</a></h2>";
	}
else
	{
	session_start();
	$lll = $_SESSION['s_login'] ;
	$ppp = $_SESSION['s_pass'] ;
	echo "<form action='../main.php'  method='POST'>";
	echo " <input type='hidden' name='j_username' value=". $lll  ." >" ;
	echo " <input type='hidden' name='j_password' value=". $ppp  ." >" ;
	echo "<center><input type='submit' value='В главное меню' style='width:150px;height:30px;'></center>";
	echo "</form>";
}
?>
</body></html>



