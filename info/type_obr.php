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
		
echo "<H2>\n<center>Справка по типам обращений</center>\n</H2>\n";
echo "<div class=\"col-md-8 col-md-offset-2\">\n";
echo "<form class=\"form-inline\" id=\"infoForm\" name=\"infoForm\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">\n";
echo "<div class=\"form-group\">\n";
echo "<label for=\"type_obr\">Информация по теме&nbsp;</label>\n";
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
	
	
	
	
	echo "<button name=\"edit\" class=\"btn btn-default btn-lg\" onclick=\"submitForm(7)\">Показать</button>\n";
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
		echo "<h3 class=\"panel-title\">Вопрос: {$tab_sql[0]}</h3>\n";
		echo "</div>\n";
		echo "<div class=\"panel-heading\">\n";
		echo "<h3 class=\"panel-title\">Продолжительность приема по вопросу: {$tab_sql[1]} минут.</h3>\n";
		echo "</div>\n";
		mysqli_free_result($result);
		
		echo "<div class=\"panel-body\">\n";
		
		
		echo "<ul class=\"nav nav-tabs\">\n";
		//echo "<li class=\"active\"><a data-toggle=\"tab\" href=\"#panel1\">Документы</a></li>\n";
		echo "<li class=\"active\"><a id=\"first\" data-toggle=\"tab\" href=\"#panel1\">Документы</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel2\">Действия</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel3\">Этикет</a></li>\n";
		echo "<li><a data-toggle=\"tab\" href=\"#panel4\">Стоп-фразы</a></li>\n";
		
        echo "</ul>\n";
     
		echo "<div class=\"tab-content\">\n";
		echo "<div id=\"panel1\" class=\"tab-pane\">\n";
		echo "<h3>Документы</h3>\n";
		echo $doc;
		echo "</div>\n";
		
		echo "<div id=\"panel2\" class=\"tab-pane fade\">\n";
		echo "<h3>Действия</h3>\n";
		echo $act;
		echo "</div>\n";	
		
echo "<div id=\"panel3\" class=\"tab-pane fade\">\n";
echo "<h3>Рекомендации при ведении приема граждан</h3>\n";
?>
<table class="table treetable">
<thead>
<tr>
<th width="20%">Этап</th>
<th width="50%">Содержание</th>
<th>Фразы</th>
</tr>
</thead>
<tbody>
<tr class="lev1">
<td>Приветствие</td>
<td>
<ul>
<li>Сотрудник обязан поздороваться с клиентом первым и предложить ему сесть;</li>
<li>необходимо установить визуальный контакт, приветливо улыбнуться (рекомендуется взгляд в область переносицы (возможно чуть ниже или чуть выше этой области), это с одной стороны помогает установить контакт, с другой - не вызывает дискомфорт у собеседников);</li>
<li>во время разговора, следует обращаться к клиенту по имени и отчеству, нейтрально на Вы или по обращению, предложенному клиентом; </li>
<li>во время общения с клиентом требуется сохранять приветливое, доброжелательное выражение лица, открытую позу (осанка прямая, руки открыты, не рекомендуется поза со скрещенными руками и наклон корпуса в сторону от клиента).</li>
</ul>
</td>
<td>
<ul>
<li>«Здравствуйте»,</li>
<li>«Доброе утро» (с 8.00-12.00),</li>
<li>«Добрый день» (с 12.00- 18.00),</li>
<li>«Здравствуйте, присаживайтесь, пожалуйста, я Вас слушаю».</li>
<li>«Добрый день, присаживайтесь, пожалуйста, какой у Вас вопрос?»</li>
</ul>
</td>
</tr>
<tr class="lev1">
<td>Изучение цели обращения клиента</td>
<td>Выслушивание цели обращения, обсуждение обстоятельств, существа дела, достижение понимания запроса клиента.</td>
<td>-</td>
</tr>
<tr class="lev1">
<td>Разъяснение запроса</td>
<td>
<ul>
<li>Необходимо терпеливо и вежливо задавать уточняющие вопросы;</li>
<li>при разъяснении необходимо использовать доходчивый язык, доступный для клиента, с примерами, пояснениями, без использования специальной терминологии. При необходимости объяснение следует повторить;</li>
<li>на протяжении приема следует поддерживать визуальный контакт с клиентом;</li>
<li>во время разговора с клиентом необходимо делать паузы и интонационно выделять ключевые фразы (интонация в данном случае повышается, взгляд направлен на клиента);</li>
<li>при необходимости оказать помощь при заполнении документов (например: указать место подписи, объяснить порядок заполнения документа, предоставить образец и т. д.).</li>
</ul>
</td>
<td>-</td>
</tr>
<tr class="lev1">
<td>Завершение приема</td>
<td>Завершение разговора, прощание (сотрудник дает клиенту понять, что вопрос решен, и консультация закончена своими действиями, например, закрывает или сворачивает документы, которые были нужны в процессе консультации).</td>
<td>«По данному вопросу это вся информация. / Работа по данному вопросу закончена. У Вас еще есть вопросы?» 
«До свидания», «Всего Вам хорошего».
</td>
</tr>
</tbody>
</table>
<?php
echo "</div>\n";

echo "<div id=\"panel4\" class=\"tab-pane fade\">\n";
echo "<h3>Перечень СТОП - фраз и их альтернативные варианты</h3>\n";
?>
<table class="table treetable">
<thead>
<tr>
<th>СТОП-фразы (следует исключить)</th>
<th>Рекомендуется употреблять</th>
</tr>
</thead>
<tr class="lev1">
<td>Девушка, женщина, молодой человек, мужчина</td>
<td>Обращайтесь к клиенту по имени и отчеству или нейтрально на Вы
<br>
— Скажите, пожалуйста…</td>
</tr>
<tr class="lev1">
<td>
Нет
<br>
Нельзя («так оформлять нельзя»)
<br>
Не получится («так сделать не получится»)
<br>
Невозможно
<br>
Но
</td>
<td>
— Я предлагаю…
<br>
— Можно («можно оформить по-другому»)
<br>
— Получится, только если… 
<br>
— В нашем с Вами случае возможно только…
<br>
—Тем не менее…, вместе с тем…, с другой стороны…, наилучший вариант – это…
</td>
</tr>
<tr class="lev1">
<td>Ваша проблема</td>
<td>Этот вопрос…,<br>наш вопрос…,<br>наша с Вами ситуация…</td>
</tr>
<tr class="lev1">
<td>Уменьшительно-ласкательные слова: Минутку, секундочку, звоночек</td>
<td>Одну минуту, пожалуйста…<br>
Звонок</td>
</tr>
<tr class="lev1">
<td>— Вы не поняли.</td>
<td>— Я имел ввиду…</td>
</tr>
<tr class="lev1">
<td>
— Я не знаю.<br>
— У меня нет информации.</td>
<td>
— Одну минуту, пожалуйста, я уточню.<br>
— Давайте я выясню этот вопрос и позвоню Вам сегодня до конца дня (и обязательно перезвонить!)
</td>
</tr>
<tr class="lev1">
<td>
— Здесь мы ничего не можем сделать для вас.<br>
— Я больше ничем не могу вам помочь.</td>
<td>
— В этом случае Вам следует…<br>
— Вы можете сделать…<br>
— Я Вам рекомендую…
</td>
</tr>
<tr class="lev1">
<td>
— Вы должны...<br>
— Вам придется...
</td>
<td>— Давайте мы с Вами сделаем следующее…</td>
</tr>
<tr class="lev1">
<td>— Руководитель сейчас не сможет с вами поговорить.</td>
<td>
— Решение этого вопроса в моей компетенции.<br>
— Давайте посмотрим, что можно сделать.
</td>
</tr>
<tr class="lev1">
<td>— Мы этого не делаем (не оформляем, не предоставляем).</td>
<td>— Этим вопросом занимается другая служба. Запишите номер телефона.</td>
</tr>
<tr class="lev1">
<td>
— Этого не может быть.<br>
— Вы что-то путаете.<br>
— А у меня в базе другая информация.
</td>
<td>— Давайте уточним.</td>
</tr>
<tr class="lev1">
<td>— Точных сроков сказать не могу.</td>
<td>
—Точные сроки сейчас назвать сложно.<br>
—Точные сроки будут известны через несколько дней. Рекомендую Вам позвонить на следующей неделе.
</td>
</tr>
<tr class="lev1">
<td>—Если Вы не согласны идите в суд, суд Вам все присудит…</td>
<td>— Решение Управления ПФР Вами может быть обжаловано в вышестоящем органе (Отделении ПФР) или в судебном порядке.
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