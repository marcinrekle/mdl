<template>
    <div id="HourAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie ilości godzin' : "Edycja ilości godzin" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeHour() : updateHour()" method="post"> 
                        <div class="form-group">
                            <label for="user_id">Kursant</label>
                            <select name="user_id" id="user_id" class="form-control" v-model="hour.user_id" required>
                                <option v-for="student in students" :value="student.id">{{ student.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="count">Ilość godzin</label>
                            <input type="number" ref="count" step="0.5" min="0" max="12" id="count" class="form-control" v-model="hour.count" required autofocus/>
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
                hour: {
                    id:'',
                    user_id:'',
                    count:'',
                    drive_id:'',
                },
                error: [],
                add: false,
                hourOriginal: '',
                hourCached: '',
                processing:false,
            }
        },
        mounted() {
            this.hourOriginal = this.hour;
        },
        methods: {
            close(){
                //this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                this.user = this.add ?  Object.assign({},this.hourOriginal) : Object.assign({},this.hourCached);
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
                    //this.$store.commit('updateHour',res.data.hour);
                    //this.$parent.driveToCal('current',1);
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