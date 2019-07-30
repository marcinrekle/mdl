<template>
	<nav class="" id="sidebar">
		<div class="">
      Witaj <h3>{{$auth.user().name}}</h3>
      <br>
			<ul class="nav flex-column">
				<li class="nav-item" v-for="(link,index) in permittedLinks">
					<router-link :to="link.path" class="nav-link">
						<i :class="link.icon"></i>
						{{ link.name }}
					</router-link>
				</li>
        <li class="nav-item">
          <a class="nav-link" v-if="$auth.check()" @click="$auth.logout()">
            <i class="fa fa-sign-out"></i>
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
                path: '/permission',
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
    mounted:function(){
      $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
      });
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
  		/* box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); */
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

 #sidebarCollapse {
    width: 40px;
    height: 40px;
    background: #f5f5f5;
  }
  
  #sidebarCollapse span {
      width: 80%;
      height: 2px;
      margin: 0 auto;
      display: block;
      background: #555;
      transition: all 0.8s cubic-bezier(0.810, -0.330, 0.345, 1.375);
  }
  #sidebarCollapse span:first-of-type {
      /* rotate first one */
      transform: rotate(45deg) translate(2px, 2px);
  }
  #sidebarCollapse span:nth-of-type(2) {
      /* second one is not visible */
      opacity: 0;
  }
  #sidebarCollapse span:last-of-type {
      /* rotate third one */
      transform: rotate(-45deg) translate(1px, -1px);
  }
  #sidebarCollapse.active span {
      /* no rotation */
      transform: none;
      /* all bars are visible */
      opacity: 1;
      margin: 5px auto;
  }
  .wrapper {
      display: flex;
      align-items: stretch;
      perspective: 1500px; 
  }
  
  #sidebar {
      min-width:200px;
      max-width:200px;
      transition: all 0.6s cubic-bezier(0.945, 0.020, 0.270, 0.665);
      transform-origin: center left; /* Set the transformed position of sidebar to center left side. */
  }
  
  #sidebar.active {
      margin-left: -200px;
      transform: rotateY(100deg); /* Rotate sidebar vertically by 100 degrees. */
  }
  @media (max-width: 768px) {
    /* Reversing the behavior of the sidebar: 
       it'll be rotated vertically and off canvas by default, 
       collapsing in on toggle button click with removal of 
       the vertical rotation.   */
    #sidebar {
        margin-left: -250px;
        transform: rotateY(100deg);
    }
    #sidebar.active {
        margin-left: 0;
        transform: none;
    }
    /* Reversing the behavior of the bars: 
       Removing the rotation from the first,
       last bars and reappear the second bar on default state, 
       and giving them a vertical margin */
    #sidebarCollapse span:first-of-type,
    #sidebarCollapse span:nth-of-type(2),
    #sidebarCollapse span:last-of-type {
        transform: none;
        opacity: 1;
        margin: 5px auto;
    }
    /* Removing the vertical margin and make the first and last bars rotate again when the sidebar is open, hiding the second bar */
    #sidebarCollapse.active span {
        margin: 0 auto;
    }
    #sidebarCollapse.active span:first-of-type {
        transform: rotate(45deg) translate(2px, 2px);
    }
    #sidebarCollapse.active span:nth-of-type(2) {
        opacity: 0;
    }
    #sidebarCollapse.active span:last-of-type {
        transform: rotate(-45deg) translate(1px, -1px);
    }
  }
</style>