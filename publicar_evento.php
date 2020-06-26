<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("users.php");
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  start_user();
  if ($_GET != NULL && isset($_GET['event']) && ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'gestor')){
    $idEvent = $_GET['event'];
    if (filter_var($idEvent, FILTER_VALIDATE_INT)) {
        publish_event($idEvent);
        if (isset($_GET['event_screen'])) {
            header("Location: evento.php?event=" . $idEvent);
            exit();
        }
    }
  }
  header("Location: index.php");
?>