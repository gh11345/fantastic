<template>
    <div>
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">

            <div class="logo"><a class="simple-text logo-normal">
                Fantastic Products LTD
            </a></div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/#/products">
                            <i class="material-icons">person</i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./tables.html">
                            <i class="material-icons">content_paste</i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./typography.html">
                            <i class="material-icons">library_books</i>
                            <p>Typography</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./icons.html">
                            <i class="material-icons">bubble_chart</i>
                            <p>Icons</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./map.html">
                            <i class="material-icons">location_ons</i>
                            <p>Maps</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./notifications.html">
                            <i class="material-icons">notifications</i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./rtl.html">
                            <i class="material-icons">language</i>
                            <p>RTL Support</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">

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
                                    <a class="dropdown-item" href="#">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

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
                    }

                }.bind(this));
            }

        },
        mounted() {
            this.switchActive();
        },
        methods: {
            switchActive() {
                $(".nav-link").click(function(){
                    $('.nav > .nav-item').removeClass("active");
                    $(this).parent().addClass("active");
                });
            }
        }
    }
</script>
