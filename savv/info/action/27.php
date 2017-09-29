<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<?php
$time1=isset($_REQUEST['time1'])?$_REQUEST['time1']:0;
$time2=isset($_REQUEST['time2'])?$_REQUEST['time2']:0;
$nuw_date=mktime(0,0,0,$m1,$d1,$y1);
$ti1="<h5 class=\"tt\">Вами выбран прием на <br><span style='color:red;'>". fdate("$y1-$m1-$d1", 'd')." в ". substr($time1,0,5) 
        ."</span> <br><br><br>Подтвердите ваш выбор или <br> вернитесь к выбору времени приема</h5><br>";
?>
<h5 class="tt"><?php echo $ti1 ?></h5>
<?php
//тут попадаем только в предварительной записи
//ЗАПИШЕМ НА ПРЕДВАРИТЕЛЬНЫЙ ПРИЕМ
?>
<script type="text/javascript">
<!--
function da_predv()
{
var loc;
loc="rec_pos.php?action=1&fio=<?php echo urlencode($fio); ?>&vopros=<?php echo $vopros; ?>&kabinka=<?php echo $kabinka; ?>&time1=<?php echo $time1; ?>&time2=<?php echo $time2; ?>&d1=<?php echo $d1; ?>&m1=<?php echo $m1; ?>&y1=<?php echo $y1; ?>";
window.location.replace(loc);
};
-->
</script>
<form>
    <input type="button" class="input-button2" value="Назад" onclick="javascript:history.go(-1)">   
<input name="DAP" type="button" class="input-button2" value="Записать" onClick = "da_predv(); document.forms[0].DAP.value='Ждите'"><br>
</form>
<?php

echo "</td></tr>";