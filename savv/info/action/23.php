<tr>
<!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<h5 class="tt"><?php echo $ti1 ?></h5>

<?php
//echo $fio ." (ям-".$inumber.")<br>";
//$result = mysqli_query($dbI,"SELECT id,zatrat,full_name,group_id FROM types_obr where actual>'0' order by full_name") or die("Query failed : " . mysqli_error());
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
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=".(($today==1)?24:25)."&vopros=".$myrow[0]."&fio=".urlencode($fio).">"; 
       echo '<INPUT class="sub_type" type="submit" value="'.$myrow[2].'" >';
       echo '</FORM>';
       if ($i==17){echo '</div>';}
       }
       if ($i>=18 and $i<36){
           $num_divs=2;
           
       if ($i==18){echo '<div id=div_types'.$num_divs.'>';}
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=".(($today==1)?24:25)."&vopros=".$myrow[0]."&fio=".urlencode($fio).">"; 
       echo '<INPUT class="sub_type" type="submit" value="'.$myrow[2].'">';
       echo '</FORM>';
       if ($i==35){echo '</div>';}
       }
       
       if ($i>=36 and $i<54){
           $num_divs=3;
           
       if ($i==36){echo '<div id=div_types'.$num_divs.'>';}
       echo "<FORM id=\"frm_type\"method=\"post\" action=". $PHP_SELF. "?action=".(($today==1)?24:25)."&vopros=".$myrow[0]."&fio=".urlencode($fio).">"; 
       echo '<INPUT class="sub_type" type="submit" value="'.$myrow[2].'">';
       echo '</FORM>';
       if ($i==53){echo '</div>';}
       }
       
       $i++;
    }


}//if n>0


//echo $fio;
echo "</td></tr>";