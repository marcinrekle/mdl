<template>
	<div class="container-fluid">
		<div class="row">
    	    <sideBar v-if="$auth.check()"></sideBar>
    	    <router-view></router-view>
		</div>
	</div>
</template>