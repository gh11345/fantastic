// require('./bootstrap');
import Vue from 'vue'
import VueSession from 'vue-session';
import VueRouter from 'vue-router';
import VueCookie from 'vue-cookie';
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'

import App from './components/app.vue'
window.jQuery = window.$ = require('jquery');
window.axios = require('axios');

Vue.use(VueMaterial)
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
        component: require('./components/app.vue').default,
        children: [
            {
                path: '/',
                name: 'home',
                component: require('./components/content.vue').default
            },
            {
                path: '/products',
                name: 'products',
                component: require('./components/productListing.vue').default
            },
            {
                path: '/employee',
                name: 'employee',
                component: require('./components/employee.vue').default
            },
            {
                path: '/commission',
                name: 'commission',
                component: require('./components/commission.vue').default
            },
            {
                path: '/items',
                name: 'items',
                component: require('./components/items.vue').default
            },
            {
                path: '/report',
                name: 'report',
                component: require('./components/report.vue').default
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
