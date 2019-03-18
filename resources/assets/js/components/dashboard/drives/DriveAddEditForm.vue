<template>
    <div id="DrivesAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej jazdy' : "Edycja jazdy" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeDrive() : updateDrive()" method="post"> 
                        <div class="form-group">
                            <label for="user_id">Imie Nazwisko</label>
                            <select name="user_id" id="user_id" class="form-control" v-model="drive.user_id" required>
                                <option v-for="instructor in instructors" :value="instructor.id">{{ instructor.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hours_count">Godzina</label>
                            <input type="number" step="0.5" min="" max="" id="hours_count" class="form-control" v-model="drive.hours_count" required autofocus />
                        </div>
                        <div class="form-group">
                            <label for="date">Data jazdy</label>
                            <input type="datetime-local" id="date" class="form-control" v-model="drive.date" required>
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
        props: {
            instructors: {},
        },
        data() {
            return {
                user: {
                    id:'',
                    name:'',
                },
                drive: {
                    id:'',
                    user_id:'',
                    date:'',
                    hours_count:'',
                },
                error: [],
                add: true,
                driveOriginal: '',
                driveCached: ''
            }
        },
        mounted() {
            this.driveOriginal = this.drive;
        },
        methods: {
            close(){
                this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                this.user = this.add ?  Object.assign({},this.driveOriginal) : Object.assign({},this.driveCached);
            },
            submitForm(){
                console.log('submitForm');
            },
            storeDrive(){
                console.log('storeDrive');
                this.$http({
                    url: 'drive',
                    method: 'POST',
                    data: this.drive
                }).then((res) => {
                    console.log(res.data);
                    //add notify
                }, (res) => {
                    console.log('error'+res);
                });
            },
            updateDrive(){
                console.log('updateDrive');
                this.$http({
                    url: 'drive/'+this.drive.id,
                    method: 'PUT',
                    data: this.drive
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