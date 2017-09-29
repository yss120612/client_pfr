<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<!--<h5 class="tt"><?php //echo $ti1 ?></h5>-->
<?php
$q1=(isset($_REQUEST['q1']))?$_REQUEST['q1']:0;
$q2=(isset($_REQUEST['q2']))?$_REQUEST['q2']:0;
$q3=(isset($_REQUEST['q3']))?$_REQUEST['q3']:0;
$q4=(isset($_REQUEST['q4']))?$_REQUEST['q4']:0;
$q5=(isset($_REQUEST['q5']))?$_REQUEST['q5']:0;
$q6=(isset($_REQUEST['q6']))?$_REQUEST['q6']:0;
$req="select * from opros where pers_num='". $inumber. "' AND dat='".date("Y-m-d")."'";


$result = mysqli_query($dbI,$req) or die("Query failed 7a : " . mysqli_error());
$no = mysqli_num_rows($result);
if ($no>0)
{
$req="UPDATE opros SET otv1='".$q1."', otv2='".$q2."',otv3='".$q3."',otv4='".$q4."', otv5='".$q5."',otv6='".$q6."' 
    WHERE pers_num='".$inumber."' AND dat='".date("Y-m-d")."'";
$result = mysqli_query($dbI,$req) or die("Query failed 8a : " . mysqli_error());
    echo '<br><br><br><br><br><br><br><p><font size="7">Спасибо, Ваш голос был принят</font></p>';
}
else
{
$req="insert into opros (dat ,pers_num , otv1 , otv2 , otv3 , otv4 , otv5, otv6) values('". date("Y-m-d") ."','". $inumber. "','". $q1 ."','". $q2."','". $q3 ."','". $q4."','". $q5. "','".$q6."')";
$result = mysqli_query($dbI,$req) or die("Query failed 9a : " . mysqli_error());
    echo '<br><br><br><br><br><br><br><p><font size="7">Спасибо, Ваш голос был принят</font></p>';
}

//какое то действие
echo "</td></tr>";