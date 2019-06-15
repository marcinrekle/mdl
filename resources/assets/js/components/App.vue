<template>
	<div class="container-fluid">
		<div class="row justify-content-center">
    	    <sideBar v-if="sideBarShow"></sideBar>
    	    <!-- <main role="main" :class="[sideBarShow ? 'col-md-9 ml-sm-auto col-lg-10 pt-3 px-4' : 'col-12']"> -->
    	    <main role="main" class="col-md-9 col-lg-10 pt-3 px-4">
    	    	<router-view></router-view>
    	    </main>
		</div>
	</div>
</template>
<script>
	import {mapState} from 'vuex';
	export default{
		data(){
			return {
			}
		},
		computed: {
			sideBarShow(){
				return this.$auth.check() && this.$auth.user().role[0]!=='Student';
			},
			...mapState(['isLoading']),
		}
	}
</script>