<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("bd.php");
    include("users.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    start_user();

    if($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['comment']) && isset($_POST['id'])) {
                $id = $_POST['id'];
                $comment = $_POST['comment'];
                edit_comment($id, $comment);
            }
        }
    }
?>