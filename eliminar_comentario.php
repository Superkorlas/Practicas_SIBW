<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("bd.php");
    include("users.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    start_user();

    if($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $id = $_POST['id'];
                delete_comment($id);
            }
        }
    }
?>