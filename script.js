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
/*
document.addEventListener('DOMContentLoaded', function () {
    // Define your function to handle login success
    function handleLoginSuccess() {
        login_out.classList.add('logged');
        wrapper.classList.remove('active-popup');
    }
});
*/
/*
function handleLoginSuccess() {
    login_out.classList.add('logged');
    wrapper.classList.remove('active-popup');
}
*/
document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the form submission
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch the form data
        const formData = new FormData(this);

        // Send the form data to login.php for validation
        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                // If login is successful, execute operations
                login_out.classList.add('logged');
                wrapper.classList.remove('active-popup');
                console.log('Login successful');
            } else {
                // If login is unsuccessful, display an error message or take appropriate action
                alert('Invalid username or password');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

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