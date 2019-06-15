<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <div class="alert alert-danger" >
                        <p>There was an error, unable to sign in with those credentials.</p>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" autocomplete="off" @submit.prevent="login">
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" v-model="email" required autofocus>
                                    <span class="help-block" >
                                        <strong>Email error</strong>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" v-model="password" required autofocus>
                                    <span class="help-block">
                                        <strong>Password error</strong>
                                    </span>
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" v-model="rememberMe"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted login.')
        },
        data() {
            return {
                error: false,
                errors: {'email' : false, 'password' : false},
            }
        },
    }
</script>
