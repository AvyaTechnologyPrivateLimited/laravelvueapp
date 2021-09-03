<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-danger" role="alert" v-if="errors.length">
                    <li v-for="error in errors" :key="error.id">{{ error }}</li>
                </div>

                <div class="alert alert-danger" role="alert" v-if="errors2.length">
                    <div v-for="(v, k) in errors2" :key="k">
                        <p v-for="error in v" :key="error" >{{ error }}</p>
                    </div>
                </div>

                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address&nbsp;<span class="red">*</span></label>
                                <div class="col-md-6">
                                    <input required id="email" type="email" class="form-control" v-model="email" 
                                           autofocus autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password&nbsp;<span class="red">*</span></label>
                                <div class="col-md-6">
                                    <input max="20" oncopy="return false" onpaste="return false" required id="password" type="password" class="form-control" v-model="password"
                                            autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
                                    </button>
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
    data() {
        return {
            email: "",
            password: "",
            errors: {},
            errors2: {}
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            this.errors = [];
            this.errors2 = [];
            if (!this.email || !this.password) {
                this.errors.push('All fields are required.');
                return false;
            } 

            if (!this.validEmail(this.email)) {
                this.errors.push('Valid email required.');
                return false;
            }

            if (this.password.length < 6 || this.password.length > 20) {
                this.errors.push('Password field must be between 6 to 20 char long');
                return false;
            }
            

            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.$router.go('/dashboard')
                        } else {
                            this.errors2.push(response.data.message)
                            return false;
                        }
                    })
                    .catch(function (errors) {
                        console.error(errors);
                    });
                })
            }
        },
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
