<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("new_event.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
  
    start_user();

    if ($_SESSION['role'] == 'super' || $_SESSION['role'] == 'gestor') {
        $twig_errors = array();
        $event = null;
        $is_editing = false;

        if ($_GET != NULL && isset($_GET['event'])){
            $idEvent = $_GET['event'];
            if (filter_var($idEvent, FILTER_VALIDATE_INT)) {
                $event = get_event($idEvent);
                $tags = $event['tags'];
                $event['tags'] = "";
                for ($i = 0; $i < count($tags); $i++) {
                    $event['tags'] = $event['tags'] . $tags[$i] . " ";
                }
                $is_editing = true;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['title']) &&  isset($_POST['organizer']) && isset($_POST['date']) &&  isset($_POST['description'])) {
                $errors = array();
                if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                    $errors = check_image($_FILES['image']);
                } else if(!isset($_POST['eventID'])) {
                    $errors[] = "Not image found";
                }
                
                if (empty($errors)==true) {
                    $title = $_POST['title'];
                    $organizer =  $_POST['organizer'];
                    $organizerLink = $_POST['organizerLink'];
                    $date =  $_POST['date'];
                    $description = $_POST['description'];
                    $tags = $_POST['tags'];
                    $path = "img/eventos/" . str_replace(" ", "_", $title);
                    $image = $path . "/" . $_FILES['image']['name'];

                    if (isset($_POST['eventID'])) {
                        $eventID = $_POST['eventID'];
                        $old_event = get_event($eventID);
                        if ($_FILES['image']['name'] == "") {
                            $image = $old_event['image'];
                        }
                        if ($old_event['image'] != $image) {
                            delete_image($old_event['image']);
                        }
                        edit_event($eventID, $title, $organizer, $organizerLink, $date, $description, $image, $tags);
                    } else {
                        $eventID = create_event($title, $organizer, $organizerLink, $date, $description, $image, $tags);
                    }
                    mkdir($path, 0777, true);
                    move_uploaded_file($_FILES['image']['tmp_name'], $image);

                    header("Location: evento.php?event=" . $eventID);
                    exit();
                }
                
                if (sizeof($errors) > 0) {
                    $twig_errors = $errors;
                }
            }
        }
        echo $twig->render('nuevo_evento.html', ['user' => $_SESSION, 'event' => $event, 'is_editing' => $is_editing, 'errors' => $twig_errors]);
    }

?>