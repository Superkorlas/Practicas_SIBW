<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    start_user();
    
    $events_headers = array();

    if ($_GET != null && isset($_GET['tag'])) {
        $events_headers = get_events_headers_with_tags($_GET['tag']);
    } else {
        $events_headers = get_events_headers();
    }

    echo $twig->render('portada.html', ['user' => $_SESSION, 'events' => $events_headers]);
?>