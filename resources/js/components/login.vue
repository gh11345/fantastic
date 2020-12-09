<template>
    <div id="login">

            <div class="content login-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="login-header">
                                        <div class="info info-horizontal">
                                            <div class="description">
                                                <h4 class="info-title">Fantastic Product LTD</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="username" v-model="email" placeholder="Username" />
                                    <input class="form-control" type="password" name="password" v-model="password" placeholder="Password" />
                                    <tr></tr>
                                    <button class="btn btn-primary login" v-on:click="login()">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</template>

<style>

    .login-header {
        margin-bottom: 30px;
    }

    .login {
        float: right;
        margin-top: 30px;
    }
    .login-content {
        left: 35% !important;
        top: 40% !important;
        position: absolute !important;
        width: 30% !important;
    }
</style>

<script>
    export default {
        mounted() {
            this.keypress();
        },
        data() {
            return {
                email: '',
                password: '',
                remember: 0,
            }
        },
        methods: {
            keypress(){

                $(document).keyup(function( event ) {
                }).keydown(function( event ) {
                    if ( event.which == 13 ) {
                        var url = $(location).attr('href');
                        if (url.toLowerCase().indexOf("login") >= 0) {
                            event.preventDefault();
                            this.login();
                        }
                    }
                }.bind(this));
            },
            login() {

                if(this.username != "" && this.password != "") {
                    axios({
                        method: 'post',
                        url: '/api/user/login',
                        data:  {
                            email: this.email,
                            password: this.password,
                            remember: this.remember
                        }
                    }).then( function (response) {
                        var token =  response.data.token;
                        this.$cookie.set('token', token, 3600);
                        this.$router.push({ path: '/'});
                    }.bind(this));

                } else {
                    console.log("A username and password must be present!!!!!");
                }
            }
        }
    }
</script>
