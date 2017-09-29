<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">

<?php
//тут попадаем только в предварительной записи
//выберим время

$nuw_date=mktime(0,0,0,$m1,$d1,$y1);
$date_priem=date("Y-m-d",$nuw_date);
$no=0;
$req="call free_interval('". $date_priem ."','". $vopros ."')";
$result = mysqli_query($dbI,$req) or die("Query failed 7a : " . mysqli_error());
$no = mysqli_num_rows($result);
$myrow=mysqli_fetch_row($result);
if ($myrow[0]==0 or !$myrow){$no=0; echo '<h5 class="tt"> На '.$date_priem.' по выбранному вопросу невозможно записаться предварительно</h5>';}
else echo '<h5 class="tt">'. $ti1. '</h5>';
if ($no>0)
{
echo '<table class="select_time" align=center>';
$i=0;
while ($myrow)
{
if ($i==0){echo "<tr>\n";}
echo '<td class="tsel">';
echo "<FORM action=". $PHP_SELF ."?action=8&m1=".$m1. "&y1=". $y1 ."&d1=". $d1 ."&kabinka=". $myrow[0] ."&inumber=". $inumber ."&vopros=" .$vopros. "&time1=". $myrow[1] ."&time2=". $myrow[2] ." method=\"post\">";
//echo "<a href=". $PHP_SELF ."?action=8&m1=".$m1. "&y1=". $y1 ."&d1=". $d1 ."&kabinka=". $myrow[0] ."&inumber=". $inumber ."&vopros=" .$vopros. "&time1=". $myrow[1] ."&time2=". $myrow[2] .">". substr($myrow[1],0,5) ."</a>";
echo '<INPUT type="submit" value="'. substr($myrow[1],0,5) .'">';
echo '</FORM>';
echo "</td>\n";
if ($i==1){echo "</tr>\n";}
$i=($i>0)?0:1;
$myrow=mysqli_fetch_row($result);
}
echo "</table>";
}//no>0

echo "</td></tr>";