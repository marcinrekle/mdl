<template>
    <div id="RoleAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej roli' : "Edycja roli" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeRole() : updateRole()" method="post"> 
                        <div class="form-group">
                            <label for="name">Nazwa</label>
                            <input type="text" ref="name" id="name" class="form-control" v-model="role.name" required autofocus/>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Nazwa wyświetlana</label>
                            <input type="text" ref="display_name" id="display_name" class="form-control" v-model="role.display_name" required />
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
                },
                error: [],
                add: false,
                roleOriginal: '',
                roleCached: '',
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
            storeHour(){
                console.log('storeHour');
                this.processing = true;
                this.$http({
                    url: 'hour',
                    method: 'POST',
                    data: this.hour
                }).then((res) => {
                    console.log(res.data);
                    //this.$store.commit('updateHour',res.data.hour);
                    //this.$parent.driveToCal('current',1);
                    this.processing = false;
                    this.close();
                    //add notify
                }, (res) => {
                    this.processing = false;
                    console.log('error'+res);
                    this.close();
                });
            },
            updateHour(){
                this.processing = true;
                console.log('updateHour',this.hour);
                this.$http({
                    url: 'hour/'+this.hour.id,
                    method: 'PUT',
                    data: this.hour
                }).then((res) => {
                    this.processing = false;
                    console.log(res.data);
                    if(this.driveHourIdx>-1){
                        this.$store.commit('updateHourInDrive',res.data.hour);
                        this.$parent.driveToCal('current',1);
                    }else{
                        this.$store.commit('updateHour',res.data.hour);
                    };
                    this.close();
                }, (res) => {
                    this.processing = false;
                    console.log('error'+res);
                    this.close();
                });
            },
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>