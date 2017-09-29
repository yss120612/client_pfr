<?php
// тут показываем календарь предв. запись онли
    
$m0=($m1>1)?($m1-1):12;
$m2=($m1<12)?($m1+1):1;
$y0=($m1>1)?$y1:$y1-1;
$y2=($m1<12)?$y1:$y1+1;

$day_count = 1;
$dayofmonth = date('t',mktime(0, 0, 0, $m1,1,$y1));
$dayofweek = date('w', mktime(0, 0, 0, $m1,1,$y1))-1;
if($dayofweek <0) $dayofweek = 6; 
$shft=$dayofweek;
$param=$PHP_SELF ."?action=5&inumber=".$inumber."&vopros=".$vopros;
$param2=$PHP_SELF ."?action=7&inumber=".$inumber."&vopros=".$vopros;
?>
<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<h5 class="tt"><?php echo $ti1 ?></h5>
<?php


echo '<table class="tcdr" align="center">';
echo '<tr>
        <td class="cdrn">
            <a class="cdr" href='. $param . '&m1='. $m1 .'&y1='. ($y1-1) .'> год- </a> 
         </td> 
         <td class="cdrn">
                <a href='. $param . '&m1='. $m0 .'&y1='. $y0 .'> мес.- </a>
         </td>';
echo '<td colspan="3" class="cdrn" align="center">'. $MY[$m1-1] .'&nbsp;'. $y1 .'</td>';
echo '<td class="cdrn">
            <a href='. $param . '&m1='. $m2 .'&y1='. $y2 .'> мес.+ </a>
       </td> 
       <td class="cdrn">
            <a href='. $param. '&m1='. $m1 .'&y1='.($y1+1).'> год+ </a>
       </td>
       </tr>';

for($j = -1; $j < (($shft+$dayofmonth>35)?6:(($shft+$dayofmonth<29)?4:5)); $j++)
  {
  echo "<tr>\n";
  for($i = 0; $i < 7; $i++)
  {
   $dc=$j*7+$i;
   if ($dc<$shft || $dc>$dayofmonth+$shft-1) 
   {
   if ($dc<0) {echo "<td class=\"cdrn\">".$DY[$i]."</td>\n";} else {echo "<td td class=\"" . (($i<5)?'cdr':'cdrv') ."\">-</td>\n";}
   }
   else
   {
   if ($i<5 and time()<mktime(0, 0, 0, $m1, $day_count, $y1))
   {//рабочий
   echo "<td class=\"" . (($i<5)?'cdr':'cdrv') ."\"><a href=". $param2 . "&m1=". $m1 ."&y1=". $y1 ."&d1=". $day_count .">". $day_count ."</a></td>\n";
   }
   else
   {//выходной
   echo "<td class=\"" . (($i<5)?'cdr':'cdrv') ."\">". $day_count ."</a></td>\n";
   }
   $day_count++;
   }
  }//for i
  echo "</tr>\n";
}//for j  
echo "</table>\n";
?>
</td></tr>