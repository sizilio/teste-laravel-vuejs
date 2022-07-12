//require('./bootstrap');
//import Vue from 'vue';
import { createApp } from 'vue'
// window.Vue = require('vue').default;
// import App from './App.vue';
// import * as VueRouter from 'vue-router';
// import VueAxios from 'vue-axios';
// import axios from 'axios';
// import {routes} from './routes';
// window.Vue.use(VueRouter);
// window.Vue.use(VueAxios, axios);
// const router = new VueRouter({
//     mode: 'history',
//     routes: routes
// });
// const app = new Vue({
//     el: '#app',
//     router: router,
//     render: h => h(App),
// });

require('./bootstrap');
import Vue from 'vue/dist/vue';
window.Vue = require('vue');
import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
