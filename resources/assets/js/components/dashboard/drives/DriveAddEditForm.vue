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
                            <label for="user_id">Instruktor</label>
                            <select name="user_id" id="user_id" class="form-control" v-model="drive.user_id" required>
                                <option v-for="instructor in instructors" :value="instructor.id">{{ instructor.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Data jazdy</label>
                            <input type="datetime-local" id="date" class="form-control" v-model="drive.date" required>
                        </div>
                        <div class="form-group">
                            <label for="hours_count">Ilość godzin</label>
                            <input type="number" ref="hours_count" step="0.5" min="0" max="12" id="hours_count" class="form-control" v-model="drive.hours_count" required autofocus/>
                        </div>
                        <div class="form-group">
                            <label for="s_user_id">Kursant(ci)</label>
                            <select name="s_user_id" id="s_user_id" class="form-control" v-model="drive.s_user_id" multiple required>
                                <option v-for="student in students" :value="student.id" :disabled="drive.s_user_id.length>=2 && !drive.s_user_id.includes(student.id)">{{ student.name }}</option>
                            </select>
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
            instructors: {},
            students: {},
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
                    s_user_id:[],
                },
                error: [],
                add: true,
                driveOriginal: '',
                driveCached: '',
                processing:false,
            }
        },
        mounted() {
            this.driveOriginal = this.drive;
        },
        methods: {
            close(){
                //this.resetForm();
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
                this.processing = true;
                this.$http({
                    url: 'drive',
                    method: 'POST',
                    data: this.drive
                }).then((res) => {
                    console.log(res.data);
                    this.$store.commit('updateDrive',res.data.drive);
                    this.$parent.driveToCal('current',1);
                    this.processing = false;
                    this.close();
                    //add notify
                }, (res) => {
                    this.processing = false;
                    console.log('error'+res);
                    this.close();
                });
            },
            updateDrive(){
                this.processing = true;
                console.log('updateDrive',this.drive);
                this.$http({
                    url: 'drive/'+this.drive.id,
                    method: 'PUT',
                    data: this.drive
                }).then((res) => {
                    this.processing = false;
                    console.log(res.data);
                    this.$store.commit('updateDrive',res.data.drive);
                    this.$parent.driveToCal('current',1);
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