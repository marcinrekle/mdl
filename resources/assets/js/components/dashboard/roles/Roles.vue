<template>
	<div id="drives">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista jazd 
                    <button @click="driveToCal('prev')">
                        <i class="fa fa-caret-left"></i>
                    </button>
                    <datepicker @selected="selectedDate" v-model="date" :format="'yyyy-MM-dd'" :language="pl" :bootstrap-styling="true" :wrapper-class="'d-inline-block'"></datepicker>
                    <button @click="driveToCal('next')">
                        <i class="fa fa-caret-right"></i>
                    </button>
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showDriveAddEditForm()">
                        <i class="fa fa-user-plus"></i>
                    </button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <div class="row">
                    <div class="col">
                        <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                        <h3 v-show="!isLoading && !drives">Brak jazd</h3>
                    </div>
                </div>
                <div class="row">
                    <div v-if="fixedCol" class="col-2 table-responsive">
                        <table class="table table-striped">
                            <tbody>    
                                <tr>
                                    <th>Godz</th>
                                </tr>
                                <tr v-for="(item,index) in cal[0].hours">
                                    <td
                                    :key="'hours' + index"
                                    :class=""
                                    :style=""
                                    >
                                        {{cal[0].hours[index].text}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div :class="[fixedCol ? 'col-10':'col-12', 'table-responsive']">
                        <table class="table table-striped table-borderless">
                            <tbody>    
                                <tr>
                                    <th class="w-33" v-for="col in cal" :test="col.name">{{col.name=='hours' ? 'Godz':getUserById(parseInt(col.name)).name}}</th>
                                </tr>
                                <tr v-for="(item,index) in cal[0].hours">
                                    <td v-for="col in cal"
                                    :key="col.name + col.hours[index].index"
                                    :class="[col.hours[index].class,{ hours : col.name=='hours', selected: col.hours[index].selected, drive: col.hours[index].drive }]"
                                    :style="col.hours[index].style" 
                                    :drive-id="col.hours[index].drive_id" 
                                    @click="$auth.check(['drive-crud','drive-create'],'perms') ? showDriveAddEditForm(col.hours[index],col.name):{}"
                                    >
                                        <b>{{col.hours[index].text}}</b> 
                                        <span v-if="col.hours[index].hour_count!=undefined" class="hour-info">
                                            <i class="fa fa-clock-o"></i>
                                            {{ col.hours[index].hour_count }}
                                        </span>
                                        <button v-if="$auth.check(['drive-crud','drive-delete'],'perms') && col.hours[index].deleteBtn" type="button" class="btn btn-sm btn-danger float-right" title="Usuń" @click.stop="deleteDrive(col.hours[index])">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button v-if="col.hours[index].hourFormBtn" type="button" class="btn btn-sm btn-success float-right" title="Dodaj/Edytuj" @click.stop="showHourAddEditForm(col.hours[index])">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
		<DriveAddEditForm ref="DriveAddEditForm" :instructors="this.instructors" :students="this.students" v-show="ShowDriveAddEditForm" @close="closeDriveAddEditForm" />
        <HourAddEditForm ref="HourAddEditForm" :students="this.students" v-show="ShowHourAddEditForm" @close="closeHourAddEditForm" />
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import RoleAddEditForm from './RoleAddEditForm.vue';
    import HourAddEditForm from './RolePermissionsForm.vue';
    export default {
        components: {
            RoleAddEditForm,
            RolePermissionsForm,
        },
        data() {
            return {
                ShowRoleAddEditForm: false,
                ShowRolePermissionsForm: false,
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this }) ;
        },
        mounted() {
            this.$store.state.users.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchData", { self: this });
                },200) : this.$store.dispatch("fetchData", { self: this });
        },
        methods: {
            showRoleAddEditForm(e){
                this.ShowRoleAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeRoleAddEditForm(){
                this.ShowRoleAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            closeRolePermissionsForm(){
                this.ShowRolePermissionsForm = false;
                $('body').removeClass('modal-open');
            },
            deleteRole(role){
                console.log('delete',role);
                let confirmed = confirm('Usunąć '+role.name+' ?');
                if(confirmed){    
                    this.$http({
                        url: 'role/'+role.id,
                        method: 'DELETE'
                    }).then((res) => {
                        console.log(res.data);
                        this.$store.commit('deleterole',role.name);
                    }, (res) => {
                        console.log('error'+res);
                    });
                }
            }
        },
        computed : {
            ...mapState(['isLoading','roles']),
            ...mapGetters([]),
            instructorMap(){
                return new Map(this.instructors.map((e,i)=>([e.id,i+1])));
            },
            formatDate(){
                return this.$moment(this.date).format('YYYY-MM-DD');
            }
        },
        
    }
</script>
<style>
.table th, .table td{
    padding:0.1rem;
}
</style>