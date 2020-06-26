<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("bd.php");
  include("users.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  start_user();
  
  $idEvent = 1;
  if ($_GET != NULL){
    $idEvent = $_GET['event'];
    if (false === filter_var($idEvent, FILTER_VALIDATE_INT)) {
      $idEvent = 1;
    }
  }

  $event = get_event($idEvent);

  if (isset($event['idEvent'])) {
    $search = "";
    if (isset($_GET['search'])){
      $search = $_GET['search'];
    }
    echo $twig->render('evento.html', ['user' => $_SESSION, 'event' => $event, 'comments' => $event['comments'], 'banned_words' => $event['banned_words'], 'search' => $search ]);
  } else {
    header("Location: index.php");
    exit();
  }
?>