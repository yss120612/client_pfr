<?php
$err=isset($_REQUEST['err'])?$_REQUEST['err']:1;
$family_pers=isset($_REQUEST['fam'])?$_REQUEST['fam']:0;
$name_pers=isset($_REQUEST['nam'])?$_REQUEST['nam']:0;
$father_pers=isset($_REQUEST['fath'])?$_REQUEST['fath']:0;
$kabinka=isset($_REQUEST['kab'])?$_REQUEST['kab']:0;
$time1=isset($_REQUEST['time'])?$_REQUEST['time']:0;
$dt=isset($_REQUEST['dt'])?$_REQUEST['dt']:0;

if($err==1){$time_refresh=60;}
else{$time_refresh=10;}


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="refresh" CONTENT="<?php echo $time_refresh;?>;url=index.php">
<link rel="shortcut icon" href="images/pfr.gif" />

<script language="VBScript">  
	Sub Printer()  
		OLECMDID_PRINT = 6  
		OLECMDEXECOPT_DONTPROMPTUSER = 2  
		OLECMDEXECOPT_PROMPTUSER = 1  
		call WB.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER,1)  
	End Sub  
	document.write "<object ID='WB' WIDTH=0 HEIGHT=0 CLASSID='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'></object>"  
</script>

<!--<script language="javascript1.2">
	setTimeout('document.location.replace("index.php")',5000);
</script>-->
<STYLE type="text/css">
	body{
	/*text-align:center;*/
	font-family: 'Times New Roman';
	/*font-size: 1.5em;*/
	/*color: #447bd4;*/
	}   
	h1{font-size:53px;}     
	/*ДЛЯ ЭКРАНА*/
	/*div{	
	position: fixed;
	left:25%;
	top:30%;
	font-size: 50px;
	text-align:left;
	margin:0 auto;
	}*/
	/*Для ПРИНТЕРА*/
	div{	
	position: fixed;
	left:0;
	top:0;
	font-size: .9em;
	text-align:left;
	margin:0 auto;
	}
	div font{font-size: 50px; color:#ff3019;}
	.inp_home{
	     background-image: url(../info/images/button_200_50.png);
	     background-repeat: no-repeat;
	    background-color: transparent;
	    border: 0px;
	    height: 50px;
	    width: 200px;
	    color: #FFFFFF;
	    font-size: 20px;
	    font-weight: bold;   
	    margin-right: 2px;
	    margin-left: 2px;
	    margin-bottom: 2px;
	    margin-top: 2px;
	    padding-right: 0px;
	    padding-left: 0px;
	    padding-bottom: 0px;
	    padding-top: 0px;
	}
	.frm_button_home{
	    font-size:30px;
	    color:#045A8C;
	    position: fixed;
	    left: 10px;
	    bottom: 10px;
	    margin-right: 0px;
	    margin-left: 0px;
	    margin-bottom: 0px;
	    margin-top: 0px;
	    padding-right: 0px;
	    padding-left: 0px;
	    padding-bottom: 0px;
	    padding-top: 0px;
	    vertical-align: bottom;
	    text-align: left;
}
	#dv_print{
		font-family:arial;
		
	}
	#dv_print p{
		margin:0;
		
	}
	#dv_print .p_big{
		font-size:1.1em;
		font-weight: bold;
	}
</STYLE>

<?php 

if ($err==1){
    echo "<body onLoad=\"VBScript:Printer()\">";
    echo "<h1 align=center style='color:red;'>Ошибка записи<br>обратитесь к диспетчеру</h1>";
    echo '
    <FORM class="frm_button_home" action="index.php">
            <input class="inp_home" type="submit" value="< Главное меню">
    </FORM>
    ';
}
else{
//Вывод на печать 
//echo "<body onLoad=\"javascript:window.print()\">";
echo "<body onLoad=\"VBScript:Printer()\">";
//НЕ Выводить на печать
//echo "<body>";
//Вывод на экран 0 на печать 1
$screen=1;
    if ($screen==0){
            //echo '<H1>Пожалуйста, запомните или запишите следующую информацию:</H1>';
    echo '<div>';
    echo '<b>Посетитель: ';				  	
    echo '<font>'.$family_pers . ' ' . strtoupper(substr($name_pers,0,1)) . '.' . strtoupper(substr($father_pers,0,1)) . '.</font>';
    echo '<br><b>Назначение:</b><font> Кабинка № '.$kabinka.'</font>';
    echo '<br><b>Дата приема: <font>'.$dt.'</font>';
    echo '<br><b>Время приема: <font>'. substr($time1,0,5).'</font>';
    echo '</div>';
    //echo '<br>_____________________';
    echo '
    <FORM class="frm_button_home" action="index.php">
            <input class="inp_home" type="submit" value="< Главное меню">
    </FORM>
    ';
    }
    else{
        echo '<div id="dv_print">';
            echo '<p>Посетитель:</p>';				  	
            echo '<p class="p_big">'.$family_pers. ' ' . strtoupper(substr($name_pers,0,1)) . '.' . strtoupper(substr($father_pers,0,1)) . '.</p>';
            echo '<p>Назначение:</p>';
			echo '<p class="p_big">Кабинка № '.$kabinka.'</p>';
            echo '<p>Дата:</p>';
			echo '<p class="p_big">'.$dt.'</p>';
            //echo '<p>Предполагаемое</p>';
			//echo '<p>время приема:</p>';
			//echo '<p class="p_big">'.substr($time1,0,5).'</p>';
            //echo '<p>_____________________</p>';
        echo '</div>';
    }
}//else err
?>
</body>	
</html>
