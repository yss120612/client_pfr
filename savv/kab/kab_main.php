<?php 
session_start();
//header("Cache-Control: no-store"); 
//header("Expires: " .  date("r"));

$lll = $_SESSION['s_login'] ;
$ppp = $_SESSION['s_pass'] ;

$PHP_SELF=$_SERVER['PHP_SELF'];

//$posetits=(isset($_REQUEST['posetits']))?$_REQUEST['posetits']:0;

$RADD=$_SERVER['REMOTE_ADDR'];
$nomer_kab=isset($_REQUEST['nomer_kab'])?$_REQUEST['nomer_kab']:0;
$raion=$_REQUEST['rajon'];
$sub_raion=$_REQUEST['sub_rajon'];

$id_posetit=isset($_REQUEST['id_posetit'])?$_REQUEST['id_posetit']:0;
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;

$button_normal='btn btn-default btn-lg';
$button_hidden='btn btn-default btn-lg hidden';
$posetit_status=0;
$type_obr_name='';
$posetit_status='';
$type_obr_help='';
$type_obr_maxtime=0;
$time_nach_p='00:00:00';

			
include_once("../loginI.php");

$result = mysqli_query($dbI,"SELECT FIO,active,id,frang from specialict Where kab=". $nomer_kab." and reg=".$raion." and office=".$sub_raion); 
$myrow=mysqli_fetch_row($result);
//0 ФИО, 1-активе, 2-ид спеца, 3-ранг
//$priem_po_zap=$myrow[0];
$FIO_spec=$myrow[0];
$kab_status=$myrow[1];//перерыв-2  прием-1 
$id_spec=$myrow[2];
$frang=$myrow[3];
mysqli_free_result($result);
$data4que = array("raion" => $raion,"sub_raion" => $sub_raion,"id_spec"=>$id_spec);  


switch ($action)
{
	case 1://приступить к работе.
	$sql_br="call end_break({$id_spec})";
	mysqli_query($dbI,$sql_br);  
	break;
	case 2://перерыв
	$sql_br="call start_break({$id_spec})";
	mysqli_query($dbI,$sql_br);  
	break;
	case 3://вызвать
	$sql="select id from posetit
		Where date_comin=current_date and otrab='0' AND rajon={$raion} AND sub_rajon={$sub_raion} and 
		(type_obr in (select id_vopr from spec_vopr where id_spec={$id_spec}))
		AND (predvar='0' OR time_comin<=current_time) order by predvar desc, time_comin limit 1";
	$result = mysqli_query($dbI,$sql) or die("Query failed select call: " . mysqli_error()); 
	$myrow=mysqli_fetch_row($result);
	if(!empty($myrow)){//ставим пометочку
		$id_posetit=$myrow[0];
		mysqli_query($dbI,"UPDATE posetit SET otrab=7,kab={$nomer_kab} Where id={$id_posetit}") 
		or die("Query failed10 : " . mysqli_error($dbI)); 
	}
	mysqli_free_result($result);
	break;
	case 4://начать прием
	$sql="UPDATE posetit SET otrab=8, time_nach_p=current_time, ip='{$RADD}' , user='{$lll}', id_spec={$id_spec} WHERE id={$id_posetit}";
	$result=mysqli_query($dbI,$sql) or die("Query failed update posetit (начало приема): " . mysqli_error()); 
	mysqli_free_result($result);
	break;
	case 5://завершить прием
	$sql="UPDATE posetit SET otrab=1, time_end_p=current_time Where id={$id_posetit}";
	$result = mysqli_query($dbI,$sql) or die("Query failed10 : " . mysqli_error()); 
	mysqli_free_result($result);
	break;
	case 6://не пришел
	$result=mysqli_query($dbI,"Update posetit SET otrab=2 Where id={$id_posetit}")
			or die("Query failed update posetit (не пришел): " . mysqli_error()); 
	mysqli_free_result($result);			
	break;
	case 7://уточнить вопрос
	 $sql="Update posetit SET type_obr={$type_obr} Where id={$id_posetit}";
    mysqli_query($dbI,$sql) or die("Query failed edit: " . mysqli_error());  
	mysqli_free_result($result);
	break;
	case 8://записываем, и сразу ведем прием
	$family=isset($_REQUEST['family'])?$_REQUEST['family']:'';
	$name=isset($_REQUEST['name'])?$_REQUEST['name']:'';
	$father=isset($_REQUEST['father'])?$_REQUEST['father']:'';
	//$work_date= new DateTime();
	if ($family!="" && $name !="")
	{
    $sql="insert into posetit (family,name,father,otrab,kab,type_obr, date_comin, time_comin, predvar, ip,ipzap,dopinfo,user, userzap,rajon,sub_rajon,time_nach_p,id_spec) 
					   values (UPPER('{$family}'),UPPER('{$name}'),UPPER('{$father}'),8,{$nomer_kab},{$type_obr}, current_date,current_time,'0', '{$RADD}', '{$RADD}','self writed','{$lll}','{$lll}',{$raion},{$sub_raion},current_time,{$id_spec})";
	//echo $sql;
    mysqli_query($dbI,$sql) or die("Query failed add & save:<br>".$sql."<br>". mysqli_error());  
	mysqli_free_result($result);
	}
	break;
	default:
	break;
}



if ($action>0)
{
 if (!headers_sent()) {
 header ("location:/kab/kab_main.php?nomer_kab={$nomer_kab}&rajon={$raion}&sub_rajon={$sub_raion}",true);
 
 }
 else
 {
    echo "Заголовки уже отправлены. Редирект невозможен, пожалуйста нажмите <a href=\"".$_SERVER['PHP_SELF'] ."\">здесь</a> самостоятельно\n";
 }
 return;
}


include("../inc/head.php");
//<link rel="stylesheet" type="text/css" href="/css/styles.css" />
?>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css" />
<link rel="stylesheet" type="text/css" href="/css/validation.css" />


<script src="/js/jquery.datetimepicker.full.min.js" charset="utf-8"></script>
<script src="/js/jquery.validate.min.js" charset="utf-8"></script>
</head>
<?php 
include("../inc/body.php");

echo "<H2>\n<center>Кабинка <span class='text-info'>№ {$nomer_kab}</span> клиентской службы</center>\n</H2>\n";
echo "<H3>\n<center>Прием ведет специалист <span class='text-info'>{$FIO_spec}</span></center>\n</H3>\n"; 

echo "<div id=\"tme\">\n</div>";



$work_btn=$button_hidden;
$pereryv_btn=$button_hidden;
$call_btn=$button_hidden;
$begin_btn=$button_hidden;
$end_btn=$button_hidden;
$not_go_btn=$button_hidden;
$save_begin_btn=$button_normal;
$set_vopros_btn=$button_hidden;
$id_posetit=0;
$posetit_status=0;	
$can_call=0;
$type_need_update=false;	
	
if ($kab_status==1)
{//если не ушел на перерыв
	//$sql="select a.id,CONCAT(a.family,' ',SUBSTRING(a.name,1,1),'.',SUBSTRING(a.father,1,1),'.'),b.name,a.otrab,b.help,a.time_nach_p,b.id,b.zatrat from posetit  a JOIN types_obr b ON b.id=a.type_obr  Where otrab>6 and kab={$nomer_kab} and rajon={$raion} and sub_rajon={$sub_raion} and date_comin=current_date";
	$sql="select a.id,CONCAT(a.family,' ',a.name,' ',a.father),a.otrab,a.time_nach_p,a.type_obr from posetit a Where otrab>6 and kab={$nomer_kab} and rajon={$raion} and sub_rajon={$sub_raion} and date_comin=current_date";
	$result = mysqli_query($dbI,$sql) or die("Query failed select begin_priem : " . mysqli_error()); 
	$myrow=mysqli_fetch_row($result);
		if(is_null($myrow[0])) 
		{//если нет человека на приеме и не на перерыве кнопка вызвать (если есть очередь)
			$can_call=1;
			$pereryv_btn=$button_normal;
			//$call_btn=($queue_count==0)?$button_hidden:$button_normal;
		} 
		else 
		{//если человек на приеме или вызван 
	
			$id_posetit=$myrow[0];
			$fam=$myrow[1];
			$posetit_status=$myrow[2];
			$type_obr=$myrow[4];

			if ($type_obr>=10000)
			{
				$type_need_update=true;		
				$resultX = mysqli_query($dbI,"select full_name from group_types_obr where id={$type_obr}-10000") or die("Query failed select begin_priem : " . mysqli_error()); 
				$myrowX=mysqli_fetch_row($resultX);
				$type_obr_name=$myrowX[0];
				$type_obr_help="";
				$type_obr_maxtime=999;
				mysqli_free_result($resultX);
			}
			else
			{
				$resultX = mysqli_query($dbI,"select full_name,help,zatrat from types_obr where id={$type_obr}") or die("Query failed select begin_priem : " . mysqli_error()); 
				$myrowX=mysqli_fetch_row($resultX);
				$type_obr_name=$myrowX[0];
				$type_obr_help=$myrowX[1];
				$type_obr_maxtime=$myrowX[2];
				mysqli_free_result($resultX);
			}
			
			
			if($posetit_status==8)
			{//сидит
				if (!$type_need_update)
				{
				$end_btn=$button_normal;
				}
				$set_vopros_btn=$button_normal;
				$time_nach_p=$myrow[3];
				echo "<H2><center>На приеме <span class=\"text-success\">{$fam}</span> по вопросу: <span class=\"text-success\">{$type_obr_name}</span>\n</center>\n</H2>\n";
				echo "<H2><center><div id=\"timer_posetit\">\n</div>\n</center>\n</H2>\n";
			}
			else
			{//вызван
				$begin_btn=$button_normal;
				$not_go_btn=$button_normal;
				echo "<H2><center>Вызван  <span class=\"text-danger\">{$fam}</span> по вопросу   <span class=\"text-danger\">{$type_obr_name}</span>\n</center>\n</H2>\n";
			}
		}
}
else{//если на перерыве
	$work_btn=$button_normal;
}
mysqli_free_result($result);

echo "<form id=\"kabForm\" name=\"kabForm\" action=\"{$PHP_SELF}\" method=\"post\">\n";
echo "<br>\n";
echo "<div class=\"text-center\">";
echo "<button type=\"button\" class=\"{$work_btn}\" name=\"bwork\" onclick=\"submitForm(1)\"><span class=\"glyphicon glyphicon-bell\"></span> Приступить к работе</button>\n";
echo "<button type=\"button\" class=\"{$pereryv_btn}\" name=\"bstop\" onclick=\"submitForm(2)\"><span class=\"glyphicon glyphicon-share\"></span> Уйти на перерыв</button>\n";

if ($can_call)
{	
echo "<button type=\"button\" class=\"{$call_btn}\" id=\"bcall\" name=\"bcall\" onclick=\"submitForm(3)\"><span class=\"glyphicon glyphicon-bullhorn\"></span> Вызвать</button>\n";
}

echo "<button type=\"button\" class=\"{$begin_btn}\" name=\"bbegin\" onclick=\"submitForm(4)\"><span class=\"glyphicon glyphicon-flag\"></span> Начать прием</button>\n";
echo "<button type=\"button\" class=\"{$end_btn}\" name=\"bok\" onclick=\"submitForm(5)\"><span class=\"glyphicon glyphicon-ok-circle\"></span> Принят</button>\n";
echo "<button type=\"button\" class=\"{$not_go_btn}\" name=\"bdelete\" onclick=\"submitForm(6)\"><span class=\"glyphicon glyphicon-ban-circle\"></span> Не пришел</button>\n";

echo "<BR>\n";
echo "<INPUT TYPE=\"hidden\" name=\"id_posetit\" VALUE=\"{$id_posetit}\">\n";
echo "<INPUT TYPE=\"hidden\" name=\"nomer_kab\" VALUE=\"{$nomer_kab}\">\n";
echo "<INPUT TYPE=\"hidden\" name=\"rajon\" VALUE=\"{$raion}\">\n";
echo "<INPUT TYPE=\"hidden\" name=\"sub_rajon\" VALUE=\"{$sub_raion}\">\n";
echo "<INPUT TYPE=\"hidden\" name=\"action\" id=\"action\" VALUE=\"0\">\n";
echo "<INPUT TYPE=\"hidden\" name=\"time_np\" id=\"time_np\" VALUE=\"{$time_nach_p}\">\n";
echo "</div>\n<br>\n";


if ($posetit_status>7 || $kab_status==1 && $id_posetit==0 && $frang==7)
{//если ведем прием, могем и поточнее вопрос заострить
	if ($type_need_update)
	{
		echo"<h4 class=\"text-center text-danger\">Вопрос требует уточнения</h4>";
	}
	echo "<p class=\"text-center form-inline\">\n";
	$result = mysqli_query($dbI, "select t.full_name, t.id, g.full_name,g.id 
		from types_obr t left join group_types_obr g on (t.group_id=g.id) 
		where t.actual='1' order by COALESCE(g.id,9999),t.orders") or die("Query failed : " . mysqli_error());

	echo "<label>".(($id_posetit>0)?"Уточнить вопрос&nbsp;":"Вопрос&nbsp;")."</label>\n<select name=\"type_obr\" value=\"{$type_obr}\" class=\"form-control\">\n";
	$og=-1;
	// $tag_opened=false;
	// while($tab_sql=mysqli_fetch_row($result)) 
	// { 
		// if ($og!=$tab_sql[3])
		// {
			// if ($tag_opened){echo "</optgroup>\n";}
			// $og=$tab_sql[3];
			// echo "<optgroup label=\"{$tab_sql[2]}\">\n";
			// $tag_opened=true;
		// }
		// echo "<option value=\"{$tab_sql[1]}\" ".(($type_obr==$tab_sql[1])?" selected=\"selected\"":"").">{$tab_sql[0]}</option>\n";
	
	// }
	// if ($tag_opened){echo "</optgroup>\n";}
	while($tab_sql=mysqli_fetch_row($result)) 
	{ 
		if ($og!=$tab_sql[3])
		{
			echo "<option class=\"label-warning\" value=\"".($tab_sql[3]+10000)."\" ".(($type_obr==$tab_sql[3]+10000)?" selected=\"selected\"":"").">{$tab_sql[2]}</option>\n";
			$og=$tab_sql[3];
		}
		echo "<option value=\"{$tab_sql[1]}\" ".(($type_obr==$tab_sql[1])?" selected=\"selected\"":"").">{$tab_sql[0]}</option>\n";
	
	}
	
	echo "</select>\n";
	mysqli_free_result($result);
	echo "<INPUT TYPE=\"button\" name=\"edit\" VALUE=\"Установить\" class=\"{$set_vopros_btn}\" onclick=\"submitForm(7)\">\n";
	echo "</p>\n";
}


if ($kab_status==1 && $id_posetit==0 && $frang==7)
{
echo "<div class=\"container col-md-6 col-md-offset-3\">";	
echo "<table class=\"table bg-info bordered\">\n<tr>\n";
echo "<td width=\"20%\">ФАМИЛИЯ <input class=\"form-control\" id=\"a\" Type=\"text\" Name=\"family\" Size=\"20\" MAXLENGTH=\"35\" Value=\"\"></td>\n";
echo "<td width=\"20%\">ИМЯ <Input class=\"form-control\" id=\"b\" Type=\"text\" Name=\"name\" Size=\"20\" MAXLENGTH=\"25\" Value=\"\"></td>\n";
echo "<td width=\"20%\">ОТЧЕСТВО <input class=\"form-control\" id=\"a1\" Type=\"text\" Name=\"father\" Size=\"20\" MAXLENGTH=\"25\" Value=\"\"></td>\n";
echo "<td align=\"center\" valign=\"middle\">\n";
echo "<INPUT class=\"{$save_begin_btn}\" TYPE=\"button\" name=\"savebegin\" VALUE=\"Записать и принять\" onclick=\"submitForm(8)\">\n";
echo "</td>\n";
echo "</tr></table></div>";
}

echo "</form>\n<br>\n";

if ($posetit_status>7)
{
 echo "<div class=\"container text-center\">\n"	;
 echo $type_obr_help;
 echo "</div>\n";	
}

echo "<div class=\"container text-center\">";	

if ($frang==7)
{
include_once("../inc/home.php");
}

echo "<a class=\"btn btn-default btn-lg\" href=\"/close.php\">Выход</a>\n";
echo "</div>\n";
?>



<script type="text/javascript">

 
	 $(document).ready(function(){  
	 
	 
    mode_q();  
	setInterval('mode_q()',20000);  
	<?php
	if($posetit_status==8)
	{
	echo "calctime();";
	echo "setInterval('calctime()',10000);";  
	}
	?>
    
	
    });  
	
 
 function submitForm(a)
 {
	 $('#action').val(a);
	 if (a==8 && ($('#a').val()=='' || $('#b').val()==''))
	 {
		 alert("Заполните имя и фамилию");
		 return;
	 }
		 
	 $('#kabForm').submit();
	 
 }
 

function mode_q() {
	$.getJSON('kab_qcount.php', <?php echo json_encode($data4que)?>,function(data) {  
	$.each(data, function(key, val) {   
				if (key=='qcount')
				{
				$('#tme').html('<H3 class="text-center"> Количество людей в очереди - '+val+'</H3>');
				var cc=<?php echo $can_call?>;
				if (cc!=0)
				{
						if (val=='0')
						{
							$('#bcall').addClass('hidden');	
						}
						else
						{
							$('#bcall').removeClass('hidden');
						}
				}}});  
            });  
}



				
 function calctime() {
 var tim=$('#time_np').val();
 var arr = tim.split(':');
 
 var stime=new Date();
 //stime.setHours(arr[0],arr[1],arr[2],0);
 
 var fin=stime.getHours()*3600+stime.getMinutes()*60+stime.getSeconds();
 var st=parseInt(arr[0])*3600+parseInt(arr[1])*60+parseInt(arr[2]);
 var dif=fin-st;
 var hour=~~( dif / 3600 );
 var min=~~((dif%3600)/60);
 var res=min+' мин.';
 if (hour>0)
 {
	 res=hour+' ч. '+res;
 }
 
 if (Math.floor( dif / 60 )><?php echo $type_obr_maxtime?>)
 {
	 $('#timer_posetit').addClass('text-danger');
 }
 
 $('#timer_posetit').html('Прием длится '+res);
 }



</script>
</body>
</html>
