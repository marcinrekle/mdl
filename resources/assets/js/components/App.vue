<template>
	<div class="container-fluid">
		<div class="row">
    	    <sideBar v-if="$auth.check()"></sideBar>
    	    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
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
				//isLoading: false
			}
		},
		computed: {
			...mapState(['isLoading']),
		}
	}
</script>