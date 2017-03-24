
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

 import { store } from './components/store/store.js';

import Customer from './components/Customer.vue';
import CustomerCreate from './components/CustomerCreate.vue';

window.store = store;

// plugins
import noty from 'noty';
window.noty = noty;

const app = new Vue({
    el: '#app',
    components: { Customer, CustomerCreate },
    store
});
