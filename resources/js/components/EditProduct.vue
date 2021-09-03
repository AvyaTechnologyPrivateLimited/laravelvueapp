<template>
    <div>
        <h4 class="text-center">Edit Product</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div><br>
                    <div class="form-group">
                        <label>Manufacture Year</label>
                        <input type="text" class="form-control" v-model="product.manufacture_year">
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
            product: {}
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
        updateProduct() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/products/update/${this.$route.params.id}`, this.product)
                    .then(response => {
                        this.$router.push({name: 'products'});
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
