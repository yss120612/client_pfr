<?php
session_start();

setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'russian');

$vLogin =  $_REQUEST['j_username'];
$vPassword = $_REQUEST['j_password'] ;



$_SESSION['s_login'] = $vLogin;
$_SESSION['s_pass'] = $vPassword;

include_once("loginI.php");


	
$queryL  = mysqli_query($dbI,"Select kab, fio, frang,reg,office from specialict where flogin = '$vLogin' and fpassword = '$vPassword'");
$massivL = mysqli_fetch_row($queryL);
$num_rows = mysqli_num_rows($queryL) ;
$admsiteref = '#';
$remarks = 'Нет значения';
$sqltxt = "Select refname, remarks  from admref where orders = 0";
$qadmmenu = mysqli_query($dbI,$sqltxt);
$rajon=$massivL[3];
$sub_rajon=$massivL[4];

$_SESSION['rajon'] =$rajon;
$_SESSION['sub_rajon'] =$sub_rajon;


$queryT  = mysqli_query($dbI,"Select region, dist from title where dst_kod=".$rajon);
$massivT = mysqli_fetch_row($queryT);
$num_rows_t = mysqli_num_rows($queryT) ;



if ($num_rows_t)
	{
	$tRegion=$massivT[0];
	$tDist=$massivT[1];
	}
else
	{
	$tRegion = '';
	$tDist = '';
	}



if ($qadmmenu)
	{
	while($row = mysqli_fetch_row($qadmmenu))
	{
      $admsiteref = $row[0];
      $remarks = $row[1];
   	}
	}
?>

<html>
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Style-Type" content="text/css">
<!--<link rel="stylesheet" type="text/css" href="cssmenustyles.css">-->
<!--<script language="javascript" src="cssmenujs.js" type="text/javascript"></script>-->
<link rel="stylesheet" href="/css/liMenuHor.css">
<link rel="stylesheet" href="/css/liMenuHorTheme-gray.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap-3.3.5.min.css"  />
<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css"  />

<!--<script src="/js/jquery-1.8.min.js"></script>-->
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/jquery.liMenuHor.js"></script>
<script type="text/javascript" src="/js/bootstrap-3.3.5.min.js"></script> 


<title>ПТК Клиент ПФР</title>
</head>


<body background="image/glabkgnd.jpg"  bgcolor="#C0C0C0" link="#FFFFFF" vlink="#FFFFFF" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" text="#0A50A1">
<p class="h5 text-right text-info"><?php echo $massivL[1];?>&nbsp;&nbsp;&nbsp;&nbsp;</p>
<table border="0" width=100% cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">
		&nbsp; </td>
		<td>
		<h3 align="center"><b>
		ОТДЕЛЕНИЕ ПЕНСИОННОГО ФОНДА РОССИЙСКОЙ ФЕДЕРАЦИИ<br>
		(государственное учреждение)<br>
		по <?php echo "$tRegion"?></b></h3></td>
	</tr>
	<tr>
		<td width="40">
		&nbsp;</td>
		<td>
		<h2 class="text-danger text-center">
		
		ПТК &quot;КЛИЕНТ ПФР&quot<br>
		<?php echo "$tDist"?>
		</h2></td>
	</tr>
</table>

<?php 
if ($num_rows) 
{
$_SESSION['err']=0;
// Блок если найден пользователь в базе
    if ($massivL[2] == 4) 
    {
	// Блок для администратора
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">
		
		<!--<li><a href="main/main.php">Диспетчер</a></li>
		<li><a href="#">Специалисты</a>
		<ul>-->
		<?php 
		//$queryK  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
		//$queryV  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
		//$num_rows_k = mysqli_num_rows($queryK) ;
		//$num2 = $num_rows_k%5 ;
		//$num1 = round(($num_rows_k -$num2)/5) ;
		//$jj = 0 ;
		//$nstart = 0;
		//$nend = 0;
		//$qq =0;
		//if ($num2 > 0) {$num1 = $num1 + 1;}
		//	for ($i = 0; $i <= $num1-1; ++$i){
		//	$vv = 0;
		//	$nstart = 0;
		//	for ($q = $qq; $q <= $num_rows_k-1; ++$q){
		//	if ($vv < 5){
		//		$massivK = mysqli_fetch_row($queryV);
		//		$qq = $qq + 1 ;
		//		}
		//		$vv = $vv + 1 ;
		//	}
		//	$nend = $massivK[0];
			?>
			<!-- <li><a href="#">Кабинки c <?php echo $nstart+1 ?> по <?php echo $nend?></a>
				<ul>-->
			<?php 
		//	$ff = 0;
		//	for ($j = $jj; $j <= $num_rows_k-1; ++$j){
		//		if ($ff < 5){
		//			$massivK = mysqli_fetch_row($queryK);
		//			$jj = $jj + 1 ;
					?>
		<!--			<li><a href="kab/kab_main.php?nomer_kab=<?php //echo "$massivK[0]"?>&beg_priem=0"><?php //echo "$massivK[1]"?></a></li> -->
					<?php 
		//		}
		//		$ff = $ff + 1 ;
		//	}
			?>
				<!--</ul></li> -->
			<?php 
			//}
			?>
			<!--</ul>
			</li>-->
			<!--<li><a href="reports/reports.php">Отчеты</a></li>-->			
			<!--<li><a href="telefon/add.php">Cправочный телефон</a></li>-->
			<li><a href="#">Администратор</a>
			<ul>
			<li><a href="/admcs" >Администрирование КС</a></li>                        			
			<!--<li><a href="zapis/table_type_kab.php"> Типы обращения и кабинки (привязка типов обр. с кабинками)</a></li>			-->
			
			</ul>
			<li><a href="/close.php">Выход</a></li>
			</ul>
			
			
			</div>
			</td>
		</tr>
	</table></center>
	<?php 
    }
    elseif ($massivL[2] == 1) 
    {
	// Блок руководителя
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<div>
		<!--<ul id="cssmenu">-->
		<ul class="menu_hor">
		<li><a href="main/main.php">Диспетчер</a>
		</li>
		<!--<li><a href="#">Специалисты</a>
		<ul>-->
<?php 
	
	//	$queryK  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
	//	$queryV  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
	//	$num_rows_k = mysqli_num_rows($queryK) ;
	//	$num2 = $num_rows_k%5 ;
	//	$num1 = round(($num_rows_k -$num2)/5) ;
	//	$jj = 0 ;
	//	$nstart = 0;
	//	$nend = 0;
	//	$qq =0;
	//	if ($num2 > 0) {$num1 = $num1 + 1;}
	//		for ($i = 0; $i <= $num1-1; ++$i) 
	//		{
?>
			<?php 
		//	$vv = 0;
		//	$nstart = 0;
		//	for ($q = $qq; $q <= $num_rows_k-1; ++$q)
		//	{
		//	if ($vv < 5)
		//	{
		//	$massivK = mysqli_fetch_row($queryV);
		//	$qq = $qq + 1 ;
		//	}
		//	$vv = $vv + 1 ;
		//	}
		//	$nend = $massivK[0];
			?>
			 <!--<li><a href="#">Кабинки c <?php //echo $nstart+1 ?> по <?php //echo $nend?></a>
			<ul>-->
			<?php
			//$ff = 0;
			//for ($j = $jj; $j <= $num_rows_k-1; ++$j)
			//{
			//if ($ff < 5)
			//{
			//$massivK = mysqli_fetch_row($queryK);
			//$jj = $jj + 1 ;
			?>
			 <!--<li><a href="kab/kab_main.php?nomer_kab=<?php //echo "$massivK[0]"?>&beg_priem=0"><?php //echo "$massivK[1]"?></a></li> -->
			<?php
			//}
			//$ff = $ff + 1 ;
			//}
			?>			
			<!--</ul>-->
			<?php 
			//}
		?>
		<!--</li>
		</ul>
		</li>-->
		<li><a href="reports/reports.php">Отчеты</a>
		</li>
		<!--<li><a href="zapis/left_disp.php">Предварительная запись</a>			
		</li>-->
		<!--<li><a href="telefon/add.php">Cправочный телефон</a></li>-->
		<li><a href="/close.php">Выход</a></li>
		</ul></div>
		</td>	</tr>
	</table></center>
	<?php
    }
//
    elseif ($massivL[2] == 5) 
    {
	// Блок диспетчер + телефон
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">		 
			<li><a href="main/main.php">Диспетчер</a></li>			
			<li><a href="telefon/add.php">Cправочный телефон</a></li>
			<li><a href="/close.php">Выход</a></li>
		</ul>
		</div>
		</td></tr>
	</table></center>
	<?php
    }
//
    elseif ($massivL[2] == 2) 
    {
	// Блок диспетчера
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">
		<li><a href="main/main.php">Диспетчер</a></li>
		<li><a href="zapis/table_type_kab.php?rajon=<?php echo $massivL[3];?>&sub_rajon=<?php echo $massivL[4];?>"> Типы обращения и кабинки (привязка типов обр. с кабинками)</a></li>
		<li><a href="/close.php">Выход</a></li>
		</ul>
		</div>
		</td>	</tr>
	</table></center>
	<?php
    }

    elseif ($massivL[2] == 6) 
    {
	// Блок Архивариуса
	?>
	<script lahguage="JavaScript">
		window.location.replace('kab/arj.php');	
	</script>
	<?php
	
    }
	elseif ($massivL[2] == 7) 
    {
	// Блок для Диспетчер+специалист
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">
		
		<li><a href="main/main.php">Диспетчер</a></li>
		<li><a href="#">Специалисты</a>
		<ul>
		<?php 
		$queryK  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' AND reg=".$rajon." AND office=".$sub_rajon." group by kab ");
		$queryV  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' AND reg=".$rajon." AND office=".$sub_rajon." group by kab ");
		$num_rows_k = mysqli_num_rows($queryK) ;
		$num2 = $num_rows_k%5 ;
		$num1 = round(($num_rows_k -$num2)/5) ;
		$jj = 0 ;
		$nstart = 0;
		$nend = 0;
		$qq =0;
		if ($num2 > 0) {$num1 = $num1 + 1;}
			for ($i = 0; $i <= $num1-1; ++$i){
			$vv = 0;
			$nstart = 0;
			for ($q = $qq; $q <= $num_rows_k-1; ++$q){
			if ($vv < 5){
				$massivK = mysqli_fetch_row($queryV);
				$qq = $qq + 1 ;
				}
				$vv = $vv + 1 ;
			}
			$nend = $massivK[0];
			?>
			 <li><a href="#">Кабинки c <?php echo $nstart+1 ?> по <?php echo $nend?></a>
				<ul>
			<?php 
			$ff = 0;
			for ($j = $jj; $j <= $num_rows_k-1; ++$j){
				if ($ff < 5){
					$massivK = mysqli_fetch_row($queryK);
					$jj = $jj + 1 ;
					?>
					<li><a href="kab/kab_main.php?nomer_kab=<?php echo $massivL[0];?>&beg_priem=0&rajon=<?php echo $massivL[3];?>&sub_rajon=<?php echo $massivL[4];?>"><?php echo "$massivK[1]"?></a></li> 
					<?php 
				}
				$ff = $ff + 1 ;
			}
			?>
				</ul></li> 
			<?php 
			}
			?>
			</ul>
			</li>	
			<li><a href="zapis/table_type_kab.php?rajon=<?php echo $massivL[3];?>&sub_rajon=<?php echo $massivL[4];?>"> Типы обращения и кабинки (привязка типов обр. с кабинками)</a></li>
			<li><a href="/close.php">Выход</a></li>
			</ul>
			
			
			</div>
			</td>
		</tr>
	</table></center>
	<?php 
    }
	elseif ($massivL[2] == 8) 
    {
	// Блок руководителя района
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<div>
		<!--<ul id="cssmenu">-->
		<ul class="menu_hor">
		<li><a href="main/main.php">Диспетчер</a>
		</li>
		<!--<li><a href="#">Специалисты</a>
		<ul>-->
<?php 
	
	//	$queryK  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
	//	$queryV  = mysqli_query($dbI,"Select kab, vid_name from specialict where priem = '1' group by kab ");
	//	$num_rows_k = mysqli_num_rows($queryK) ;
	//	$num2 = $num_rows_k%5 ;
	//	$num1 = round(($num_rows_k -$num2)/5) ;
	//	$jj = 0 ;
	//	$nstart = 0;
	//	$nend = 0;
	//	$qq =0;
	//	if ($num2 > 0) {$num1 = $num1 + 1;}
	//		for ($i = 0; $i <= $num1-1; ++$i) 
	//		{
?>
			<?php 
		//	$vv = 0;
		//	$nstart = 0;
		//	for ($q = $qq; $q <= $num_rows_k-1; ++$q)
		//	{
		//	if ($vv < 5)
		//	{
		//	$massivK = mysqli_fetch_row($queryV);
		//	$qq = $qq + 1 ;
		//	}
		//	$vv = $vv + 1 ;
		//	}
		//	$nend = $massivK[0];
			?>
			 <!--<li><a href="#">Кабинки c <?php //echo $nstart+1 ?> по <?php //echo $nend?></a>
			<ul>-->
			<?php
			//$ff = 0;
			//for ($j = $jj; $j <= $num_rows_k-1; ++$j)
			//{
			//if ($ff < 5)
			//{
			//$massivK = mysqli_fetch_row($queryK);
			//$jj = $jj + 1 ;
			?>
			 <!--<li><a href="kab/kab_main.php?nomer_kab=<?php //echo "$massivK[0]"?>&beg_priem=0"><?php //echo "$massivK[1]"?></a></li> -->
			<?php
			//}
			//$ff = $ff + 1 ;
			//}
			?>			
			<!--</ul>-->
			<?php 
			//}
		?>
		<!--</li>
		</ul>
		</li>-->
		<li><a href="reports/reports.php">Отчеты</a>
		</li>
		<!--<li><a href="zapis/left_disp.php">Предварительная запись</a>			
		</li>-->
		<!--<li><a href="telefon/add.php">Cправочный телефон</a></li>-->
		<li><a href="/close.php">Выход</a></li>
		</ul></div>
		</td>	</tr>
	</table></center>
	<?php
    }
	
    else 
    {
	// Блок специалиста
	?>
	<script lahguage="JavaScript">
		window.location.replace('kab/kab_main.php?nomer_kab=<?php echo $massivL[0];?>&beg_priem=0&rajon=<?php echo $massivL[3];?>&sub_rajon=<?php echo $massivL[4];?>');	
	</script>
	<?php
    }
}
else 
{
// Блок если пользователя в базе нет
$_SESSION['err']=1;
?>
<table border="0" width=100% cellspacing="0" cellpadding="0" id="table1">
  <tr>
	<td width="40">&nbsp; </td>
	<td>
	<font color="#000000">
	<SCRIPT type="text/javaScript">
      	//alert ('Введен неправильный логин-пароль. Повторите снова.');
		window.location.replace('index.php');	
	</script>
	</font></td>
  </tr>
</table>
<?php 
}
?>

<script>
$(function(){
  $('.menu_hor').liMenuHor();
});
</script>

</body>
</html>