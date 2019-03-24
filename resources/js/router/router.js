import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/login/Login'
import SignUp from "../components/login/SignUp";
import Logout from "../components/login/Logout";
import AppContent from "../components/AppContent";
import NewTask from "../components/manager/NewTask";
import AllTasks from "../components/manager/AllTasks";
import MyTasks from "../components/worker/MyTasks";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: AppContent, name: 'home'},
    {path: '/login', component: Login, name: 'login'},
    {path: '/signup', component: SignUp, name: 'signup'},
    {path: '/logout', component: Logout, name: 'logout'},
    {path: '/new-task', component: NewTask, name: 'new-task'},
    {path: '/all-tasks', component: AllTasks, name: 'all-tasks'},
    {path: '/my-tasks', component: MyTasks, name: 'my-tasks'},
];

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history'
});

export default router;
