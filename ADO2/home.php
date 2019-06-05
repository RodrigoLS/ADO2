<?php 
    session_start();
    var_dump($_SESSION['loginTime']);
    $name_user = $_SESSION['userName'];

    require('templates/home.php');
?>