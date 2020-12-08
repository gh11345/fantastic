import VueRouter from 'vue-router';

const routes = [
    {
        path: '/',
        component: require('./components/app.vue').default,
        children: [
            {
                path: '/home',
                name: 'home',
                component: require('./components/content.vue').default
            },
            {
                path: '/content2',
                name: 'content2',
                component: require('./components/content2.vue').default
            },
            {
                path: '/products',
                name: 'products',
                component: require('./components/productListing.vue')
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

