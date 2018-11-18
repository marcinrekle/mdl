<template>
	<div id="loading" class="">
		<h3>
			{{ loadingText }} 
			<i class="fa fa-spinner fa-spin"></i>
		</h3>
	</div>
</template>
<script>
	export default{
		props: {
			loadingText: '',
		}
	}
</script>
<style>
	#loading {
		display:inline-block;
  		margin-left: 30%;
  		min-width: 33%;
	}
	.modal {
		display:block;
	}
	#loading h3{
	}
</style>