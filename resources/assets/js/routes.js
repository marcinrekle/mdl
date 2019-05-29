import VueRouter from 'vue-router';

let routes = [
    {
        name: 'home',
        path: '/',
        component: require('./components/auth/Login.vue').default,
        meta: {
            auth: false
        }
    },
    {
        name: 'login',
        path: '/login',
        component: require('./components/auth/Login.vue').default,
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
        name: 'dashboard',
        path: '/dashboard',
        component: require('./components/Dashboard.vue').default,
        meta: {
            auth: true
        }
    },
    {
        name: 'payment',
        path: '/payment',
        component: require('./components/dashboard/payments/Payments.vue').default,
        meta: {
            auth: true,
            perms: 'payment',
        }
    },
    {
        name: 'drive',
        path: '/drive',
        component: require('./components/dashboard/drives/Drives.vue').default,
        meta: {
            auth: true,
        }
    },
    {
        name: 'hour',
        path: '/hour',
        component: require('./components/dashboard/hours/Hours.vue').default,
        meta: {
            auth: true,
        }
    },{
        name: 'role',
        path: '/role',
        component: require('./components/dashboard/roles/Roles.vue').default,
        meta: {
            auth: true,
        }
    },
    {
        path: '*',
        redirect: '/dashboard'//change to 404 component
    }
];

export default new VueRouter({
    routes
});