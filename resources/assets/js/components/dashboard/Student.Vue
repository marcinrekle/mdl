<template>
	<div id="student">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">
                    {{ student.name }}
                    <button type="button" class="btn btn-sm btn-success float-right" @click="$auth.logout()" title="Wyloguj"><i class="fa fa-sign-out"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <div class="row">
                    <div class="col">
                        <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                        <h3 v-show="!isLoading && !student">Coś poszło nie tak</h3>
                    </div>
                </div>
                <div class="row">
                    <div :class="['col-12','table-responsive']">
                        <table class="table table-borderless ">
                            <tr>
                              <th></th>
                              <th>Godziny</th>
                              <th>Płatności</th>
                              <th>Jazdy w tygodniu</th>
                            </tr>
                            <tr>
                              <td>
                                <div class="placeholder">
                                  <img :src="student.avatar" style="width:50px" class="img-responsive img-circle avatar avatar-big">
                                </div>
                              </td>
                              
                              <td>13 / 30</td>
                              <td>
                              Kurs : 1000/1500 <br />
                              Lekarz : 100/100
                              </td>
                              <td>
                              2
                              </td>
                              <td>
                                
                              </td>
                            </tr>
                        </table>
                    </div>
                </div>
    		</div>
		</div>
        <hr>
        <div class="card-group">
            <div class="card text-white bg-primary">
                <div class="card-header">
                    <h5 class="card-title">
                        Godziny
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                            <h3 v-show="!isLoading && !student.hours">Coś poszło nie tak</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div :class="['col-12','table-responsive']">
                            <table class="table table-borderless">
                                <tr>
                                  <th>Data</th>
                                  <th>Ilość</th>
                                  <th>Instruktor</th>
                                </tr>
                                <tr v-for="hour in student.hoursSorted">
                                  <td>{{ hour.drive.date }}</td>
                                  <td>{{ hour.count }}</td>
                                  <td>{{ hour.drive.user.name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-white bg-success">
                <div class="card-header">
                    <h5 class="card-title">
                        Płatności
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                            <h3 v-show="!isLoading && !student.payments">Coś poszło nie tak</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div :class="['col-12','table-responsive']">
                            <table class="table table-borderless ">
                                <tr>
                                  <th>Kwota</th>
                                  <th>Data</th>
                                  <th>Typ</th>
                                </tr>
                                <tr v-for="payment in student.payments">
                                  <td>{{ payment.amount }}</td>
                                  <td>{{ payment.payment_date }}</td>
                                  <td>{{ payment.payment_for == 'course' ? 'Kurs' : 'Lekarz' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex';
	//import UserEditForm from './UserEditForm.vue';
	export default{
		components: {

		},
		data() {
			return {
                userLogged : this.$auth.user(),
			}
		},
		created() {
            this.$store.dispatch("fetchStudentById", { self: this });
        },
        methods: {
        },
        computed :{
        	...mapState(['isLoading','student','costNames']),
        	...mapGetters([]),
        },
	}
</script>
<style>

</style>