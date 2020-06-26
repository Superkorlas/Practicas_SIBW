<?php
    require_once "../phpmyadmin/vendor/autoload.php";
    include("users.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    start_user();

    if($_SESSION['role'] == 'super') {
        $users = get_users();
        $roles = get_roles();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            for ($i = 0; $i < count($users); $i++) {
                $user = $users[$i];
                if(isset($_POST[str_replace('.','_',$user['email'])])) {
                    $new_role = $_POST[str_replace('.','_',$user['email'])];
                    if (change_role($user['email'],$user['role'], $new_role)) {
                        $users[$i]['role'] = $new_role;
                    }
                }
            }
        }
        echo $twig->render('cambiar_permisos.html', ['user' => $_SESSION, 'users' => $users, 'roles' => $roles]);
        exit();
    }
    header("Location: index.php");
    exit();
?>