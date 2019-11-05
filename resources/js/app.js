require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

import User from './helpers/User';
window.User = User;

window.EventBus = new Vue(); // create new Vue app just for events

Vue.component('AppHome', require('./components/AppHome.vue').default); // rendered on resources/views/home.blade.php
import { router } from './router/router';

const app = new Vue({
    el: '#app',
    router
});