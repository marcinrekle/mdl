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
                                    @click="showDriveAddEditForm(col.hours[index],col.name)"
                                    >
                                        {{col.hours[index].text}}
                                        <button v-if="$auth.check(['drive-crud','drive-delete'],'perms') && col.hours[index].deleteBtn" type="button" class="btn btn-sm btn-danger float-right" title="Usuń" @click.stop="deleteDrive(col.hours[index])">
                                            <i class="fa fa-trash"></i>
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
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import DriveAddEditForm from './DriveAddEditForm.vue';
    import Datepicker from 'vuejs-datepicker';
    import {pl} from 'vuejs-datepicker/dist/locale';
    export default {
        components: {
            DriveAddEditForm,
            Datepicker,
        },
        data() {
            return {
                pl:pl,
                fixedCol:false,
                ShowDriveAddEditForm: false,
                date: this.$moment().format('YYYY-MM-DD'),
                instructorMap1: {'3':1,'7':2},
                instructorMap2: {},
                hourMap: new Map(Array(26).fill(0).map((e, i) => ([ ('0'+Math.floor(i*0.5+7)).slice(-2) + (i%2 == 0 ? ':00' : ':30'),i]))),
                hours: Array(26).fill(0).map((e, i) => ({
                            index: i*0.5 + 7,
                            hour: ('0'+Math.floor(i*0.5+7)).slice(-2) + (i%2 == 0 ? ':00' : ':30'),
                            selected: false,
                            drive: false,
                            drive_id: 0,
                            style: '',
                            text:' ',
                            class: '',
                        })),
                cal: ['hours'].map((e,i) => ({
                        name: e,
                        hours: e=='hours' ? Array(26).fill(0).map((e, i) => ({text:Math.floor(i*0.5+7) + (i%2 == 0 ? ':00' : ':30')})) : Array(26).fill(0).map((e, i) => ({
                            index: i*0.5 + 7,
                            hour: ('0'+Math.floor(i*0.5+7)).slice(-2) + (i%2 == 0 ? ':00' : ':30'),
                            selected: false,
                            drive: false,
                            drive_id: 0,
                            style: '',
                            text:'',
                            class: '',
                        }))
                })),
                cal2:[],
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this }) ;
        },
        mounted() {
            this.$store.state.users.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchDrives", { self: this });
                },200) : this.$store.dispatch("fetchDrives", { self: this });
        },
        methods: {
            showDriveAddEditForm(e,instructor_id){
                let drive = this.getDriveById(e.drive_id);
                let add = e.drive_id == '0' ? true:false;
                this.$refs.DriveAddEditForm.processing = false;
                this.$refs.DriveAddEditForm.add = add;
                this.$refs.DriveAddEditForm.user = this.getUserById(parseInt(instructor_id));
                this.$refs.DriveAddEditForm.drive.id = add ? null:drive.id;
                this.$refs.DriveAddEditForm.drive.user_id = add ? parseInt(instructor_id):drive.user_id;
                this.$refs.DriveAddEditForm.drive.date=this.$moment(add?this.formatDate+'T'+e.hour:drive.date).format('YYYY-MM-DDTHH:mm');
                this.$refs.DriveAddEditForm.drive.hours_count = add ? 0:drive.hours_count;
                this.$refs.DriveAddEditForm.drive.s_user_id = add ? []:drive.hours.map(hour => hour.user_id);
                this.ShowDriveAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closeDriveAddEditForm(){
                this.ShowDriveAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            driveToCal(date,interval){
                console.log('---Start driveToCal()---',date,this.date,interval);
                const clone = (items) => items.map(item => Array.isArray(item) ? clone(item) : item);
                this.instructorMap2=new Map(this.instructors.map((e,i)=>([e.id,i+1])));
                this.cal.splice(1);
                console.log(this.cal,this.instructor);
                this.cal = this.cal.concat(this.instructors.map(e => ({name:e.id,hours:_.cloneDeep(this.hours,true)})));
                console.log(this.cal,this.instructor);
                switch(date){
                    case 'first':
                        date = '2018-12-02';
                        break;
                    case 'today':
                        date = this.$moment().format('YYYY-MM-DD');
                        break;
                    case 'next':
                        date = this.$moment(this.date).add(1,'d').format('YYYY-MM-DD');
                        break;
                    case 'prev':
                        date = this.$moment(this.date).add(-1,'d').format('YYYY-MM-DD');
                        break;
                    case 'current':
                        date = this.date;
                        break;
                }
                this.date = date;
                let drives = this.getDriveByDate(date);
                console.log('date',date);
                console.log('--Jazdy - drives--',drives);
                console.log('instMap - instMap[3] - hoursmap - get 7:00',this.instructorMap,this.instructorMap[3],this.hourMap.get('07:00'));
                drives.forEach((e,index) => {
                    console.log('--drives loop start -- index:', index);
                    console.log('drive - id', e.id);
                    //let instructor = this.instructorMap[e.user_id];
                    let instructor = this.instructorMap.get(e.user_id);
                    let hour = this.hourMap.get(e.time);
                    //let hoursCount = e.hours_count*2 == 0 ? e.hours_count*2: e.hours.length; 
                    //let hoursCount = e.hours_count*2 || e.hours.length; 
                    let hoursCount = Math.max(e.hours_count*2, e.hours.length);
                    console.log('!!!! drives.foreach ins hour hCount hours !!!!',instructor,hour,hoursCount,e.hours);
                    for(let i=0;i<hoursCount;i++){
                        i==0?this.cal[instructor].hours[i+hour].deleteBtn=true:{};
                        this.cal[instructor].hours[i+hour].drive=true;
                        this.cal[instructor].hours[i+hour].drive_id=e.id;
                        this.cal[instructor].hours[i+hour].class='drive-'+index%3;
                    }
                    e.hours.forEach((e,index) => {
                        console.log('--e.hours foreach -- index:', index);
                        console.log('hours foreach getuserbyid e.count',this.getUserById(e.user_id),e.count);
                        this.cal[instructor].hours[index+hour].text=this.getUserById(e.user_id).name;
                        //this.cal[instructor].hours[index+hour].style="border-top:2px solid black";
                        //this.cal[instructor].hours[index+hour+(e.count*2)-1].style="border-bottom:2px solid black";
                    });
                });
                console.log('---End driveToCal()---');
            },
            selectedDate(date){
                console.log('---selectedDate()---', date,this.date);
                this.date = this.$moment(date).format('YYYY-MM-DD');
                console.log('---date this.date---', date,this.date);
                this.driveToCal('current');
            },
            select(e,instructor_id){
                console.log('select e instructor_id',e,instructor_id);
                if(!e.drive){
                    this.showDriveAddEditForm(e,false,instructor_id);
                }
                //e.selected = !e.selected;
            },
            editDrive(id){
                console.log('editDrive id',id);
            },
            toggleSelectBetween(start,stop,instructor){
                for(let i=start;i<stop;i++)this.cal[instructor].hours[i].selected=!this.cal[instructor].hours[i].selected;
            },
            deleteDrive(drive){
                console.log('delete',drive);
                let confirmed = confirm('Usunąć '+drive.drive_id+' ?');
                if(confirmed){    
                    this.$http({
                        url: 'drive/'+drive.drive_id,
                        method: 'DELETE'
                    }).then((res) => {
                        console.log(res.data);
                        this.$store.commit('deleteDrive',drive.drive_id);
                        this.driveToCal('current',1);
                    }, (res) => {
                        console.log('error'+res);
                    });
                }
            }
        },
        computed : {
            ...mapState(['isLoading','drives']),
            ...mapGetters(['getDriveByDate','getDriveById','getUserById','getUsersByRole','students','instructors']),
            instructorMap(){
                return new Map(this.instructors.map((e,i)=>([e.id,i+1])));
            },
            formatDate(){
                return this.$moment(this.date).format('YYYY-MM-DD');
            }
        },
        watch:{
            date:function(val){
                this.date = this.$moment(val).format('YYYY-MM-DD');
            }
        }
    }
</script>
<style>
.selected{
    background-color: gray;
}
.drive{
    
}
.drive-0{
    background-color: lightgray;
}
.drive-1{
    background-color: darkgray;
}
.drive-2{
    background-color: grey;
}
.selected.drive{
    background-color: lightblue;
}
.hours{
    width:20px;
}
.table th, .table td{
    padding:0.1rem;
}
</style>