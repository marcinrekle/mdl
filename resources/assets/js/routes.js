import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./components/Example.vue')
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
        path: '/dashboard',
        component: require('./components/Dashboard.vue'),
        meta: {
            auth: true
        }
    }
];

export default new VueRouter({
    routes
});