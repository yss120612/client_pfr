<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<h5 class="tt"><?php echo $ti1 ?></h5>
<?php
// ������� �� �������
//$req="call zapis_info(".$vopros.",@kabinka, @t1info, @t2info)";
//$result=mysqli_query($dbI,$req) or die("Query failed : " . mysqli_error());
//$req="select @kabinka, @t1info, @t2info";
//$result=mysqli_query($dbI,$req) or die("Query failed : " . mysqli_error());

$req="call zapis_info('".$vopros."')";
$result=mysqli_query($dbI,$req) or die("Query failed 11: " . mysqli_error());
$myrow=mysqli_fetch_row($result);

if ($myrow[0]!=0)
{
echo "<h5 class=\"tt\">�� ������ ������� ����� ����������<br>� ". $myrow[0] ." ������� �� ". date("H:i",strtotime($myrow[1])) .".<br><br><br>����������� ������</h5>";
?>
<script type="text/javascript">
<!--
function da()
{
var loc;
loc="rec_pos.php?action=1&fio=<?php echo $fio ?>&vopros=<?php echo $vopros ?>&kabinka=<?php echo $myrow[0] ?>&time1=<?php echo $myrow[1] ?>&time2=<?php echo $myrow[2] ?>";
window.location.replace(loc);
};
-->
</script>
<form>
<input name="DA" type="button" class="input-button5" value="��������" onClick = "da(); document.forms[0].DA.value='�����'"><br>
</form>

<?php
}
else
{//������ �������
//echo "<h5 class=\"tt\">".$myrow[1]."<br>���������� � ����������.</h5>";
    echo "<h5 class=\"tt\">".$myrow[1]."<br>�������� ������ ���� ��� ���������</h5>";
 
}
echo "</td></tr>";