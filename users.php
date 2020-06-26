<?php
  function start_user()
  {
    if (!isset($_SESSION)) {
      session_start();
      if (!isset($_SESSION['role'])) {
        $_SESSION['role'] = 'anon';
      }
    }
  }

  function check_sign_up($email, $pass, $name)
  {
    if (!exist_user($email)) {
     add_user($email, $pass, $name);
     return check_login($email, $pass);
    } else {
      return false;
    }
  }

  function check_login($email, $pass) 
  {
    $user = get_user($email);

    if (isset($user['email'])) {
      if (password_verify($pass, $user['password'])) {
          $_SESSION['userName'] = $user['userName'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['role'] = $user['role'];
          return true;
      } else {
        echo("Conatraseña incorrecta");
      }
    } else {
      echo("No existe ese usuario.");
    }
    return false;
  }

  function logout()
  {
    start_user();
    session_destroy();
  }

  function change_role($email, $current_role, $new_role) {
    if($current_role != $new_role) {
      if ($current_role != "super" || get_super_users_count() > 1) {
        update_role($email, $new_role);
        if($email == $_SESSION['email']) {
          $_SESSION['role'] = $new_role;
        } 
        return true;
      }
    }
    return false;
  }
?>