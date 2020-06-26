function show_login() {
    var loginPanel = document.getElementById("loginPanel");
    
    if (loginPanel.style.display == "block") {
        loginPanel.style.display = 'none';
    } else {
        loginPanel.style.display = 'block';
    }
}

function show_sign_up() {
    var loginPanel = document.getElementById("signUpPanel");
    
    if (loginPanel.style.display == "block") {
        loginPanel.style.display = 'none';
    } else {
        loginPanel.style.display = 'block';
    }
}