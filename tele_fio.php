<?php 
header('Content-type: text/html; charset=windows-1251');

$raion=$_REQUEST['rajon'];
$sub_raion=$_REQUEST['sub_rajon'];

//include_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT').'/view/head_old_page.php';

include("/inc/head.php");
echo "</head>\n";
include("/inc/body.php");
$parametrs=array("raion" => $raion,"sub_raion" => $sub_raion);

?>
<div id="tque">
</div>


</body>
<script type="text/javascript">
	
$(document).ready(function(){  
    mode();  
    setInterval('mode()',10000);  
    });  

function mode() {
	 $('#tque').load('tele_que.php',<?php echo json_encode($parametrs)?>);
}
</script>
</html> 
