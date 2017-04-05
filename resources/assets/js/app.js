
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

// 3rd party
import noty from 'noty';

import Customer from './components/Customer.vue';
import CustomerCreate from './components/CustomerCreate.vue';
import CustomerSignature from './components/CustomerSignature.vue';

window.store = store;
window.noty = noty;

const app = new Vue({
	name: 'Northern',
    el: '#app',
    components: { Customer, CustomerCreate, CustomerSignature },
    store
});
