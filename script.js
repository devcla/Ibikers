const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');
const login_out = document.querySelector('.login-out');
const logout = document.getElementById('btn-logout');
//const login = document.getElementById('login');
const loginForm = document.getElementById('login-form');

registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
});

/*document.addEventListener('DOMContentLoaded', function () {
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); 

        login_out.classList.add('logged');
        wrapper.classList.remove('active-popup');
    })
});*/

function handleLoginSuccess() {
    login_out.classList.add('logged');
    wrapper.classList.remove('active-popup');
}

logout.addEventListener('click', () => {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        // Redirect to the login page after logout
        window.location.href = 'index.php';
    };

    login_out.classList.remove('logged');
    xhr.send();
});