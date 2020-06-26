document.addEventListener("DOMContentLoaded", search_terms);

function search_terms() {
    var search_term = document.getElementById("search_term").innerHTML;
    var title = document.getElementById("title");
    var organizer = document.getElementById("organizer");
    var description = document.getElementById("description");
    var tags = document.getElementsByClassName("tag");

    var res = title.innerHTML.replace(search_term, "<strong>" + search_term + "</strong>");
    title.innerHTML = res;

    res = organizer.innerHTML.replace(search_term, "<strong>" + search_term + "</strong>");
    organizer.innerHTML = res;

    res = description.innerHTML.replace(search_term, "<strong>" + search_term + "</strong>");
    description.innerHTML = res;

    res = description.innerHTML.replace(search_term, "<strong>" + search_term + "</strong>");
    description.innerHTML = res;

    for (var i = 0; i < tags.length; i++){
        res = tags.item(i).innerHTML.replace(search_term, "<strong>" + search_term + "</strong>");
        tags.item(i).innerHTML = res;
    }
}