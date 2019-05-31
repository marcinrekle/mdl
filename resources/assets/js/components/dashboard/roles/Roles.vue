<template>
	<div id="roles">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista ról 
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showRoleAddEditForm()">
                        <i class="fa fa-user-plus"></i>
                    </button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <div class="row">
                    <div class="col">
                        <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                        <h3 v-show="!isLoading && !roles">Brak ról</h3>
                    </div>
                </div>
                <div class="row">
                    <div :class="['col-12','table-responsive']">
                        <table class="table table-striped table-borderless">
                            <tbody>    
                                <tr>
                                    <th>Lp</th>
                                    <th>Nazwa</th>
                                    <th>Nazwa wyświetlana</th>
                                    <th>Opcje</th>
                                </tr>
                                <tr v-for="(item,index) in roles"
                                    :key="item.id"
                                >
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.display_name }}</td>
                                    <td>
                                        <button  v-if="$auth.check(['role-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showRoleAddEditForm(item)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button  v-if="$auth.check(['role-crud','role-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deleteRole(item)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button  v-if="$auth.check(['role-perms-set'],'perms')" type="button" class="btn btn-sm btn-success" title="Uprawnienia" @click="openRolePermissionsForm(item.name)">
                                            Uprawnienia
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
		<RoleAddEditForm ref="RoleAddEditForm" v-show="ShowRoleAddEditForm" @close="closeRoleAddEditForm" />
        <RolePermissionsForm ref="RolePermissionsForm" :permissions="this.permissions" v-show="ShowRolePermissionsForm" @close="closeRolePermissionsForm" />
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import RoleAddEditForm from './RoleAddEditForm.vue';
    import RolePermissionsForm from './RolePermissionsForm.vue';
    export default {
        components: {
            RoleAddEditForm,
            RolePermissionsForm,
        },
        data() {
            return {
                ShowRoleAddEditForm: false,
                ShowRolePermissionsForm: false,
                roleWithPerms:'',
            }
        },
        created() {
            this.$store.state.roles.length < 1 && this.$store.dispatch("fetchRoles", { self: this }) ;
            this.$store.state.permissions.length < 1 && this.$store.dispatch("fetchPerms", { self: this }) ;
        },
        mounted() {
            this.$store.state.roles.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchRoles", { self: this });
                },200) : this.$store.dispatch("fetchRoles", { self: this });
        },
        methods: {
            showRoleAddEditForm(role){
                let form = this.$refs.RoleAddEditForm;
                form.add = role ? false : true;
                form.role = role ? role : {...form.roleOriginal};
                this.ShowRoleAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeRoleAddEditForm(){
                this.ShowRoleAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            closeRolePermissionsForm(){
                this.ShowRolePermissionsForm = false;
                $('body').removeClass('modal-open');
            },
            openRolePermissionsForm(role){
                this.ShowRolePermissionsForm = true;
                $('body').addClass('modal-open');
                let form = this.$refs.RolePermissionsForm;
                form.role = role;
                form.perms = this.roleWithPerms[role];
            },
            deleteRole(role){
                console.log('delete',role);
                let confirmed = confirm('Usunąć '+role.name+' ?');
                if(confirmed){    
                    this.$http({
                        url: 'role/'+role.id,
                        method: 'DELETE'
                    }).then((res) => {
                        console.log(res.data);
                        this.$store.commit('deleterole',role.name);
                    }, (res) => {
                        console.log('error'+res);
                    });
                }
            }
        },
        computed : {
            ...mapState(['isLoading','roles','permissions']),
            ...mapGetters([]),
        },
        
    }
</script>
<style>
.table th, .table td{
    padding:0.1rem;
}
</style>