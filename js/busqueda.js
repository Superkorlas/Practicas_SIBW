var http_request;

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

function focus_out() {
    setTimeout(function() {
        document.getElementById("search_results").style.display = 'none';
    }, 100);
}

function word_added() {
    document.getElementById("search_results").style.display = 'block';
    var search_nav = document.getElementById("search").value;
    if(search_nav != "") {
        var data = "text=" + search_nav;
        ajax_request("buscar_evento.php", "POST", search, data);
    } else {
        document.getElementById("search_results").getElementsByTagName("ul")[0].innerHTML = "";
    }
}

function search() {
    if (http_request.readyState == 4) { 
        if (http_request.status == 200) {
            document.getElementById("search_results").getElementsByTagName("ul")[0].innerHTML = "";
            var events_headers = JSON.parse(http_request.responseText);
            var length = Object.keys(events_headers).length;
            for (i = 0; i < length; i++) {
                add_event_result(events_headers[i]);
            }
        } else {
            alert("Ha ocurrido un error");
        }
    }
}

function add_event_result(event_header) {
    var search_results = document.getElementById("search_results").getElementsByTagName("ul")[0];
    var link = document.createElement("a");
    var list_element = document.createElement("li");
    var image = document.createElement("img");

    link.href = "evento.php?event=" + event_header.idEvent + "&search=" + document.getElementById("search").value;
    image.src = event_header.image;
    
    list_element.append(image);
    list_element.append(document.createTextNode(event_header.title));
    link.append(list_element);
    search_results.append(link);
}