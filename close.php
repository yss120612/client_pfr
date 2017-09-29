<?php
session_start();
clSess();

function clSess(){
    session_unset();
    session_regenerate_id();
    session_destroy();
    header("Location: /");exit();
}
?>
