<template>
    <div>
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
                        <input  max="4" type="text" class="form-control" v-model="product.manufacture_year">
                    </div><br>
                   <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" v-on:change="onImageChange">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Update Product</button>
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
            this.errors = [];
            if (!this.product.name || !this.product.manufacture_year){
                this.errors.push('Name and Manufactured Year fields are required.');
                return false;
            } 
            if (this.product.manufacture_year.length > 4 || this.product.manufacture_year.length < 4) {
                this.errors.push('Manufactured Year must be 4 digit long.');
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
