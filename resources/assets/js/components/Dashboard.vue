<template>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
       <users />
    </main>
</template>
<script>
    import Users from './dashboard/users/Users.vue';
    export default{
        components: {
            Users,
        },
		data() {
			return {
                notify: [],
			}
		},
		mounted() {
        },
		methods: {
		}
	}
</script>