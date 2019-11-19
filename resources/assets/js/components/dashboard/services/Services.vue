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
    		            <th>Nazwa</th>
    		            <th>Nazwa w adresie www</th>
    		            <th>Opis</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="service in services" 
    		            :key="service.id"
    		        >
    		            <td>{{ service.id }}</td>
    		            <td>{{ service.name }}</td>
                        <td>{{ service.slug }}</td>
    		            <td>{{ service.description }}</td>
    		            <td>
    		                <button  v-if="$auth.check(['service-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showServiceAddEditForm(service)">
    		                    <i class="fa fa-edit"></i>
    		                </button>
    		                <button  v-if="$auth.check(['service-crud','service-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deleteServiceAction(service)">
    		                    <i class="fa fa-trash"></i>
    		                </button>
    		            </td>
    		        </tr>
    		    </table>
    		</div>
		</div>
		<ServiceAddEditForm  ref="ServiceAddEditForm" v-show="ShowServiceAddEditForm" @close="closeServiceAddEditForm" />	
	</div>
</template>
<script>
	import { mapState, mapGetters, mapActions } from 'vuex';
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
                name : 'Service',
				ShowServiceAddEditForm : false,
			}
		},
		created() {
            //this.$store.dispatch("fetchServices", { self: this });
            this.fetchServices();
        },
        methods: {
            ...mapActions(['deleteService','fetchServices', 'deleteEntry']),
        	getData(){
                this.services = this.$store.getters.services;
                //this.users = this.$store.state.users;
			},
            showServiceAddEditForm(service){
            	let form = this.$refs.ServiceAddEditForm;
                form.add = service ? false : true;
                form.service = service ? service : {...form.serviceOriginal};
                this.ShowServiceAddEditForm = true;
                $('body').addClass('modal-open');
                console.log(service);
            },
            closeServiceAddEditForm(){
                this.ShowServiceAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            deleteServiceAction(service){
                if(confirm('Usunąć '+service.name+' ?')){
                    console.log(service);
                    //this.$store.dispatch("deleteService", service);
                    //this.deleteService(service);
                    this.deleteEntry({model:'Service', obj:service});
                }
            }
        },
        computed :{
        	...mapState(['services','isLoading']),
        	...mapGetters(['services']),
        },
	}
</script>
<style>

</style>