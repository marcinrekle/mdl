<template>
	<div id="drives">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista jazd 
                    << {{ date }}  >>
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showDriveAddEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                <h3 v-show="!isLoading && !drives">Brak jazd</h3>
                <table class="table table-striped">
                <tbody>    
                    <tr>
                        <th v-for="col in cal" :test="col.name">{{col.name=='hours'?'Godz':getUserById(parseInt(col.name)).name}}</th>
                    </tr>
                    <tr v-for="(item,index) in cal[0].hours">
                        <td v-for="col in cal"
                        :key="col.name + (col.name!='hours' ? col.hours[index].index:index)"
                        :class="[col.hours[index].class,{ hours : col.name=='hours', selected: col.hours[index].selected, drive: col.hours[index].drive }]"
                        :style="col.hours[index].style" 
                        @click="col.name!='hours' ? showDriveAddEditForm(col.hours[index],col.name):{}"
                        >
                            {{col.hours[index].text}}
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
		</div>
		<DriveAddEditForm ref="DriveAddEditForm" :instructors="this.instructors" :students="this.students" v-show="ShowDriveAddEditForm" @close="closeDriveAddEditForm" />	
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
                //drives: [],
                costNames: [],
                ShowDriveAddEditForm: false,
                date: this.$moment().format('YYYY-MM-DD'),
                table: [],
                selectedTd: [],
                instructorMap: {'3':1,'7':2},
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
                            text:' ',
                            class: '',
                        }))
                })),
                cal2:[],
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this }) ;
            this.$store.dispatch("fetchDrives", { self: this });
        },
        mounted() {
            this.createHoursTable(7,20);
        },
        methods: {
            showDriveAddEditForm(e,instructor_id){
                let drive = this.getDriveById(e.drive_id)[0];
                let add = e.drive_id == '0' ? true:false;
                //this.$refs.DriveAddEditForm.drive = {...drive};
                //this.$refs.DriveAddEditForm.drive = Object.assign({},drive);
                //console.log(add,e,drive,instructor_id);
                //if(!add){
                //    console.log(drive);
                //    this.$refs.DriveAddEditForm.drive = drive;
                //    this.$refs.DriveAddEditForm.add = false;
                //}else{}
                this.$refs.DriveAddEditForm.add = add;
                this.$refs.DriveAddEditForm.user = this.getUserById(parseInt(instructor_id));
                this.$refs.DriveAddEditForm.drive.id = add ? null:drive.id;
                this.$refs.DriveAddEditForm.drive.user_id = add ? parseInt(instructor_id):drive.user_id;
                this.$refs.DriveAddEditForm.drive.date=this.$moment(add?this.date+'T'+e.hour:drive.date).format('YYYY-MM-DDTHH:mm');
                this.$refs.DriveAddEditForm.drive.hours_count = add ? null:drive.hours_count;
                this.$refs.DriveAddEditForm.drive.s_user_id = add ? []:drive.hours.map(hour => hour.user_id);
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
            drivesToTable(date){
                    console.log(this.getDriveByDate('2018-12-02'))
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
            },
            driveToCal(date,interval){
                console.log('---Start driveToCal()---');
                this.cal2=this.instructors.map(e => ({name:e.id,hours:[...this.hours]}));
                this.cal = this.cal.concat(this.instructors.map(e => ({name:e.id,hours:[...this.hours]})));
                switch(date){
                    case 'first':
                        date = '2018-12-02';
                        break;
                    case 'today':
                        date = this.$moment().format('YYYY-MM-DD');
                        break;
                }
                let drives = this.getDriveByDate(date);
                console.log('date',date);
                console.log('--Jazdy - drives--',drives);
                console.log('instMap - instMap[3] - hoursmap - get 7:00',this.instructorMap,this.instructorMap[3],this.hourMap.get('07:00'));
                drives.forEach((e,index) => {
                    console.log('--drives loop start -- index:', index);
                    console.log('drive - id', e.id);
                    let instructor = this.instructorMap[e.user_id];
                    let hour = this.hourMap.get(e.time);
                    let hoursCount = e.hours_count*2;

                    //console.log('drives.foreach ins hour hCount hours',instructor,hour,hoursCount,e.hours);
                    for(let i=0;i<hoursCount;i++){
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
            createHoursTable(start,end){
                let count = end-start;
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
            }
        },
        computed : {
            ...mapState(['isLoading','drives']),
            ...mapGetters(['getDriveByDate','getDriveById','getUserById','getUsersByRole','students','instructors']),
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
    padding:0.25rem;
}
</style>