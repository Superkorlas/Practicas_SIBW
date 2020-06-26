<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("users.php");
  include("new_event.php");
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  start_user();
  if ($_GET != NULL && ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'gestor')){
    $idEvent = $_GET['event'];
    if (filter_var($idEvent, FILTER_VALIDATE_INT)) {
        $event = get_event($idEvent);
        delete_image($event['image']);
        delete_event($idEvent);
    }
  }
  header("Location: index.php");
?>