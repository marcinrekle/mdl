<template>
	<nav class="col-md-2 d-none d-md-block sidebar">
		<div class="sidebar-sticky">
			<ul class="nav flex-column">
				<li class="nav-item" v-for="(link,index) in sidebarLinks">
					<router-link :to="link.name" class="nav-link">
						<i :class="link.icon"></i>
						{{ link.name }}
					</router-link>
				</li>
			</ul>
		</div>
	</nav>
</template>
<script>
	export default {
		data() {
			return {
				sidebarLinks : [
    				{
      					name: 'Dashboard',
      					icon: 'fa fa-tachometer',
      					path: '/dashboard'
    				},
    				{
      					name: 'Users',
      					icon: 'fa fa-users',
      					path: '/users'
    				},
  				]
			}
		}
	}
</script>
<style>
	.sidebar {
  		position: fixed;
  		top: 0;
  		bottom: 0;
  		left: 0;
  		z-index: 100; /* Behind the navbar */
  		padding: 0;
  		box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
  	}
	.sidebar-sticky {
		position: sticky;
		/* top: 48px; Height of navbar */
  		/* height: calc(100vh - 48px); */
  		padding-top: .5rem;
  		overflow-x: hidden;
  		overflow-y: auto;
	}
	.sidebar .nav-link {
  		font-weight: 500;
  		color: #333;
	}
</style>