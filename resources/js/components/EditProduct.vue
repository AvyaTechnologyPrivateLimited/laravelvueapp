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
                        <label>Name&nbsp;<span class="red">*</span></label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div><br>
                    <div class="form-group">
                        <label>Manufacture Year&nbsp;<span class="red">*</span></label>
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
            this.errors = [];
            if (!this.name){
                this.errors.push('Name field is required.');
                this.isSubmitting = false
                return false;
            }
             if (!this.manufacture_year){
                this.errors.push('Manufacture Year field is required.');
                this.isSubmitting = false
                return false;
            }

            if (this.manufacture_year <= 1900 || this.manufacture_year >= 2021){
                this.errors.push('Manufacture Year must be between 1990 and present');
                this.isSubmitting = false
                return false;
            } 

            if (this.image.size > 1024 * 1024 * 2) {
                e.preventDefault();
                this.errors.push('File Size can not be taken more than 2MB');
                this.isSubmitting = false
                return false;
            }
            
            this.type = ['image/png', 'image/jpeg', 'image/jpeg'];
            if(!this.type.some(data => data.id === this.image.type)){
                e.preventDefault();
                this.errors.push('File type must be jpg, jpeg, png');
                this.isSubmitting = false
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

