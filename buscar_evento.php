<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("bd.php");
    include("users.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    start_user();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['text'])) {
            $text = $_POST['text'];
            $events = get_events_headers_from_search($text);
            echo json_encode($events);
        }
    }
?>