import VueRouter from 'vue-router';

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

export default new VueRouter({
    routes
});

