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
                <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-6" v-for="col in cal">
                        <table v-show="drives" class="table table-striped">
                            <tr>
                                <th>{{col.name}}</th>
                            </tr>    
                            <tr
                                v-for="hour in col.hours" 
                                :key="hour.index"
                            >
                                <td 
                                    v-if="hour.colspan"
                                >
                                    {{hour.text}}
                                </td>
                            </tr>
                        </table>
                    </div>  
                </div>
                <div class="row">
                        <table v-show="drives" class="table table-striped">
                            <tr>
                                <th v-for="col in cal">{{col.name}}</th>
                            </tr>    
                            <tr v-for="(item,index) in cal[0].hours" :test1="index" test2:="item.index" :key="item.index">
                                <td v-for="col in cal" :class="{ hours : col.name=='hours', selected: col.hours[index].selected }" @click="col.name!='hours' ? select(col.hours[index]):{}">
                                    {{col.hours[index].text}} - {{col.hours[index].index}}
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
		</div>
		<DriveAddEditForm  :drives="this.drives" ref="DriveAddEditForm" v-show="ShowDriveAddEditForm" @close="closeDriveAddEditForm" />	
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
                table: [],
                instructorMap: {'3':0},
                hourMap: new Map(Array(26).fill(0).map((e, i) => ([ ('0'+Math.floor(i*0.5+7)).slice(-2) + (i%2 == 0 ? ':00' : ':30'),i]))),
                cal: ['hours', '3'].map((e,i) => ({
                        name: e,
                        hours: e=='hours' ? Array(26).fill(0).map((e, i) => ({text:Math.floor(i*0.5+7) + (i%2 == 0 ? ':00' : ':30'),text2:i%2,colspan:1})) : Array(26).fill(0).map((e, i) => ({
                            index: i*0.5 + 7,
                            selected: false,
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
                console.log(drives);
                console.log(this.instructorMap,this.instructorMap[3],this.hourMap.get('07:00'));
                drives.forEach(e => {
                    let instructor = this.instructorMap[e.user_id];
                    let hour = this.hourMap.get(e.time);
                    console.log(instructor,hour);
                    this.cal3[instructor][hour].drive = e;
                    this.cal3[instructor][hour].td = 'Antek <br> Zenek';
                    let hoursCount = e.hours_count*2;
                    this.cal3[instructor][hour].colspan = hoursCount;
                    for(i=hour+1;i<hour+hoursCount;i++)this.cal3[instructor][i].td=0; 

                });
                this.cal3[0].forEach(e => console.log(e.td));
            },
            createHoursTable(start,end){
                let count = start-end;
                alert(count);
            },
            select(e){
                e.selected = !e.selected;
            }
        },
        computed : {
            ...mapState(['isLoading','drives']),
            ...mapGetters(['getDriveByDate','students']),
        }
    }
</script>
<style>
.selected{
    background-color: gray;
}
.hours{
    width:20px;
}
</style>