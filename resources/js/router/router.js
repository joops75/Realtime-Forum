import Vue from 'vue';
import VueRouter from 'vue-router';
import Loading from '../components/Loading';
import Login from '../components/login/Login';
import Logout from '../components/login/Logout';
import Signup from '../components/login/Signup';
import Forum from '../components/forum/Forum';
import Question from '../components/forum/Question';
import Category from '../components/category/Category';

Vue.use(VueRouter);

const routes = [
    { path: '/loading', component: Loading },
    { path: '/login', component: Login },
    { path: '/logout', component: Logout },
    { path: '/signup', component: Signup },
    { path: '/forum', component: Forum },
    { path: '/question/:slug', component: Question },
    { path: '/category', component: Category }
];

export const router = new VueRouter({
    mode: 'history', // default is 'hash'
    routes
});
