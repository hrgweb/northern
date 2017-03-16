<template>
	<ul class="alert alert-danger">
		<li v-for="error in errors">{{ error[0] }}</li>
	</ul>
</template>

<script>
	export default {
		props: ['errors'],
	}
</script>