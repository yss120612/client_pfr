<?php
session_start();

setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'russian');

$vLogin =  $_REQUEST['j_username'];
$vPassword = $_REQUEST['j_password'] ;

$_SESSION['s_login'] = $vLogin;
$_SESSION['s_pass'] = $vPassword;

include_once("loginI.php");
	
$queryL  = mysqli_query($dbI,"Select kab, fio, frang,reg,office,id from specialict where flogin = '{$vLogin}' and (fpassword = '{$vPassword}' or fpassword=password('{$vPassword}'))");
$massivL = mysqli_fetch_row($queryL);
$have_user = mysqli_num_rows($queryL);
mysqli_free_result($queryL);	  


$num_rows_t = 0;
$tRegion = '';
$tDist = '';
$raion=0;
$sub_raion=0;
$frang=0;
$num_rows_t=0;
$current_id=0;

 if ($have_user>0 && isset($vPassword) && $vPassword!='')
 {
 // Блок если найден пользователь в базе	
 $_SESSION['err'] = 0;
 $frang = $massivL[2];		
 $raion = $massivL[3];
 $sub_raion = $massivL[4];
 $nomer_kab = $massivL[0];
 $id_spec = $massivL[5];
 $_SESSION['rajon'] = $raion;
 $_SESSION['sub_rajon'] = $sub_raion;
 $_SESSION['frang'] = $frang;
 $_SESSION['$current_id'] = $current_id;
 $queryT  = mysqli_query($dbI,"Select region, dist from title where dst_kod={$raion}");
 $massivT = mysqli_fetch_row($queryT);
 $num_rows_t = count($massivT);
  if ($num_rows_t>1)
	  {
	  $tRegion=$massivT[0];
	  $tDist=$massivT[1];
	  }
 mysqli_free_result($queryT);	  
 
 $link_dispatcher="<li><a href=\"main/main.php\">Диспетчер</a></li>";
 $link_admin="<li><a href=\"/admcs\" >Администрирование КС</a></li>";
 $link_reports="<li><a href=\"reports/reports.php\">Отчеты</a></li>";
 $link_kab_types="<li><a href=\"zapis/table_type_kab.php?rajon={$raion}&sub_rajon={$sub_raion}\"> Типы обращения и кабинки (привязка типов обр. к кабинкам)</a></li>";
 $link_kab_select="kab/kab_main.php?nomer_kab={$nomer_kab}&rajon={$raion}&sub_rajon={$sub_raion}";
 $link_exit="<li><a href=\"/close.php\">Выход</a></li>";
 }
 else
 { // Блок если пользователя в базе нет
	$_SESSION['err']=1;
	$_SESSION['s_login'] = '';
	echo "<SCRIPT type=\"text/javaScript\">window.location.replace(\"index.php\");</script>";	 
 }




include("/inc/head.php");

?>
<link rel="stylesheet" href="/css/liMenuHor.css">
<link rel="stylesheet" href="/css/liMenuHorTheme-gray.css">
<script src="/js/jquery.liMenuHor.js"></script>
</head>
<?php 
include("/inc/body.php");
?>
<p class="h5 text-right text-info"><?php echo $massivL[1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>
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
/*
0-Не определено
2-Диспетчер
1-Руководитель
3-Оператор
4-Администратор
5-Диспетчер+Телефон нет
6-Архивариус нет
7-Диспетчер+Оператор 
8-Руководитель района нет
*/
switch ($frang)
    {
		
	case 1:
	// Блок руководителя подрайона//////////////////////////////////////////////////////////////////////////////////////////////////
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<div>
			<ul class="menu_hor">
				<?php echo $link_dispatcher ?>	
				<?php echo $link_reports ?>	
				<?php echo $link_exit ?>	
			</ul>
		</div>
		</td>
	</tr>
	</table></center>
	<?php
	break;
	
	case 2:
	// Блок диспетчера
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">
		<?php echo $link_dispatcher ?>	
		<?php echo $link_kab_types ?>	
		<?php echo $link_exit ?>	
		</ul>
		</div>
		</td>	</tr>
	</table></center>
	<?php
	break;
		
	case 4:	
	// Блок для администратора////////////////////////////////////////////////////////////////////////////////////////////
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<div>
			<ul class="menu_hor">
				<li><a href="#">Администратор</a>
				<ul>
					<?php echo $link_admin ?>	
				</ul>
				<?php echo $link_exit ?>	
		</ul>
		</div>
		</td>
		</tr>
	</table></center>
	<?php 
    //}
	break;

	case 7:
    // Блок для Диспетчер+специалист
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<!--<ul id="cssmenu">-->
		<div>
		<ul class="menu_hor">
		<?php echo $link_dispatcher ?>
		<li><a href="#">Специалисты</a>
		<ul>
		<?php 
		$queryK  = mysqli_query($dbI,"Select kab, FIO from specialict where priem = '1' AND reg=".$raion." AND office=".$sub_raion." group by kab order by kab ");
		$num_rows_k = mysqli_num_rows($queryK) ;
		$group_count=5;
		$sub_menu_count=(integer)($num_rows_k/$group_count);
		$last_menu_count=$num_rows_k%$group_count;
		if ($last_menu_count>0)
		{
		 $sub_menu_count+=1;	
		}
		
		$ii=0;$jj=0;
		while ($massivK = mysqli_fetch_row($queryK))
		{
		if ($ii==0)
		{
			echo "<li><a href=\"#\">Кабинки c ". ($jj*$group_count+1) ." по ". (($jj+1)*$group_count) ."</a>\n";	
			echo "<ul>\n";
		}
		if ($nomer_kab==$massivK[0])
		{
		echo "<li><a href=\"kab/kab_main.php?nomer_kab={$massivK[0]}&rajon={$raion}&sub_rajon={$sub_raion}\">{$massivK[1]}</a></li>\n";
		}
		$ii+=1;
		
		if ($ii>=$group_count)	
			{
				echo "</ul>\n";	
				echo "</li>\n";	
				$jj+=1;
				$ii=0;
			}
		}
		
		if ($ii!=0)
		{
			echo "</ul>\n";	
			echo "</li>\n";	
		}
		
		mysqli_free_result($queryK);
		
			?>
			</ul>
			</li>	
				<?php echo $link_kab_types ?>	
				<?php echo $link_exit ?>	
			</ul>
			
			
			</div>
			</td>
		</tr>
	</table></center>
	<?php 
	break;
	
	case 8:
	// Блок руководителя района
	?>
	<center><table border="0" width="1024" cellspacing="0" cellpadding="0" id="table1">
	<tr>
		<td width="40">&nbsp;</td>
		<td>
		<div>
		<!--<ul id="cssmenu">-->
		<ul class="menu_hor">
			<?php echo $link_dispatcher ?>	
			<?php echo $link_reports ?>	
			<?php echo $link_exit ?>	
		</ul>
		</div>
		</td></tr>
	</table></center>
	<?php
	break;
	
	default:	
	// Блок специалиста
	?>
	<script lahguage="JavaScript">
		window.location.replace('<?php echo $link_kab_select ?>');	
	</script>
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