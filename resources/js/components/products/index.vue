<template>
	<div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Products</div>

                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" placeholder="Todo.." class="form-control" aria-label="todo" aria-describedby="todo" v-model="todo_input">
                            <div class="input-group-append">

                                <button  type="button" class="btn btn-info text-white" >Add</button>

                                <button  class="btn btn-info text-white">Update</button>

                                
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm text-danger float-right" @click="resetTodo()">Reset</button>

                        <table class="table table-bordered mt-4">
                            <thead>
                                <th>S.no</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
