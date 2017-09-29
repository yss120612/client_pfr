<?php
session_start();

echo '<html>'."\n";
$PHP_SELF=$_SERVER['PHP_SELF'];
$m1=$_REQUEST['m1'];
$dat=(isset($_REQUEST['dat']))?$_REQUEST['dat']:'';
$y1=$_REQUEST['y1'];
$d1=$_REQUEST['d1'];
if ($dat=='')
 {$dat=$y1 ."-". $m1 ."-". $d1;}
else {

	$tmp=explode('-',$dat);
	if( !checkdate($tmp[1] , $tmp[0] , $tmp[2] )){$d1= $tmp[2];$m1= $tmp[1];$y1= $tmp[0];} 
//echo $dat;
	}


//date_default_timezone_set ('Asia/Irkutsk');
echo '<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">'."\n";
echo '<link rel="stylesheet" href="../styles1.css" type="text/css" >'."\n";
echo '<body background="../image/glabkgnd.jpg" >'."\n";
//покажем основную таблицу
include_once('../login.php');
include_once("../obj.php");

$lchet=isset($_REQUEST['lchet'])?$_REQUEST['lchet']:"";
$chkit=isset($_REQUEST['chkit'])?$_REQUEST['chkit']:"";
$pers_num=isset($_REQUEST['pers_num'])?$_REQUEST['pers_num']:"";
$name=isset($_REQUEST['name'])?$_REQUEST['name']:"";
$family=isset($_REQUEST['family'])?$_REQUEST['family']:"";
$father=isset($_REQUEST['father'])?$_REQUEST['father']:"";
$Kabinka=isset($_REQUEST['Kabinka'])?$_REQUEST['Kabinka']:"";
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:"";
$to_time=isset($_REQUEST['to_time'])?$_REQUEST['to_time']:"";
$time_zap =isset($_REQUEST['time_zap'])?$_REQUEST['time_zap']:"";
$p_num1=isset($_REQUEST['p_num1'])?$_REQUEST['p_num1']:"";
$p_num2=isset($_REQUEST['p_num2'])?$_REQUEST['p_num2']:"";
$p_num3=isset($_REQUEST['p_num3'])?$_REQUEST['p_num3']:"";
$m =isset($_REQUEST['m'])?$_REQUEST['m']:"";


//$message_ = array("","","распределен в кабинку №",
//		"Невозможно принять посетителя в  данный момент в кабинке №","Неверное время","");
$message_ = array("Перемещение посетителя прошло успешно", "","распределен в кабинку №");

?>
<link rel="stylesheet" href="../jQuery/css/validationEngine.css" type="text/css" media="screen" charset="utf-8" />
<script src="../jQuery/jquery.js" type="text/javascript"></script>
<script src="../jQuery/validationEngine-ru.js" type="text/javascript"></script>
<script src="../jQuery/validationEngine.js" type="text/javascript"></script>
<script type="text/javascript">
       $(document).ready(function() {
        $("#validForm").validationEngine({
		 openDebug: false
		})
       }); 
</script>
<?
date_default_timezone_set ('Asia/Irkutsk');
echo '<meta http-equiv="Content-Type" content="text/html">'."\n";
echo '<link rel="stylesheet" href="../styles1.css" type="text/css" >'."\n";
echo '<body background="../images/glabkgnd.jpg" >'."\n";

echo "<H2><center> Выбрана дата " . $d1.'-' .$m1.'-'.$y1."</center></H2>\n";

//покажем основную таблицу
$i=0;
$result = mysql_query("SELECT kab,priem,priem_po_zap,FIO,time_nach_p,vid_name,time_osv FROM specialict where priem='1' order by kab",$db) or die("Query failed : " . mysql_error());
$MaxKab=mysql_num_rows($result);
$icurr=-1;
if ($MaxKab>0)
{
	while($myrow=mysql_fetch_row($result)) 
	{// создание объектов кабинка
		$KS[$i++]=new K($myrow[0],$myrow[1],$myrow[2],$myrow[3],strtotime($myrow[4]),$myrow[5],$myrow[6]);
		if (($Kabinka<>"")&&($Kabinka==$myrow[0])) {$icurr=$i-1;};
	}
}

$maxcol=(count($KS)<9)?count($KS):9;	//здесь устанавливается макс. число колонок таблицы (9)
$k_max = $KS[$maxcol-1]->PhN;
$nx=ceil(count($KS)/$maxcol);	//сколько таблиц
$dcol=count($KS)%$maxcol;//остаток
$cw=round(100/$maxcol);

for ($k=0;$k<$nx;$k++)
{
	echo "<TABLE class=\"disp\" WIDTH=\"100%\">\n";
	echo "<tr>\n";
	if ($k<>$nx-1){
		$m1 = $KS[$k*$maxcol]->PhN ;
		$m2 = $KS[($k+1)*$maxcol-1]->PhN;}
	else{
		$m1 = $KS[$k*$maxcol]->PhN ;
		$m2 = $KS[$k*$maxcol+$dcol-1]->PhN;}

	$result = mysql_query("call CreateKabList1('$dat')",$db) or die("Query failed : " . mysql_error()); 
	$result= mysql_query("select count(*) from QueueKab 
		where predvar<'2' and kab between " .$m1. " and ". $m2 ." group by kab order by 1 desc limit 1",$db)  or die("Query failed : " . mysql_error()); 
	$myrow=mysql_fetch_row($result);
	$MaxOrder=$myrow[0];
	for ($i=0;$i<(((($k+1)*$maxcol)>count($KS))?$dcol:$maxcol);$i++)
		{ // вывод специалистов
		echo "<TD  class=\"tit_disp\" width=\"". $cw ."%\" >
		<b><center>    " . $KS[$i+$k*$maxcol]->vid_name . "<br>(". $KS[$i+$k*$maxcol]->spec_name .")</center></b></td>\n";
	}
	echo "</tr>\n";
	for ($j=0;$j<$MaxOrder;$j++)
		{
		echo "<tr>\n";
		for ($i=0;$i<(((($k+1)*$maxcol)>count($KS))?$dcol:$maxcol);$i++)
			{
			echo "<td class=\"data_disp\">\n";
			$result= mysql_query("select * from QueueKab where kab=". $KS[$i+$k*$maxcol]->PhN ." and predvar<'2' order by time_s limit ". $j .",1")  or die("Query failed : " . mysql_error()); ;
			$NR=mysql_num_rows($result);
			if ($NR>0)
			{
		$myrow=mysql_fetch_row($result);
		echo " <a href=remove_t.php?id=".$myrow[8] ."&dat=".$dat."&old_kab=". $KS[$i+$k*$maxcol]->PhN ." target=_top>"."<font color=".$myrow[10].">". $myrow[1]." </font>"  .
		"<br>(". date("H:i",strtotime($myrow[3])) ."-". date("H:i",strtotime($myrow[4])) .")";
		}
		else
		{
		echo "---//---";
		}
		echo "</td>\n";
		}
	echo "</tr>\n";
	}
	echo "</TABLE>\n";
	echo "<br>\n";
}
//Проверка на принадлежность к Иркутской области
$region=mysql_query("SELECT * from title where region='Иркутской области'",$db);
//$region=mysql_query("SELECT * from title where region='Оренбуржской области'",$db);
$chkRegion=mysql_fetch_row($region);
if ($chkRegion==0){
    //$m=3;
    //$mess1="Это не Иркутская область";
    $frm_snils="";
}
else{
    include_once '../function/chekSNILS.php';
    list($m,$p_num,$mess1,$family_pers,$name_pers,$father_pers)=checkSNILS($p_num1, $p_num2, $p_num3);
    //Рисуем форму проверки СНИЛС в базе  АРМ "Регион"
    $frm_snils='<TR><TD COLSPAN=4>
        <FORM class=p_num action=main.php method=post>
            СНИЛС для проверки&nbsp;&nbsp;
            <INPUT Type="text" Name="p_num1" Size="1" MAXLENGTH="3">&nbsp;-&nbsp;
            <INPUT Type="text" Name="p_num2" Size="1" MAXLENGTH="3">&nbsp;-&nbsp;
            <INPUT Type="text" Name="p_num3" Size="1" MAXLENGTH="3">&nbsp;&nbsp;
            <INPUT Type="submit" Name="chk_snils" Value="Проверить СНИЛС">
            <INPUT type="hidden" name="dat" value='. $dat .' >
        </FORM>
        </TD></TR>';
}

$color_='#105bcb';
if ($m==2){$mess1=$family." ".$name." ".$father." ";$color_='#105bcb';$mess2=$Kabinka;
        $family="";
        $name="";
        $father="";
}
if ($m==0){$mess2=" ";$mess1=" ";}
if ($m==3){$mess2=" ".$Kabinka;}
echo "<font color='".$color_."'>".$mess1.$message_[$m].$mess2."</font>";



echo "<TABLE class=\"manage\" WIDTH=\"100%\">\n";
echo $frm_snils;
echo '<form id="validForm" action=main_act.php?dat='.$dat.' method=post>';
echo '<TD>Фамилия <Input class="validate[required,custom[onlyLetterRus],length[0,100]]" id="a" Type="text" Name="family" Size="20" MAXLENGTH="40" Value="' . $family_pers . '"></TD>';
echo '<TD>Имя <Input class="validate[required,custom[onlyLetterRus],length[0,100]]" id="b" Type="text" Name="name" Size="15" MAXLENGTH="40" Value="' .$name_pers.'"></TD>' ;
echo '<TD>Отчество <Input class="validate[optional,custom[onlyLetterRus],length[0,100]]" id="a1" Type="text" Name="father" Size="20" MAXLENGTH="40" Value="'. $father_pers.'"></TD>';
echo '<TD>СНИЛС <Input class="validate[optional,custom[snils]]" id="g" Type="text" Name="pers_num" Size="15" MAXLENGTH="13" Value="'.$p_num .'"></TD></TR>';
echo '<TR><TD>Номер пенсионного дела <Input Type="text" Name="lchet" Size="5" MAXLENGTH="6" Value="'. $lchet.'"></TD>';
echo '<TD>Телефон<Input class="validate[optional,custom[telephone]]" id="e" Type="text" Name="telefon" Size="10" MAXLENGTH="12" Value="'. $telefon.'"></TD>';

echo '<TD>Вопрос <SELECT name="type_obr">';

$result = mysql_query("select t.full_name name, t.id, g.full_name gname 
	from types_obr t left join group_types_obr g on (t.group_id=g.id) 
	where actual='1' order by COALESCE(g.id,9999),t.orders",$db) or die("Query failed : " . mysql_error());
$tab_sql=mysql_fetch_row($result);
	$group=$tab_sql[2];

	echo "<OPTGROUP LABEL='" . $tab_sql[2] . "'>";

while($tab_sql) 
{ 
if(!($group==$tab_sql[2]))
{	//
echo "</OPTGROUP>";
if($tab_sql[2]){echo "<OPTGROUP LABEL='".$tab_sql[2]."'>";}
	$group=$tab_sql[2];}
	

echo "<OPTION VALUE=$tab_sql[1]>$tab_sql[0] </OPTION>";
 $tab_sql=mysql_fetch_row($result);//$group=$tab_sql[2];
 }
echo "</SELECT></TD>";

echo '<TD><SELECT name="Kabinka" class="validate[required]" id="d"><OPTION value="" selected>Выбор кабинки</OPTION>';
$result = mysql_query("SELECT kab,vid_name FROM specialict where priem='1' ORDER BY kab ",$db); 
while($tab_sql=mysql_fetch_row($result)) 
{ 
echo "<OPTION VALUE=$tab_sql[0]>$tab_sql[1] </OPTION>";
}
echo '</TD></TR><TR><TD COLSPAN=3>Дополнительные сведения <Input Type="text" Name="dopinfo" Size="50" MAXLENGTH="30" Value="'. $dopinfo.'"></TD></TR>';

echo '<TD>Время в формате чч:мм <Input class="validate[optional,custom[time]]" id="f"
	 Type="text" Name="time_zap" Size="3" MAXLENGTH="5" Value="'. $time_zap .'"></TD> ';


echo '<TD COLSPAN=2><center><Input Type="submit" Name="to_time" Value="Записать" style="width:150px;height:30px;"></center></TD>';
echo "</table> ";
echo '</Form>';
echo "<form action='print_zap.php'  method='POST'>";
echo " <input type='hidden' name='dat' value=". $dat  ." >" ;
echo "<center><input type='submit' value='Для печати' style='width:150px;height:30px;'></center>";
echo "</form>";



$lll = $_SESSION['s_login'] ;
$ppp = $_SESSION['s_pass'] ;

echo "<form action='../main.php'  method='POST'>";
echo " <input type='hidden' name='j_username' value=". $lll  ." >" ;
echo " <input type='hidden' name='j_password' value=". $ppp  ." >" ;
echo "<center><input type='submit' value='В главное меню' style='width:150px;height:30px;'></center>";
echo "</form>";
mysql_close($db);	           

//echo '<iframe src="error.php" width="0" height="0"> </iframe>';
echo '</body>'."\n";


?>

___________________________<br>
<i>Для получения более полной информации и ее изменения  кликните на посетителя<BR>
 Для записи нового посетителя заполните необходимые поля и нажмите кнопку "ЗАПИСАТЬ"</i>

</html>
