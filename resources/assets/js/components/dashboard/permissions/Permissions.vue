<template>
	<div id="roles">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista uprawnień 
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showPermissionAddEditForm()">
                        <i class="fa fa-user-plus"></i>
                    </button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <div class="row">
                    <div class="col">
                        <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                        <h3 v-show="!isLoading && !permissions">Brak listy uprawnień</h3>
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
                                    <th>Opis</th>
                                    <th>Nazwa grupy</th>
                                    <th>Opcje</th>
                                </tr>
                                <tr v-for="(item,index) in permissions"
                                    :key="item.id"
                                >
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.display_name }}</td>
                                    <td>{{ item.description }}</td>
                                    <td>{{ item.groupName }}</td>
                                    <td>
                                        <button  v-if="$auth.check(['permission-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showPermissionAddEditForm(item)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button  v-if="$auth.check(['permission-crud','permission-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deletePermission(item)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
		<PermissionAddEditForm ref="PermissionAddEditForm" v-show="ShowPermissionAddEditForm" @close="closePermissionAddEditForm" />
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import PermissionAddEditForm from './PermissionAddEditForm.vue';
    export default {
        components: {
            PermissionAddEditForm,
        },
        data() {
            return {
                ShowPermissionAddEditForm: false,
            }
        },
        created() {
            this.$store.state.permissions.length < 1 && this.$store.dispatch("fetchPermissions", { self: this }) ;
        },
        mounted() {
            this.$store.state.permissions.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchPermissions", { self: this });
                },200) : this.$store.dispatch("fetchPermissions", { self: this });
        },
        methods: {
            showPermissionAddEditForm(permission){
                let form = this.$refs.PermissionAddEditForm;
                form.add = permission ? false : true;
                form.permission = permission ? permission : {...form.permissionOriginal};
                this.ShowPermissionAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closePermissionAddEditForm(){
                this.ShowPermissionAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            deletePermission(permission){
                console.log('delete',permission);
                let confirmed = confirm('Usunąć '+permission.name+' ?');
                if(confirmed){    
                    this.$http({
                        url: 'permission/'+permission.id,
                        method: 'DELETE'
                    }).then((res) => {
                        console.log(res.data);
                        this.$store.commit('deletePermission',permission.name);
                    }, (res) => {
                        console.log('error'+res);
                    });
                }
            }
        },
        computed : {
            ...mapState(['isLoading','permissions']),
            ...mapGetters([]),
        },
        
    }
</script>
<style>
.table th, .table td{
    padding:0.1rem;
}
</style>