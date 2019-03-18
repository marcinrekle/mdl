<template>
    <div id="PaymentsAddEditModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ this.add ? 'Dodawanie nowej jazdy' : "Edycja jazdy" }}
                    <button type="button" class="close" @click="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="add ? storeHour() : updateHour()" method="post"> 
                        <div class="form-group">
                            <label for="user_id">Imie Nazwisko</label>
                            <select name="user_id" id="user_id" class="form-control" v-model="hour.user_id" required>
                                <option v-for="option in options" :value="option.id">{{ option.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Godzina</label>
                            <input type="number" id="amount" class="form-control" v-model="payment.amount" required autofocus />
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
        props: {
            options: {},
        },
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