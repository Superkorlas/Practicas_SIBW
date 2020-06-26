<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("bd.php");
    include("users.php");
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    start_user();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] != 'anon') {
        if(isset($_POST['comment']) && isset($_POST['email']) 
            && isset($_POST['eventID']) && isset($_POST['date']) && isset($_POST['time'])) {
            $email = $_POST['email'];
            $comment = $_POST['comment'];
            $eventID = $_POST['eventID'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            add_comment($email, $eventID, $comment, $date, $time);
        }
    }
?>