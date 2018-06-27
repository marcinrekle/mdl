<template>
    <div class="panel panel-default">
        <div class="panel-heading">
        <h1>Dash</h1>
        <b>Username:</b> {{ $auth.user().name }}
        </div>
        <div class="panel-body">
        	<table class="table table-stripped">
        		<tr>
        			<th>Id</th>
        			<th>Imie nazwisko</th>
        			<th>email</th>
        			<th>Rola</th>
        		</tr>
        		<tr v-for="user in users">
        			<td>{{ user.id }}</td>
        			<td>{{ user.name }}</td>
        			<td>{{ user.email }}</td>
        			<td v-for="role in user.roles">{{ role.display_name }}</td>
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