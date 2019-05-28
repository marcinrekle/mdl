<template>
    <users />
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