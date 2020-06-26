<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    start_user();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $pass = $_POST['password'];
      
        if (check_login($email, $pass)) {        
          start_user();
          header("Location: index.php");
          exit();
        }
    }
    //TODO: avisar a usuario de datos incorrectos.
    header("Location: index.php");
?>