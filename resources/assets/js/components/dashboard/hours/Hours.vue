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
                        <h3 v-show="!isLoading && !hours">Brak godzin</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-borderless">
                            <tbody>    
                                <tr>
                                    <th class="">Lp</th>
                                    <th class="">Kursant</th>
                                    <th class="">Instruktor</th>
                                    <th class="">Ilość godzin</th>
                                    <th class="">Data</th>
                                    <th class="">Opcje</th>
                                </tr>
                                <tr v-for="(item,index) in hours.data"
                                    :key="item.id"
                                >
                                    <td>{{ index+1 }}</td>
                                    <td>{{ item.user.name }}</td>
                                    <td>{{ item.drive.user.name }}</td>
                                    <td>{{ item.count }}</td>
                                    <td>{{ item.drive.date }}</td>
                                    <td>
                                        <button  v-if="$auth.check(['hour-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showHourAddEditForm(item)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button  v-if="$auth.check(['hour-crud','hour-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deleteHour(item)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :limit="2" :data="hours" @pagination-change-page="getHours"></pagination>
                    </div>
                </div>
            </div>
		</div>
        <HourAddEditForm ref="HourAddEditForm" :students="this.students" v-show="ShowHourAddEditForm" @close="closeHourAddEditForm" />
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import pagination from 'laravel-vue-pagination';
    import HourAddEditForm from './HourAddEditForm.vue';
    export default {
        components: {
            HourAddEditForm,
            pagination,
        },
        data() {
            return {
                ShowHourAddEditForm: false,
                page: 1,
                forPage:30,
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
            showHourAddEditForm(hour){
                //let drive = this.getDriveById(hour.drive_id);
                //console.log('---showHourAddEditForm --- e drive',e,drive);
                //let add = hour.drive_id == '0' ? true:false;
                this.$refs.HourAddEditForm.hour.id = hour.id;
                this.$refs.HourAddEditForm.hour.count = hour.count;
                this.$refs.HourAddEditForm.hour.user_id = hour.user_id;
                this.$refs.HourAddEditForm.hour.drive_id = hour.drive_id;
                this.ShowHourAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeHourAddEditForm(){
                this.ShowHourAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            getHours(page = 1){
                this.page = page;
                this.$store.dispatch("fetchHours", { self: this });
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