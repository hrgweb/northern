<template>
	<div class="customer">
		<!-- Customer Search -->
		<customer-search 
			:auth="authUser" 
			:customers="customers"
			:table="tblCustomer"
			@isedited="editRecord"
		></customer-search>

		<!-- Customer Edit -->
		<customer-edit 
			:auth="auth" 
			:token="token" 
			:customer="record"
			:ic="icList"
			@isedited="showEditForm = false"
			v-if="showEditForm"
		></customer-edit>
	</div>
</template>

<script>
	import CustomerSearch from './CustomerSearch.vue';
	import CustomerEdit from './CustomerEdit.vue';

	export default {
		components: { CustomerSearch, CustomerEdit },
		props: ['auth', 'date', 'token'],
		data() {
			return {
				authUser: {},
		    	showEditForm: false,
		    	record: {},
				customers: [],
				tblCustomer: '',
				icList: []
		    }
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			this.allCustomer();
		},
		mounted() {
			store.commit('SET_AUTH_USER', this.authUser);
		},
		methods: {
			editRecord(customer) {
				this.showEditForm = true;
				this.record = customer;
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