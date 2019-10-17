<template>
	<div id="services">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Kursy
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showServiceEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
				<loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
    			<div v-show="services" class="input-group mb-3">
  					
				</div>
    		    <h3 v-show="!isLoading && !services">Brak użytkowników</h3>
    		    <table v-show="services" class="table table-striped">
    		        <tr>
    		            <th>Id</th>
    		            <th>Imie nazwisko</th>
    		            <th>email</th>
    		            <th>Rola</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="service in services" 
    		            :key="service.id"
    		        >
    		            <td>{{ user.id }}</td>
    		            <td>{{ user.name }}</td>
    		            <td>{{ user.email }}</td>
    		            <td>{{ role.display_name }}</td>
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
	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex';
	import ServiceAddEditForm from './ServiceAddEditForm.vue';
	export default{
		components: {
			ServiceAddEditForm,
		},
		data() {
			return {
				//users: [],
				//fields: [],
				//roles: [],
				ShowServiceAddEditForm : false,
			}
		},
		created() {
            this.$store.dispatch("fetchService", { self: this });
        },
        methods: {
        	getData(){
                this.services = this.$store.getters.getServices;
                //this.users = this.$store.state.users;
			},
            showUserEditForm(service){
            	console.log(service);
            },
        },
        computed :{
        	...mapState(['services','isLoading']),
        	...mapGetters(['services','getServicesById']),
        },
	}
</script>
<style>

</style>