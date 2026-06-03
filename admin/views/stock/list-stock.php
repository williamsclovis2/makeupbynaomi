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
                                    <h6 class="page-title">Items  list</h6>
                                    <?php  include("includes/timer.php");?>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                        <div class="dropdown">
                                            <a class="btn btn-primary " aria-expanded="false" href="stock-new">
                                                <i class="mdi mdi-plus me-2"></i> Add Items
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
                                        <h4 class="card-title mb-4">Items  List</h4>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover table-centered table-nowrap mb-0">
                                                <thead id="table-head">
                                                    <tr>
                                                        <th scope="col">#N</th>
                                                        <th scope="col">ITEM NAME</th>
                                                        <th scope="col">CATEGORY</th>
                                                        <th scope="col">BRAND</th>
                                                        <th scope="col">QTY</th>
                                                        <th scope="col">UNIT</th>
                                                        <th scope="col">COST</th>
                                                        <th scope="col">PRICE</th>
                                                        <th scope="col">STATUS</th>
                                                        <th scope="col">LAST UPDATED</th>
                                                        <th scope="col">ACTION</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Acrylic Powder – Clear</td>
                                                        <td>Acrylic</td>
                                                        <td>Mia Secret</td>
                                                        <td>2</td>
                                                        <td>Jars</td>
                                                        <td>40,000 UGX</td>
                                                        <td>80,000 UGX</td>
                                                        <td><span class="badge bg-warning">Low Stock</span></td>
                                                        <td>18 Jan 2026</td>
                                                        <td>
                                                        <button class="btn btn-sm btn-primary">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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