<template>
   <div id="app">
      	<router-view></router-view>
       <!-- Navbar -->

  <!-- /.navbar -->

      <!-- <nav class="navbar navbar-dark navbar-expand-sm bg-dark fixed-top">
         <div class="container">
            <router-link to="/" class="navbar-brand"> &nbsp;Todo</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarCollapse" class="collapse navbar-collapse">
               <ul class="navbar-nav ml-auto" v-if="isLoggedIn">

	               	<li class="navbar-nav ml-auto">
	               		<router-link class="nav-link" to="/dashboard">Dashboard</router-link>
	               	</li>

	               	<li class="navbar-nav ml-auto">
	               		<button class="btn btn-secondary text-white pl-3 pr-3 btn-sm" @click="logout()">Logout</button>
	               	</li>
               	
               </ul>

               <ul class="navbar-nav ml-auto" v-else>
                  <li class="nav-item">
                  	<router-link to="/login" class="nav-link">Login</router-link>
                  </li>
                  <li class="nav-item">
                  	<router-link to="/register" class="nav-link">Register</router-link>
                  </li>
               </ul>
            </div>
         </div>
      </nav> -->


   </div>
</template>

<script>
   export default{
   	name:"App",
      data(){
         return{
            user:''
         }
      },
   	computed : {
        isLoggedIn : function(){ 
         	return this.$store.getters.isLoggedIn
        }
      },
      created(){
         if(this.isLoggedIn){
            this.$store.dispatch('getUser');
         }
      },
      methods: {
        async logout (){
            await this.$store.dispatch('logout')
            this.$router.push('/login')
        }
      },
   }
</script>

