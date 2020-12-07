<template>
    <div>
        test
        <div id="nav">
            <router-link  to="/login" >Login</router-link>
        </div>
    </div>
</template>
<script>

    export default {
        beforeCreate: function() {
            var cookie = this.$cookie.get('token');
            if(cookie=='' || cookie=='undefined' || cookie == null) {
                console.log('here123');
                this.$router.push({ name: 'login', query: { redirect: '/login' } });
            }
            // else {
            //     axios({
            //         method: 'post',
            //         url: '/api/user/authenticate',
            //         headers: {'auth':cookie}
            //
            //     }).then( function (response) {
            //         var session =  response.data.auth;
            //         if(session!='valid') {
            //             this.$cookie.delete('token');
            //             this.$router.push({ name: 'login', query: { redirect: '/login' } });
            //         }
            //
            //     }.bind(this));
            // }

        }
    }
</script>
