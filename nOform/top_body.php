<?php
session_start(); 
header('Content-type: text/html; charset=windows-1251'); 
 
 $rajon=$_SESSION['rajon'];
$sub_rajon=$_SESSION['sub_rajon'];
$title=iconv('utf-8','windows-1251','ПТК Клиент ПФР');
?>

<!DOCTYPE html>
<html>

<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<meta http-equiv="Page-Enter" content="revealTrans(Duration=1.0,Transition=1)">-->

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link href="/styles1.css" rel="stylesheet" type="text/css"/>
        <link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>        
        <link href="/css/validationEngine.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-3.3.5.min.css"  />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css"  />
        
        <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
        <script  src="/js/showHide.js" type="text/javascript"></script>
        <script src="/js/jquery.ui.draggable.js" type="text/javascript"></script>
        <script src="/js/jquery.alerts.js" type="text/javascript"></script>

        <script type="text/javascript" src="/js/bootstrap-3.3.5.min.js"></script>          
        <title><?php echo $title;?></title>





<meta name="Microsoft Border" content="t">
</head>

<!--<body background="../nOform/glabkgnd.jpg" link="#045A8C" vlink="#045A8C" alink="#FF0000" onload="FP_preloadImgs(/*url*/'images/button39.jpg', /*url*/'images/button38.jpg', /*url*/'images/buttonA2.jpg', /*url*/'images/buttonA3.jpg', /*url*/'images/buttonA5.jpg', /*url*/'images/buttonA6.jpg', /*url*/'images/buttonAF.jpg', /*url*/'images/buttonB0.jpg', /*url*/'images/buttonB8.jpg', /*url*/'images/buttonB9.jpg', /*url*/'images/buttonBE.jpg', /*url*/'images/buttonBF.jpg')"><!--msnavigation-->
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>
</table>
<font face="Tahoma" size="3" color="#055883">
<table ><tr><td width=30>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>