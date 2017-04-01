<template>
	<div class="customer">
		<!-- Customer Search -->
		<customer-search 
			:auth="authUser" 
			:customers="customers"
			:table="tblCustomer"
			@isedited="editRecord"
			@ishistory="purchaseRecord"
		></customer-search>

		<!-- Customer Edit -->
		<customer-edit 
			:auth="auth" 
			:token="token" 
			:customer="record"
			@isedited="showEditForm = false"
			v-if="showEditForm"
		></customer-edit>

		<!-- Customer Purchase -->
		<customer-purchase
			:auth="authUser"
			:customer="purchaseCustomerRecord"
			@ishistory="showPurchaseForm = false"
			v-if="showPurchaseForm"
		></customer-purchase>
	</div>
</template>

<script>
	import CustomerSearch from './CustomerSearch.vue';
	import CustomerEdit from './CustomerEdit.vue';
	import CustomerPurchase from './CustomerPurchase.vue';

	export default {
		components: { CustomerSearch, CustomerEdit, CustomerPurchase },
		props: ['auth', 'date', 'token'],
		data() {
			return {
				authUser: {},
		    	showEditForm: false,
		    	showPurchaseForm: false, // tmp -false
		    	record: {},
		    	purchaseCustomerRecord: {},
				customers: [],
				tblCustomer: '',
				// icList: [],
		    }
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			// this.allCustomer();
		},
		mounted() {
			store.commit('SET_AUTH_USER', this.authUser);
		},
		watch: {
			authUser() {
				this.tblCustomer = this.authUser.AllowedtblCustomer;
			}
		},
		methods: {
			editRecord(customer) {
				this.showEditForm = true;
				this.record = customer;
			},
			purchaseRecord(customer) {
				this.showPurchaseForm = true;
				this.purchaseCustomerRecord = customer;
			},
			allCustomer() {
				let tblCustomer = this.authUser.AllowedtblCustomer;

				store.dispatch('ALL_CUSTOMER', tblCustomer).then(() => {
					let state = store.state;

					this.customers = state.customers;
					this.tblCustomer = state.tblCustomer;
					this.icList = state.icList;
				});
			},
		}
	}
</script>