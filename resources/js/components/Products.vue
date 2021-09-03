<template>
    <div >
        <h4 class="text-center">All Products</h4><br/>
        <div class="alert alert-success" role="alert" v-if="success.length">
            {{ success }}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Manufacture Year</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product,index) in products" :key="index">
                    <td>{{ index+1 }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.manufacture_year }}</td>
                    <td>
                        <img class="full" v-bind:src="product.photo" width="80"  />
                    </td>
                    <td>{{ callDate(product.created_at) }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'editproduct', params: { id: product.id }}" class="btn btn-primary">Edit
                            </router-link>
                            <button :disabled="isSubmitting" class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <button type="button" class="btn btn-info" @click="this.$router.push('/products/add')">Add Product</button>
    </div>
</template>

<script>
import moment from "moment";
export default {
    data() {
        return {
            products: [],
            'fullWidthImage': false,
            success: [],
            isSubmitting: false,
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/products')
                .then(response => {
                    //console.log(response.data)
                    this.products = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        callDate(date) {
          const date1 = new Date(date);
            return moment(date1).format("DD/MM/YYYY");
        },
        deleteProduct(id) {
            this.isSubmitting = true
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/products/delete/${id}`)
                    .then(response => {
                        if (response.data.success) {
                            let i = this.products.map(item => item.id).indexOf(id); // find index of your object
                            this.products.splice(i, 1)
                            this.success = response.data.message
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
