require('./bootstrap');

import Vue from 'vue';

import Vuetify from 'vuetify';
Vue.use(Vuetify);

import VueSimplemde from 'vue-simplemde';
Vue.component('vue-simplemde', VueSimplemde);
window.md = require('marked');

import User from './helpers/User';
window.User = User;

window.EventBus = new Vue(); // create new Vue app just for events

Vue.component('AppHome', require('./components/AppHome.vue').default); // rendered on resources/views/home.blade.php
import { router } from './router/router';

const app = new Vue({
    el: '#app',
    router
});