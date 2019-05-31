<template>
    <div id="RoleAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej roli' : "Edycja roli" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="storeRole()" method="post"> 
                        <div class="form-group">
                            <label for="name">Nazwa</label>
                            <input type="text" ref="name" id="name" class="form-control" v-model="role.name" required autofocus/>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Nazwa wyświetlana</label>
                            <input type="text" ref="display_name" id="display_name" class="form-control" v-model="role.display_name" required />
                        </div>
                        <div class="form-group">
                            <label for="description">Opis</label>
                            <textarea type="text" ref="description" id="description" class="form-control" v-model="role.description" required />
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
        data() {
            return {
                role: {
                    id:'',
                    name:'',
                    display_name:'',
                    description:'',
                },
                error: [],
                add: false,
                roleOriginal: {},
                roleCached: {},
                processing:false,
            }
        },
        mounted() {
            this.roleOriginal = this.role;
        },
        methods: {
            close(){
                //this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                //this.user = this.add ?  Object.assign({},this.hourOriginal) : Object.assign({},this.hourCached);
            },
            submitForm(){
                console.log('submitForm');
            },
            storeRole(){
                this.$store.dispatch("storeRole", { self: this });
            },
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>