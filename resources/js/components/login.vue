<template>
    <div id="login">
        <h1>Login</h1>
        <input type="text" name="username" v-model="email" placeholder="Username" />
        <input type="password" name="password" v-model="password" placeholder="Password" />
        <button type="button" v-on:click="login()">Login</button>
    </div>
</template>

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
                    }.bind(this));;

                } else {
                    console.log("A username and password must be present!!!!!");
                }
            }
        }
    }
</script>

<style scoped>
    #login {
        width: 500px;
        border: 1px solid #CCCCCC;
        background-color: #FFFFFF;
        margin: auto;
        margin-top: 200px;
        padding: 20px;
    }
</style>
