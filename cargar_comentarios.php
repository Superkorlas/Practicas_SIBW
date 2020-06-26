<?php
  require_once "../phpmyadmin/vendor/autoload.php";
  include("bd.php");
  include("users.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  start_user();

  if ($_GET != NULL){
    if(isset($_GET['event'])) {
      $idEvent = $_GET['event'];
      if (filter_var($idEvent, FILTER_VALIDATE_INT)) {
        $comments = get_comments($idEvent);
        $comments["can_edit"] = ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator');
        echo json_encode($comments);
      }
    }
  } else if ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator') {
    $comments = get_all_comments();// get_comments($idEvent);
    $comments["can_edit"] = ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'moderator');
    echo json_encode($comments);
  }
  
?>