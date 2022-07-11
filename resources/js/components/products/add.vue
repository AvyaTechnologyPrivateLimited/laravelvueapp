<template>
<main class="app-content" id="app">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cogs"></i>Add Product </h1>
        </div>
    </div>
    <form role="form">
        <div class="row user">
            <div class="col-md-9">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Name</label>
                                    <input class="form-control " type="text" placeholder="Enter product name" id="name" value="ICT" />
                                   
                                    <div class="invalid-feedback active"><i class="fa fa-exclamation-circle fa-fw"></i></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="slug"> Custom URL (Slug) - Optional </label>
                                    <input class="form-control " type="text" placeholder="Enter product slug" id="slug" />
                                  
                                    <div class="invalid-feedback active"><i class="fa fa-exclamation-circle fa-fw"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="sku">SKU</label>
                                    <input class="form-control " type="number" placeholder="Enter product sku" id="sku"  />
                                  
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="brand_id">Brand</label>
                                    <Select>
                                        <Option>--Select-</Option>
                                    </Select>

                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="price">Price</label>
                                    <InputNumber class="form-control " type="text" placeholder="Enter product price" id="price" value="85.00" />
                                  
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="quantity">Quantity</label>
                                    <InputNumber min=1 class="form-control " type="number" placeholder="Enter product quantity" id="quantity" />
                                 
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea id="description" rows="2" class="form-control" >It's good product </textarea>
                            
                        </div>
                    </div>
                    <!-- SUBMIT BUTTON   -->
                    <!-- form -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"> Categories / Publishing </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;">
                                <Select>
                                    <Option>--Select--
                                       </Option>
                                </Select>
                              
                                <div class="form-group mt-3 mb-0">
                                    <label for="status"> Publish : </label>
                                    <i-switch  color="success"> </i-switch>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-warning collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"> Image </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2 ml-4">
                <div class="col-6 text-right">
                    <Button type="success" >
                        <i class="fa fa-fw fa-lg fa-check-circle"></i>
                     </Button>
                    <Button type="default" >
                        <i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back </Button>
                </div>
            </div>
        </div>
    </form>
</main>
</template>
<style>
    .demo-upload-list{
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
    /* .ivu-icon {
        line-height: 58px;
    } */
</style>
