<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <meta http-equiv="refresh" CONTENT="300;url=index.php">
        <link rel="stylesheet" href="../css/styles_info.css" type="text/css">   
        <link rel="shortcut icon" href="images/pfr.gif" />
        <title>�������������� �����</title>
<?php
//action=0 �������� ��������
//action=1 ����� (�������������� ��� �� �������)
//action=2 ����� ��������� ��� ����
//action=3 ����������� ������
//action=4 �������� ���� ���������
//action=5 ����� ���� (��������������� ������)
//action=6 �������� ����������� ������ �� �������, ������������ �������������
//action=7 ����� ������� (��������������� ������)
//action=8 �������� ����������� �����. ������, ������������ �������������
//action=9 ������������� �����. ������
$action=isset($_REQUEST['action'])?$_REQUEST['action']:0;
$today=isset($_REQUEST['today'])?$_REQUEST['today']:0;
$ident=isset($_REQUEST['ident'])?$_REQUEST['ident']:0;
$inumber=isset($_REQUEST['inumber'])?$_REQUEST['inumber']:0;
$rajon=isset($_REQUEST['rajon'])?$_REQUEST['rajon']:0;
$kabinka=isset($_REQUEST['kabinka'])?$_REQUEST['kabinka']:0;
$vopros=isset($_REQUEST['vopros'])?$_REQUEST['vopros']:0;
$PHP_SELF=$_SERVER['PHP_SELF'];
$m1=(isset($_REQUEST['m1']))?$_REQUEST['m1']:date('n');
$y1=(isset($_REQUEST['y1']))?$_REQUEST['y1']:date('Y');
$d1=(isset($_REQUEST['d1']))?$_REQUEST['d1']:0;
$dat1=(isset($_REQUEST['dat1']))?$_REQUEST['dat1']:"";
$dat2=(isset($_REQUEST['dat2']))?$_REQUEST['dat2']:"";
$DY=array("��","��","��","��","��","��","��");
$MY=array("������","�������","����","������","���","����","����","������","��������","�������","������","�������");
date_default_timezone_set ('Asia/Irkutsk');

$fio=(isset($_REQUEST['fio']))?$_REQUEST['fio']:"";

include_once('../loginI.php');
include_once('../function/fncDat.php');

$sql="select * from title";
$result=mysqli_query($dbI,$sql)	or die("Query failed : " . mysqli_error());
$R=mysqli_fetch_row($result);
if (is_null($R[0]) ) {$ti0='��� � �����������';} else {$ti0=$R[2];}
switch ($action)
{
case 0: $ti1="�������� ������ �����, ����� �� ���� �������!";break;
case 1: $ti1="������ � ������� �� �����";break;
case 2: $ti1="������ �� ���<br>���<br>������ ���������� �������������";break;
case 3:if ($vopros==0) {
        if($ident==1){$ti1="������� ����� ������<br>������� ��� ��������";}
        if($ident==2){$ti1="������� ����� ���������� �������������";}    
}
    elseif ($vopros==1 || $vopros==2){
        if($ident==1){$ti1="������� ����� ������<br>������� ��� ��������";}
        if($ident==2){$ti1="������� ����� ���������� �������������";}    
    }
    elseif ($vopros==10){
        if($ident==1){$ti1="������� ����� ������<br>������� ��� ��������";}
        if($ident==2){$ti1="������� ����� ���������� �������������";}    
    }break; 
    //$ti1="������� ����� ���������� �������������";break;
case 4: if ($vopros==0) {$ti1="�������� ���� ���������";}
    elseif ($vopros==1){$ti1="������ �������";}
	elseif ($vopros==3 || $vopros==2){$ti1="�������� ������";}
	elseif ($vopros==10){$ti1="������ ������������";};break;
case 5: $ti1="�������� ���� ������";break;
case 6: $ti1="";break;
case 7: $ti1="�������� ����� ������";break;
//case 4: $ti1="�������������� �����";break;
case 4: $ti1="�������������� �����";break;
case 11: $ti1="��������� �������";break;
case 12: $ti1="������ 12";break;
case 13: if ($vopros==0) 
		  {$ti1="����� �� ������� ������<br>(����������� ����� �� 17.12.2001 ���� � 173-��)";}
		 elseif ($vopros==2)
		  {
		  $ti1="����� �� ��������� ���������� �������� ������<br>(����������� ����� �� 17.12.2001 ���� � 173-��)";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="����� �� ��������������� ���������� �����������<br>(����������� ����� �� 15.12.2001 ���� � 166-��)";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="��������� ����<br>(����������� ����� �� 17.12.2001 ���� � 173-��)";
		  }
		  elseif ($vopros==5)
		  {
		  $ti1="����� ����������, ������������, ���������� � ������������� �������� ������<br>(����������� ����� �� 17.12.2001 ���� � 173-��)";
		  }
		  elseif ($vopros==6)
		  {
		  $ti1="������� � �������� ������, ��������� �� ������";
		  }
		  elseif ($vopros==7)
		  {
		  $ti1="������������ ���������� �����������<br>(����������� ����� �� 15.12.2001 ���� � 167-��)";
		  }
		  elseif ($vopros==8)
		  {
		  $ti1="�������������� ������������ �����������<br>(����������� ����� �� 04.03.2002 ���� � 21-��)";
		  }
		  elseif ($vopros==9)
		  {
		  $ti1="����� ���������� ����� (���. �����)";
		  }
		  elseif ($vopros==10)
		  {
		  $ti1="������ ��������� �������. ����� 1";
		  }
		  elseif ($vopros==11)
		  {
		  $ti1="������ ��������� �������. ����� 2";
		  }
	break;
case 14: $ti1="������� � ������";break;
case 15: $ti1="������ ������������";break;
case 16: if ($vopros==1)
		  {
		  $ti1="��������� ����� �����������";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="������ �� ���������";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="������� �� �����";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="������� �������� <br>� ������������ ���������� ������<br> � �������� �16 <br>��� ������������ ���������, <br> ��������������� ��������";
		  }
		break;
case 17: $ti1="����������������"; break;
case 18: if ($vopros==1)
		  {
		  $ti1="����������� ���� �� ����������� �����������";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="�������� ���������� ��� ���������� �������� ������ �� ��������";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="�������� ���������� ��� ����������&nbsp;�������� ������ �� ������������";
		  }
		  elseif ($vopros==4)
		  {
		  $ti1="�������� ���������� ��� ���������� �������� ������ �� �� ������ ������ ���������";
		  }
		  elseif ($vopros==5)
		  {
		  $ti1="�������� ���������� ��� ���������� ���������� ������";
		  }
		break;
		
case 19: $ti1="�������������� ������"; break;
case 20: if ($vopros==1)
		  {
		  $ti1="�������. ��������. ��������.";
		  }
		  elseif ($vopros==2)
		  {
		  $ti1="��� ������� ������ ������� �� ����";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="����������� �������";
		  }
		elseif ($vopros==4)
		  {
		  $ti1="��� ��������� ������� ������?";
		  }
		elseif ($vopros==5)
		  {
		  $ti1="����� 5";
		  }
		elseif ($vopros==6)
		  {
		  $ti1="��������� ���������������� ���������������� ������";
		  }
		elseif ($vopros==7)
		  {
		  $ti1="����� 7";
		  }
		elseif ($vopros==8)
		  {
		  $ti1="����� 8";
		  }
		elseif ($vopros==9)
		  {
		  $ti1="����� 9";
		  }
		elseif ($vopros==10)
		  {
		  $ti1="������ ���������! �.1";
		  }
		elseif ($vopros==11)
		  {
		  $ti1="������ ���������! �.2";
		  }
		elseif ($vopros==12)
		  {
		  $ti1="������ ���������! �.3";
		  }
		break;
		
case 21: if ($vopros==2)
		  {
		  $ti1="��������� ������� �� ������ � $dat1 �� $dat2.";
		  }
		  elseif ($vopros==3)
		  {
		  $ti1="��������� ������� �� ������ � $dat1 �� $dat2.";
		  }
		  
		break;		
case 23: $ti1="�������� ���� ���������";break;
case 24: $ti1="";break;
case 25: $ti1="�������� ���� ������";break;
case 26: $ti1="�������� ����� ������";break;
    		
}


		
?>
<script type="text/javascript">
<!--
function FP_swapImg() {//v1.0
 var doc=document,args=arguments,elm,n; doc.$imgSwaps=new Array(); for(n=2; n<args.length;
 n+=2) { elm=FP_getObjectByID(args[n]); if(elm) { doc.$imgSwaps[doc.$imgSwaps.length]=elm;
 elm.$src=elm.src; elm.src=args[n+1]; } }
}

function FP_preloadImgs() {//v1.0
 var d=document,a=arguments; if(!d.FP_imgs) d.FP_imgs=new Array();
 for(var i=0; i<a.length; i++) { d.FP_imgs[i]=new Image; d.FP_imgs[i].src=a[i]; }
}

function FP_getObjectByID(id,o) {//v1.0
 var c,el,els,f,m,n; if(!o)o=document;
 if(o.getElementById) el=o.getElementById(id);
 else if(o.layers) c=o.layers; 
 else if(o.all) el=o.all[id]; 
 if(el) return el;
 if(o.id==id || o.name==id) return o; 
 if(o.childNodes) c=o.childNodes; if(c)
 for(n=0; n<c.length; n++) { el=FP_getObjectByID(id,c[n]); if(el) return el; }
 f=o.forms; if(f) for(n=0; n<f.length; n++) { els=f[n].elements;
 for(m=0; m<els.length; m++){ el=FP_getObjectByID(id,els[n]); if(el) return el; } }
 return null;
}
// -->
</script>
<!--<script type="text/javascript" src="jwplayer.js"></script>-->

</head>
<body onselectstart="return false">
<table id="table1">
	<tr>
		<td width="104">
                    <img border="0" src="images/pfr.gif" width="103" height="104">
		</td>
		<td >
                    <p id="baner"><?php echo $ti0 ."<br>�������������� �����";?></p>
		</td>
<td>
<script type="text/javascript">
<!--//
var smonth=[<?php for ($i=0;$i<12;$i++){echo "\"".($MY[$i])."\"";if ($i<11) {echo ",";}}; ?>];

function fulltime() {
var time=new Date();
hours = time.getHours();
mins = time.getMinutes();
secs = time.getSeconds();
if (hours < 10) {hours = "0" + hours }
if (mins < 10) {mins = "0" + mins }
if (secs < 10) {secs = "0" + secs }
datastr = ( hours + ":" + mins + ":" + secs )
document.clock.full.value=datastr;
setTimeout('fulltime()',500)
};

calendar = new Date();

day = calendar.getDay();
document.write("<table id=top_calen>");
document.write("<tr><td><center>");
var sday=["�����������","�����������","�������","�����","�������","�������","�������"];
if (day == 0 || day==6) {
document.write("<font color=#ff0000>"+sday[day]+"</font>")
}else
{
document.write("<font color=#FFFFFF>"+sday[day]+"</font>")
}
document.write("</center></td></tr><tr><td><center><font size=2>")
document.write("<font color=#FFFFFF>"+smonth[calendar.getMonth()]+"</font>")
document.write("</font></center></td></tr><tr><td><center><font size=6  color=#FFFFFF>")
document.write(calendar.getDate())
document.write("</font></center></td></tr><tr><td><center><font size=2 color=#FFFFFF>")
document.write(calendar.getFullYear())
document.write("</font></center></td></tr></table>")
//-->
</script>


		</td>
	</tr>
</table>
<table class="mn" id="table2">

<?php

//������������ �������
if ($action>=0 && $action<=27){include_once 'action/'.$action.'.php';}

mysqli_close($dbI);
?>		

<tr><td class="mnbd">&nbsp;
<?php
if ($action>100 && $action<99)
{
?>
<FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=1">
    <input class="inp_home" type="submit" value="< ������ �������" onMouseOver="window.status=''; return null;">
</FORM>
<?php
}
if ($action>0)
{
?>
<FORM class="frm_button_home" action="<?php echo $PHP_SELF ?>">
    <input class="inp_home" type="submit" value="< ������� ����" onMouseOver="window.status=''; return null;">
</FORM>
<?php
}
?>
<form class="clc" name=clock>
    <input type=text class="input-time" name="full">
<script type="text/javascript">
fulltime();
</script>
</form>
</td></tr>
</table>
</body>
</html>
