<template>
    <div>
        <div class="alert alert-danger" v-if="error">
            <p>There was an error, unable to sign in with those credentials.</p>
        </div>
        <form autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
            </div>
            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
    </div>
</template>
<script>
  export default {
    data(){
      return {
        email: 'admin@example.com',
        password: 'admin',
        error: false,
        _token: ''
      }
    },
    methods: {
        login(){
            var app = this
            this.$auth.login({
                data: {
                    email: app.email,
                    password: app.password,
                    _token: window.Laravel.csrfToken
                }, 
                success: function () {},
                error: function () {app.error = true},
                rememberMe: true,
                redirect: '/dashboard',
                fetchUser: true,
            });       
        },
        login2(){
            var app = this;
            axios.post('api/auth/login',{
                email: app.email,
                password: app.password
            })
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                alert(error);
                console.log(error);
            });
        }
    }
  } 
</script>