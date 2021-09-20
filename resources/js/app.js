require('./bootstrap');

import { createApp } from "vue"

window.Vue = require('vue');

const app = createApp({
    el: '#app',
});

window.toggleMenu = function() {
    let icons = document.getElementById("buttonMenu").querySelectorAll("svg");
    icons.forEach(element => element.classList.toggle('hidden'));

    let menu = document.getElementById("navMenu");
    menu.classList.toggle("hidden");
}

window.toggleUserMenu = function() {
    let menu = document.getElementById("navUserMenu");
    menu.classList.toggle("hidden");
}

window.addEventListener('click', function(event) {
    let navMenu = document.getElementById("navMenu");
    let buttonMenu = document.getElementById("buttonMenu");

    if (event.target !== buttonMenu && event.target.parentNode !== buttonMenu && event.target.parentNode.parentNode !== buttonMenu) {
        navMenu.classList.add('hidden');
        let icons = buttonMenu.querySelectorAll("svg");
        icons[0].classList.remove('hidden');
        icons[1].classList.add('hidden');
    }

    let navUserMenu = document.getElementById("navUserMenu");
    let buttonUserMenu = document.getElementById("buttonUserMenu");

    if (event.target !== buttonUserMenu && event.target.parentNode !== buttonUserMenu && event.target.parentNode.parentNode !== buttonUserMenu) {
        navUserMenu.classList.add('hidden');
    }
});


