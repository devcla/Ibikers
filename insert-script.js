const wrapper = document.querySelector('.wrapper');
const iconBack = document.querySelector('.icon-back');
const textArea = document.getElementById('.descrizione');
const logout = document.getElementById('btn-logout');

document.addEventListener("DOMContentLoaded", function() {
    wrapper.classList.add('show');
});

iconBack.addEventListener('click', function() {
    window.location.href = 'index.php';
});

logout.addEventListener('click', () => {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        // Redirect to the login page after logout
        window.location.href = 'index.php';
    };
    xhr.send();
});