<?php
    function init_bd_connection()
    {
        $mysqli = new mysqli("localhost", "root", "", "SIBW");
        if ($mysqli->connect_errno) {
            echo("Fallo al conectar: " . $mysqli->connect_errno);
        }
        return $mysqli;
    }

    function exist_user($email)
    {
        $user = get_user($email);
        if($user) {
            return true;
        } else {
            return false;
        }
    }

    function add_user($email, $pass, $name)
    {
        $sql = init_bd_connection();
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql->query("INSERT INTO `users`(`userName`, `email`, `password`, `role`) VALUES ('" . $name . "', '" . $email . "', '" . $pass . "', 'register')");
    }

    function get_users() 
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT `email`,`role` FROM `users`");        
        $users = Array();

        $index = 0;
        while ($user = $res->fetch_assoc()) {
            $users[$index]['email'] = $user['email'];
            $users[$index]['role'] = $user['role'];
            $index++;
        }
        return $users;
    }

    function get_super_users_count() {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT COUNT(*) as count FROM users WHERE role=\"super\"");
        if($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            return $res['count'];
        }
        return 0;  
    }

    function get_user($email)
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT * FROM users WHERE email=\"" . $email . "\"");        
        $user = [];
        if ($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            $user['userName'] = $res['userName'];
            $user['email'] = $res['email'];
            $user['password'] = $res['password'];
            $user['role'] = $res['role'];
        }
        return $user;
    }

    function change_user_name($email, $name)
    {
        $sql = init_bd_connection();
        $res = $sql->query("UPDATE users SET userName='" . $name . "' WHERE email='" . $email . "'"); 
        $_SESSION['userName'] = $name;       
    }
  
    function change_user_email($current_email, $email)
    {
      if (!exist_user($email)) {
        $sql = init_bd_connection();
        $res = $sql->query("UPDATE comments SET email='" . $email . "' WHERE email='" . $current_email . "'");
        $res = $sql->query("UPDATE users SET email='" . $email . "' WHERE email='" . $current_email . "'"); 
        $_SESSION['email'] = $email;  
      }
    }
  
    function change_user_pass($email, $pass)
    {
        $sql = init_bd_connection();
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $res = $sql->query("UPDATE users SET password='" . $pass . "' WHERE email='" . $email . "'"); 
    }

    function get_roles() 
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT * FROM `roles`");        
        $roles = Array();

        $index = 0;
        while ($role = $res->fetch_assoc()) {
            $roles[$index] = $role['role'];
            $index++;
        }
        return $roles;
    }

    function update_role($email, $new_role) {
        $sql = init_bd_connection();
        $res = $sql->query("UPDATE users SET role='" . $new_role . "' WHERE email='" . $email . "'");
    }

    function get_events_headers()
    {
        $sql = init_bd_connection();
        $query = "SELECT * FROM events ";
        if ($_SESSION['role'] != 'super' && $_SESSION['role'] != 'gestor') {
            $query = $query . " WHERE events.is_published=1";
        }
        $res = $sql->query($query);
        $events = extract_events_headers($res);
        return $events;
    }

    function get_events_headers_with_tags($tag)
    {
        $sql = init_bd_connection();
        $query = "SELECT * FROM events,tags WHERE events.idEvent=tags.idEvent and tags.tagName=\"" . $tag . "\"";
        if ($_SESSION['role'] != 'super' && $_SESSION['role'] != 'gestor') {
            $query = $query . " and events.is_published=1";
        }
        $res = $sql->query($query);
        $events = extract_events_headers($res);
        return $events;
    }
//`idEvent`, `title`, `image`, `is_published`
    function get_events_headers_from_search($text)
    {
        $sql = init_bd_connection();
        $query = "SELECT DISTINCT events.idEvent, title, image, is_published FROM events events,tags WHERE ((events.idEvent=tags.idEvent and tags.tagName LIKE '%" . $text . "%')";
        $query = $query . " or events.title LIKE '%" . $text . "%'";
        $query = $query . " or events.organizer LIKE '%" . $text . "%'";
        $query = $query . " or events.description LIKE '%" . $text . "%'";
        if ($_SESSION['role'] != 'super' && $_SESSION['role'] != 'gestor') {
            $query = $query . ") and events.is_published=1";
        } else {
            $query = $query . ")";
        }
        $res = $sql->query($query);
        $events = extract_events_headers($res);
        return $events;
    }    

    function extract_events_headers($events_headers_response)
    {
        $events = array();
        $index = 0;
        while ($event = $events_headers_response->fetch_assoc()) {
            $events[$index]['idEvent'] = $event['idEvent'];
            $events[$index]['title'] = $event['title'];
            $events[$index]['image'] = $event['image'];
            $events[$index]['is_published'] = $event['is_published'];
            $index++;
        }
        return $events;
    }

    function get_event($idEvent)
    {
        $sql = init_bd_connection();
        $query = "SELECT * FROM events WHERE idEvent=" . $idEvent;
        $res = $sql->query($query);        

        $event = [];
        if ($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            $event['idEvent'] = $res['idEvent'];
            $event['title'] = $res['title'];
            $event['image'] = $res['image'];
            $event['eventDate'] = $res['eventDate'];
            $event['organizer'] = $res['organizer'];
            $event['organizerLink'] = $res['organizerLink'];
            $event['description'] = $res['description'];
            $event['is_published'] = $res['is_published'];
        }

        $res = $sql->query("SELECT * FROM comments, users WHERE comments.email = users.email and idEvent=" . $idEvent);
        $event['comments'] = extract_comments($res);

        $res = $sql->query("SELECT * FROM banned_words");
        $words = extract_banned_words($res);
        $event['banned_words'] = $words;

        $res = $sql->query("SELECT * FROM tags WHERE idEvent=" . $idEvent);
        $tags = array();
        $index = 0;
        while ($tag = $res->fetch_assoc()) {
            $tags[$index] = $tag['tagName'];
            $index++;
        }

        $event['tags'] = $tags;

        return $event;
    }

    function get_event_with_image_count($image)
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT COUNT(*) as count FROM events WHERE image=\"" .$image . "\"");
        if($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            return $res['count'];
        }
        return 0; 
    }

    function delete_event($idEvent) 
    {
        $sql = init_bd_connection();
        $res = $sql->query("DELETE FROM comments WHERE idEvent=" . $idEvent);
        $res = $sql->query("DELETE FROM tags WHERE idEvent=" . $idEvent);
        $res = $sql->query("DELETE FROM events WHERE idEvent=" . $idEvent);
    }

    function add_event($title, $organizer, $organizerLink, $date, $description, $image, $tags) {
        $sql = init_bd_connection();
        $res = $sql->query("INSERT INTO `events` (`title`, `eventDate`, `image`, `organizer`, `organizerLink`, `description`) VALUES ('" . $title . "', '" . $date . "', '" . $image . "', '" . $organizer . "', '" . $organizerLink . "', '" . $description . "')");
        $idEvent = $sql->insert_id;
        
        $query = "INSERT INTO `tags` (`tagName`, `idEvent`) VALUES ";
        for($i = 0; $i < count($tags); $i++) {
            $query = $query . "('" . $tags[$i] . "', '" . $idEvent . "'),";
        }
        $query = trim($query, ',');
        $query = $query . ';';
        $res = $sql->query($query);

        return $idEvent;
    }

    function publish_event($idEvent)
    {
        $sql = init_bd_connection();
        $res = $sql->query("UPDATE events SET is_published=1 WHERE idEvent='" . $idEvent . "'");
    }

    function update_event($idEvent, $title, $organizer, $organizerLink, $date, $description, $image, $tags) 
    {
        $sql = init_bd_connection();
        $settings = "title='" . $title . "'";
        $settings = $settings . ", eventDate='" . $date . "'";
        $settings = $settings . ", image='" . $image . "'";
        $settings = $settings . ", organizer='" . $organizer . "'";
        $settings = $settings . ", organizerLink='" . $organizerLink . "'";
        $settings = $settings . ", description='" . $description . "'";
        $res = $sql->query("UPDATE events SET " . $settings . " WHERE idEvent='" . $idEvent . "'");
        
        $res = $sql->query("DELETE FROM tags WHERE idEvent=" . $idEvent);

        $query = "INSERT INTO `tags` (`tagName`, `idEvent`) VALUES ";
        for($i = 0; $i < count($tags); $i++) {
            $query = $query . "('" . $tags[$i] . "', '" . $idEvent . "'),";
        }
        $query = trim($query, ',');
        $query = $query . ';';
        $res = $sql->query($query);
    }

    function get_banned_words()
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT * FROM banned_words");
        return extract_banned_words($res);
    }

    function extract_banned_words($banned_words_response)
    {
        $words = array();
        $index = 0;
        while ($word = $banned_words_response->fetch_assoc()) {
            $words[$index] = $word['word'];
            $index++;
        }
        return $words;
    }

    function get_all_comments()
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT * FROM comments, users WHERE comments.email = users.email");        
        $comments = extract_comments($res);
        return $comments;
    }

    function get_comments($idEvent)
    {
        $sql = init_bd_connection();
        $res = $sql->query("SELECT * FROM comments, users WHERE comments.email = users.email and idEvent=" . $idEvent);
        $comments = extract_comments($res);
        return $comments;
    }

    function extract_comments($comments_response) 
    {
        $comments = array();
        $index = 0;
        while ($comment = $comments_response->fetch_assoc()) {
            $comments[$index]['idComment'] = $comment['idComment'];
            $comments[$index]['idEvent'] = $comment['idEvent'];
            $comments[$index]['userName'] = $comment['userName'];
            $comments[$index]['commentDate'] = $comment['commentDate'];
            $comments[$index]['commentTime'] = $comment['commentTime'];
            $comments[$index]['comment'] = $comment['comment'];
            $comments[$index]['is_edited'] = ($comment['is_edited'] == 1);
            $index++;
        }
        return $comments;
    }

    function add_comment($email, $eventID, $comment, $date, $time)
    {
        $sql = init_bd_connection();
        $res = $sql->query("INSERT INTO `comments` (`idEvent`, `commentDate`, `commentTime`, `email`, `comment`) VALUES ('" . $eventID . "', '" . $date . "', '" . $time . "', '" . $email . "', '" . $comment . "')");
    }

    function edit_comment($id, $comment)
    {
        $sql = init_bd_connection();
        $res = $sql->query("UPDATE comments SET comment='" . $comment . "', is_edited=1 WHERE idComment=" . $id);
    }

    function delete_comment($id)
    {
        $sql = init_bd_connection();
        $res = $sql->query("DELETE FROM comments WHERE idComment=" . $id);
    
    }
?>
