<template>
	<div id="payments">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista jazd
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showDriveAddEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                <h3 v-show="!isLoading && !drives">Brak jazd</h3>	
    		    <table v-show="drives" class="table table-striped">
    		        <tr>
    		            <th>Id</th>
    		            <th>Płatnik</th>
    		            <th>Kwota</th>
                        <th>Data</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="drive in drives" 
    		            :key="drive.id"
    		        >
    		            <td>{{ drive.id }}</td>
    		            <td>{{  }}</td>
                        <td>{{  }}</td>
    		            <td>{{ drive.date }}</td>
    		            <td>
                            <button  v-if="$auth.check(['drive-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showDriveAddEditForm(drive)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button  v-if="$auth.check(['drive-crud','drive-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deleteDrive(drive)">
                                <i class="fa fa-trash"></i>
                            </button>
    		                <button  v-if="$auth.check(['drive-crud','drive-add'],'perms')" type="button" class="btn btn-sm btn-success" :title="'Dodaj płatność dla '" @click="showDriveAddEditForm(payment)">
    		                    <i class="fa fa-dollar"></i>
    		                </button>
    		            </td>
    		        </tr>
    		    </table>
    		</div>
		</div>
		<DriveAddEditForm  :options="this.drives" ref="DriveAddEditForm" v-show="ShowDriveAddEditForm" @close="closeDriveAddEditForm" />	
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import DriveAddEditForm from './DriveAddEditForm.vue';
    export default {
        components: {
            DriveAddEditForm,
        },
        data() {
            return {
                drives: [],
                costNames: [],
                ShowDriveAddEditForm: false,
                table: [],
                drives2: [
                    [{ 
                        id: 1,
                        user_id: 3,
                        date: "2018-11-27 07:00:00",
                        hours_count: 5,
                        hours:[{
                            id: 1,
                            user_id: 5,
                            count: 3,
                            drive_id: 1
                        },
                        {
                            id: 2,
                            user_id: 8,
                            count: 2,
                            drive_id: 1
                        }],
                    }], 
                ],
                cal: ['hours', '3'].map(e => ({
                    name: e,
                    hours: Array(26).fill(0).map((e, i) => ({
                        index: i*0.5 + 7,
                        selected: false,
                        text:''
                    }))
                })),
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this }) ;
        },
        mounted() {
            this.getDrives();
        },
        methods: {
            getDrives(){
                this.$http({
                    url: 'drive',
                    method: 'GET',
                })
                .then((res) => {
                    this.drives = res.data.drives;
                    this.drivesToTable();
                }, (res) => {
                    console.log('error '+res);
                });    
            },
            showDriveAddEditForm(drive){
                if(drive){
                    console.log(drive);
                    this.$refs.DriveAddEditForm.user = drive.user;
                    this.$refs.DriveAddEditForm.drive = drive;
                    this.$refs.DriveAddEditForm.add = false;
                }
                this.ShowDriveAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeDriveAddEditForm(){
                this.ShowDriveAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            parseDrives(){
                return this.createHoursTh(7,20);
            },
            drivesToTable(){
                Object.keys(this.drives['2018-12-02']).forEach(instructor =>
                        Object.keys(instructor).forEach(drive =>  
                            {
                            console.log(drive[0]);
                            }
                        )
                );
            },
            createHoursTh(start,stop){
                let obj= [];
                for(let j = start;j<stop;j++){
                    obj[j] = [];
                }
                console.log(obj);
                for(let i = 0;i<3;i++){
                    let drive = this.drives[i][0];
                    let hour = (new Date(drive.date)).getHours();
                    obj[hour][drive.user_id] = obj[hour][drive.user_id] || [];
                    obj[hour][drive.user_id].push(drive);
                }
                console.log(obj);
                return obj;
            }
        },
        computed : {
            ...mapState(['isLoading']),
            ...mapGetters(['getUsersByRole','students']),
        }
    }
</script>
<style>
</style>