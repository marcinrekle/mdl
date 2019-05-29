<template>
    <div id="HourAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Uprawnienia dla {{ this.role }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="updateHour()" method="post"> 
                        <fieldset v-for="(group,key) in permissions">
                            <legend> {{key}} </legend>
                            <div class="form-group" v-for="item in group">
                                <label :for="item.name">{{ item.display_name }}</label>
                                <input type="checkbox" :name="item.name" :value="item.name" :id="item.name" class="form-control" v-model="perms" required/>
                            </div>
                        </fieldset>
                        <button 
                            type="submit" 
                            class="btn btn-primary"
                        >
                            Zatwierdź
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
            permissions: {},
        },
        data() {
            return {
                role:'',
                perms:[],
                error: [],
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