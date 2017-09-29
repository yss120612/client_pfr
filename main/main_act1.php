<?php


session_start();

$PHP_SELF=$_SERVER['PHP_SELF'];
$name=isset($_REQUEST['name'])?$_REQUEST['name']:"";
$family=isset($_REQUEST['family'])?$_REQUEST['family']:"";
$father=isset($_REQUEST['father'])?$_REQUEST['father']:"";
$Kabinka=isset($_REQUEST['Kabinka'])?$_REQUEST['Kabinka']:"";
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:"";
$time_zap =isset($_REQUEST['time_zap'])?$_REQUEST['time_zap']:"30:90";
$lchet=isset($_REQUEST['lchet'])?$_REQUEST['lchet']:"";
$pers_num=isset($_REQUEST['pers_num'])?$_REQUEST['pers_num']:"";
$dopinfo=isset($_REQUEST['dopinfo'])?$_REQUEST['dopinfo']:"";
$telefon=isset($_REQUEST['telefon'])?$_REQUEST['telefon']:"";
$srv_name=isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:"";
$user = $_SESSION['s_login'] ;
$chkit=isset($_REQUEST['chkit'])?$_REQUEST['chkit']:"";
$to_time=isset($_REQUEST['to_time'])?$_REQUEST['to_time']:"";
$to_time_print=isset($_REQUEST['to_time_print'])?$_REQUEST['to_time_print']:"";
$subm =isset($_REQUEST['subm'])?$_REQUEST['subm']:"";
$print =isset($_REQUEST['print'])?$_REQUEST['print']:"";
$chk_snils =isset($_REQUEST['chk_snils'])?$_REQUEST['chk_snils']:"";
$RADD=$_SERVER['REMOTE_ADDR'];
$tmp= $_SERVER['HTTP_REFERER'];
$home='http://'.$srv_name.':'.$_SERVER['SERVER_PORT'].'/main/main.php';
$loc="location: " . $tmp;

$rajon=isset($_REQUEST['rajon'])?$_REQUEST['rajon']:"";
$sub_rajon=isset($_REQUEST['sub_rajon'])?$_REQUEST['sub_rajon']:"";

include_once('../loginI.php');

include_once("../obj.php");
include_once("../function/printCheck.php");



echo "<html><body><h1>$_REQUEST['sub_kind']</h1></body></html>";

//Кнопка Распределить 
if ($subm<>'') 
{	
	$sql="insert Into posetit 
		(family,kab,otrab,type_obr,name,father,orders, date_comin, time_comin, predvar, ipzap,dopinfo,telefon,userzap,rajon,sub_rajon) 
	  Values (UPPER('$family'),0,'0',$type_obr,UPPER('$name'),UPPER('$father'),100, CURRENT_DATE, CURRENT_TIME,'0', 
		'$RADD','$dopinfo','$telefon','$user','$rajon','$sub_rajon')";
		echo $sql;
	 $result = mysqli_query($dbI,$sql) or die("Query2 failed : " . mysql_error()); 
 	  //if (!headers_sent()) {header ($loc . "?e=0&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka."&time_zap=".$time_zap,FALSE);exit;}
	  if (!headers_sent()) {header ($loc ,FALSE);exit;}
	exit; 
}

//Кнопка Записать на время
if($to_time<>'')
{	
	if (($family=="")or($name=="")){ header ($home . "?m=0");exit;}  
	if (!($Kabinka>0)){header ($loc . "?m=1&family=".$family."&name=".$name);exit;	}
	$s1=substr($time_zap,0,2);$s2=substr($time_zap,3,2);$s3=substr($time_zap,2,1);
	if( $s1<24 and $s1>=0 and $s2>=0 and $s2<60 and $time_zap<>''and $s3==':' )
	{		
		$sql="call record_time ('".$family."','".$name."','".$father."',".$Kabinka.",".$type_obr.",0,0,'".$time_zap.":00','".$user."','".$RADD."',@z)";
		//echo $sql;
		$result = mysql_query($sql,$db)  or die("record failed : " . mysql_error());
		$result = mysql_query("Select @z",$db)  or die("record failed : " . mysql_error());
		$res=mysql_fetch_row($result);
		if (is_null($res[0])) {
			$strAddress=$home."?m=2&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka;
                    print_check($strAddress,$family,$name,$father,$Kabinka,$time_zap);
                    
			}
		else
			{
                    //header ($loc . "?m=5&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka);exit;
                    if (!headers_sent()) {header ($loc . "?e=5&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka,FALSE);exit;}
                    }
	}
	else
	{
		//header ($loc ."?m=4&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka."&time_zap=".$time_zap);
            if (!headers_sent()) {header ($loc . "?e=4&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka."&time_zap=".$time_zap,FALSE);exit;}
	}

}
?>

