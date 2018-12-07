<template>
	<div id="users">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Użytkownicy
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showUserEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
				<loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
    			<div v-show="users" class="input-group mb-3">
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
    		    <h3 v-show="!isLoading && !users">Brak użytkowników</h3>
    		    <table v-show="users" class="table table-striped">
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
    		                <button  v-if="$auth.check(['user-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showUserEditForm(user)">
    		                    <i class="fa fa-edit"></i>
    		                </button>
    		                <button  v-if="$auth.check(['user-crud','user-delete',user.roles[0].name+'-crud'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deleteUser(user)">
    		                    <i class="fa fa-trash"></i>
    		                </button>
    		                <button  v-if="$auth.check(['payment-crud','payment-add'],'perms') && user.roles[0].name=='Student'" type="button" class="btn btn-sm btn-success" title="Dodaj płatność" @click="showPaymentAddEditForm(user)">
    		                    <i class="fa fa-dollar"></i>
    		                </button>
    		                <button  v-if="$auth.check(['drive-crud','drive-add'],'perms') && (user.roles[0].name=='Student' || user.roles[0].name=='Instructor' )" type="button" class="btn btn-sm btn-success" title="Dodaj jazdę" @click="alert('a')">
    		                    <i class="fa fa-car"></i>
    		                </button>
    		            </td>
    		        </tr>
    		    </table>
    		</div>
		</div>
		<UserEditForm  ref="UserEditForm" v-show="ShowUserEditForm" @close="closeUserEditForm" />	
		<PaymentAddEditForm  :options="this.students" ref="PaymentAddEditForm" v-show="ShowPaymentAddEditForm" @close="closePaymentAddEditForm" />	
	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex';
	import UserEditForm from './UserEditForm.vue';
	import PaymentAddEditForm from '../payments/PaymentAddEditForm.vue';
	export default{
		components: {
			UserEditForm,
			PaymentAddEditForm,
		},
		data() {
			return {
				//users: [],
				//fields: [],
				//roles: [],
				ShowUserEditForm : false,
				ShowPaymentAddEditForm : false,
				roleShow : {'Su' : 0,'Admin' : 0,'Instructor' : 0,'Officce' : 0,'Student' : 1, }
			}
		},
		created() {
            this.$store.dispatch("fetchData", { self: this });
        },
        methods: {
        	getData(){
                this.users = this.$store.getters.getUsers;
                //this.users = this.$store.state.users;
                this.fields = this.$store.state.fields;
                this.roles = this.$store.state.roles;
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
            },
            showPaymentAddEditForm(user){
            	console.log(user);
                this.$refs.PaymentAddEditForm.user = user;
                this.$refs.PaymentAddEditForm.payment.user_id = user.id;
                this.ShowPaymentAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closePaymentAddEditForm(){
            	this.ShowPaymentAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            showUserProfile(){},
            closeUserProfile(){},
        },
        computed :{
        	...mapState(['users','fields','roles','isLoading']),
        	...mapGetters(['getUsersByRole','students']),
        },
	}
</script>
<style>

</style>