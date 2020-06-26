<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    start_user();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
      
        if (check_sign_up($email, $pass, $name)) {        
          header("Location: index.php");
          exit();
        } else {
            echo("fallo al iniciar");
        }
    }
    //TODO: avisar al usuario que ya existe ese usuario
    header("Location: index.php");
?>