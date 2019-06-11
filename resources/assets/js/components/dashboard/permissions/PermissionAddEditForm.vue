<template>
    <div id="PermissionAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie uprawnienia' : "Edycja uprawnienia" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storePermission() : updatePermission()" method="post"> 
                        <div class="form-group">
                            <label for="name">Nazwa</label>
                            <input type="text" ref="name" id="name" class="form-control" v-model="permission.name" required autofocus/>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Nazwa wyświetlana</label>
                            <input type="text" ref="display_name" id="display_name" class="form-control" v-model="permission.display_name" required />
                        </div>
                        <div class="form-group">
                            <label for="description">Opis</label>
                            <textarea ref="description" id="description" class="form-control" v-model="permission.description" />
                        </div>
                        <div class="form-group">
                            <label for="groupName">Nazwa grupy</label>
                            <input type="text" ref="groupName" id="groupName" class="form-control" v-model="permission.groupName" />
                        </div>
                        <button 
                            type="submit" 
                            class="btn btn-primary"
                        >
                            {{ this.add ? 'Dodaj' : 'Aktualizuj' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click="close">Anuluj</button>
                        <h3 v-if="processing" class="d-inline pl-5">
                            <i class="fa fa-spinner fa-spin"></i>
                        </h3>
                    </form>   
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
    export default{
        props: {
        },
        data() {
            return {
                permission: {
                    id:'',
                    name:'',
                    display_name:'',
                    description:'',
                    groupName:'',
                },
                error: [],
                add: false,
                permissionOriginal: '',
                permissionCached: '',
                processing:false,
            }
        },
        mounted() {
            this.permissionOriginal = this.permission;
        },
        methods: {
            close(){
                //this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                this.permission = this.add ?  Object.assign({},this.permissionOriginal) : Object.assign({},this.permissionCached);
            },
            submitForm(){
                console.log('submitForm');
            },
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>