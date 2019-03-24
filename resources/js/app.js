require('./bootstrap');

import Vue from 'vue';
import User from './helpers/User';
import Vuetify from 'vuetify';
import VueSimplemde from 'vue-simplemde';
import md from 'marked';
import router from './router/router.js';

window.Vue = new Vue;
window.EventBus = new Vue;
Vue.use(Vuetify);
Vue.use(VueSimplemde);
window.md = md;

window.User = User;

Vue.component('app-home', require('./components/AppHome.vue').default);

const app = new Vue({
    el: '#app',
    router
});
