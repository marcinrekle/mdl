<template>
	<div class="container-fluid">
		<div class="wrapper justify-content-center">
    	    <sideBar v-if="sideBarShow"></sideBar>
    	    <!-- <main role="main" :class="[sideBarShow ? 'col-md-9 ml-sm-auto col-lg-10 pt-3 px-4' : 'col-12']"> -->
    	    <main role="main" class="w-100 pt-3 px-4">
    	    	<button type="button" id="sidebarCollapse" class="navbar-btn d-lg-none" v-if="sideBarShow">
                	<span></span>
                	<span></span>
                	<span></span>
            	</button>
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