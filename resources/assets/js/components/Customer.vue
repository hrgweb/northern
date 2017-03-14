<template>
	<div class="customer">
		<customer-search :auth="auth"></customer-search>
	</div>
</template>

<script>
	import CustomerSearch from './CustomerSearch.vue';

	export default {
		components: { CustomerSearch },
		props: ['auth']
	}
</script>