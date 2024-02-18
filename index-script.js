const wrapper = document.querySelector('.wrapper');
const loginLinks = document.querySelectorAll('.login-link');
const registerLink = document.querySelector('.register-link');
const modifyLink = document.querySelector('.modify-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');
const login_out = document.querySelector('.login-out');
const logout = document.getElementById('btn-logout');
const loginForm = document.getElementById('login-form');
const modifyForm = document.getElementById('modify-form')
const registerForm = document.getElementById('register-form');
const post_form = document.getElementById('post-form');
let edit_clicked = false;
let delete_clicked = false;


registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLinks.forEach(loginLink => {
    loginLink.addEventListener('click', () => {
        wrapper.classList.remove('active');
        wrapper.classList.remove('modify');
    });
});

modifyLink.addEventListener('click', () => {
    wrapper.classList.add('modify');
});

btnPopup.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
});

function editClicked() {
    edit_clicked = true;
}

function deleteClicked() {
    delete_clicked = true;
}

document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the form submission
    post_form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch the form data
        const formData = new FormData(this);

        if (edit_clicked) {
            window.location.href = 'edit.php?' + new URLSearchParams(formData).toString();
            edit_clicked = false;
        }
        // If delete button was clicked, send form data to delete.php using POST request
        else if (delete_clicked) {
            fetch('delete.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Handle response from delete.php
                    if (data === 'success') {
                        // Delete operation was successful
                        console.log('Delete successful');
                        location.reload();
                    } else {
                        // Delete operation failed
                        console.error('Delete failed:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            delete_clicked - false;
        }



    });
});

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
                location.reload();
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

document.addEventListener('DOMContentLoaded', function() {
    //dovrebbe mandare una mail con un link
    modifyForm.addEventListener('submit', function(event) {
        event.preventDefault();


        const formData = new FormData(this);


        fetch('modify.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                wrapper.classList.remove('modify');
                alert('Email sent');
            } else {
                alert('Invalid data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the form submission
    registerForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Fetch the form data
        const formData = new FormData(this);

        // Send the form data to register.php for validation
        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                wrapper.classList.remove('active');
                alert('Register successful');
            } else {
                // If register is unsuccessful, display an error message or take appropriate action
                alert('Invalid data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

logout.addEventListener('click', () => {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        // Redirect to the login page after logout
        window.location.href = 'index.php';
    };

    login_out.classList.remove('logged');
    xhr.send();
});