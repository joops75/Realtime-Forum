require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

import User from './helpers/User';
window.User = User;

Vue.component('AppHome', require('./components/AppHome.vue').default); // rendered on resources/views/home.blade.php
import { router } from './router/router';

const app = new Vue({
    el: '#app',
    router
});