<?php
include_once('../loginI.php');
$type_obr=isset($_REQUEST['type_obr'])?$_REQUEST['type_obr']:0;
include("../inc/head.php");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/help_table.css\"/>";
echo "<script src=\"/js/help_table.js\" charset=\"utf-8\"></script>";
echo "</head>\n";
include("../inc/body.php");
$result = mysqli_query($dbI, "select t.full_name name, t.id, g.full_name,g.id 
		from types_obr t left join group_types_obr g on (t.group_id=g.id)
		left join help h on (t.id=h.id and page=1)
		where not isnull(h.text) and h.text<>'' and t.actual='1' order by COALESCE(g.id,9999),t.orders") or die("Query failed : " . mysqli_error());
		
echo "<H2>\n<center>������� �� ����� ���������</center>\n</H2>\n";
echo "<div class=\"col-md-8 col-md-offset-2\">\n";
echo "<form class=\"form-inline\" id=\"infoForm\" name=\"infoForm\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">\n";
echo "<div class=\"form-group\">\n";
echo "<label for=\"type_obr\">���������� �� ����&nbsp;</label>\n";
echo "<select id=\"type_obr\" name=\"type_obr\" value=\"{$type_obr}\" class=\"form-control input-lg ".(($type_obr<10000)?"":"label-warning")."\">\n";
	$og=-1;
	$tag_opened=false;
	while($tab_sql=mysqli_fetch_row($result)) 
	{ 
		if ($og!=$tab_sql[3])
		{
			//echo "<option class=\"label-warning\" value=\"".($tab_sql[3]+10000)."\" ".(($type_obr==$tab_sql[3]+10000)?" selected=\"selected\"":"").">{$tab_sql[2]}</option>\n";
			if ($tag_opened){echo "</optgroup>\n";}
			$og=$tab_sql[3];
			echo "<optgroup label=\"{$tab_sql[2]}\" >\n";
			$tag_opened=true;
		}
		echo "<option value=\"{$tab_sql[1]}\" ".(($type_obr==$tab_sql[1])?" selected=\"selected\"":"").">{$tab_sql[0]}</option>\n";
	
	}
	if ($tag_opened){echo "</optgroup>\n";}
	echo "</select>\n";
	echo "</div>\n";
	mysqli_free_result($result);
	
	
	
	
	echo "<button name=\"edit\" class=\"btn btn-default btn-lg\" onclick=\"submitForm(7)\">��������</button>\n";
	//echo "</p>\n";
	echo "<INPUT TYPE=\"hidden\" name=\"action\" id=\"action\" VALUE=\"0\">\n";
	echo "</form>\n</div>\n<br>\n";
	$doc="";
	$act="";
	
	if ($type_obr>0)
	{
	$result = mysqli_query($dbI, "select * from help where id={$type_obr} order by page") or die("Query failed : " . mysqli_error());
	while($tab_sql=mysqli_fetch_row($result)) 
	{ 
		if ($tab_sql[1]==1)
		{
			$doc=$tab_sql[2];
		}
		if ($tab_sql[1]==2)
		{
			$act=$tab_sql[2];
		}
	}
	
		
		
		
		$result = mysqli_query($dbI, "select full_name,zatrat,help from types_obr where id={$type_obr}") or die("Query select failed : " . mysqli_error());
		$tab_sql=mysqli_fetch_row($result);
		echo "<div class=\"panel panel-default col-md-8 col-md-offset-2\">\n";
		echo "<div class=\"panel-heading\">\n";
		echo "<h3 class=\"panel-title\">������: {$tab_sql[0]}</h3>\n";
		echo "</div>\n";
		echo "<div class=\"panel-heading\">\n";
		echo "<h3 class=\"panel-title\">����������������� ������ �� �������: {$tab_sql[1]} �����.</h3>\n";
		echo "</div>\n";
		mysqli_free_result($result);
		
		echo "<div class=\"panel-body\">\n";
		
		
		echo "<ul class=\"nav nav-tabs\">\n";
		//echo "<li class=\"active\"><a data-toggle=\"tab\" href=\"#panel1\">���������</a></li>\n";
		echo "<li class=\"active\"><a id=\"first\" data-toggle=\"tab\" href=\"#panel1\">���������</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel2\">��������</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel3\">������</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel4\">����-�����</a></li>\n";
		
        echo "</ul>\n";
     
		echo "<div class=\"tab-content\">\n";
		echo "<div id=\"panel1\" class=\"tab-pane\">\n";
		echo "<h3>���������</h3>\n";
		echo $doc;
		echo "</div>\n";
		
		echo "<div id=\"panel2\" class=\"tab-pane fade\">\n";
		echo "<h3>��������</h3>\n";
		echo $act;
		echo "</div>\n";	
		
echo "<div id=\"panel3\" class=\"tab-pane fade\">\n";
echo "<h3>������������ ��� ������� ������ �������</h3>\n";
?>
<table class="table treetable">
<thead>
<tr>
<th width="20%">����</th>
<th width="50%">����������</th>
<th>�����</th>
</tr>
</thead>
<tbody>
<tr class="lev1">
<td>�����������</td>
<td>
<ul>
<li>��������� ������ ������������� � �������� ������ � ���������� ��� �����;</li>
<li>���������� ���������� ���������� �������, ���������� ���������� (������������� ������ � ������� ���������� (�������� ���� ���� ��� ���� ���� ���� �������), ��� � ����� ������� �������� ���������� �������, � ������ - �� �������� ���������� � ������������);</li>
<li>�� ����� ���������, ������� ���������� � ������� �� ����� � ��������, ���������� �� �� ��� �� ���������, ������������� ��������; </li>
<li>�� ����� ������� � �������� ��������� ��������� �����������, ���������������� ��������� ����, �������� ���� (������ ������, ���� �������, �� ������������� ���� �� ����������� ������ � ������ ������� � ������� �� �������).</li>
</ul>
</td>
<td>
<ul>
<li>�������������,</li>
<li>������� ���� (� 8.00-12.00),</li>
<li>������� ����� (� 12.00- 18.00),</li>
<li>�������������, ��������������, ����������, � ��� �������.</li>
<li>������� ����, ��������������, ����������, ����� � ��� ������?�</li>
</ul>
</td>
</tr>
<tr class="lev1">
<td>�������� ���� ��������� �������</td>
<td>������������ ���� ���������, ���������� �������������, �������� ����, ���������� ��������� ������� �������.</td>
<td>-</td>
</tr>
<tr class="lev1">
<td>����������� �������</td>
<td>
<ul>
<li>���������� ��������� � ������� �������� ���������� �������;</li>
<li>��� ����������� ���������� ������������ ���������� ����, ��������� ��� �������, � ���������, �����������, ��� ������������� ����������� ������������. ��� ������������� ���������� ������� ���������;</li>
<li>�� ���������� ������ ������� ������������ ���������� ������� � ��������;</li>
<li>�� ����� ��������� � �������� ���������� ������ ����� � ������������ �������� �������� ����� (��������� � ������ ������ ����������, ������ ��������� �� �������);</li>
<li>��� ������������� ������� ������ ��� ���������� ���������� (��������: ������� ����� �������, ��������� ������� ���������� ���������, ������������ ������� � �. �.).</li>
</ul>
</td>
<td>-</td>
</tr>
<tr class="lev1">
<td>���������� ������</td>
<td>���������� ���������, �������� (��������� ���� ������� ������, ��� ������ �����, � ������������ ��������� ������ ����������, ��������, ��������� ��� ����������� ���������, ������� ���� ����� � �������� ������������).</td>
<td>��� ������� ������� ��� ��� ����������. / ������ �� ������� ������� ���������. � ��� ��� ���� �������?� 
��� ���������, ������ ��� ��������.
</td>
</tr>
</tbody>
</table>
<?php
echo "</div>\n";

echo "<div id=\"panel4\" class=\"tab-pane fade\">\n";
echo "<h3>�������� ���� - ���� � �� �������������� ��������</h3>\n";
?>
<table class="table treetable">
<thead>
<tr>
<th>����-����� (������� ���������)</th>
<th>������������� �����������</th>
</tr>
</thead>
<tr class="lev1">
<td>�������, �������, ������� �������, �������</td>
<td>����������� � ������� �� ����� � �������� ��� ���������� �� ��
<br>
� �������, �����������</td>
</tr>
<tr class="lev1">
<td>
���
<br>
������ (���� ��������� �������)
<br>
�� ��������� (���� ������� �� ����������)
<br>
����������
<br>
��
</td>
<td>
� � ����������
<br>
� ����� (������ �������� ��-�������)
<br>
� ���������, ������ ���� 
<br>
� � ����� � ���� ������ �������� ������
<br>
���� �� �����, ������ � ���, � ������ ��������, ��������� ������� � ���
</td>
</tr>
<tr class="lev1">
<td>���� ��������</td>
<td>���� ������,<br>��� ������,<br>���� � ���� ���������</td>
</tr>
<tr class="lev1">
<td>�������������-������������ �����: �������, ����������, ��������</td>
<td>���� ������, �����������<br>
������</td>
</tr>
<tr class="lev1">
<td>� �� �� ������.</td>
<td>� � ���� �����</td>
</tr>
<tr class="lev1">
<td>
� � �� ����.<br>
� � ���� ��� ����������.</td>
<td>
� ���� ������, ����������, � ������.<br>
� ������� � ������ ���� ������ � ������� ��� ������� �� ����� ��� (� ����������� �����������!)
</td>
</tr>
<tr class="lev1">
<td>
� ����� �� ������ �� ����� ������� ��� ���.<br>
� � ������ ����� �� ���� ��� ������.</td>
<td>
� � ���� ������ ��� �������<br>
� �� ������ ��������<br>
� � ��� �����������
</td>
</tr>
<tr class="lev1">
<td>
� �� ������...<br>
� ��� ��������...
</td>
<td>� ������� �� � ���� ������� ���������</td>
</tr>
<tr class="lev1">
<td>� ������������ ������ �� ������ � ���� ����������.</td>
<td>
� ������� ����� ������� � ���� �����������.<br>
� ������� ���������, ��� ����� �������.
</td>
</tr>
<tr class="lev1">
<td>� �� ����� �� ������ (�� ���������, �� �������������).</td>
<td>� ���� �������� ���������� ������ ������. �������� ����� ��������.</td>
</tr>
<tr class="lev1">
<td>
� ����� �� ����� ����.<br>
� �� ���-�� �������.<br>
� � � ���� � ���� ������ ����������.
</td>
<td>� ������� �������.</td>
</tr>
<tr class="lev1">
<td>� ������ ������ ������� �� ����.</td>
<td>
������� ����� ������ ������� ������.<br>
������� ����� ����� �������� ����� ��������� ����. ���������� ��� ��������� �� ��������� ������.
</td>
</tr>
<tr class="lev1">
<td>����� �� �� �������� ����� � ���, ��� ��� ��� ��������</td>
<td>� ������� ���������� ��� ���� ����� ���� ���������� � ����������� ������ (��������� ���) ��� � �������� �������.
</td>
</tr>
</table>
<?php
echo "</div>\n";

echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
	}
?>

<script type="text/javascript">
$("#first")[0].click();
</script>

<script type="text/javascript">

 	$(document).ready(function(){  
		ResetAll();	
		$('#panel1').addClass('active');
	}); 
	
 function submitForm(a)
 {
	 $('#action').val(a);
	 $('#infoForm').submit();
	 
 }
 
function ok(val)
{
	
	var Elt=$("#plus"+val);
	//alert(Elt.hasClass("hidden"));
	if (Elt.hasClass("glyphicon glyphicon-menu-right"))
	{
		Elt.removeClass("glyphicon glyphicon-menu-right");
		Elt.addClass("glyphicon glyphicon-menu-down");
		
	}
	else
	{
		Elt.removeClass("glyphicon glyphicon-menu-down");
		Elt.addClass("glyphicon glyphicon-menu-right");
	}
	
}


</script>