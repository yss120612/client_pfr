<?php
include_once('../loginI.php');

$fio=(isset($_REQUEST['fio']))?$_REQUEST['fio']:"";
$m1=(isset($_REQUEST['m1']))?$_REQUEST['m1']:date('n');
$y1=(isset($_REQUEST['y1']))?$_REQUEST['y1']:date('Y');
$d1=(isset($_REQUEST['d1']))?$_REQUEST['d1']:0;
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$inumber=isset($_REQUEST['inumber'])?$_REQUEST['inumber']:0;
$vopros=isset($_REQUEST['vopros'])?$_REQUEST['vopros']:0;
$kabinka=isset($_REQUEST['kabinka'])?$_REQUEST['kabinka']:0;
$time1=isset($_REQUEST['time1'])?$_REQUEST['time1']:0;
$time2=isset($_REQUEST['time2'])?$_REQUEST['time2']:0;

$serv=$_SERVER['SERVER_NAME'];
$port=$_SERVER['SERVER_PORT'];
$RADD=$_SERVER['REMOTE_ADDR'];

if($action==1){
    //ФИО с клавиатуры
    
    //echo $fio;
    if (!empty($fio)){
        $fio=  urldecode($fio);
        list ($family_pers,$name_pers,$father_pers)= explode(" ",$fio);
    }
    
   if ($d1==0){
        $dt=strftime("%d/%m/%y");
        $dt_pred=strftime("%y-%m-%d");
        $predv=0;
        $req="insert into posetit (family,Kab,otrab,type_obr,name,father,pers_num,time_comin,predvar,time_nach_p,time_end_p,userzap,ipzap,date_comin) 
        values('".$family_pers."',". $kabinka .",'0',". $vopros .",'".$name_pers."','".$father_pers."','".$inumber."','". date("H:i:s") ."','". $predv ."','". $time1 ."','". $time2 ."','Infomat','". $RADD ."','". date("Y-m-d") ."')";
    }
    else{
        $nuw_date=mktime(0,0,0,$m1,$d1,$y1);
        $dt_pred=date("Y-m-d",$nuw_date);
        $dt=date("d/m/Y",$nuw_date);
        $predv=1;
        $req="insert into posetit (family,Kab,otrab,type_obr,name,father,pers_num,datepredvar,time_comin,predvar,time_nach_p,time_end_p,userzap,ipzap,date_comin) 
        values('".$family_pers."',". $kabinka .",'0',". $vopros .",'".$name_pers."','".$father_pers."','".$inumber."','". date("Y-m-d") ."','". date("H:i:s") ."','". $predv ."','". $time1 ."','". $time2 ."','Infomat','". $RADD ."','".$dt_pred."')";		
    }
    $result=mysqli_query($dbI,$req)	or die("Query failed : " . mysqli_error());
    header ("Refresh: 0; url=http://".$serv.':'.$port.'/info/zap_view.php?err=0&fam='.
                    urlencode($family_pers).
            '&nam='.urlencode($name_pers).
            '&fath='.urlencode($father_pers).
            '&kab='.$kabinka.
            '&dt='.$dt.
            '&time='.$time1);exit();	
    
    mysqli_close($dbI);
}
elseif($action==2){
    //ФИО по СНИЛС из базы
    include_once '../function/getPers.php';
        //$inumber=substr($inumber,0,9);
        list ($err_getPers,$family_pers,$name_pers,$father_pers,$rajon)=getPers($inumber);
        
        if ($err_getPers==0 or $err_getPers==1){		
		if ($d1==0){
		$dt=strftime("%d/%m/%y");
		$dt_pred=strftime("%y-%m-%d");
		$predv=0;
		$req="insert into posetit (family,Kab,otrab,type_obr,name,father,pers_num,time_comin,predvar,time_nach_p,time_end_p,userzap,ipzap,date_comin) 
		values('".$family_pers."',". $kabinka .",'0',". $vopros .",'".$name_pers."','".$father_pers."','".$inumber."','". date("H:i:s") ."','". $predv ."','". $time1 ."','". $time2 ."','Infomat','". $RADD ."','". date("Y-m-d") ."')";
                }
                else{
		$nuw_date=mktime(0,0,0,$m1,$d1,$y1);
		$dt_pred=date("Y-m-d",$nuw_date);
		$dt=date("d/m/Y",$nuw_date);
		$predv=1;
		$req="insert into posetit (family,Kab,otrab,type_obr,name,father,pers_num,datepredvar,time_comin,predvar,time_nach_p,time_end_p,userzap,ipzap,date_comin) 
		values('".$family_pers."',". $kabinka .",'0',". $vopros .",'".$name_pers."','".$father_pers."','".$inumber."','". date("Y-m-d") ."','". date("H:i:s") ."','". $predv ."','". $time1 ."','". $time2 ."','Infomat','". $RADD ."','".$dt_pred."')";		
                }
		$result=mysqli_query($dbI,$req)	or die("Query failed : " . mysqli_error());
                header ("Refresh: 0; url=http://".$serv.':'.$port.'/info/zap_view.php?err=0&fam='.
                                urlencode($family_pers).
                        '&nam='.urlencode($name_pers).
                        '&fath='.urlencode($father_pers).
                        '&kab='.$kabinka.
                        '&dt='.$dt.
                        '&time='.$time1);exit();		
	}
        else {
            //echo "<h1 align=center>Ошибка записи<br>обратитесь к диспетчеру</h1>";
            header ("Refresh: 0; url=http://".$serv.':'.$port.'/info/zap_view.php?err=1');
            exit();
        }//нет в базах
    mysqli_close($dbI);
}
else{
    //Ошибка
    header ("Refresh: 0; url=http://".$serv.':'.$port.'/info/zap_view.php?err=1');exit();
}

?>
