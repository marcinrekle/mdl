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
                            <input type="name" id="username" class="form-control" placeholder="Jan Nowak" v-model="user.name" required autofocus disabled>
                        </div>
                        <div class="form-group">
                            <label for="amount">Kwota</label>
                            <input type="name" id="amount" class="form-control" placeholder="100" v-model="payment.amount" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Data wpłaty</label>
                            <input type="name" id="date" class="form-control" placeholder="" v-model="payment.date" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_for"></label>
                            <input type="name" id="date" class="form-control" placeholder="" v-model="payment.date" required>
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
                    payment_for:'',
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
                this.user = this.add ?  Object.assign({},this.userOriginal) : Object.assign({},this.userCached);
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
                    this.$parent.users.push(res.data.user);
                }, (res) => {
                    console.log('error'+res);
                });
            },
            updatePayment(){
                console.log('updateUser');
                this.$http({
                    url: 'user/'+this.user.id,
                    method: 'PATCH',
                    data: this.user
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