<?php 
$form=$_REQUEST['forma'];
If ($form=='old')
{
	if (isset($_REQUEST['report1']))include('report1_old.php');
	if (isset($_REQUEST['report2']))include('report2_old.php');
	if (isset($_REQUEST['report3']))include('report3_old.php');
}
else 
{
	if (isset($_REQUEST['report1']))include('report1.php');
	if (isset($_REQUEST['report2']))include('report2.php');
	if (isset($_REQUEST['report3']))include('report3.php');
    if (isset($_REQUEST['report4']))include('report4.php');
    if (isset($_REQUEST['report5']))include('report5.php');
}
?>


