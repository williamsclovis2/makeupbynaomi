<?php   
date_default_timezone_set('Africa/Kampala');
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

require_once 'core/init.php'; 
require_once 'app/controller.php';
if(!$session_user->isLoggedIn()){ 
    Redirect::to(DNADMIN.'/login');
}?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'views'._.'includes/head'.PL;?>
</head>

<body data-sidebar="dark">
<!-- Begin page -->
    <div id="layout-wrapper">
        <!-- TOP HEADER -->
         <?php include 'views'._.'includes/header'.PL;?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- PAGE CONTENT -->
                    <?php include 'views/routes'.PL;?>

                </div><!-- container-fluid -->
            </div><!-- End Page-content -->

            <!-- FOOTER -->
            <footer class="footer">
                <?php include 'views'._.'includes/footer'.PL;?>

            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

<!-- RIGHT SIDEBAR -->

<!-- <div class="control-sidebar-bg"></div> -->

<!-- REQUIRED JS -->

  <?php include 'views'._.'includes/script'.PL;?>


</body>
</html>
