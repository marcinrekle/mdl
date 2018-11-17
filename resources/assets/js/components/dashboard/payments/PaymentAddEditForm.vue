<template>
    <div id="PaymentsAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej płatności' : "Edycja płatności" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storePayment() : updatePayment()" method="post"> 
                        <div class="form-group">
                            <label for="name">Imie Nazwisko</label>
                            <input type="name" id="username" class="form-control" placeholder="Jan Nowak" v-model="user.name" required autofocus>
                            <select name="user_id" id="user_id" class="form-control" v-model="user.name" required autofocus >
                                <option v-for="option in options" :value="student.id">{{ student.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Kwota</label>
                            <input type="number" id="amount" class="form-control" v-model="payment.amount" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Data wpłaty</label>
                            <input type="date" id="payment_date" class="form-control" v-model="payment.payment_date" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_for">Typ płatności</label>
                            <select name="payment_for" id="payment_for" class="form-control" v-model="payment.payment_for" required>
                                <option value="course">Kurs</option>
                                <option value="doctor">Lekarz</option>
                            </select>
                        </div>
                        <button 
                            type="submit" 
                            class="btn btn-primary"
                        >
                            {{ this.add ? 'Dodaj' : 'Aktualizuj' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click="close">Anuluj</button>
                    </form>   
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
    export default{
        data() {
            return {
                user: {
                    id:'',
                    name:'',
                },
                payment: {
                    id:'',
                    payment_for:'course',
                    payment_date:'',
                    user_id:'',
                    amount:'',
                },
                options: [],
                error: [],
                add: true,
                paymentOriginal: '',
                paymentCached: ''
            }
        },
        mounted() {
            this.paymentOriginal = this.payment;
        },
        methods: {
            close(){
                this.resetForm();
                this.$emit('close');
            },
            resetForm(){
                this.user = this.add ?  Object.assign({},this.paymentOriginal) : Object.assign({},this.paymentCached);
            },
            submitForm(){
                console.log('submitForm');
            },
            storePayment(){
                console.log('storePayment');
                this.$http({
                    url: 'payment',
                    method: 'POST',
                    data: this.payment
                }).then((res) => {
                    console.log(res.data);
                    //add notify
                }, (res) => {
                    console.log('error'+res);
                });
            },
            updatePayment(){
                console.log('updatePayment');
                this.$http({
                    url: 'payment/'+this.payment.id,
                    method: 'PUT',
                    data: this.payment
                }).then((res) => {
                    console.log(res.data);
                }, (res) => {
                    console.log('error'+res);
                });
            }
        }
    }
</script>
<style>
    .modal {
        display:block;
    }
</style>