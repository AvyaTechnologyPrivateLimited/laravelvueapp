<template>
    <div>
        <h4 class="text-center">Add Product</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="addProduct" enctype="multipart/form-data">
                    <div class="alert alert-danger" role="alert" v-if="errors.length">
                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" v-model="name">
                    </div><br>
                    <div class="form-group">
                        <label>Manufacture Year</label>
                        <input max="4" min="4" name="manufacture_year" type="text" class="form-control" v-model="manufacture_year">
                    </div><br>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" v-on:change="onImageChange">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            product: {},
            errors: {},
            image: '',
            name: '',
            manufacture_year: ''
        }
    },
    methods: {
        onImageChange(e){
            this.image = e.target.files[0];
        },
        addProduct(e) {
            e.preventDefault()
            this.errors = [];
            if (!this.name || !this.manufacture_year){
                this.errors.push('Name and Manufacture Year fields are required.');
                return false;
            }
            if (this.manufacture_year.length != 4){
                this.errors.push('Manufacture Year must be 4 digit long');
                return false;
            }

            let currentObj = this;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.name);
            formData.append('manufacture_year', this.manufacture_year);

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/products/add', formData, config)
                    .then(response => {
                        if (response.data.success) {
                            this.$router.push({name: 'products'})
                        } else {
                            this.errors = response.data.message
                        }
                        
                    })
                    .catch(function (error) {
                        console.error(error);
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
