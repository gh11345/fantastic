<template>
    <div>
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">

            <div class="logo"><a class="simple-text logo-normal">
                Fantastic Product LTD
            </a></div>
            <div class="sidebar-wrapper">
                <ul class="nav nav-side">
                    <li class="nav-item dashboard fSider">
                        <a class="nav-link nav-parent" href="/">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item products fSider">
                        <a class="nav-link nav-parent" href="/#/products">
                            <i class="material-icons">content_paste</i>
                            <p>Sales Records</p>
                        </a>
                    </li>

                    <li class="nav-item employee fSider" >
                        <a class="nav-link nav-parent" href="/#/employee">
                            <i class="material-icons">person</i>
                            <p>Employee</p>
                        </a>
                    </li>

                    <li class="nav-item items fSider" >
                        <a class="nav-link nav-parent" href="/#/items">
                            <i class="material-icons">work</i>
                            <p>Items</p>
                        </a>
                    </li>

                    <li class="nav-item commission fSider" >
                        <a class="nav-link nav-parent" href="/#/commission">
                            <i class="material-icons">attach_money</i>
                            <p>Commission</p>
                        </a>
                    </li>

                    <li class="nav-item report fSider" >
                        <a class="nav-link nav-parent" href="/#/report">
                            <i class="material-icons">text_snippet</i>
                            <p>Report</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">

                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" v-on:click="logout">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content contentMod">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<style>
    .dropdown-item {
        color: #333 !important;
        text-decoration: none !important;
    }
    .dropdown-item:hover {
        color: white !important;
        text-decoration: none !important;
    }

    .contentMod {
        margin-top: 30px !important;
    }


</style>

<script>

    export default {
        beforeCreate: function() {
            var cookie = this.$cookie.get('token');
            if(cookie=='' || cookie=='undefined' || cookie == null) {
                this.$router.push({ name: 'login', query: { redirect: '/login' } });
            }
            else {
                axios({
                    method: 'post',
                    url: '/api/user/authenticate',
                    headers: {'auth':cookie}

                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session!='valid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.role = response.data.role;

                        if (this.role !='admin') {
                            $('.employee').remove();
                            $('.commission').remove();
                            $('.items').remove();
                            $('.report').remove();
                        }
                    }

                }.bind(this));
            }

        },
        mounted() {
            this.switchActive();
        },
        data() {
            return {
                role : '',
            }
        },
        methods: {
            logout() {
                this.$cookie.delete('token');
                this.$router.push({ name: 'login', query: { redirect: '/login' } });
            },
            switchActive() {
                $(".nav-parent").click(function(){
                    $('.nav-side > .nav-item').removeClass("active");
                    $(this).parent().addClass("active");
                });
                $( document ).ready(function() {
                    if (window.location.href.indexOf("products") > -1) {
                        $(".products").addClass("active");
                    } else if (window.location.href.indexOf("employee") > -1){
                        $(".employee").addClass("active");
                    } else if (window.location.href.indexOf("commission") > -1){
                        $(".commission").addClass("active");
                    } else if (window.location.href.indexOf("items") > -1){
                        $(".items").addClass("active");
                    } else if (window.location.href.indexOf("report") > -1){
                        $(".report").addClass("active");
                    } else {
                        $(".dashboard").addClass("active");
                    }
                });
            }
        }
    }
</script>
