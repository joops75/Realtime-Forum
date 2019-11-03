require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

Vue.component('AppHome', require('./components/AppHome.vue').default); // rendered on resources/views/home.blade.php
import { router } from './router/router';

const app = new Vue({
    el: '#app',
    router
});