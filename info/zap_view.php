<?php
$err=isset($_REQUEST['err'])?$_REQUEST['err']:1;
$family_pers=isset($_REQUEST['fam'])?$_REQUEST['fam']:0;
$name_pers=isset($_REQUEST['nam'])?$_REQUEST['nam']:0;
$father_pers=isset($_REQUEST['fath'])?$_REQUEST['fath']:0;
$kabinka=isset($_REQUEST['kab'])?$_REQUEST['kab']:0;
$time1=isset($_REQUEST['time'])?$_REQUEST['time']:0;
$dt=isset($_REQUEST['dt'])?$_REQUEST['dt']:0;
$raion=isset($_REQUEST['raion'])?$_REQUEST['raion']:0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;

if($err==1){$time_refresh=60;}
else{$time_refresh=10;}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<?php
echo "<meta http-equiv=\"refresh\" CONTENT=\"{$time_refresh};url=index.php?raion={$raion}&sub_raion={$sub_raion}\">";
?>

<script language="VBScript">  
	Sub Printer()  
		OLECMDID_PRINT = 6  
		OLECMDEXECOPT_DONTPROMPTUSER = 2  
		OLECMDEXECOPT_PROMPTUSER = 1  
		call WB.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER,1)  
	End Sub  
	document.write "<object ID='WB' WIDTH=0 HEIGHT=0 CLASSID='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'></object>"  
</script>

<STYLE type="text/css">
	body{
	font-family: 'Times New Roman';
	}   
	h1{font-size:53px;}     
	/*ДЛЯ ЭКРАНА*/
	div.scr{	
	position: fixed;
	left:25%;
	top:30%;
	font-size: 50px;
	text-align:left;
	margin:0 auto;
	}
	
	/*Для ПРИНТЕРА*/
	div.print{	
	font-family:arial;
	position: fixed;
	left:0;
	top:0;
	font-size: .9em;
	text-align:left;
	margin:0 auto;
	}
	
	div.print p{
		margin:0;
		
	}
	div.print .p_big{
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
$screen=0;
$family_pers=$family_pers.' '.strtoupper(substr($name_pers,0,1)).'.'.strtoupper(substr($father_pers,0,1)).'.';
    if ($screen==0){
		echo "<div class=\"screen\">";
		echo "<b>Посетитель: ";				  	
		echo "<font>{$family_pers}</font>";
		echo "<br><b>Дата записи: <font>{$dt}</font>";
		echo "<br><b>Время записи: <font>{$time1}</font>";
		echo "<p>Вы записаны в очередь.</p>";
		echo "<p>Ожидайте вызова</p>";
		echo "<p>к специалисту.</p>";
		echo "</div>";
    }
    else
	{
        echo "<div class=\"print\">";
        echo "<b>Посетитель: ";				  	
		echo "<font>{$family_pers}</font>";
		echo "<p>Дата:</p>";
		echo "<p class=\"p_big\">{$dt}</p>";
		echo "<p>Время:</p>";
		echo "<p class=\"p_big\">{$time1}</p>";
		echo "<p>Вы записаны в очередь.</p>";
		echo "<p>Ожидайте вызова</p>";
		echo "<p>к специалисту.</p>";
		echo "</div>";
    }
}//else err
?>
</body>	
</html>
