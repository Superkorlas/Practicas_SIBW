var http_request;
var comment_selected;
var comment_selected_id;
var current_user_name;
var current_user_email;

document.addEventListener("DOMContentLoaded", load_comments_request);

function show_comments_panel() {
    var commentsPanel = document.getElementById("commentsPanel");
    
    if (commentsPanel.style.display == "block") {
        commentsPanel.style.display = 'none';
    } else {
        commentsPanel.style.display = 'block';
        load_comments_request();
    }
}

function get_event_id() {
    var element = document.getElementById("eventID");
    if(element) {
        return element.innerHTML;
    } else {
        return null;
    }
}

function send_comment() {
    var name = document.getElementById("name");
    var email = document.getElementById("email");
    var commentText = document.getElementById("commentText");
    var date = new Date();
    var date2 = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    var dateTime = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    var dateFormatted = "(" + date2 + " - ";
    dateFormatted += dateTime + ")";
    if (name.innerHTML != "" && email.innerHTML != "" && commentText.value != "") {
        if (is_valid_email(email.innerHTML)) {
            var data = "email=" + email.innerHTML;
            data += "&name=" + name.innerHTML;
            data += "&comment=" + commentText.value;
            data += "&date=" + date2;
            data += "&time=" + dateTime;
            data += "&eventID=" + get_event_id();
            ajax_request("enviar_comentario.php", "POST", send_comment_request,data);
            
            commentText.value = "";
        }
    } else {
        alert("Error: Ha dejado algún campo sin rellenar.");
    }
}

function is_valid_email(email) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.match(mailformat))
    {
        return (true);
    } else {
        alert("Dirección de email inválida.");
        return (false);
    }
}

function check_comment() {
    var comment = document.getElementById("commentText");
    var comment_words = comment.value.split(" ");
    var last_word = comment_words[comment_words.length - 1];
    comment.value = "";
    for (i = 0; i < comment_words.length - 1; i++) {
        comment.value += comment_words[i] + " ";
    }
    comment.value += checking_word(last_word);
}

function checking_word(word){
    var banned_words = document.getElementById("banned_words");
    var words = banned_words.innerText.split(" ");

    var lower_case_word = word.toLowerCase();
    
    for (i = 0; i < words.length; i++) {
        if (lower_case_word == words[i] && words[i] != "") {
            return ban_word(lower_case_word);
        }
    }
    return word;
}

function ban_word(banned_word) {
    var word = "";
    for (i = 0; i < banned_word.length; i++) {
        word += "*";
    }
    return word;
}

function load_comments_request() {
    var eventID = get_event_id();
    var url = "cargar_comentarios.php";
    if (eventID){
        url = url + "?event=" + eventID;
    }
    ajax_request(url, "GET", load_all_comments, null);
}

function init_xhr() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest;
    } else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        return false;
    }
}

function ajax_request(url, method, func, data) {
    http_request = init_xhr();
    if (http_request) {
        http_request.onreadystatechange = func;
        http_request.open(method, url, true);

        if (data) {
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.setRequestHeader("Content-length", data.length);
            http_request.setRequestHeader("Connection", "close");
        }

        http_request.send(data);
        return true;
    }
}

function send_comment_request() {
    if (http_request.readyState == 4) { 
        if (http_request.status == 200) {
            console.log(http_request.responseText);
            load_comments_request();
        } else {
            alert("Ha ocurrido un error");
        }
    }
}

function load_all_comments() {
    if (http_request.readyState == 4) { 
        if (http_request.status == 200) {
            var commentsField = document.getElementById("comments");
            commentsField.innerHTML = "";
            var comments = JSON.parse(http_request.responseText);
            var length = Object.keys(comments).length - 1;
            for (i = 0; i < length; i++) {
                add_comment(comments[i], "comments", comments.can_edit);
            }
        } else {
            alert("Ha ocurrido un error");
        }
    }
}

function add_comment(json_comment, attach_to, can_edit) {
    var comments = document.getElementById(attach_to);
    var tag = document.createElement("p");
    var text = json_comment.userName;
    text += " (" + json_comment.commentDate + " - " + json_comment.commentTime + ")"; 
    text += ":";

    var comment = document.createElement("p");
    comment.appendChild(document.createTextNode(json_comment.comment));

    var comment_data = document.createTextNode(text);
    tag.appendChild(comment_data);
    tag.appendChild(comment);

    if (json_comment.is_edited) {
        var edited = document.createElement("p");
        edited.className = "EditedMessage";
        edited.appendChild(document.createTextNode("<Editado por moderador>"));
        tag.appendChild(edited);
    }

    if (can_edit) {
        var edit_button = document.createElement("button");
        edit_button.innerHTML = "Editar";
        edit_button.addEventListener("click", function() {
            init_edit_comment(tag, json_comment);
          });
        tag.appendChild(edit_button);

        var delete_button = document.createElement("button");
        delete_button.innerHTML = "Eliminar";
        delete_button.addEventListener("click", function() {
            delete_comment(json_comment.idComment);
          });
        tag.appendChild(delete_button);
    }
    comments.appendChild(tag);
}

function init_edit_comment(tag, json_comment) {
    show_comments_edit(true);
    if (comment_selected) {
        comment_selected.style.backgroundColor = "bisque";
    }
    tag.style.backgroundColor = "blue";
    comment_selected = tag;
    comment_selected_id = json_comment.idComment;

    var user = document.getElementById("name");
    var email = document.getElementById("email");
    var comment = document.getElementById("commentText");

    if (current_user_email == null && current_user_name == null) {
        current_user_name = user.innerHTML;
        current_user_email = email.innerHTML;
    }

    user.innerHTML = json_comment.userName;
    email.innerHTML = "";
    comment.value = json_comment.comment;
}

function show_comments_edit(show) {
    var edit = document.getElementById("edit");
    var cancel = document.getElementById("cancel");
    var send = document.getElementById("send");

    if (!show) {
        edit.style.display = 'none';
        cancel.style.display = 'none';
        if (send) {
            send.style.display = 'inline-block';
        }
    } else {
        edit.style.display = 'inline-block';
        cancel.style.display = 'inline-block';
        if (send) {
            send.style.display = 'none';
        }
    }
}

function cancel_edit_comment() {
    if (comment_selected) {
        comment_selected.style.backgroundColor = "bisque";
    }

    if (current_user_email != null && current_user_name != null) {
        var user = document.getElementById("name");
        var email = document.getElementById("email");
        var comment = document.getElementById("commentText");
        user.innerHTML = current_user_name;
        email.innerHTML = current_user_email;
        comment.value = "";
    }
    show_comments_edit(false);
}

function edit_comment() {
    var data = "id=" + comment_selected_id;
    data += "&comment=" + document.getElementById("commentText").value;
    ajax_request("editar_comentario.php", "POST", send_comment_request, data);
    cancel_edit_comment();
}

function delete_comment(id) {
    var data = "id=" + id;
    ajax_request("eliminar_comentario.php", "POST", send_comment_request, data);
    cancel_edit_comment();
}