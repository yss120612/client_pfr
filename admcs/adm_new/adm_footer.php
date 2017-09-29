<?php
echo "<div class=\"footer container-fluid\">\n";
echo "<div class=\"row\">\n";
echo "<div class=\"text-left col-xs-2\">\n";
if ($show_home)
{
echo "<input class=\"btn btn-lg btn-block infobtn wrap-normal\" type=\"button\" value=\"Меню администратора\" onclick=\"javascript:document.location.href='/admcs/adm_new/index.php'\">\n";
echo "</div>\n";
echo "<div class=\"text-left col-xs-2\">\n";
echo "<input class=\"btn btn-lg btn-block infobtn wrap-normal\" type=\"button\" value=\"Главное меню\" onclick=\"javascript:document.location.href='/index.php'\">\n";
}
echo "</div>\n";
echo "<div class=\"col-xs-6 err\">\n";

if ($action==1)
{
	echo "<h3>Отредактируйте выделенную запись</h3>";
}
else if ($action==2)
{
	echo "<h3>Подтвердите операцию удаления</h3>";
}
else if ($action==3)
{
	echo "<h3>Добавление записи</h3>";
}

?>
</div>
<div id="clock" class="text-right col-xs-2"></div>
</div>
</div>

</div>
<script type="text/javascript">

$(document).ready(function(){  
<?php
if ($scrol>0)
{
echo "$(window).scrollTop({$scrol});";	
}

if ($action>=4 && $action<100)
{
echo "clickForm(0,0);";
}

?>
});

function clickForm(a,v)
	{
		console.warn("A="+a+" V="+v);
		if (a<-100)
		{
			$("#f"+(a*-1-100)).val('');
		}
	
		if (a<0)
		{
			a=0;
		}
		
		
		
		
		if (a==4 || a==5)
		{
			if (checkForm(a,v)==0)
			{
			return 0;
			}
		}
		
		$("#action").val(a);
		$("#id").val(v);
		$("#scrol").val($(window).scrollTop());
		$("#raion_form").submit();
	}
</script>	