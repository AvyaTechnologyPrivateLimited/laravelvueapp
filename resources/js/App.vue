<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Laravel Vue CRUD Example</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto" v-if="isLoggedIn">
                    <li class="nav-item ">
                        <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/products" class="nav-item nav-link">Products</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                    </li>
                </ul>

                <ul class="navbar-nav mr-auto" v-else>
                    <li class="nav-item ">
                        <router-link to="/" class="nav-item nav-link">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/login" class="nav-item nav-link">login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/register" class="nav-item nav-link">Register
                        </router-link>
                    </li>
                </ul>
    
            </div>
        </nav>

       
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,

        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {   
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/login"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>
