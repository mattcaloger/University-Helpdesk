<?php 
    unset($_COOKIE['sessionToken']);
    unset($_COOKIE['user']);
    setcookie("sessionToken", "", 1);
    setcookie("user_first_name", "", 1);
    
    header('Location: /');
    exit;
?>