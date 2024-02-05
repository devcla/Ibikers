const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');
const login_out = document.querySelector('.login-out');
const logout = document.getElementById('btn-logout');
const login = document.getElementById('login');

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

login.addEventListener('click', () => {
    login_out.classList.add('logged');
    wrapper.classList.remove('active-popup');
})

logout.addEventListener('click', () => {
    login_out.classList.remove('logged');
})