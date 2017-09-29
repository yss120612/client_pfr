<?php
session_start();

//echo '<html>'."\n";
$n_=isset($_REQUEST['name'])?$_REQUEST['name']:"";
$f_=isset($_REQUEST['family'])?$_REQUEST['family']:"";
$p_=isset($_REQUEST['father'])?$_REQUEST['father']:"";
$cab=isset($_REQUEST['Kabinka'])?$_REQUEST['Kabinka']:"";
$v1=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:"";
$time_zap =isset($_REQUEST['time_zap'])?$_REQUEST['time_zap']:"30:90";
$lch_=isset($_REQUEST['lchet'])?$_REQUEST['lchet']:"";
$ins_=isset($_REQUEST['pers_num'])?$_REQUEST['pers_num']:"";
$di_=isset($_REQUEST['dopinfo'])?$_REQUEST['dopinfo']:"";
$t_=isset($_REQUEST['telefon'])?$_REQUEST['telefon']:"";
$dat=isset($_REQUEST['dat'])?$_REQUEST['dat']:"";


$lll= $_SESSION['s_login'] ;

$PHP_SELF=$_SERVER['PHP_SELF'];
$to_time=isset($_REQUEST['to_time'])?$_REQUEST['to_time']:"";
$tmp= $_SERVER['HTTP_REFERER'];

if($n=strpos($tmp,"?"))
        {$home=substr($tmp,0,$n);}
  else {$home=$tmp;}


  $loc="location: " . $home;
include_once('../login.php');

if($to_time<>'')
{	
	$s1=substr($time_zap,0,2);$s2=substr($time_zap,3,2);$s3=substr($time_zap,2,1);
	if( $s1<24 and $s1>=0 and $s2>=0 and $s2<60 and $time_zap<>''and $s3==':' )
	{
		$ipz = $_SERVER["REMOTE_ADDR"];
		$sql="call record_time1('$f_', '$n_', '$p_', $cab, $v1, '$lch_','$ins_', '$dat', '$time_zap','$t_','$di_', '$lll','$ipz',@z)";
//echo $sql;exit;
		$result = mysql_query($sql,$db) or die("call record_time1 : " . mysql_error()); 
		$result = mysql_query("select @z",$db) or die("select @z failed : " . mysql_error()); 
		$z =mysql_fetch_row($result);
		if (is_null($z[0])){ 
                     if (!headers_sent()) {header ($loc ."?dat=".$dat. "&m=3&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka);exit;}}
		else { if (!headers_sent()) {header ($loc ."?dat=".$dat. "&m=2&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka);exit;;}}
	}
	else
	{
		 if (!headers_sent()) {header ($loc ."?dat=".$dat."&m=4&family=".$family."&name=".$name."&father=".$father."&Kabinka=".$Kabinka."&time_zap=".$time_zap);}
	}

}

mysql_close($db);	           
//echo '</html>'."\n";
?>
