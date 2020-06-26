<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $idEvent = 1;
  if ($_GET != NULL){
    $idEvent = $_GET['event'];
    if (false === filter_var($idEvent, FILTER_VALIDATE_INT))
      $idEvent = 1;
  }

  $event = get_event($idEvent);
  
  echo $twig->render('evento_imprimir.html', ['event' => $event, 'comments' => $event['comments'], 'banned_words' => $event['banned_words'] ]);
?>