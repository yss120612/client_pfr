<?php 
session_start();
header("Cache-Control: no-store"); 
header("Expires: " .  date("r"));

$lll = $_SESSION['s_login'] ;
$ppp = $_SESSION['s_pass'] ;

$PHP_SELF=$_SERVER['PHP_SELF'];
$nomer_kab=$_REQUEST['nomer_kab'];
$posetits=(isset($_REQUEST['posetits']))?$_REQUEST['posetits']:0;
$RADD=$_SERVER['REMOTE_ADDR'];
$rajon=$_REQUEST['rajon'];
$sub_rajon=$_REQUEST['sub_rajon'];

include_once("../loginI.php");

include("../inc/head.php");
?>
<!--link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>        
<link href="/css/validationEngine.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" /-->
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/ >
<link rel="stylesheet" type="text/css" href="/css/validation.css"/ >
<link rel="stylesheet" type="text/css" href="/css/styles.css" />

<script src="/js/jquery.datetimepicker.full.min.js" charset="utf-8"></script>
<!--script src="/js/showHide.js" type="text/javascript"></script>
<script src="/js/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="/js/jquery.alerts.js" type="text/javascript"></script-->
<script src="/js/jquery.validate.min.js" charset="utf-8"></script>
          

</head>
<?php 
include("../inc/body.php");
?>


echo '<html><head>';
//echo '<meta http-equiv="Refresh" content="10"; URL="' . $PHP_SELF . '?nomer_kab=' . $nomer_kab .'">'."\n";
echo '<link rel="stylesheet" href="../styles.css" type="text/css" >'."\n";
?>
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

		<style type="text/css">
		
		.input-time
{
    background-color: transparent;
    border-style:none;
    border-width:0px;
    font-size: 18pt;
    font-weight: bold;
    width:110px;
    height: 30px;
    /*color:#447bd4;	*/
    margin-right: 0px;
    margin-left: 0px;
    margin-bottom: 0px;
    margin-top: 0px;
    padding-right: 0px;
    padding-left: 0px;
    padding-bottom: 0px;
    padding-top: 0px;
    
    
}

	.table-content td{white-space: normal; min-width:20px;}
		
		</style>
		
<?php




echo '<body background="/image/glabkgnd.jpg" >'."\n";




//include_once("../obj.php");

//сколько людей в очереди
$sql="select count(*) from posetit Where otrab=0 and date_comin=current_date  AND rajon=".$rajon." AND sub_rajon=".$sub_rajon;
$result = mysqli_query($dbI,$sql) or die("Query failed select no que: " . mysqli_error());
$myrow=mysqli_fetch_row($result);
$colman=$myrow[0];
// spec
$result = mysqli_query($dbI,"SELECT priem_po_zap,FIO,active,id,frang FROM specialict Where kab=". $nomer_kab." AND reg=".$rajon." AND office=".$sub_rajon); 
$myrow=mysqli_fetch_row($result);
echo "<H2><center>Кабинка <span class='text-info'>№ ". $nomer_kab ."</span> клиентской службы</center> </H2>\n";
echo "<H3><center>Прием ведет специалист <span class='text-info'>".$myrow[1]."</span></center></H3>\n"; 
//echo "<H3><center>Прием ведет специалист ".$myrow[1].", текущее время ". date( 'H:i' ). " .</center></H3>\n"; 
$priem_po_zap=$myrow[0];$status=$myrow[2];$id_spec=$myrow[3];$frang=$myrow[4];//$status перерыв-2  прием-1 


if ($status)
{//если не ушел на перерыв
	$stop_button='Уйти на перерыв';    $beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='';
	$sql="select a.id,CONCAT (a.family,' ',SUBSTRING(a.name,1,1),'.',SUBSTRING(a.father,1,1),'.'),b.name,otrab,b.help from posetit  a JOIN types_obr b ON b.id=a.type_obr  Where otrab>6 and kab=". $nomer_kab ." AND rajon=".$rajon." AND sub_rajon=".$sub_rajon." and date_comin=current_date";
	$result = mysqli_query($dbI,$sql) or die("Query failed select begin_priem : " . mysqli_error()); 
	$myrow=mysqli_fetch_row($result);
	if(is_null($myrow[0])) 
	{//если нет человека на приеме
		
		if(!$colman) {$beg_call='disabled';} else {$beg_call='';}
		$id=0;	$stop_disabled='';	$beg_dis='disabled';$end_dis='disabled';} 
	else 
	{//если человек на приеме или вызван 
		$id=$myrow[0];$fam=$myrow[1];$vopros=$myrow[2];$help=$myrow[4];
		$stop_disabled='disabled';$beg_dis='';$call_dis='disabled';
		if($myrow[3]==8){$priem=8;
			$del_dis='disabled';$beg_dis='disabled';$end_dis='';}
		else{$priem=7;$del_dis='';}
	}
}
else{
	$stop_button='Приступить к работе';$beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='disabled';
}
//echo $vopros,$help;

if(isset($_REQUEST['bstop'])) 
{//если перерыв или приступаем к работе
	if ($status)	{
		$status=0;$stop_button='Приступить к работе';$beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='disabled';
		$sql_br="call start_break(".$id_spec.")";
		}
	else {
		$status=1;$stop_button='Уйти на перерыв';    $beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='';
		$sql_br="call end_break(".$id_spec.")";
		}
	$sql="Update specialict SET active='". $status. "' where id=".$id_spec;
	mysqli_query($dbI,$sql_br);  
	mysqli_query($dbI,$sql);  
	unset($_REQUEST['bstop']);
}

if(isset($_REQUEST['bcall'])) 
{//если мы хотим вызвать
	unset($_REQUEST['bcall']);
	
	
	$sql="select a.id,CONCAT (a.family,' ',SUBSTRING(a.name,1,1),'.',SUBSTRING(a.father,1,1),'.'),
		b.name from posetit a 
		JOIN types_obr b ON b.id=a.type_obr  
		Where date_comin=current_date and otrab='0' AND rajon=".$rajon." AND sub_rajon=".$sub_rajon." 
		AND a.type_obr IN (SELECT id_vopr from spec_vopr where id_spec=".$id_spec.") order by time_comin limit 1";
	$result = mysqli_query($dbI,$sql) or die("Query failed select call: " . mysqli_error()); 
	$myrow=mysqli_fetch_row($result);$id=$myrow[0];$fam=$myrow[1];$vopros=$myrow[2];
	
	if(!empty($myrow)){
		$result = mysqli_query($dbI,"UPDATE posetit SET otrab=7,kab=". $nomer_kab .", ip='". $RADD ."',  user='".$lll."'  
		Where id=". $id) or die("Query failed10 : " . mysqli_error($dbI)); 
		$beg_dis='';$del_dis='';$end_dis='disabled';$stop_disabled='disabled';$call_dis='disabled';
		$priem=7;$colman=$colman-1;
	}
	else{
		$priem=9;
	}
	
} 

if(isset($_REQUEST['bok'])) 
{//если мы хотим отметить что отработали чела otrab=1
	unset($_REQUEST['bok']);
	$sql="UPDATE posetit SET otrab=1, ip='". $RADD ."', time_end_p=current_time, user='".$lll."' Where id=". $id;
	$result = mysqli_query($dbI,$sql) or die("Query failed10 : " . mysqli_error()); 
	$stop_button='Уйти на перерыв';    $beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='';$stop_disabled='';
	$priem=0;
} 

if(isset($_REQUEST['bbegin'])) 
{//если начало приема otrab=8
	unset($_REQUEST['bbegin']);
	
	$sql_time_nach_p="SELECT time_nach_p from posetit WHERE id=". $id;
	$res_time_nach_p=mysqli_query($dbI,$sql_time_nach_p) or die("Query failed get time_nach_p : " . mysqli_error($dbI)); 
	$time_nach_p = mysqli_fetch_row($res_time);
	
	if(empty($time_nach_p[0])){
		$sql="UPDATE posetit SET otrab=8, kab=". $nomer_kab .",time_nach_p=current_time, user='".$lll."'  	WHERE id=". $id;
	}
	else{
		$sql="UPDATE posetit SET otrab=8, kab=". $nomer_kab .",time_nach_p='".$time_nach_p."', user='".$lll."'  	WHERE id=". $id;
	}
	
	
	//$sql="UPDATE posetit SET otrab=8, kab=". $nomer_kab .",time_nach_p=current_time, user='".$lll."'  	WHERE id=". $id;
	mysqli_query($dbI,$sql) or die("Query failed update posetit : " . mysqli_error()); 
	$beg_dis='disabled';$end_dis='';$del_dis='disabled';
	
	$priem=8;
}  

if(isset($_REQUEST['bdelete'])) 
{//если мы хотим отметить чела как отказ otrab=2
	if ($id<>0) {$beg_dis='';$end_dis='disabled';}
	mysqli_query($dbI,"Update posetit SET otrab=2, ip='". $RADD ."', user='".$lll."'  Where id=". $id);  
	unset($_REQUEST['bdelete']);
	$beg_dis='disabled';$end_dis='disabled';$del_dis='disabled';$call_dis='';$stop_disabled='';
	$priem=0;
}

if(isset($_REQUEST['edit'])) 
{//Уточняем вопрос
    $sql="Update posetit SET type_obr=". $_REQUEST['vopros'] ." Where id=". $_REQUEST['id_posetit'];
    mysqli_query($dbI,$sql) or die("Query failed edit: " . mysqli_error());  
	unset($_REQUEST['edit']);
	$sql="select name,help from types_obr Where id=". $_REQUEST['vopros'];
	$result = mysqli_query($dbI,$sql) or die("Query failed select no que: " . mysqli_error());
	$myrow=mysqli_fetch_row($result);
	$vopros=$myrow[0];$help=$myrow[1];
}

if(isset($_REQUEST['refrech'])) 
{//обновление экрана
unset($_REQUEST['refresh']);}  
//<h2 class='h2 text-center text-danger'>Время приёма:</h2>

if ($priem==7){echo "<H2><center>Вызван  <span class='text-danger'>". $fam ."</span> по вопросу   <span class='text-danger'>".$vopros."</span></center> </H2>\n";}
if ($priem==8){echo "<H2><center>На приеме <span class='text-success'>". $fam ."</span> по вопросу   <span class='text-success'>".$vopros."</span></center> </H2>
				
				<h2 class='h2 text-center text-danger'>Время приёма: <span  id='timer'></span></h2>
				";
				$sql_time="SELECT TIME_TO_SEC(TIMEDIFF(current_time,time_nach_p)) from posetit WHERE id=". $id;
				$res_time=mysqli_query($dbI,$sql_time) or die("Query failed get time : " . mysqli_error($dbI)); 
				$time_diff = mysqli_fetch_row($res_time);
	
				echo '<input type="hidden" id="hdnTimer" value="'.$time_diff[0].'">';
				
				
				}
if ($priem==9){echo "<H2><center><span class='text-danger'>По вопросам данного специалиста нет посетителей</span></center> </H2>\n";}				
				
echo   " <H2 class='text-center'> Количество людей в очереди -  ". $colman."</H2>" ;
//делаем посетителей 
$sql="select family,b.name,time_comin,time_nach_p,time_end_p,otrab from posetit a JOIN types_obr b ON b.id=a.type_obr 
	where date_comin=current_date  AND rajon=".$rajon." AND sub_rajon=".$sub_rajon." order by time_comin";
$result = mysqli_query($dbI,$sql) or die("Query failed 4: " . mysqli_error()); 
$Colposetit=mysqli_num_rows($result);
/*
if($nomer_kab==7)
{// Режим отладки только для седьмой
	$ColWidth=array(150,350,150);//размер колоночег
	echo '<div align="center"><TABLE class="operator">';
	echo "\n<TR>\n";
	echo "<TH width='$ColWidth[0]'>  Посетитель </TH>\n";
	echo "<TH width='$ColWidth[1]'>  Цель обращения </TH>\n";
	echo "<TH width='$ColWidth[2]'>  Время записи </TH>\n";
	echo "<TH width='$ColWidth[2]'>  Время beg </TH>\n";echo "<TH width='$ColWidth[2]'>  Время end </TH>\n";echo "<TH width='$ColWidth[2]'> otrab </TH>\n";
	echo "</TR>\n";
	while ($R=mysqli_fetch_row($result))
	{	echo "<tr>\n";  
		echo "<td width='$ColWidth[0]'>". $R[0] ."</td>\n";
		echo "<td width='$ColWidth[1]'>". $R[1] ."</td>\n";
		echo "<td width='$ColWidth[1]'>". $R[2] ."</td>\n";
		echo "<td width='$ColWidth[1]'>". $R[3] ."</td>\n";	
		echo "<td width='$ColWidth[1]'>". $R[4] ."</td>\n";	echo "<td width='$ColWidth[1]'>". $R[5] ."</td>\n";	
		echo "</tr>";  
	}
echo "</table>\n";
}//закончили с табличкой
 */
 echo "<form name='frm1' action=". $PHP_SELF ."?nomer_kab=". $nomer_kab ."&rajon=".$rajon."&sub_rajon=".$sub_rajon." method=post>";

echo "<br>";

if ($beg_dis==''){
$sql="select a.id,family,b.name from posetit a JOIN types_obr b ON b.id=a.type_obr 
	where date_comin=current_date and otrab=0 order by time_comin";
}
 else {$sql="SELECT id,family,type_obr FROM posetit Where kab=". $nomer_kab ." and otrab=8 and date_comin=current_date order by ip";}
$result = mysqli_query($dbI,$sql) or die("Query failed 5: " . mysqli_error()); 
$myrow=mysqli_fetch_row($result);
$selected_vopros=$myrow[2];$id_posetit=$myrow[0];
echo '<div class="text-center">';
echo '<INPUT ' .$stop_disabled .' TYPE="submit" name="bstop" VALUE="'.$stop_button.'"  class="btn btn-default">';
echo '<INPUT ' . $call_dis .' TYPE="submit" name="bcall" VALUE="Вызвать" class="btn btn-default">';
echo '<INPUT ' . $beg_dis .' TYPE="submit" name="bbegin" VALUE="Начать прием" class="btn btn-default">';
echo '<INPUT ' . $end_dis .' TYPE="submit" name="bok" VALUE="Принят" class="btn btn-default">';
echo '<INPUT ' . $del_dis .' TYPE="submit" name="bdelete" VALUE="Не пришел" class="btn btn-default">';
if($nomer_kab==7){echo '<INPUT TYPE="submit" name="refresh" VALUE="Обновить список" class="btn btn-default">';}

echo '<BR>';
echo '<INPUT TYPE="hidden" name="id_posetit" VALUE='.$id_posetit.'>';
echo '</div><br>';
echo "<p class='text-center form-inline'>";
echo "<label>Уточнить вопрос&nbsp;</label><SELECT class='form-control' " . $end_dis . " name='vopros' maxlength='20'>";
$result = mysqli_query($dbI,"select t.full_name name, t.id, g.full_name gname 
	from types_obr t left join group_types_obr g on (t.group_id=g.id) 
	where actual='1' order by COALESCE(g.id,9999),t.orders") or die("Query failed : " . mysqli_error());
$tab_sql=mysqli_fetch_row($result);
$group=$tab_sql[2];
echo "<OPTGROUP LABEL='" . $tab_sql[2] . "'>";
while($tab_sql) 
{ 
	if(!($group==$tab_sql[2]))
	{	//
	echo "</OPTGROUP>";
	if($tab_sql[2]){echo "<OPTGROUP LABEL='".$tab_sql[2]."'>";}
	$group=$tab_sql[2];
	}
	if($tab_sql[2])	
	{if($selected_vopros==$tab_sql[1]){$selected="selected";} else {$selected="";}
	echo "<OPTION ".$selected." VALUE=$tab_sql[1]>$tab_sql[0] </OPTION>";
	}
 $tab_sql=mysqli_fetch_row($result);//$group=$tab_sql[2];
 }
echo '</SELECT>&nbsp;';
//echo "<br>";
echo '<INPUT ' . $end_dis .' TYPE="submit" name="edit" VALUE="записать" class="btn btn-default">';
echo "</p>";

echo '</form>';
echo "<br>";

echo '<center>';

echo $help;

echo "</center>";

if ($frang==7){
echo "<form action='../main.php'  method='POST'>";
echo " <input type='hidden' name='j_username' value=". $lll  ." >" ;
echo " <input type='hidden' name='j_password' value=". $ppp  ." >" ;
echo "<center><input type='submit' value='В главное меню' class='btn btn-default'></center>";

echo "</form>";
}
else{
	echo '<p class="text-center"><a class="btn btn-default" href="/close.php">Выход</a></p>';
}

?>




<script type="text/javascript">

if ($('#timer').length > 0) {
	start_t();
}

function start_t(){
	var elapsed_seconds;
	
	//if ($('#hdnTimer').length>0){
		elapsed_seconds =Number($('#hdnTimer').val());
	//}
	//else{elapsed_seconds = 0;}
		
	setInterval(function() {
		elapsed_seconds = elapsed_seconds + 1;
		
		$('#timer').text(get_elapsed_time_string(elapsed_seconds) );
		}, 1000);
}

function get_elapsed_time_string(total_seconds) {
  function pretty_time_string(num) {
    return ( num < 10 ? "0" : "" ) + num;
  }

  var hours = Math.floor(total_seconds / 3600);
  total_seconds = total_seconds % 3600;

  var minutes = Math.floor(total_seconds / 60);
  total_seconds = total_seconds % 60;

  var seconds = Math.floor(total_seconds);
 
  hours = pretty_time_string(hours);
  minutes = pretty_time_string(minutes);
  seconds = pretty_time_string(seconds);

  var currentTimeString = hours + ":" + minutes + ":" + seconds;

  return currentTimeString;
}



function fulltime() {
var time=new Date();
hours = time.getHours();
mins = time.getMinutes();
secs = time.getSeconds();
if (hours < 10) {hours = "0" + hours }
if (mins < 10) {mins = "0" + mins }
if (secs < 10) {secs = "0" + secs }
//datastr = ( hours + ":" + mins + ":" + secs )
datastr = ( hours + ":" + mins )
document.clock.full.value=datastr;
setTimeout('fulltime()',500)
}



</script>


<form class="clc" name=clock>
    <input type=text class="input-time text-info" name="full">
<script type="text/javascript">
fulltime();
</script>
</form>


<?php


//mysqli_close($db);	           
echo '</body>'."\n";
echo '</html>'."\n";

?>