<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    $events_headers = get_events_headers();
    
    logout();
    header("Location: index.php");
    
    exit();
?>