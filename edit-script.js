const wrapper = document.querySelector('.wrapper');
const iconBack = document.querySelector('.icon-back');
const logout = document.getElementById('btn-logout');
const editForm = document.getElementById('edit-form');


document.addEventListener("DOMContentLoaded", function() {
    wrapper.classList.add('show');
    editForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('edit-post.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert('modifica avvenuta');
                    window.location.href = 'index.php';
                } else {
                    alert('modifica non avvenuta');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

});

iconBack.addEventListener('click', function() {
    window.location.href = 'index.php';
});




logout.addEventListener('click', () => {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        // Redirect to the login page after logout
        window.location.href = 'index.php';
    };
    xhr.send();
});