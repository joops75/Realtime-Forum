import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/login/Login';

Vue.use(VueRouter);

const routes = [
    { path: '/login', component: Login }
];

export const router = new VueRouter({
    mode: 'history', // default is 'hash'
    routes
});
