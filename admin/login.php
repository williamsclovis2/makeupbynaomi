
<?php   
    require_once 'core/init.php'; 
    require_once 'app/controller.php'; 
    if($session_user->isLoggedIn()){ 
        Redirect::to(DNADMIN);
    }else{

            
        if(Input::CheckInput('login_username','post','1')){
            $pageviewClass = new PageView();
            $page_type = 'Login';
            $page_item_ID = 1;

            $grab_info = '';

            $grab_info .= Input::get('login_username','post');
            $pageviewClass->insert(array('page_ID'=>$page_item_ID,
                                'type'=>$page_type,
                                'grabbed_info'=>$grab_info));
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'views'._.'includes/head'.PL;?>
    </head>
    <style>
        .account-page-full{
               background-color: #0e192e;
        }
    </style>
    <body class="account-pages">
        <!-- Begin page -->
        <div class="accountbg" style="background: url('<?=DNADMIN?>/assets/images/bg.png');background-size: cover;background-position: center;"></div>

        <div class="wrapper-page account-page-full">
            <div class="card shadow-none">
                <div class="card-block">
                    <div class="account-box login-box" style="background: url(<?=DNADMIN?>/assets/images/l-bg.png); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <?php 
                            if(Input::checkInput('request','get','1')){
                                $post_request = Input::get('request','get');
                                switch($post_request){
                                    case 'resetpassword':
                                        include 'views/login/login-resetpassword'.P;
                                        break; 
                                    case 'forgotpassword':
                                        include 'views/login/login-forgotpassword'.P;
                                        break;   
                                    default:
                                        include 'views/login/login'.P;
                                    break;
                                }
                        }?>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- JAVASCRIPT -->
         <?php include 'views'._.'includes/script'.PL;?>
    </body>

<!-- Mirrored from themesbrand.com/veltrix/layouts/pages-login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Dec 2025 10:05:09 GMT -->
</html>
<?php

}?>