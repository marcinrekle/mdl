<template>
	<div id="users">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Użytkownicy
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showUserEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
    			<div class="input-group mb-3">
  					<div class="btn-group">
    					<button 
    						v-for="role in roles"
    						:class="['btn', roleShow[role.name] ? 'btn-success' : 'btn-danger']" 
    						@click="roleShow[role.name] = roleShow[role.name] ? 0 : 1"
    						type="button"
    					>
    							{{role.display_name}}
    					</button>
  					</div>
				</div>
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
    		            v-show="roleShow[user.roles[0].name]"
    		            :role="roleShow[user.roles[0].name]"
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
		<UserEditForm  ref="UserEditForm" v-show="ShowUserEditForm" @close="closeUserEditForm" />	
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
				fields: [],
				roles: [],
				ShowUserEditForm : false,
				roleShow : {'Su' : 0,'Admin' : 0,'Instructor' : 0,'Officce' : 0,'Student' : 1, }
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
                    this.fields = res.data.fields;
                    this.roles = res.data.roles;
                }, (res) => {
                    console.log('error '+res);
                });
			},
            deleteUser(user) {
                let confirmed = confirm('Usunąć '+user.name+' ?');
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
            	console.log(user);
                if(user != undefined){
					this.$refs.UserEditForm.userCached = Object.assign({},user);
					this.$refs.UserEditForm.user = user;
                	this.$refs.UserEditForm.add = false;
                }else{
                	this.$refs.UserEditForm.user = Object.assign({},this.$refs.UserEditForm.userOriginal);
                	this.$refs.UserEditForm.add = true;
                }
                this.ShowUserEditForm = true;
                $('body').addClass('modal-open');
            },
            closeUserEditForm(){
            	this.ShowUserEditForm = false;
                $('body').removeClass('modal-open');
            }
        }
	}
</script>
<style>

</style>