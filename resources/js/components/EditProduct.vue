<template>
    <div>
        <div class="loader" v-if="loader"></div>
        <h4 class="text-center">Edit Product</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                    <div class="alert alert-danger" role="alert" v-if="errors.length">
                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div><br>
                    <div class="form-group">
                        <label>Manufacture Year</label>
                        <input @keypress="isNumber($event)" max="4" type="text" class="form-control" v-model="product.manufacture_year">
                    </div><br>
                   <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" v-on:change="onImageChange">
                    </div><br>
                    <button :disabled="isSubmitting" type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</template>
s
<script>
export default {
    data() {
        return {
            product: {},
            errors: {},
            image: '',
            loader: false,
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/products/edit/${this.$route.params.id}`)
                .then(response => {
                    console.log(response.data)
                    this.product = response.data
                    
                })
                .catch(function (error) {
                    console.error(error);
                });
        })   
    },
    methods: {
        onImageChange(e){
            this.image = e.target.files[0];
        },
        updateProduct(e) {
            e.preventDefault()
            this.isSubmitting = true
            this.loader = true;
            this.errors = [];
            if (!this.product.name || !this.product.manufacture_year){
                this.errors.push('Name and Manufactured Year fields are required.');
                return false;
            } 
            if (this.product.manufacture_year.length > 4 || this.product.manufacture_year.length < 4) {
                this.errors.push('Manufactured Year must be 4 digit long.');
                return false;
            }

            if (this.manufacture_year <= 1990 || this.manufacture_year >= 2021){
                this.errors.push('Manufacture Year must be between 1990 and present');
                return false;
            } 

            let currentObj = this;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.product.name);
            formData.append('manufacture_year', this.product.manufacture_year);


            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/products/update/${this.$route.params.id}`, formData, config)
                    .then(response => {
                        if (response.data.success) {
                            this.$router.push({name: 'products'})
                        } else {
                            this.errors = response.data.message
                            console.log(this.errors);
                        }
                    })
                    .catch(function (errors) {
                        console.error(errors);
                    });
            })
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();;
            } else {
            return true;
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
<style scoped>
    loader {
        position: absolute;
        left:50%;
        top:50%;
        transform: translate(-50%, -50%);
        border: 10px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 75px;
        height: 75px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style> 
