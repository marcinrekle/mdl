<template>
	<nav class="col-md-2 d-none d-md-block sidebar">
		<div class="sidebar-sticky">
			<ul class="nav flex-column">
				<li class="nav-item" v-for="(link,index) in permittedLinks">
					<router-link :to="link.path" class="nav-link">
						<i :class="link.icon"></i>
						{{ link.name }}
					</router-link>
				</li>
        <li class="nav-item">
          <a class="nav-link" v-if="$auth.check()" @click="$auth.logout()">
            <i class="fa fa-sign-out-alt"></i>
            Wyloguj
          </a>
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
      					name: 'Panel główny',
      					icon: 'fa fa-tachometer',
      					path: '/dashboard',
                perms: ''
    				},
    				{
      					name: 'Użytkownicy',
      					icon: 'fa fa-users',
      					path: '/user',
                perms: ['user-retrive','user-crud']
    				},
    				{
      					name: 'Płatności',
      					icon: 'fa fa-dollar',
      					path: '/payment',
                perms: ['payment-retrive','payment-crud']
    				},
            {
                name: 'Jazdy',
                icon: 'fa fa-car',
                path: '/drive',
                perms: ['drive-retrive','drive-crud']
            },{
                name: 'Godziny',
                icon: 'fa fa-clock-o',
                path: '/hour',
                perms: ['hour-retrive','hour-retrive-own']
            },{
                name: 'Role',
                icon: 'fa fa-cog',
                path: '/role',
                perms: ['role-retrive','role-crud']
            },{
                name: 'Uprawnienia',
                icon: 'fa fa-cogs',
                path: '/permissions',
                perms: ['permission-retrive','permission-crud']
            },
  				]
			}
		},
    computed: {
      permittedLinks() {
        return this.sidebarLinks.filter(elem => this.perms(elem.perms));
      }
    },
    methods: {
      perms(perm) {
        if(perm=='') return true;
        //return this.$auth.user().perms.includes(perm);
        return this.$auth.check(perm,'perms');
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