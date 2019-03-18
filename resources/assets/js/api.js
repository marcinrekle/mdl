
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
import store from './store';
import VueAxios from 'vue-axios';

import router from './routes.js';
import App from './components/App.vue';
import sideBar from './components/sideBar.vue';
import loading from './components/Loading.vue';
import deleteBtn from './components/DeleteBtn.vue';
import grid from './components/Grid.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(require('vue-moment'));

axios.defaults.baseURL = 'http://mdl.test/api/';

Vue.router = router;

Vue.component('sideBar', sideBar);
Vue.component('loading', loading);
Vue.component('delete-btn', deleteBtn);
Vue.component('grid', grid);

Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});
App.router = Vue.router;

new Vue({
  	store, // inject store to all children
  	el: '#app',
  	render: h => h(App)
})
/*new Vue({App, store}).$mount('#app');*/

