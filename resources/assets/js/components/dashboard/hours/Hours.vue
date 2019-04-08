<template>
	<div id="drives">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista godzin kursantów 
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showHourAddEditForm()">
                        <i class="fa fa-user-plus"></i>
                    </button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <div class="row">
                    <div class="col">
                        <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                        <h3 v-show="!isLoading && !hours">Brak jazd</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-borderless">
                            <tbody>    
                                <tr>
                                    <th class="w-33"></th>
                                </tr>
                                <tr v-for="(item,index) in hours">
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
        <HourAddEditForm ref="HourAddEditForm" :students="this.students" v-show="ShowHourAddEditForm" @close="closeHourAddEditForm" />
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import HourAddEditForm from './HourAddEditForm.vue';
    export default {
        components: {
            HourAddEditForm,
        },
        data() {
            return {
                ShowHourAddEditForm: false,
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this }) ;
        },
        mounted() {
            this.$store.state.users.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchHours", { self: this });
                },200) : this.$store.dispatch("fetchHours", { self: this });
        },
        methods: {
            showHourAddEditForm(e){
                let drive = this.getDriveById(e.drive_id);
                console.log('---showHourAddEditForm --- e drive',e,drive);
                //let add = e.drive_id == '0' ? true:false;
                this.$refs.HourAddEditForm.hour.id = drive.hours[e.hour_idx].id;
                this.$refs.HourAddEditForm.hour.count = drive.hours[e.hour_idx].count;
                this.$refs.HourAddEditForm.hour.user_id = drive.hours[e.hour_idx].user_id;
                this.$refs.HourAddEditForm.hour.drive_id = drive.id;
                this.$refs.HourAddEditForm.driveHourIdx = e.hour_idx;
                this.ShowHourAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeHourAddEditForm(){
                this.ShowHourAddEditForm = false;
                $('body').removeClass('modal-open');
            },
        },
        computed : {
            ...mapState(['isLoading','hours']),
            ...mapGetters(['getUserById','getUsersByRole','students','instructors']),
        },
    }
</script>
<style>
</style>