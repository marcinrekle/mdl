<template>
    <div class="panel panel-default">
        <div class="panel-heading">
        <h1>Dash</h1>
        <b>Username:</b> {{ $auth.user().name }}
            <nav>
                <ul class="list-inline">
                    <li>
                        <router-link :to="{ name: 'home' }">Home</router-link>
                    </li>
                    <li v-if="!$auth.check()" class="pull-right">
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>
                    <li v-if="!$auth.check()" class="pull-right">
                        <router-link :to="{ name: 'register' }">Register</router-link>
                    </li>
                    <li v-if="$auth.check()" class="pull-right">
                        <a href="#" @click.prevent="$auth.logout()">Logout</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="panel-body">
        	<table class="table table-stripped">
        		<tr>
        			<th>Id</th>
        			<th>Imie nazwisko</th>
        			<th>email</th>
        		</tr>
        		<tr v-for="user in users">
        			<td>{{ user.id }}</td>
        			<td>{{ user.name }}</td>
        			<td>{{ user.email }}</td>
        		</tr>
        	</table>
        </div>
    </div>
</template>
<script>
	export default{
		data() {
			return {
				users: []
			}
		},
		mounted() {
            this.getUsers();
            console.log('Dashboard rulezzz!.')
        },
		methods: {
			getUsers(){
				this.$http({
                    url: 'user',
                    method: 'GET',
                })
                .then((res) => {
                    this.users = res.data;
                }, (res) => {
                    console.log('error'+res);
                });
			}
		}
	}
</script>