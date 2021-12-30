/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains the logs
 */

window.addEventListener("load", () => {
    document.body.classList.remove("preload");
});

document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector(".nav");

    document.querySelector("#btnNav").addEventListener("click", () => {
        nav.classList.add("nav--open");
    });

    document.querySelector(".nav__overlay").addEventListener("click", () => {
        nav.classList.remove("nav--open");
    });

    $(".nav #btn-disconnect").click(() => {
        disconnectUser(null);
    });
});

/**
 * Disconnects the user by sending a request to the server
 */
function disconnectUser() {
    let token = localStorage.getItem('loginToken');
    localStorage.removeItem('loginToken');
    disconnectUserRequest(token || "", disconnectUserSuccess, disconnectUserError);
}

/**
 * SuccessCallback function of the "disconnect request".
 * Reloads the page.
 */
function disconnectUserSuccess() {
    location.reload();
}

/**
 * ErrorCallback function of the "disconnect request".
 * Reloads the page.
 */
function disconnectUserError() {
    location.reload();
}

/**
 * Sets the active tab by adding a class to the specified div 
 */
function setActiveTab(tab) {
    $(`.${tab}`).addClass('nav__link--active');
}