<?php
$lll = $_SESSION['s_login'] ;
$ppp = $_SESSION['s_pass'] ;
echo "<form action=\"../main.php\"  method=\"post\">\n";
echo "<br>\n";
echo " <input type=\"hidden\" name=\"j_username\" value=\"{$lll}\"/>\n";
echo " <input type=\"hidden\" name=\"j_password\" value=\"{$ppp}\"/>\n";
echo "<center><input type=\"submit\" value=\"В главное меню\" class=\"btn btn-default\"/></center>\n";
echo "</form>\n";
echo "<br>{$message}\n";
?>