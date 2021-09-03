<template>
    <div>
        <h4 class="text-center">Add Product</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <form @submit.prevent="addProduct" enctype="multipart/form-data">

                    <div class="alert alert-danger" role="alert" v-if="errors.length">
                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                    </div>

                    <div class="alert alert-danger" role="alert" v-if="errors2.length">
                        <div v-for="(v, k) in errors2" :key="k">
                            <p v-for="error in v" :key="error" >
                                <p v-for="i in error" :key="i">{{ i }}</p>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name&nbsp;<span class="red">*</span></label>
                        <input type="text" name="name" class="form-control" v-model="name">
                    </div><br>
                    <div class="form-group">
                        <label>Manufacture Year&nbsp;<span class="red">*</span></label>
                        <input @keypress="isNumber($event)" max="4" min="4" name="manufacture_year" type="text" class="form-control" v-model="manufacture_year">
                    </div><br>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file"  name="image" class="form-control" v-on:change="onImageChange">
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
            errors2: {},
            image: '',
            isSubmitting: false,
        }
    },
    methods: {
        onImageChange(e){
            this.image = e.target.files[0];
            // alert(this.image.type);
            // return false;
        },
        addProduct(e) {
            e.preventDefault()
            this.isSubmitting = true
            this.errors = [];
            this.errors2 = [];
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

            if (this.manufacture_year.length > 4 || this.manufacture_year.length < 4) {
                this.errors.push('Manufactured Year must be 4 digit long.');
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
                            this.errors2.push(response.data.message)
                            this.isSubmitting = false
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
