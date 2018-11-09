<template>
	<div id="payments">
		<div class="card">
    		<div class="card-header">
    		    <h3 class="card-title">Lista płatności
    		    	<button type="button" class="btn btn-sm btn-success float-right" @click="showPaymentAddEditForm()"><i class="fa fa-user-plus"></i></button>
    		    </h3>
    		</div>
    		<div class="card-body">
    			
    		    <table class="table table-striped">
    		        <tr>
    		            <th>Id</th>
    		            <th>Płatnik</th>
    		            <th>Kwota</th>
                        <th>Data</th>
    		            <th>Akcje</th>
    		        </tr>
    		        <tr 
    		            v-for="payment in payments" 
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
    		</div>
		</div>
		<PaymentAddEditForm  :students=this.students ref="PaymentAddEditForm" v-show="ShowPaymentAddEditForm" @close="closePaymentAddEditForm" />	
	</div>
</template>
<script>
    import PaymentAddEditForm from './PaymentAddEditForm.vue';
    export default{
        components: {
            PaymentAddEditForm,
        },
        data() {
            return {
                payments: [],
                costNames: [],
                ShowPaymentAddEditForm: false,
                students: [],
            }
        },
        mounted() {
            this.getPayments();
            this.getStudents();
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
            getStudents(){
                this.$http({
                    url: 'user/student',
                    method: 'GET',
                })
                .then((res) => {
                    this.students = res.data.users;
                }, (res) => {
                    console.log('error '+res);
                });    
            },
            showPaymentAddEditForm(payment){
                console.log(payment);
                this.$refs.PaymentAddEditForm.user = payment.user;
                this.$refs.PaymentAddEditForm.payment = payment;
                this.ShowPaymentAddEditForm = true;
                this.$refs.PaymentAddEditForm.add = false;
                $('body').addClass('modal-open');
            },
            closePaymentAddEditForm(){
                this.ShowPaymentAddEditForm = false;
                $('body').removeClass('modal-open');
            },
        }
    }
</script>
<style>
</style>