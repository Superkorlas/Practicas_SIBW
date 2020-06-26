<?php

function check_image($image) {
    $errors = array();
    $file_name = $image['name'];
    $file_size = $image['size'];
    $file_tmp = $image['tmp_name'];
    $file_type = $image['type'];
    $file_ext = explode('.',$file_name);
    $file_ext = end($file_ext);
    $file_ext = strtolower($file_ext);
    $extensions = array("jpeg","jpg","png");
    
    if (in_array($file_ext,$extensions) === false){
        $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
    }
    
    if ($file_size > 2097152){
        $errors[] = 'Tamaño del fichero demasiado grande';
    }
    return $errors;
}

function create_event($title, $organizer, $organizerLink, $date, $description, $image, $tags) {
    $tags_array = array();
    return add_event($title, $organizer, $organizerLink, $date, $description, $image, tags_to_array($tags));
}

function edit_event($idEvent, $title, $organizer, $organizerLink, $date, $description, $image, $tags) {
    update_event($idEvent, $title, $organizer, $organizerLink, $date, $description, $image, tags_to_array($tags));
}

function tags_to_array($tags) {
    $array = array();
    $tags_array = array();
    $array = explode(" ", $tags);
    $index = 0;
    for($i = 0; $i < count($array); $i++) {
        if ($array[$i] != "") {
            $tags_array[$index] = $array[$i];
            $index++;
        }
    }
    return $tags_array;
}

function delete_image($image) {
    $dirname = dirname($image) . "/";
    if (get_event_with_image_count($image) <= 1) {
        unlink($image);
        if (count(glob($dirname . "*")) === 0) {
            rmdir($dirname);
        }
    }
}

?>