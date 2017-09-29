<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Очередь посетителей КС</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <!--<meta http-equiv="Cache-Control" content="max-age=3600, must-revalidate" />-->
    <META HTTP-EQUIV="refresh" CONTENT="10; url=tele_fio2.php">
    
    
    <STYLE type="text/css">
        div{                
            
            text-align: right;
            vertical-align: middle;
            font-weight:  normal;
            color: #ffffff;
            font-size: 2em;
            height: 40px;            
        }
        div.hat{
	    background: #2C4864;  /*old browsers */
	    background: -moz-linear-gradient(top, #0092DB 0%, #2C4864 100%); /* firefox */
	    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0092DB), color-stop(100%,#2C4864)); /* webkit */
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0092DB', endColorstr='#2C4864',GradientType=0); /* ie */
	    -ms-filter: "progid:DXImageTransform.Microsoft.gradient (enabled='true',GradientType=0, startColorstr=#0092DB, endColorstr=#2C4864)"; /* IE8 */
            text-align: center;
            vertical-align: middle;
            font-size: 2em;
            font-weight: bold;
            color: #ffffff;
        }
        /*div.kab{
	     
            background-image: none;
            text-align: left;
	    vertical-align: middle;
            font-size: 2em;
            font-weight: bold;
	    /*padding-bottom: 5px;*/
            /*color: #ffffff;
            /*border: solid 1px green;*/
        /*}*/
        div.lightColor_kab{
	    background: #61BDE8; /* old browsers */
	    background: -moz-linear-gradient(top, #61BDE8 0%, #066dab 100%); /* firefox */
	    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#61BDE8), color-stop(100%,#066dab)); /* webkit */
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#61BDE8', endColorstr='#066dab',GradientType=0 ); /* ie */
	    -ms-filter: "progid:DXImageTransform.Microsoft.gradient (enabled='true',GradientType=0, startColorstr='#61BDE8', endColorstr='#066dab')"; /* IE8 */
	    text-align: center;
	    vertical-align: middle;
	    font-family: Impact;
            font-size: 2.5em;
            font-weight: lighter;
	    color: #ffffff;
            height: 50px;

}
	div.lightColor{
	    background: #61BDE8; /* old browsers */
	    background: -moz-linear-gradient(top, #61BDE8 0%, #066dab 100%); /* firefox */
	    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#61BDE8), color-stop(100%,#066dab)); /* webkit */
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#61BDE8', endColorstr='#066dab',GradientType=0 ); /* ie */
	    -ms-filter: "progid:DXImageTransform.Microsoft.gradient (enabled='true',GradientType=0, startColorstr='#61BDE8', endColorstr='#066dab')"; /* IE8 */
	    text-align: right;
            vertical-align: middle;
            font-weight:  normal;
            color: #ffffff;
            font-size: 2em;
            height: 50px;   
            
}


	div.darkColor_kab{
	    background: #195895; /* old browsers */
	    background: -moz-linear-gradient(top, #258dc8 0%, #195895 100%); /* firefox */
	    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#258dc8), color-stop(100%,#195895)); /* webkit */
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#258dc8', endColorstr='#195895',GradientType=0 ); /* ie */
	    -ms-filter: "progid:DXImageTransform.Microsoft.gradient (enabled='true',GradientType=0, startColorstr=#258dc8, endColorstr=#195895)"; /* IE8 */
	    text-align: center;
	    vertical-align: middle;
	    font-family: Impact;
            font-size: 2.5em;
            font-weight: lighter;
	    color: #ffffff;
            height: 50px;

}
	div.darkColor{
	    background: #195895; /* old browsers */
	    background: -moz-linear-gradient(top, #258dc8 0%, #195895 100%); /* firefox */
	    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#258dc8), color-stop(100%,#195895)); /* webkit */
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#258dc8', endColorstr='#195895',GradientType=0 ); /* ie */
	    -ms-filter: "progid:DXImageTransform.Microsoft.gradient (enabled='true',GradientType=0, startColorstr=#258dc8, endColorstr=#195895)"; /* IE8 */
	    text-align: right;
            vertical-align: middle;
            font-weight:  normal;
            color: #ffffff;
            font-size: 2em;
            height: 50px;
            

}
       body {
           background-color:#619fdb;
           font-family: Tahoma;
       }
       td.hat {

           text-align: center;
           color: #ffffff; 
           font-size: 2em; 
           font-weight: bold;
       }
     
    </style>
    
</head>
<body>
<?php 
include('login.php');

$result = mysql_query("SELECT * FROM specialict Where view_telev=1 ",$db)  or die("Query failed : " . mysql_error());  
$MaxKab=mysql_num_rows($result);
?>
<TABLE style="WIDTH:100%; height:100%; border: none; border-collapse: collapse; margin: 0px; padding: 0px;">
<tr><td width="40"></td><td>
<TABLE style="WIDTH:100%; height:100%; border: none; border: solid 2px #ffffff; border-collapse: collapse; margin: 0px; padding: 0px;">
<TR>
    <td style="border: solid 2px #ffffff; /*width:150px;*/"><div class="hat">Каб</div></td>  
    <td style="border: solid 2px #ffffff;"><div class="hat"> НА ПРИЕМЕ</div></td> 
    <td style="border: solid 2px #ffffff;"><div class="hat">ОЖИДАЕТ</div></td>
    <td style="border: solid 2px #ffffff;"><div class="hat">ОЖИДАЕТ</div></td> 
</TR>
<?php 
//Заполним фамилии специалистов

$result = mysql_query("SELECT kab,fio,vid_name FROM specialict Where view_telev=1  order by kab",$db)   or die("Query failed : " . mysql_error());  
$j=0;

while($tab_kab=mysql_fetch_row($result)) 
{ 
$w=$tab_kab[1]; 
$kab=$tab_kab[0];

$result2 = mysql_query("SELECT * FROM posetit,types_obr Where (otrab=0) and (kab=$kab) and (posetit.type_obr=types_obr.id) and (types_obr.actual='1') 
and date_comin = current_date order by posetit.time_nach_p",$db)
  or die("Query failed : " . mysql_error());  
$count1=0;
//Создаем полосатость списка посетителей
if ($j%2==0){$color='lightColor';$color_kab='lightColor_kab';}
if ($j%2!=0){$color='darkColor'; $color_kab='darkColor_kab';}

//if (strlen($tab_kab[2])<=5){$sp='&nbsp;&nbsp;';}
//if (strlen($tab_kab[2])>5){$sp='';}
$b=preg_match('/(\d+)/',$tab_kab[2],$kab);
//$kab=$tab_kab[2];
$st="<tr><TD align=right style=\"border-right: solid 2px #ffffff;\"><div class=$color_kab>$kab[0]<!--<img src=\"image/div_kab_20x60.png\">--></div></TD>";

$predPosetit="";
 while(($tab_pos=mysql_fetch_row($result2)) and ($count1<3)) { 
  $count1=$count1+1;
  $name=$tab_pos[5];
  $father=$tab_pos[6];
  
  if ($predPosetit<>strtoupper($tab_pos[0].$name[0].$father[0])){
   //$st=$st."<td><font size=5 color=#00008B><b>".strtoupper($tab_pos[0]."       ".$name[0].".".$father[0].".")."</b></font></td>";
      
      $fio=strtoupper($tab_pos[0]." ".$name[0].".".$father[0].".");
      $len=strlen($fio);
      if ($len<=14){$f_size=38;}
      else if ($len>17){$f_size=28;}
      else {$f_size=34;}
      $st=$st."<td style=\"border-right: solid 2px #ffffff;\"><div class=$color style=\"font-size: ".$f_size."px;\">".$fio."</div></td>";
  }
  else { $count1=$count1-1;}
  $predPosetit=strtoupper($tab_pos[0].$name[0].$father[0]);

 }

if ($count1==1) {echo $st."<td style=\" border-right: solid 2px #ffffff;\"> <div class=$color style=\"text-align: center; font-size: 42px;\">---------------</div> 
                     </td> <td style=\" border-right: solid 2px #ffffff;\"> <div class=$color style=\"text-align: center; font-size: 42px;\">---------------</div></td></tr>"; $j++;}
if ($count1==2) {echo $st."<td style=\" border-right: solid 2px #ffffff;\"> <div class=$color style=\"text-align: center; font-size: 42px;\">---------------</div> </td></tr>";  $j++;}
if ($count1==3) {echo $st."</tr>"; $j++; }

 }

echo "</table>";
echo "</td></tr></table>";        
mysql_close($db);	           
?>
</body>
</html> 
