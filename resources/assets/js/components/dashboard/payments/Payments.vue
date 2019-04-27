<template>
	<div id="payments">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista płatności
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showPaymentAddEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
                <loading v-show="isLoading" loadingText="Ładowanie danych"></loading>
                <h3 v-show="!isLoading && !payments">Brak wpłat</h3>	
    		    <table v-show="payments" class="table table-striped">
    		        <tr>
    		            <th>Id</th>
    		            <th>Płatnik</th>
    		            <th>Kwota</th>
                        <th>Data</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="payment in payments.data" 
    		            :key="payment.id"
    		        >
    		            <td>{{ payment.id }}</td>
    		            <td>{{ payment.user.name }}</td>
                        <td>{{ payment.amount }}</td>
    		            <td>{{ payment.payment_date }}</td>
    		            <td>
                            <button  v-if="$auth.check(['payment-crud'],'perms')" type="button" class="btn btn-sm btn-primary" title="Edytuj" @click="showPaymentAddEditForm(payment)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button  v-if="$auth.check(['payment-crud','payment-delete'],'perms')" type="button" class="btn btn-sm btn-danger" title="Usuń" @click="deletePayment(payment)">
                                <i class="fa fa-trash"></i>
                            </button>
    		                <button  v-if="$auth.check(['payment-crud','payment-add'],'perms')" type="button" class="btn btn-sm btn-success" :title="'Dodaj płatność dla ' + payment.user.name" @click="showPaymentAddEditForm(payment)">
    		                    <i class="fa fa-dollar"></i>
    		                </button>
    		            </td>
    		        </tr>
    		    </table>
                <pagination :limit="2" :data="payments" @pagination-change-page="getPayments"></pagination>
    		</div>
		</div>
		<PaymentAddEditForm  :options="this.students" ref="PaymentAddEditForm" v-show="ShowPaymentAddEditForm" @close="closePaymentAddEditForm" />	
	</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex';
    import pagination from 'laravel-vue-pagination';
    import PaymentAddEditForm from './PaymentAddEditForm.vue';
    export default{
        components: {
            PaymentAddEditForm,
            pagination
        },
        data() {
            return {
                //payments: [],
                //costNames: [],
                ShowPaymentAddEditForm: false,
                page: 1,
                forPage: 30,
                //students: this.$store.getters.getUsersByRole('Student'),
                //students: [],
            }
        },
        created() {
            this.$store.state.users.length < 1 && this.$store.dispatch("fetchData", { self: this });
            //this.students = this.getUsersByRole('Student');
            //this.getPayments();
        },
        mounted() {
            this.$store.state.users.length < 1 ?
                setTimeout(()=> {
                    this.$store.dispatch("fetchPayments", { self: this });
                },200) : this.$store.dispatch("fetchPayments", { self: this });
            //this.getPayments();
            //this.getStudents();
        },
        methods: {
            getPayments(){
                this.$http({
                    url: 'payment',
                    method: 'GET',
                })
                .then((res) => {
                    this.payments = res.data.payments;
                    this.costNames = res.data.costNames;
                }, (res) => {
                    console.log('error '+res);
                });    
            },
            showPaymentAddEditForm(payment){
                if(payment){
                    console.log(payment);
                    this.$refs.PaymentAddEditForm.user = payment.user;
                    this.$refs.PaymentAddEditForm.payment = payment;
                    this.$refs.PaymentAddEditForm.add = false;
                }
                this.ShowPaymentAddEditForm = true;
                $('body').addClass('modal-open');
            },
            closePaymentAddEditForm(){
                this.ShowPaymentAddEditForm = false;
                $('body').removeClass('modal-open');
            },
            getPayments(page = 1){
                this.page = page;
                this.$store.dispatch("fetchPayments", { self: this });
            }
        },
        computed : {
            ...mapState(['isLoading']),
            ...mapGetters(['getUsersByRole','students','payments','costNames']),
        }
    }
</script>
<style>
</style>