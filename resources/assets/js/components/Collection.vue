<template>
    <div class="Collection">
        <collection-form :date="date" :auth="authUser"></collection-form>
    </div>
</template>

<script>
    import CollectionForm from './CollectionForm.vue';

    export default {
        components: { CollectionForm },
        props: ['date', 'auth'],
        data() {
        	return {
        		authUser: {}
        	}
        },
        mounted() {
			this.authUser = JSON.parse(this.auth);
        }
    }
</script>
