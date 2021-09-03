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
                        <input @keypress="isNumber($event)" max="4" min="4" name="manufacture_year" type="text" class="form-control" v-model="manufacture_year">
                    </div><br>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" v-on:change="onImageChange">
                    </div><br>
                    <button :disabled="isSubmitting" type="submit"  class="btn btn-primary">Add Product
                        
                    </button>
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
            isSubmitting: false,
        }
    },
    methods: {
        onImageChange(e){
            this.image = e.target.files[0];
        },
        addProduct(e) {
            e.preventDefault()
            this.isSubmitting = true
            this.errors = [];
            if (!this.name || !this.manufacture_year){
                this.errors.push('Name and Manufacture Year fields are required.');
                return false;
            }

            if (this.manufacture_year.length > 4 || this.manufacture_year.length < 4) {
                this.errors.push('Manufactured Year must be 4 digit long.');
                return false;
            }

            if (this.manufacture_year <= 1900 || this.manufacture_year >= 2021){
                this.errors.push('Manufacture Year must be between 1990 and present');
                return false;
            } 

            if (this.image.size > 1024 * 1024 * 2) {
                e.preventDefault();
                this.errors.push('File Size can not be taken more than 2MB');
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
