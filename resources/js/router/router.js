import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/login/Login';
import Logout from '../components/login/Logout';
import Signup from '../components/login/Signup';
import Forum from '../components/forum/Forum';

Vue.use(VueRouter);

const routes = [
    { path: '/login', component: Login },
    { path: '/logout', component: Logout },
    { path: '/signup', component: Signup },
    { path: '/forum', component: Forum }
];

export const router = new VueRouter({
    mode: 'history', // default is 'hash'
    routes
});
