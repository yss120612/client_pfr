<?php  
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'russian');
include("../loginI.php");
include("../inc/head.php");
echo "</head>";
include("../inc/body.php");
//include('../nOform/top_body.php');
// переформатируем даты
$sdate1=$_REQUEST['date1'];
$sdate2=$_REQUEST['date2'];
$raion=$_REQUEST['rajon'];
$sub_raion=$_REQUEST['sub_rajon'];

$tmp=explode('.',$sdate1);
if ($tmp[2]<'2000') {$tmp[2]=2000+$tmp[2];}
$date1=$tmp[2].'-'.$tmp[1].'-'.$tmp[0];

$tmp=explode('.',$sdate2);
if ($tmp[2]<'2000') {$tmp[2]=2000+$tmp[2];}
$date2=$tmp[2].'-'.$tmp[1].'-'.$tmp[0];

echo "<h3 class=\"text-center\">Отчет по принятым посетителям за период<br>с {$sdate1} по {$sdate2}<br>с разбивкой по офисам и специалистам</h3>\n";

//получение сумм обращений с разбивкой по кабинам и вопросам
$strQuery="
SELECT a.kab,c.FIO, b.full_name, a.type_obr, count( * ), c.office, a.type_obr>10000,d.full_name
FROM posetit a
LEFT JOIN specialict c ON a.Kab = c.kab AND a.sub_rajon=c.office AND a.rajon=c.reg
LEFT JOIN types_obr b ON a.type_obr = b.id
LEFT JOIN group_types_obr d ON a.type_obr = c.id+10000
WHERE a.otrab=1 
AND b.full_name<>'' 
AND a.date_comin BETWEEN '".$date1."'AND '".$date2."' 
AND c.reg=".$raion."
GROUP BY c.office, a.kab, a.type_obr
HAVING count( * )>0
ORDER BY c.office,kab,a.type_obr";

$result2 = mysqli_query($dbI,$strQuery);


while($sqlres=mysqli_fetch_row($result2))
{
	$tableArray[$sqlres[5]][$sqlres[3]][$sqlres[0]]=$sqlres[4];
	$tableArray[$sqlres[5]][$sqlres[3]][100000]+=$sqlres[4];
	$tableArray[$sqlres[5]][100000][$sqlres[0]]+=$sqlres[4];
	$tableArray[$sqlres[5]][100000][100000]+=$sqlres[4];
				
	if (!isset($offices[$sqlres[5]])) $offices[$sqlres[5]]=$sqlres[5];//офисы
	if (!isset($kabNames[$sqlres[5]][$sqlres[0]])) $kabNames[$sqlres[5]][$sqlres[0]]=$sqlres[1];//имена кабинок
	if (!isset($obrNames[$sqlres[3]])) $obrNames[$sqlres[3]]=($sqlres[2]>0)?$sqlres[7]:$sqlres[2];//наименование обращений
}

mysqli_free_result($result2);

$row="";
echo "<div class=\"col-xs-10 col-xs-offset-1\">\n";
foreach($offices as $office => $officeVal) 
{
	echo "<h3>Офис {$office}</h3>";
	echo "<table class=\"table table-bordered table-striped\">\n";
	echo "<thead>\n";
	echo "<tr>\n";
	echo "<th>Типы обращений</th>\n";
	foreach($kabNames[$office] as $kNo => $kName) 
	{
	 echo "<th>{$kName}</th>\n";
	}
	echo "<th>Всего</th>\n";
	echo "</tr>\n";
	echo "</thead>\n";
	echo "<tbody>\n";
	
	foreach($obrNames as $obrNo => $obrName) 
	{
		$row="<tr>\n<td>{$obrName}</td>\n";
		foreach($kabNames[$office] as $kNo => $kName) 
		{
			$row="{$row}<td>";
			if (isset($tableArray[$office][$obrNo][$kNo]))
			{
				$printRow=true;
				$row="{$row}".$tableArray[$office][$obrNo][$kNo];	
			}
			else
			{
				$row="{$row}0";
			}
			$row="{$row}</td>\n";
		}
		if (isset($tableArray[$office][$obrNo][100000]))
		{
			$row="{$row}<td>".$tableArray[$office][$obrNo][100000]."</td></tr>\n";
			echo $row;
		}
	}
	echo "<tr>\n";
	echo "<td>Итого</th>\n";
	foreach($kabNames[$office] as $kNo => $kName) 
	{
	 if (isset($tableArray[$office][100000][$kNo]))
	 {
	 echo "<td>".$tableArray[$office][100000][$kNo]."</td>\n";
	 }
	}
	if (isset($tableArray[$office][100000][100000]))
	 {
	 echo "<td>".$tableArray[$office][100000][100000]."</td>\n";
	 }
	echo "</tr>\n";
	echo "</tbody>\n";
	echo "</table>\n";
}
echo "</div>\n";	
echo "</body></html>";
?>
