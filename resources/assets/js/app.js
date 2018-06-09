
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueRouter from 'vue-router';

import router from './routes.js';
import App from './components/App.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

var deleteBtn = Vue.component('delete-btn', require('./components/Delete.vue'));

const app = new Vue({
    el: '#app',
    data: {
    	
    },
    router,
    render: app => app(App), 
});
