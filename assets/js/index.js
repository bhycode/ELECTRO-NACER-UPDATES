let signin_go = document.getElementById("signin-button-go");
let login_div = document.getElementById("signin-div");

let signup_go = document.getElementById("signup-button-go");
let registration_div = document.getElementById("registration-div");

// Hide signup part
registration_div.style.display = "none";

// SignInGo
signin_go.addEventListener("click", function() {
    login_div.style.display = "block";
    registration_div.style.display = "none";
});

// SignUpGo
signup_go.addEventListener("click", function() {
    registration_div.style.display = "block";
    login_div.style.display = "none";

});