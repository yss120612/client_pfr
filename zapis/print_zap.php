<?php 
echo '<html>'."\n";
$dat=(isset($_REQUEST['dat']))?$_REQUEST['dat']:'';
$tmp=explode('-',$dat);

echo '<meta http-equiv="Content-Type" content="text/html">'."\n";
?>
<style type="text/css">
   TABLE { 
    width: 100%; /* ������ ������� */
    border: 4px double black; /* ����� ������ ������� */
    border-collapse: collapse; /* ���������� ������ ��������� ����� */
   }
   TH { 
    text-align: left; /* ������������ �� ������ ���� */
    background: #ccc; /* ���� ���� ����� */
    padding: 5px; /* ���� ������ ����������� ����� */
    border: 1px solid black; /* ������� ������ ����� */
   }
   TD { 
    padding: 5px; /* ���� ������ ����������� ����� */
    border: 1px solid black; /* ������� ������ ����� */
   }
  </style>
<?

include_once('../login.php');

$sql="call CreateKabList1(' " . $dat . " '); ";
$result = mysql_query($sql,$db) or die("Query failed : " . mysql_error());

$result = mysql_query("select kab,name,time_s,time_f,t_obr_str from QueueKab where predvar ='1' order by kab",$db) or die("Query failed : " . mysql_error());

echo "<H2><center> ��������������� ������ ��  ".$tmp[2]."-".$tmp[1] ."-". $tmp[0] ."</center></H2>\n";

echo '<div align="center"><TABLE>';
   echo "\n<TR>\n";
   echo "<TH width=40> ������� </TH>\n";
   echo "<TH width=150>  ���������� </TH>\n";
   echo "<TH width=100>  ����� ������  </TH>\n";
   echo "<TH width=50>   ��������� </TH>\n";
   echo "<TH width=350> ��� ��������� </TH>\n";
   echo "</TR>\n";

while ($myrow=mysql_fetch_row($result))
{
$s=date("H:i",strtotime($myrow[2]));
$e=date("H:i",strtotime($myrow[3]));

echo "\n<TR>\n";
   echo "<TD width=40>". $myrow[0]." </TD>\n";
   echo "<TD width=150> ". $myrow[1]."</TD>\n";
   echo "<TD width=100> ". $s ."  </TD>\n";
   echo "<TD width=50>   ". $e." </TD>\n";
   echo "<TD width=350> ". $myrow[4]." </TD>\n";
   echo "</TR>\n";
}

 echo "</TABLE>\n";
mysql_close($db);	 
exit;

echo '</html>'."\n";
?>








