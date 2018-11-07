<template>
    <div id="editUserModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowego użytkownika' : "Edycja " + user.name }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeUser() : updateUser()" method="post"> 
                        <div class="form-group">
                            <label for="name">Imie Nazwisko</label>
                            <input type="name" id="name" class="form-control" placeholder="Jan Nowak" v-model="user.name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="user.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Hasło</label>
                            <input type="password" id="password" class="form-control" min="6" max="64" placeholder="Haslo" v-model="user.password" :required="add">
                        </div>
                        <div class="form-group">
                            <label for="role">Rola</label>
                            <select class="form-control" id="role" v-model="user.roles[0]" required>
                                <option 
                                    v-for="role in this.$parent.roles" 
                                    required  
                                    :value="role"
                                >
                                        {{role.display_name}}
                                </option>
                            </select>
                        </div>
                        <div 
                            class="form-group" 
                            v-for="field in this.$parent.fields" 
                            :key="field.id"
                        >
                            <label :for="field.name">{{field.slug}}</label>
                            <input 
                                :type="field.type" 
                                :id="field.name" 
                                v-bind="field.options.attr" 
                                v-model="user.attrs.values[field.name]" 
                            >
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" placeholder="Status" v-model="user.status" required>
                                <option value="active">Aktywny</option>
                                <option value="disabled">Nieaktywny</option>
                            </select>
                        </div>
                        <button 
                            type="submit" 
                            class="btn btn-primary"
                        >
                            {{ this.add ? 'Dodaj' : 'Aktualizuj' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click="close">Anuluj</button>
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
                user: {
                    id:'',
                    name:'',
                    email:'',
                    password: '',
                    attrs : {'values' : {}},
                    roles: [],
                    avatar:'',
                    confirmed:'0',
                    status:'active',
                },
                error: [],
                add: true,
                userOriginal: '',
                userCached: ''
            }
        },
        mounted() {
            this.userOriginal = this.user;
        },
        methods: {
            close(){
                this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                this.user = this.add ?  Object.assign({},this.userOriginal) : Object.assign({},this.userCached);
            },
            submitForm(){
                console.log('submitForm');
            },
            storeUser(){
                console.log('storeUser');
                this.$http({
                    url: 'user',
                    method: 'POST',
                    data: this.user
                }).then((res) => {
                    console.log(res.data);
                    this.$parent.users.push(res.data.user);
                }, (res) => {
                    console.log('error'+res);
                });
            },
            updateUser(){
                console.log('updateUser');
                this.$http({
                    url: 'user/'+this.user.id,
                    method: 'PATCH',
                    data: this.user
                }).then((res) => {
                    console.log(res.data);
                }, (res) => {
                    console.log('error'+res);
                });
            }
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>