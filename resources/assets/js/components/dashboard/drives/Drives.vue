<template>
	<div id="drives">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista jazd
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showDriveAddEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                <h3 v-show="!isLoading && !drives">Brak jazd</h3>
                <table class="table table-striped">
                <tbody>    
                    <tr>
                        <th v-for="col in cal">{{col.name}}</th>
                    </tr>
                    <tr v-for="(item,index) in cal[0].hours">
                        <td v-for="col in cal"
                        :key="col.name + (col.name!='hours' ? col.hours[index].index:index)"
                        :class="{ hours : col.name=='hours', selected: col.hours[index].selected, drive: col.hours[index].drive }"
                        :style="col.hours[index].style" 
                        @click="col.name!='hours' ? (col.hours[index].drive ? editDrive(col.hours[index].drive_id) : select(col.hours[index],col.name)):{}"
                        >
                            {{col.hours[index].text}}
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
		</div>
		<DriveAddEditForm ref="DriveAddEditForm" :instructors="this.instructors" v-show="ShowDriveAddEditForm" @close="closeDriveAddEditForm" />	
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
                cal: ['hours', '3','7'].map((e,i) => ({
                        name: e,
                        hours: e=='hours' ? Array(26).fill(0).map((e, i) => ({text:Math.floor(i*0.5+7) + (i%2 == 0 ? ':00' : ':30')})) : Array(26).fill(0).map((e, i) => ({
                            index: i*0.5 + 7,
                            hour: ('0'+Math.floor(i*0.5+7)).slice(-2) + (i%2 == 0 ? ':00' : ':30'),
                            selected: false,
                            drive: false,
                            drive_id: 0,
                            style: '',
                            text:' ',
                        }))
                })),
                cal3: ['3'].map(e => Array(26).fill(0).map(e => ({drive:{},td:'',colspan:0})) ),
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
            showDriveAddEditForm(e,drive,instructor_id){
                if(drive){
                    console.log(drive);
                    this.$refs.DriveAddEditForm.drive = drive;
                    this.$refs.DriveAddEditForm.add = false;
                }
                //this.$refs.DriveAddEditForm.user = drive.user;
                this.$refs.DriveAddEditForm.user = this.getUserById(parseInt(instructor_id));
                this.$refs.DriveAddEditForm.drive.user_id = parseInt(instructor_id);
                this.$refs.DriveAddEditForm.drive.hours_count = 1;
                console.log('e.hour',e.hour);
                this.$refs.DriveAddEditForm.drive.date = this.$moment(this.date+' '+e.hour).format('YYYY-MM-DDTHH:mm');
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
            driveToCal(time,interval){
                if(time == 'first') time = '2018-12-02';
                let drives = this.getDriveByDate(time);
                console.log('time',time);
                console.log('drives',drives);
                console.log('instMap instMap[3] hoursmap get 7:00',this.instructorMap,this.instructorMap[3],this.hourMap.get('07:00'));
                drives.forEach(e => {
                    console.log('drive', e.id);
                    let instructor = this.instructorMap[e.user_id];
                    let hour = this.hourMap.get(e.time);
                    let hoursCount = e.hours_count*2;

                    console.log('ins hour hCount hours',instructor,hour,hoursCount,e.hours);
                    for(let i=0;i<hoursCount;i++){
                        this.cal[instructor].hours[i+hour].drive=true;
                        this.cal[instructor].hours[i+hour].drive_id=e.id;
                    }
                    e.hours.forEach((e,index) => {
                        console.log('hours foreach getuserbyid e.count',this.getUserById(e.user_id),e.count);
                        this.cal[instructor].hours[index+hour].text=this.getUserById(e.user_id).name;
                        this.cal[instructor].hours[index+hour].style="border-top:2px solid black";
                        this.cal[instructor].hours[index+hour+(e.count*2)-1].style="border-bottom:2px solid black";
                    });

                    this.cal3[instructor][hour].drive = e;
                    this.cal3[instructor][hour].td = 'Antek <br> Zenek';
                    this.cal3[instructor][hour].colspan = hoursCount;
                    for(i=hour+1;i<hour+hoursCount;i++)this.cal3[instructor][i].td=0; 

                });
                this.cal3[0].forEach(e => console.log(e.td));
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
            ...mapGetters(['getDriveByDate','students','getUserById','getUsersByRole','instructors']),
        }
    }
</script>
<style>
.selected{
    background-color: gray;
}
.drive{
    background-color: lightgrey;
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