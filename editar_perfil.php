<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    start_user();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email']) && $_SESSION['email'] != $_POST['email']) {
            $email = $_POST['email'];
            change_user_email($_SESSION['email'], $email);
        } else if(isset($_POST['password'])) {
            $pass = $_POST['password'];
            change_user_pass($_SESSION['email'], $pass);
        } else if(isset($_POST['name']) && $_SESSION['userName'] != $_POST['name']) {
            $name = $_POST['name'];
            change_user_name($_SESSION['email'], $name);
        }
        start_user();
    }

    echo $twig->render('editar_perfil.html', ['user' => $_SESSION]);
?>