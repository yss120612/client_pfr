<?php
session_start();
header('Content-type: text/html; charset=windows-1251');

include_once('../loginI.php');
//include_once("../obj.php");


$PHP_SELF=$_SERVER['PHP_SELF'];

$raion=$_SESSION['rajon'];
$sub_raion=$_SESSION['sub_rajon'];
$frang=$_SESSION['frang'];

include("../inc/head.php");
?>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/ >
<link rel="stylesheet" type="text/css" href="/css/validation.css"/ >

<script src="/js/jquery.datetimepicker.full.min.js" charset="utf-8"></script>
<script src="/js/jquery.validate.min.js" charset="utf-8"></script>
          

</head>
<?php 
include("../inc/body.php");

$parametrs=array("raion" => $raion,"sub_raion" => $sub_raion,"frang"=>$frang);
echo "<div id=\"que\"></div>\n";

/*
0-Не определено
2-Диспетчер
1-Руководитель
3-Оператор
4-Администратор
5-Диспетчер+Телефон нет
6-Архивариус нет
7-Диспетчер+Оператор 
8-Руководитель района нет
*/

if ($frang==2 || $frang==7){
$inputColWidth=array('15%','20%','25%','30%');//размер колоночег
echo "<div class=\"container form-horizontal\">\n<form id=\"validForm\" action=\"main_act.php\" method=\"post\" role=\"form\">\n";
echo "<table class=\"table bg-info bordered\">\n<tr>\n";
echo "<td width=\"{$inputColWidth[0]}\">ФАМИЛИЯ <input class=\"form-control\" id=\"a\" Type=\"text\" Name=\"family\" Size=\"20\" MAXLENGTH=\"35\" Value=\"\"></td>\n";
echo "<td width=\"{$inputColWidth[0]}\">ИМЯ <Input class=\"form-control\" id=\"b\" Type=\"text\" Name=\"name\" Size=\"20\" MAXLENGTH=\"25\" Value=\"\"></td>\n";
echo "<td width=\"{$inputColWidth[0]}\">ОТЧЕСТВО <input class=\"form-control\" id=\"a1\" Type=\"text\" Name=\"father\" Size=\"20\" MAXLENGTH=\"25\" Value=\"\"></td>\n";

$result = mysqli_query($dbI, "select t.full_name name, t.id, g.full_name,g.id 
	from types_obr t left join group_types_obr g on (t.group_id=g.id) 
	where t.actual='1' order by COALESCE(g.id,9999),t.orders") or die("Query failed : " . mysqli_error());

	echo "<td>СОДЕРЖАНИЕ ОБРАЩЕНИЯ <select name=\"type_obr\" class=\"form-control\">\n";
$og=-1;
$tag_opened=false;
while($tab_sql=mysqli_fetch_row($result)) 
{ 
	if ($og!=$tab_sql[3])
	{
		if ($tag_opened){echo "</optgroup>\n";}
		$og=$tab_sql[3];
		echo "<optgroup label=\"{$tab_sql[2]}\">\n";
		$tag_opened=true;
	}
	echo "<option value=\"{$tab_sql[1]}\">{$tab_sql[0]}</option>\n";
}
if ($tag_opened){echo "</optgroup>\n";}
echo "</select>\n</td>\n";
mysqli_free_result($result);

echo "</tr>\n<tr>\n<td rowspan=\"2\" valign=\"middle\" align=\"center\">\n";
echo "<input Type=\"button\" name=\"submit2\" class=\"btn btn-default btn-lg\" Value=\"Записать\" onclick=\"clickForm(0)\">\n";
echo "</td>\n";
echo "<td colspan=\"3\" align=\"center\"><b>Предварительная запись</b></td>\n</tr>\n<tr>\n<td align=\"center\" valign=\"middle\" >\n";	
echo "<input Type=\"button\" name=\"submit1\" class=\"btn btn-default\" Value=\"Записать срочно\" onclick=\"clickForm(2)\">\n";
echo "</td>\n";

echo "<td>\n</td>\n<td valign=\"middle\">\n";
echo "<div class=\"form-group\">\n";
echo "<div class=\"col-sm-6\">\n";
echo "<input type=\"text\" name=\"predv_date\" class=\"form-control\" id=\"datetimepicker2\" />\n";
echo "</div>\n";
echo "<input Type=\"button\" name=\"submit3\" class=\"btn btn-default\" Value=\"Записать на эту дату\" onclick=\"clickForm(1)\">\n";
echo "</div>\n";
echo "</td>\n</tr>\n</table>\n";
echo "<input type=\"hidden\" name=\"rajon\" value=\"{$raion}\">\n";
echo "<input type=\"hidden\" name=\"sub_rajon\" value=\"{$sub_raion}\" >\n";
echo "<input type=\"hidden\" id=\"submit_kind\" name=\"sub_kind\" value=\"0\" >\n";
echo "</form>\n</div>\n";
}

echo "<form action=\"../main.php\"  method=\"POST\">\n";
echo "<input type=\"hidden\" name=\"j_username\" value=\"". $_SESSION['s_login']  ."\">\n" ;
echo "<input type=\"hidden\" name=\"j_password\" value=\"". $_SESSION['s_pass']  ."\">\n" ;
echo "<center><input type=\"submit\" value=\"В главное меню\" class=\"btn btn-default\"></center>\n";
echo "</form>\n<br>\n";
?>

<script type="text/javascript">
	
	 $(document).ready(function(){  
	 
    mode();  
	
    setInterval('mode()',10000);  
	
	$.datetimepicker.setLocale('ru');

	$("#datetimepicker2").datetimepicker({
		step:15,
		allowTimes:['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30'],
		dayOfWeekStart:1,
		minDate:0,
		disabledWeekDays:[0,6]
		});
    });  
	
	function clickForm(v)
	{
		if (v==1)
		{
			if ($("#datetimepicker2").datetimepicker('getValue')==null)
			{
			 alert ('Введите дату и время');
			 $("#validForm").validate();
			 return;		
			}
		}
		$("#submit_kind").val(v);
		$("#validForm").submit();
	}




$("#validForm").validate({
			rules: {
				family:{
					required: true,
					minlength: 2
				},
				name:{
					required: true,
					minlength: 1
				},
							
			},
			messages: {
				family:{
					required: "Введите фамилию",
					minlength: "Имя должно содержать более 2х букв"
				},
				name: {
					required: "Введите имя",
					minlength: "Имя должно содержать более 1й буквы"
				},
			}
		});
		

function mode() {
	 $('#que').load('queue.php',<?php echo json_encode($parametrs)?>);
}
	
</script>  
<?php

echo "</body>\n";
echo "</html>\n";
?>