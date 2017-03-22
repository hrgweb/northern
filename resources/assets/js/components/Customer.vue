<template>
	<div class="customer">
		<customer-search :auth="auth" @isedited="editRecord"></customer-search>
		<customer-edit 
			:auth="auth" 
			:date="date" 
			:token="token" 
			:customer="record"
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
		    	showEditForm: false,
		    	record: {}
		    }
		},
		methods: {
			editRecord(customer) {
				this.showEditForm = true;
				this.record = customer;
			}
		}
	}
</script>