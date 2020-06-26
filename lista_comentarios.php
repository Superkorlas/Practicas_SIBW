<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("bd.php");
  include("users.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  start_user();
  
  if ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator'){
    $banned_words = get_banned_words();
    echo $twig->render('lista_comentarios.html', ['user' => $_SESSION, 'banned_words' => $banned_words ]);
  }

  
?>