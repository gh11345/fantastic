// require('./bootstrap');
import Vue from 'vue'
import VueSession from 'vue-session';
import VueRouter from 'vue-router';
import VueCookie from 'vue-cookie';
import App from './components/app.vue'
window.jQuery = window.$ = require('jquery');
window.axios = require('axios');

Vue.use(VueRouter);
Vue.use(VueSession);
Vue.use(VueCookie);

// import router from './routes.js';

// window.bus = new Vue();
// Vue.component('dashboard', require('./components/app.vue'));
// Vue.component('home', require('./components/content.vue'));
// Vue.component('login', require('./components/login.vue'));

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: require('./components/app.vue').default,
        children: [
            {
                path: '/',
                name: 'home',
                component: require('./components/content.vue').default
            }
        ]
    },
    {
        path: '/login',
        name: 'login',
        component: require('./components/login.vue').default
    }
];

const router = new VueRouter({
    routes: routes
})

new Vue({
    // el: '#app',
    router,
    // render: h => h(App),
}).$mount('#app');
