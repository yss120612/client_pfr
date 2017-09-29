<?php
include_once('../loginI.php');
$raion=$_REQUEST['raion'];
$sub_raion=$_REQUEST['sub_raion'];
$frang=$_REQUEST['frang'];


if ($frang==1){//администратор района
	$sqlF="a.reg={$raion}";
	//$sqlF2="a.reg=b.rajon";
	$sqlF2="a.reg=b.rajon and b.sub_rajon=a.office";
}
else{
	$sqlF="a.reg={$raion} and a.office={$sub_raion}";
	$sqlF2="a.reg=b.rajon and b.sub_rajon=a.office";
}

$sql= "SELECT a.FIO,a.kab,CONCAT(b.family,' ',SUBSTRING(b.name,1,1),'.',SUBSTRING(b.father,1,1),'.'),b.otrab,a.office,a.active,b.time_nach_p,time(p.b_start) FROM specialict a 
	  left join posetit b on a.kab=b.kab and {$sqlF2} and b.date_comin=current_date  and b.otrab>6
	  left join break p on a.id=p.id_spe and p.id=a.break
	  where {$sqlF} order by a.office desc, a.kab desc";	
	
//echo $sql."<br>";

$result_kab = mysqli_query($dbI,$sql) or die("Query failed 1: " . mysqli_error($dbI));



$ColKab=mysqli_num_rows($result_kab);
$i=0;
$have_posetit=false;
$on_pereryv=false;
//0-FIO spec, 1-kab, 2-FIO posetit, 3-otrab, 4-subraion 5-active
while ($R_tmp[$i]=mysqli_fetch_row($result_kab))
{  //Вызван 'На приеме'
	$R[$i][0]=$R_tmp[$i][0];
	$R[$i][1]=$R_tmp[$i][1];
	$R[$i][4]=$R_tmp[$i][4];
	$R[$i][7]='';
	$have_posetit=$R_tmp[$i][2]!=null;
	if ($have_posetit)
	{
		$R[$i][2]=$R_tmp[$i][2];
		if($R_tmp[$i][3]==7) 
		{
			$R[$i][3]='Вызван';
			$R[$i][6]=3;
		} 
		else 
		{
			$R[$i][3]='На приеме';
			$R[$i][6]=4;
			$R[$i][7]=$R_tmp[$i][6];
		}
	}
	else
	{
		if ($R_tmp[$i][5]==0)
		{
			$on_pereryv=true;
			$R[$i][2]='Перерыв';	
			$R[$i][3]=' &nbsp;';
			$R[$i][6]=2;
			$R[$i][7]=$R_tmp[$i][7];
		}
		else
		{
			$R[$i][2]='---';
			$R[$i][3]='Ожидает';
			$R[$i][6]=1;
		}
	}
	$i+=1;
}
//что происходит в кабинке
//$R[$i][6]==1 Не принимает посетителя и не на перерыве (Ожидает), ==2 перерыв, ==3 вылвал посетителя, --4 принимает посетителя.
mysqli_free_result($result_kab);


$ColWidth=array('10%','15%','20%','25%','30%');//размер колоночег
echo "<div class=\"row\" >\n";
echo "<div class=\"col-md-10 col-md-offset-1\">\n";
echo "<h3 class=\"text-center\">СОСТОЯНИЕ ПРИЁМА</h3>\n";
echo "<table class=\"table table-striped table-bordered\">\n";
echo "<TR>\n";
echo "<TH width='{$ColWidth[0]}' class='text-center'>  Кабинка </TH>\n";
echo "<TH width='{$ColWidth[4]}' class='text-center'>  Специалист </TH>\n";
echo "<TH width='{$ColWidth[4]}' class='text-center'>  Посетитель </TH>\n";
echo "<TH width='{$ColWidth[1]}' class='text-center'>  Статус </TH>\n";
echo "<TH width='{$ColWidth[1]}' class='text-center'>  Время </TH>\n";
echo "<TH width='{$ColWidth[0]}' class='text-center'>  Офис </TH>\n";
echo "</TR>\n";

while ($i>0){	
$i-=1;
if(is_array($R[$i])){
	switch ($R[$i][6]) {
		case 1: $color="danger";break;
		case 2: $color="warning";break;
		case 3: $color="info";break;
		case 4: $color="success";break;
	default:$color="info";
}
	$tdur=$R[$i][7];
	if ($tdur!='')
	{
	$dt= time();
	$dts=strtotime($R[$i][7]);
	$dia=$dt-$dts;
	$hour=floor($dia/3600);
	$min=floor(($dia-$hour*3600)/60);
    $tdur= sprintf("%d:%02d", $hour,$min);
	}
	else
	{
	$tdur="---";
		
	}
	echo "<tr align='center' class='{$color}'>\n"; 
	echo "<td class='text-center'>". $R[$i][1] ."</td>\n";
	echo "<td >". $R[$i][0] ."</td>\n";	
	
	echo "<td class='h5'>". $R[$i][2]."</td>\n";	
	echo "<td >". $R[$i][3] ."</td>\n";
	echo "<td>{$tdur}</td>\n";
	echo "<td class='text-center' >". $R[$i][4] ."</td>\n";
	echo "</tr>\n";  
		}
}
echo "</table>\n</div>\n</div>\n";
//закончили с табличкой кабинок


//покажем таблицу posetit join posetit b on a.id=b.id
if ($frang==1){
	$sqlF="a.rajon={$raion}";
}
else{
	$sqlF="a.rajon={$raion} AND a.sub_rajon={$sub_raion}";
}

$sql="select family,b.name,time_comin, TIMEDIFF(current_time,time_comin),a.name,a.father,a.sub_rajon, a.predvar,a.type_obr>10000,c.full_name 
from posetit a 
left join types_obr b ON b.id=a.type_obr 
left join group_types_obr c ON a.type_obr=c.id+10000 
where date_comin=current_date and otrab='0' and (a.predvar='0' or current_time>=a.time_comin) and {$sqlF} order by a.sub_rajon, a.predvar desc, a.time_comin";

//echo $sql;
//0-фамилия, 1-обращение(стр), 2-тайм камин, 3-сколько времени в очереди, 4-имя, 5-отчество, 6-офис, 7-предвар
$result_posetit = mysqli_query($dbI,$sql) or die("Query failed 5:". mysqli_error()); 
$Colposetit=mysqli_num_rows($result_posetit);

$chel=$Colposetit.' '. 'ЧЕЛОВЕК';
if ($Colposetit>1 && $Colposetit<=4) $chel=$chel.'А';

echo "<div class=\"row\">\n";
echo "<div class=\"col-md-10 col-md-offset-1\">\n";
echo "<h3 class=\"text-center\">СОСТОЯНИЕ ОЧЕРЕДИ</h3>\n";
echo "<h4>В ОЧЕРЕДИ {$chel}</h4>\n";
echo "<table class=\"table table-striped table-bordered\">\n";
echo "<TR>\n";
echo "<TH width={$ColWidth[1]} class='text-center'>  Время записи </TH>\n";
echo "<TH width={$ColWidth[1]} class='text-center'>  Время ожидания  </TH>\n";
echo "<TH width={$ColWidth[2]} class='text-center'>  Посетитель </TH>\n";
echo "<TH class='text-center'>  Цель обращения </TH>\n";
echo "<TH width={$ColWidth[0]} class='text-center'>  Офис </TH>\n";
echo "</TR>\n";

while ($T=mysqli_fetch_row($result_posetit)){	
	
	list($h,$min,$sec)=explode(":",$T[3]);
	$diff_time=(abs($h)*3600+$min*60+$sec+1);
	if (strstr($T[3],"-")){
		$diff_time=-$diff_time;
	}
	$T[3]=sprintf("%d:%02d", $h,$min);
	
	 if ($T[7]=='1' || $T[7]=='2')
	{		 
		$color="danger";
	}
	else
	{		
		switch($diff_time){	
			case ($diff_time<=600): $color="success";break;
			case ($diff_time>=900): $color="danger";break;
			default: $color="warning";		
		}
	}
	
	echo "<tr class=\"{$color}\">\n";
	if ($T[7]=='1')
	{
		echo "<td class='text-center'>{$T[2]} [п]</td>\n";	
	}
	else if ($T[7]=='2')
	{
		echo "<td class='text-center'>{$T[2]} [с]</td>\n";	
	}
	else
	{
	echo "<td class='text-center'>{$T[2]}</td>\n";		
	}
	echo "<td class='text-center'>{$T[3]}</td>\n";	
	echo "<td>{$T[0]} {$T[4][0]}.{$T[5][0]}.</td>\n";
	if ($T[8]>0)
	{
		echo "<td>{$T[9]}</td>\n";
	}
	else
	{
		echo "<td>{$T[1]}</td>\n";
	}
	echo "<td class='text-center'>{$T[6]}</td>\n";
	echo "</tr>\n";  
}

echo "</table>\n</div>\n</div>\n";
mysqli_free_result($result_posetit);
//закончили с табличкой посетителей в очереди
?>