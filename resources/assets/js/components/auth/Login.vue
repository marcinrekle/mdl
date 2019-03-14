<template>
    <div class="card card-signin mx-auto">
        <div class="card-header bg-primary">
            <h3 class="text-light">Please Sign in</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-danger" v-if="error">
                <p>There was an error, unable to sign in with those credentials.</p>
            </div>
            <form class="form-signin" autocomplete="off" @submit.prevent="login" method="post">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" v-model="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Zaloguj</button>
                <loading v-show="isLoading"></loading>
            </form>
        </div>
    </div>
</template>
<script>
    import {mapState} from 'vuex';
    export default {
        data(){
            return {
                email: 'admin@example.com',
                password: 'admin',
                error: false,
                _token: '',
            }
        },
        mounted() {console.log('Login')},
        methods: {
            login(){
                var app = this;
                this.$store.commit('setLoading',true);
                this.$auth.login({
                    data: {
                        email: app.email,
                        password: app.password,
                        _token: window.Laravel.csrfToken
                    }, 
                    success: function () {
                        this.$store.commit('setLoading',false);
                    },
                    error: function () {
                        app.error = true;
                        this.$store.commit('setLoading',false);
                    },
                    rememberMe: true,
                    redirect: '/dashboard',
                    fetchUser: true,
                });       
            },
        },
        computed: {
            ...mapState(['isLoading']),
        }
    } 
</script>
<style>
    html,body {
        height: 100%;
    }
    body {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .card-signin{
        max-width: 500px;
    }
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    
</style>