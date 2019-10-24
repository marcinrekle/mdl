<template>
    <div id="editUserModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej usługi' : "Edycja " + service.name }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeService() : updateService()" method="post"> 
                        <div class="form-group">
                            <label for="name">Nazwa</label>
                            <input type="name" id="name" class="form-control" placeholder="Nazwa" v-model="service.name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="slug">Nazwa w adresie www</label>
                            <input type="slug" id="slug" class="form-control" placeholder="service@example.com" v-model="service.slug" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Opis</label>
                            <textarea type="text" ref="description" id="description" class="form-control" v-model="service.description" required />
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
                service: {
                    id:'',
                    name:'',
                    slug:'',
                    description: '',
                },
                error: [],
                add: true,
                serviceOriginal: {},
                serviceCached: {},
                processing:false,
            }
        },
        mounted() {
            this.serviceOriginal = this.service;
        },
        methods: {
            close(){
                this.resetForm();
                this.$emit('close');
            },
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>