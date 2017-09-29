<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=isset($_REQUEST['raion'])?isset($_REQUEST['raion']):0;
$sub_raion=isset($_REQUEST['sub_raion'])?$_REQUEST['sub_raion']:0;
$pre_include="../..";

include($pre_include."/inc/head.php");
echo "<link rel=\"stylesheet\" href=\"/css/styles_info.css\" type=\"text/css\">\n";
echo "</head>\n";
include($pre_include."/inc/body.php");
$str_title="Администрирование ПК \"Клиент ПФР\"";
$show_home=false;
include("adm_header.php");
?>



<div class="container-fluid content">

<FORM class="frm_main_button form-horizontal" id="frm_type" action="#" method="post">
   
   <div  class="col-xs-4 col-xs-offset-1">
   <div  class="form-group">
        <button class="btn btn-lg btn-primary btn-block infobtn wrap-normal" onclick="clickForm2('raions.php')">Районы</button>
		<button class="btn btn-lg btn-primary btn-block infobtn wrap-normal" onclick="clickForm2('gobr.php')">Группы обращений</button>
	</div>	
	</div>
	<div  class="col-xs-4 col-xs-offset-1">
	   <div  class="form-group">
	   	<button class="btn btn-lg btn-primary btn-block infobtn wrap-normal" onclick="clickForm2('tobr.php')">Темы обращений</button>
		<button class="btn btn-lg btn-primary btn-block infobtn wrap-normal" onclick="clickForm2('spec.php')">Специалисты</button>
		</div>
	</div>	
	<div  class="form-group">	
		<input type="hidden" id="id" name="id" value="0" >
		<input type="hidden" id="action" name="action" value="0" >
		<input type="hidden" id="raion" name="raion" value="0" >
		<input type="hidden" id="sub_raion" name="sub_raion" value="0" >
	</div>
	</FORM>
</div>	


<?php
include("adm_footer.php");
?>
<script type="text/javascript">
function clickForm2(v)
                    {
					$("#raion").val(<?php echo $raion?>);
					$("#sub_raion").val(<?php echo $sub_raion?>);
					$("#frm_type").attr("action",v);
					$("#frm_type").submit();
                    }
					

</script>
</body>
</html>
