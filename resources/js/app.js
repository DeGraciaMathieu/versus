require('./bootstrap');

import { createApp } from "vue"

window.Vue = require('vue');

const app = createApp({
    el: '#app',
});

window.toggleMenu = function() {
    let menu = document.getElementById("navMenu");
    menu.classList.toggle("hidden");
}
