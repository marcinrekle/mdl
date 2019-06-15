<template>
    <component :is="role"></component>
</template>
<script>
    export default{
        components: {
        	Student: () => import("./dashboard/Student.vue"),
        	Admin: () => import("./dashboard/users/Users.vue"),
        	Instructor: () => import("./dashboard/drives/Drives.vue"),
        	Officce: () => import("./dashboard/drives/Drives.vue"),
        },
		data() {
			return {
                notify: [],
                role:this.$auth.user().role[0],
                //comp:{component: () => import('@/components/dashboard/'+this.$auth.user().role[0]+'.vue')},
			}
		},
		mounted() {
        },
		methods: {
		}
	}
</script>