<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<?php
$err=0;

if (strlen($inumber)!=11 && $ident==2) {$err=1;}
elseif ((strlen($inumber)<1 || strlen($inumber)>6) && $ident==1) {$err=2;}
if ($ident<1 || $ident>2) {$err=6;}
if ($err==0)
{
    if ($ident==2){//����� �� ���������� ������     
	include_once '../function/getPers.php';
        $inumber=substr($inumber,0,9);
        list ($err_getPers,$family_pers,$name_pers,$father_pers,$rajon)=getPers($inumber);        
        if ($err_getPers==0 or $err_getPers==1){$err=0;
		$fio_pers=urlencode(trim($family_pers)).'+'.urlencode(trim($name_pers)).'+'.urlencode(trim($father_pers));}//ok
        else {$err=3;}//��� � �����       
    }
}
if ($err==0)
{
if ($vopros==0)//������ �� �����
{
$result = mysqli_query($dbI,
        "SELECT types_obr.id, types_obr.zatrat, types_obr.full_name, group_types_obr.full_name
            FROM types_obr,group_types_obr where actual>'0'
            AND types_obr.group_id=group_types_obr.id")
        or die("Query failed : " . mysqli_error());
$no = mysqli_num_rows($result);

if ($no>0)
{
$i=0;
?>
<h5 class="tt"><?php echo $ti1 ?></h5>

<script type="text/javascript">
 function switch_divs(numdiv)
    {
        
    if (numdiv==1){
    document.getElementById('div_types1').style.display = 'block';
    document.getElementById('div_types2').style.display = 'none';
    document.getElementById('div_types3').style.display = 'none';
    }
    
    if (numdiv==2){
    document.getElementById('div_types1').style.display = 'none';
    document.getElementById('div_types2').style.display = 'block';
    document.getElementById('div_types3').style.display = 'none';
    }
    if (numdiv==3){
    document.getElementById('div_types1').style.display = 'none';
    document.getElementById('div_types2').style.display = 'none';
    document.getElementById('div_types3').style.display = 'block';
    }
    
    return false;
}
</script>
<?php

//$no=50;
$col_divs=$no/18;
//$num_divs=1;

if ($col_divs>1 and $col_divs<2){echo '<div align="center" class="sw_main">
                                        <div onclick="switch_divs(1)" class="page_left"><</div>
                                        <div onclick="switch_divs(2)" class="page_right">></div>
                                       </div>';}
if ($col_divs>2){echo '<div align="center" class="sw_main">
                        <div onclick="switch_divs(1)" class="page_left">1</div>
                        <div onclick="switch_divs(2)" class="page_center">2</div>
                        <div onclick="switch_divs(3)" class="page_right">3</div>
                       </div>';}


    while($myrow=mysqli_fetch_row($result)){
       if ($i<18){ 
           $num_divs=1;
       if ($i==0){echo '<div id="div_types'.$num_divs.'">';}
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=". (($today==1)?6:5). "&inumber=".$inumber ."&vopros=". $myrow[0]."&fio=".$fio_pers.">"; 
       echo '<INPUT class="sub_type" type="submit" value="'. $myrow[2] .'" >';
       echo '</FORM>';
       if ($i==17){echo '</div>';}
       }
       if ($i>=18 and $i<36){
           $num_divs=2;
           
       if ($i==18){echo '<div id=div_types'.$num_divs.'>';}
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=". (($today==1)?6:5). "&inumber=".$inumber ."&vopros=". $myrow[0]."&fio=".$fio_pers.">"; 
       echo '<INPUT class="sub_type" type="submit" value="'. $myrow[2] .'">';
       echo '</FORM>';
       if ($i==35){echo '</div>';}
       }
       
       if ($i>=36 and $i<54){
           $num_divs=3;
           
       if ($i==36){echo '<div id=div_types'.$num_divs.'>';}
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=". (($today==1)?6:5). "&inumber=".$inumber ."&vopros=". $myrow[0]."&fio=".$fio_pers.">"; 
       echo '<INPUT class="sub_type" type="submit" value="'. $myrow[2] .'">';
       echo '</FORM>';
       if ($i==53){echo '</div>';}
       }
       
       $i++;
    }


}//if n>0
else
{//err>0
$err=5;//��������� �� ������������ ��������
}

}//vopros=0
elseif ($vopros==1)//������� �1
{
?>
<script language="VBScript" src="scripts/scr_help_a.vbs">
</script>
<H1>��������� ������� � ������� ������<br>
    ����������� ��� �����
</h1>
<input name="txtRajon"  type="hidden" value="<?php echo $rajon ?>">
<input name="txtText"  type="hidden" value="<?php echo $inumber ?>"><br>
<img style="visibility: hidden" name="load" src="images/loadinfo.gif"><br><br><br>
<input name="B10" type="button" class="input-button5" value="��������"><br>

<?php
}
elseif ($vopros==2 || $vopros==3)//������� �2,3
{

?>
<script type="text/javascript">
<!--
function month2num(sm)
{
var sss="";
for (i=0;i<12;i++)
{
if (smonth[i]==sm) sss=""+(i+1); 
}
if (sss.length == 1) {sss="0"+sss;}
return sss;
}

function addMon(input,gbt,character)
{
if (parseInt(character)<100)
{
input.value=smonth[parseInt(character)];
}
else
{
input.value=character;
}

if (document.forms[0].dispM1.value.length>0 && document.forms[0].dispM.value.length>0 && document.forms[0].dispY.value.length>0 && document.forms[0].dispY1.value.length>0)
{
gbt.style.display='';
}
else
{
gbt.style.display='none';
}
};

function chkfrm()
{
var dat1="01."+month2num(document.forms[0].dispM.value)+"."+document.forms[0].dispY.value;
var dat2="01."+month2num(document.forms[0].dispM1.value)+"."+document.forms[0].dispY1.value;
loc="<?php echo $PHP_SELF ?>?action=21&vopros=<?php echo $vopros ?>&inumber=<?php echo $inumber ?>&dat1="+dat1+"&dat2="+dat2+"&rajon=<?php echo $rajon ?>";
window.location.replace(loc)
};

function clr(input,gbt)
{
input.value='';
gbt.style.display='none'
};

-->
</script>
<h2>�������� ������</h2><br>
<form>
<table class="calendar" style="width: 700px;">
<tr>
<td>
<input name="dispM" class="input-disp1" value="" onFocus="document.forms[0].dispM.blur()"><br>
<td>
<input name="dispY" class="input-disp2" value="" onFocus="document.forms[0].dispY.blur()"><br>
</td>
<td rowspan="2">
<h5 class="tt">-</h5>
</td>
<td>
<input name="dispM1" class="input-disp1" value="" onFocus="document.forms[0].dispM1.blur()"><br>
</td>
<td>
<input name="dispY1" class="input-disp2" value="" onFocus="document.forms[0].dispY1.blur()"><br>
</td>
</tr>
<tr>
<td>
<?php

$end_mon=(date("m")-1);
$ystart=2014;
$cur_y=date("Y");
//$cur_y=2016;
echo '<table style="">';
for ($j=0,$i=0;$i<6;$i++,$j=($j==0)?1:0)
{
	$r=$i+6;
	echo '<tr>';
    echo "<td><input style='margin-right:5px;' type=\"button\" class=\"input-button3\" value=\"". ($MY[$i]) ."\" onClick=\"addMon(document.forms[0].dispM,document.forms[0].Btn10, '". ($i) ."')\" style='font-size:15pt;'></td>";
	echo "<td><input type=\"button\" class=\"input-button3\" value=\"". ($MY[$r]) ."\" onClick=\"addMon(document.forms[0].dispM,document.forms[0].Btn10, '". ($r) ."')\" style='font-size:15pt;'></td>";
	echo '</tr>';
 }
echo '</table>';

?>
</td>
<td style="vertical-align:top;">
<?php
while($ystart<=$cur_y){
	echo "<input type=\"button\" class=\"input-button4\" value=\"". ($ystart) ."\" onClick=\"addMon(document.forms[0].dispY,document.forms[0].Btn10, '". ($ystart) ."')\">";
	$ystart++;
}
?>
</td>


<td>
<?php

echo '<table style="">';
for ($j=0,$i=0;$i<6;$i++,$j=($j==0)?1:0)
{
	$r=$i+6;
	echo '<tr>';
    echo "<td><input style='margin-left:15px;margin-right:5px;' type=\"button\" class=\"input-button3\" value=\"". ($MY[$i]) ."\" onClick=\"addMon(document.forms[0].dispM1,document.forms[0].Btn10, '". ($i) ."')\" style='font-size:15pt;'></td>";
	echo "<td><input type=\"button\" class=\"input-button3\" value=\"". ($MY[$r]) ."\" onClick=\"addMon(document.forms[0].dispM1,document.forms[0].Btn10, '". ($r) ."')\" style='font-size:15pt;'></td>";
	echo '</tr>';
 }
echo '</table>';

?>
<td  style="vertical-align:top;">
<?php
//for ($j=0,$i=0;$i<1;$i++,$j=($j==0)?1:0)
$ystart=2014;
while($ystart<=$cur_y){
	echo "<input type=\"button\" class=\"input-button4\" value=\"". ($ystart) ."\" onClick=\"addMon(document.forms[0].dispY1,document.forms[0].Btn10, '". ($ystart) ."')\">";
	$ystart++;
}
?>
</td>
</tr>
<tr>
<td colspan="5">
&nbsp; <input style="display:none" name="Btn10" type="button" class="input-button2" value="������" onClick = "chkfrm()"> &nbsp;<br>
</tr>
</table>
</form>
<?php
}
elseif ($vopros==4)//������� �4
{
?>
<script language="VBScript" src="scripts/scr_help4_a.vbs">
</script>
<H1>��������� ������� � ���������� ���<br>
    ����������� ��� �����
</h1>
<input name="txtRajon"  type="hidden" value="<?php echo $rajon ?>">
<input name="txtText"  type="hidden" value="<?php echo $inumber ?>"><br>
<img style="visibility: hidden" name="load" src="images/loadinfo.gif"><br><br><br>
<input name="B10" type="button" class="input-button2" value="��������"><br>
<?php
}

elseif ($vopros==10)//����������� 
{
?>
<table border="0" width="100%" id="table2">
	<tr>
	   <td>
                <h2>��������� ����������!<br>
                    ��� ��� ����� ����� ���� ������ � ����� ������.</H2>
           </td>
        </tr>
        <tr>
            <td><h3>��������, ����������, ��� ��� ����������:</h3></td>
        </tr>    
                <form method="get" action="<?php echo $PHP_SELF ?>">
                <tr><td align="center">
                       <table border="0" id="table_opros">
                        
                         <tr>
                            <td><div id="div_opros" for="labeled_1"><input type="checkbox" value="1" name="q1" id="labeled_1" />
                                <label for="labeled_1">���� ������&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </label></div></td>
                        </tr>
                        <tr>
                            <td><div id="div_opros"><input type="checkbox"  value="1" name="q2" id="labeled_2" />
                            <label for="labeled_2">������� ������ (�������)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label></div></td>
			
                        </tr>
                        <tr>
                            <td><div id="div_opros"><input type="checkbox"   value="1" name="q3" id="labeled_3" />
                            <label for="labeled_3">�������������� �����������
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label></div></td>
                    
                        </tr>
                        <tr>
                        <td><div id="div_opros"><input type="checkbox"  value="1" name="q4" id="labeled_4" />
                            <label for="labeled_4">���������� �����������
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label></div></td>
                    
                        </tr>
                        <tr>
                            <td><div id="div_opros" for="labeled_5"><input type="checkbox"  value="1" name="q5" id="labeled_5" />
                            <label for="labeled_5">����������� ��������� ����������</label></div></td>	
                        </tr>
                        <tr>
                            <td><div id="div_opros"><input type="checkbox"  value="1" name="q6" id="labeled_6" />
                            <label for="labeled_6">�������� ������������
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label></div></td>
                    
                        </tr>
                       </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>������ ����������� �������� ���������</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                                <p align="center">
                                    <input type="hidden" value="<?php echo $inumber?>" name="inumber">
				<input type="hidden" value="15" name="action">
                                <!--<input type="reset" class="input-button6" value="��������" >&nbsp;-->
				<input type="submit" class="input-button6" value="�������������" onMouseOver="window.status=''; return null;">
                                </p>
                    </form>
		</td>
	</tr>

	</table>
	<?php
}

}//err =0
if ($err>0)
{
switch ($err)
{
case 1:$ti1= "�������� ��������� �����";break;
case 2:$ti1= "�������� ����� ����������� ����";break;
case 3:$ti1= "����� ����������� � ���� ������.";break;
case 4:$ti1= "�� <font color='red'>�� ����������������</font><br>� ������������� � ����������� �������<br>�.��������.<br> ���������� � ����������.";break;
case 5:$ti1= "���� � ������ ��.";break;
case 6:$ti1= "���� � ������ ��.";break;
}
echo "<h5 class=\"tt\">". $ti1 ."</h5>";
}
echo "</td></tr>";