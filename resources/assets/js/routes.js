import VueRouter from 'vue-router';

let routes = [
    {
        name: 'home',
        path: '/',
        component: require('./components/auth/Login.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/register',
        //component: require('./views/About.vue'),
        meta: {
            auth: false
        }
    },
    {
        name: 'login',
        path: '/login',
        component: require('./components/auth/Login.vue'),
        meta: {
            auth: false
        }
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: require('./components/Dashboard.vue'),
        meta: {
            auth: true
        }
    },
    {
        name: 'payment',
        path: '/payment',
        component: require('./components/dashboard/payments/Payments.vue'),
        meta: {
            auth: true
        }
    },
];

export default new VueRouter({
    routes
});