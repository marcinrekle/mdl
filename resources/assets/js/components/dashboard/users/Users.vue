<template>
	<div id="users">
		<div class="card">
    		<div class="card-header">
    		    <h1>Dash</h1>
    		    <b>Username:</b> {{ $auth.user().name }}
    		    </div>
    		<div class="card-body">
    		    <table class="table table-striped">
    		        <tr>
    		            <th>Id</th>
    		            <th>Imie nazwisko</th>
    		            <th>email</th>
    		            <th>Rola</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="user in users" 
    		            :key="user.id"
    		        >
    		            <td>{{ user.id }}</td>
    		            <td>{{ user.name }}</td>
    		            <td>{{ user.email }}</td>
    		            <td v-for="role in user.roles">{{ role.display_name }}</td>
    		            <td>
    		                <button type="button" class="btn btn-sm btn-primary" @click="showUserEditForm(user)">
    		                    <i class="fa fa-edit"></i>
    		                </button>
    		                <button type="button" class="btn btn-sm btn-danger" @click="deleteUser(user)">
    		                    <i class="fa fa-trash"></i>
    		                </button>
    		            </td>
    		        </tr>
    		    </table>
    		</div>
		</div>
		<UserEditForm v-show="ShowUserEditForm" @close="ShowUserEditForm = false" />	
	</div>
</template>
<script>
	import UserEditForm from './UserEditForm.vue';
	export default{
		components: {
			UserEditForm,
		},
		data() {
			return {
				users: [],
				ShowUserEditForm : false
			}
		},
		mounted() {
            this.getUsers();
        },
        methods: {
        	getUsers(){
				this.$http({
                    url: 'user',
                    method: 'GET',
                })
                .then((res) => {
                    this.users = res.data.users;
                }, (res) => {
                    console.log('error'+res);
                });
			},
            deleteUser(user) {
                let confirmed = confirm('Skasowac '+user.name+' ?');
                if(confirmed){
                    this.$http({
                        url: 'user/'+user.id,
                        method : 'DELETE'
                    })
                    .then((res) => {
                        this.notify = res.data.message;
                        console.log(res.data.message);
                    }, (res) => {
                    console.log('error : '+res);
                });
                }
            },
            showUserEditForm(user){
                let cuser = this.$children[0].user;
                console.log(cuser);
                console.log(user);
                for(let key in cuser) {
                    cuser[key] = (key == 'attrs' && user[key]!=null ? user[key].values : user[key]);
                }
                console.log(cuser);
                this.ShowUserEditForm = true;
            }
        }
	}
</script>
<style>

</style>