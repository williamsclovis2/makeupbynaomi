<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/veltrix/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Dec 2025 10:02:40 GMT -->
    <head>
        <?php  include("includes/head.php");?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- TOP HEADER -->
             <?php  include("includes/header.php");?>


            <!-- ========== LEFT SIDEBAR START========== -->
            
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">Create  Stock Items</h6>
                                    <?php  include("includes/timer.php");?>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                        <div class="dropdown">
                                            <a class="btn btn-primary " aria-expanded="false" href="list-stock">
                                                <i class="ti-view-grid me-2"></i> Items list
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">New Item</h4>
                                        <div class="card overflow-hidden">
                                            <div class="card-body " style="padding: unset !important;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="p-3 form-card">
                                                            <form class="mt-2">
                                                                <div class="mt-2 mb-0 row">
                                                                    <div class="col-12 mb-2">
                                                                        <p class="mb-0" style="color: red;">* All fields are mandatory</p>
                                                                    </div>
                                                                </div>

                                                                <!-- Item Name -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="item_name">Item Name</label>
                                                                    <input type="text" class="form-control" id="item_name" name="item_name"
                                                                        placeholder="e.g. Gel Polish - Red" required>
                                                                </div>

                                                                <!-- Category -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="category">Category</label>
                                                                    <select class="form-select" id="category" name="category" required>
                                                                        <option selected="">[ -- select category -- ]</option>
                                                                        <option value="Gel Polish">Gel Polish</option>
                                                                        <option value="Acrylic">Acrylic</option>
                                                                        <option value="Builder Gel">Builder Gel</option>
                                                                        <option value="Nail Tools">Nail Tools</option>
                                                                        <option value="Consumables">Consumables</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Brand -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="brand">Brand</label>
                                                                    <input type="text" class="form-control" id="brand" name="brand"
                                                                        placeholder="e.g. OPI, Mia Secret" required>
                                                                </div>

                                                                <!-- Quantity -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="quantity">Quantity</label>
                                                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                                                        placeholder="Enter quantity" required>
                                                                </div>

                                                                <!-- Unit -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="unit">Unit</label>
                                                                    <select class="form-select" id="unit" name="unit" required>
                                                                        <option selected="">[ -- select unit -- ]</option>
                                                                        <option value="Bottles">Bottles</option>
                                                                        <option value="Jars">Jars</option>
                                                                        <option value="Pieces">Pieces</option>
                                                                        <option value="Sets">Sets</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Cost Price -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="cost_price">Cost Price (UGX)</label>
                                                                    <input type="number" class="form-control" id="cost_price" name="cost_price"
                                                                        placeholder="Enter cost price" required>
                                                                </div>

                                                                <!-- Selling Price -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="selling_price">Selling Price (UGX)</label>
                                                                    <input type="number" class="form-control" id="selling_price" name="selling_price"
                                                                        placeholder="Enter selling price" required>
                                                                </div>

                                                                <!-- Minimum Stock Alert -->
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="min_stock">Minimum Stock Alert</label>
                                                                    <input type="number" class="form-control" id="min_stock" name="min_stock"
                                                                        placeholder="e.g. 3" required>
                                                                </div>

                                                                <!-- Submit Button -->
                                                                <div class="mb-3 row">
                                                                    <div class="col-12 text-end">
                                                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                                                                id="addStock" type="button">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                        <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                
                <footer class="footer">
                     <?php  include("includes/footer.php");?>
                </footer>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.html" 
                            data-appStyle="assets/css/app-dark.min.html" />
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
                    <div class="d-grid">
                        <a href="https://1.envato.market/grNDB" class="btn btn-primary mt-3" target="_blank"><i class="mdi mdi-cart me-1"></i> Purchase Now</a>
                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <?php  include("includes/script.php");?>

    </body>


<!-- Mirrored from themesbrand.com/veltrix/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Dec 2025 10:03:39 GMT -->
</html>