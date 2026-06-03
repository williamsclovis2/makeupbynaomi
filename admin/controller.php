<?php


$error_message = '';
$form_error = false;
$form = (object)['ERRORS' => false];

$request = Input::get('request','get');
$url_struc['tree'] = Input::get('request','get');
$url_struc['trunk'] = Input::get('trunk','get');
$url_struc['branch'] = Input::get('branch','get');
$var_branch = array();

if(Input::checkInput('branch','get','1')){
    $var_branch = explode('-',Input::get('branch','get'));
    $url_struc['branch'] = $var_branch[0];
}

$url_struc['branch-sub1'] = @$var_branch[1];
$url_struc['branch-sub2'] = @$var_branch[2];


if($url_struc['tree'] =='app'){
    $url_struc['app-idname'] = Input::get('idname','get');
}
if($url_struc['branch-sub2'] =='export'){
    
    $event_ID = Input::get('id','get');
    Redirect::to(DNADMIN.'/export/'.$event_ID);
}

if($url_struc['branch-sub2'] =='exportsearch'){
    
    $event_ID = Input::get('id','get');
    Redirect::to(DNADMIN.'/exportsearch/');
}

//********************//
//    GET DETECTS    //
//******************//



if(Input::checkInput('request','get','1')){
	$post_request = Input::get('request','get');
	switch($post_request){
            
       // Logout
            
		case 'logout':
			$db = DB::getInstance();
            $sessionName = Config::get('session/session_name');
            $cookieName = Config::get('remember/cookie_name');
            $temp = Config::get('time/seconds');
            if(isset($_SESSION[$sessionName])){
                $user_ID = Session::get($sessionName);
                
        
                $db->delete('app_user_session',array('user_ID','=',$user_ID));
                $db->update('app_users',$user_ID,array('account_session'=>'0','last_access'=>$temp));
                Cookie::delete($cookieName);
                
                session_destroy();
                session_unset();
                //session_regenerate_id(true);

                $sessionName = Config::get('session/session_name');
                $cookieName = Config::get('remember/cookie_name');

                if(isset($_COOKIE["$sessionName"])){
                    unset($_COOKIE["$sessionName"]);
                    setcookie($sessionName, null, -1, '/');
                    Cookie::delete($cookieName);
                } 
            }
            Redirect::to(DNADMIN.'/login');
		break;
            
		case 'resetpassword':
            if(Input::checkInput('id','get','1')){
               $generated_string = Input::get('code','get');

                $user_id = Input::get('id','get');
                $userTable = new User();
                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `ID`= ? AND `recovery_string`!=''",array($user_id));
                if(!$userTable->count()){
                    Redirect::to(DNADMIN.'/login/forgotpassword');
                }else{

                    $user_data = $userTable->first();
                    $secret_key = $user_data->password;
                    $recovery_string = strtoupper(hash_hmac('SHA256', $generated_string, pack('H*',$secret_key)));
                    if($recovery_string == $user_data->recovery_string){

                        $user_ID = $user_data->ID;                 
                    }else{
                        Redirect::to(DNADMIN.'/login/forgotpassword');
                    }
                } 
            }else{
                if(Input::get('response','get') != 'success'){
                    Redirect::to(DNADMIN.'/login/forgotpassword');
                }
            }
		break;
    }
}
?>


<?php 
          
		// USERS
if(Input::checkInput('request','post','1')){
	$post_request = Input::get('request','post');
	switch($post_request){
		// USERS
		case 'user_sigggnup':
			$form = UserController::signup();
			if($form->ERRORS == false){
                $_POST['login_username'] = $_POST['signup_username'];
                $_POST['login_password'] = $_POST['signup_password'];
                $form = UserController::login('Signup');
                $form = CompanyController::create();
				Redirect::to('login');
			}else{
				// echo errors
			}
		break;
		case 'user_login':
			$form = UserController::login();
			if($form->ERRORS == false){
				Redirect::to(DNADMIN);
			}else{
				//echo errors
			}
		break;
		case 'recover-login':
            if(Input::checkInput('recover-email','post','1')){
                $user_email = Input::get('recover-email','post');
                $userTable = new User();
                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `email`= ?",array($user_email));
                if(!$userTable->count()){
                    $form->ERRORS = true;
                }else{
                    $user_data = $userTable->first();
                    if($user_data->email == $user_email){
                        
                        $user_ID = $user_data->ID;

                        $form = UserController::requestPasswordReset($user_ID);

                        if($form->ERRORS == false){
                            Redirect::to(DNADMIN.'/login/forgotpassword/success');
                        }else{
                            //echo errors
                        }                   
                    }
                }
			}
            Redirect::to(DNADMIN.'/login/forgotpassword/errors');
		break;
		case 'user-new':
            $CompanyDb = DB::getInstance();
            $Company_select = $CompanyDb->get(array('ID'),'app_company',array('ID','=',$session_company_ID));
            if($Company_select->count()){
                $_POST['user-company_ID'] = $session_company_ID;
                $form = UserController::add();
                if($form->ERRORS == false){
                   Redirect::to(DNADMIN.'/company/users/list');
                }else{
                    //echo errors
                }
            }
		break;
		case 'user-update':
            if(Input::checkInput('id','get','1')){
                $user_ID = Input::get('id','get');
                $userTable = new User();
                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `company_ID`=? AND `ID`= ?",array($session_company_ID,$user_ID));
                if(!$userTable->count()){
                    Functions::errorPage(404);
                }else{
                    $user_data = $userTable->first();
                    $user_ID = $user_data->ID;
                
                    $user_ID = Str::sanAsID(Input::get('id','get'));
                    if($url_struc['branch-sub1'] == 'password'){
                        $form = UserController::updatePassword($user_ID);
                    }else{
                        $form = UserController::update($user_ID);
                    }
                    
                    if($form->ERRORS == false){
				        Session::put('success','User account updated successfully');
                        Redirect::to(DNADMIN.'/company/users/list');
                    }else{
                        //echo errors
                    }
                }
			}else{
				Session::put('errors','Bad request! Please, contact the Admin'); 
                Redirect::to(DNADMIN.'/company/users/list');
			}
		break;
		case 'reset-password':
            if(Input::checkInput('id','get','1')){
                $user_ID = Input::get('id','get');
                $userTable = new User();
                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `ID`= ?",array($user_ID));
                if(!$userTable->count()){
                   // Redirect::to(DNADMIN.'/404');
                }else{
                    $user_data = $userTable->first();
                    $user_ID = $user_data->ID;
                
                    $form = UserController::resetPassword($user_ID);
                    
                    if($form->ERRORS == false){
				        Session::put('success','Password changed successfully');
                        Redirect::to(DNADMIN.'/login/resetpassword/success');
                    }else{
                        //echo errors
                    }
                }
			}else{
                Redirect::to(DNADMIN.'/404');
			}
		break;
            
		case 'user-state':
            $user_ID = Str::sanAsID(Input::get('user-id','post'));
            $userTable = new User();
            $userTable->selectQuery("SELECT * FROM `app_users` WHERE `company_ID`=? AND `ID`= ?",array($session_company_ID,$user_ID));
            if(!$userTable->count()){
                Functions::errorPage(404);
            }else{
                $user_data = $userTable->first();
                if(Input::checkInput('block','post','0')){
                     $state = 'Block';
                     $form = UserController::changeState($state,$user_ID);
                 }elseif(Input::checkInput('activate','post','0')){
                     $state = 'Activate';
                     $form = UserController::changeState($state,$user_ID);
                     if($form){
                         
                     }
                    
                    if($form->ERRORS == false){
                       Redirect::to(DNADMIN.'/company/users/list');
                    }else{
                        //echo errors
                    }
                }
			}
        break;

        
        case 'serie-package-new':
            $form = StoriSeriePackageController::add();
            if($form->ERRORS == false){
                Session::put('success','Package added successfully');
                Redirect::to(DNADMIN.'/app/serie-package/list');
            }else{
                //echo errors
            }
        break; 
        case 'serie-package-edit':
                                            
            $package_ID = Input::get('package_id','get');
            $storiSeriePackageTable = new StoriSeriePackage();

            if($storiSeriePackageTable->find($package_ID)){
                $stori_serie_package_data = $storiSeriePackageTable->data();
                
                $form = StoriSeriePackageController::edit($stori_serie_package_data);
                if($form->ERRORS == false){
                    Session::put('success','Serie edited successfully');
                    Redirect::to(DNADMIN.'/app/serie-package/list');
                }else{
                    //echo errors
                }
            }
        break; 
		case 'serie-package-status':
          
            $package_ID = Input::get('package-id','post');
           
            if(Input::checkInput('Published','post','0')){
                 $state = 'Published';
                
                 $form = StoriSeriePackageController::changeState($state,$package_ID);
            }elseif(Input::checkInput('Deleted','post','0')){
                $state = 'Deleted';
                $form = StoriSeriePackageController::changeState($state,$package_ID);
              
            }elseif(Input::checkInput('PinTop','post','0')){
                
                $form = StoriSeriePackageController::pinOnTop($package_ID);
                
            }
            Redirect::to(DNADMIN.'/app/serie-package/list');
            
        break;

           
        case 'serie-new':
            $form = StoriSerieController::add();
            if($form->ERRORS == false){
                //$subscriber_data = $form->ERRORS_SCRIPT['data'];
                
                Session::put('success','Serie added entry added successfully');
                Redirect::to(DNADMIN.'/app/serie/list');
            }else{
                //echo errors
            }
        break; 
        case 'serie-edit':
            
                                
            $serie_ID = Input::get('serie_id','get');
            $storiSerieTable = new StoriSerie();

            if($storiSerieTable->find($serie_ID)){
                $stori_serie_data = $storiSerieTable->data();
                
                $form = StoriSerieController::edit($stori_serie_data);
                if($form->ERRORS == false){
                    //$subscriber_data = @$form->ERRORS_SCRIPT['data'];

                    Session::put('success','Serie edited successfully');
                    Redirect::to(DNADMIN.'/app/serie/list');
                }else{
                    //echo errors
                }
            }
        break; 
            
		case 'serie-status':
          
            $serie_ID = Input::get('serie-id','post');
            
            if(Input::checkInput('Published','post','0')){
                 $state = 'Published';
                
                 $form = StoriSerieController::changeState($state,$serie_ID);
            }elseif(Input::checkInput('Pending','post','0')){
                 $state = 'Pending';
                 $form = StoriSerieController::changeState($state,$serie_ID);
                 
            }elseif(Input::checkInput('Deleted','post','0')){
                $state = 'Deleted';
                $form = StoriSerieController::changeState($state,$serie_ID);
            }elseif(Input::checkInput('PinTop','post','0')){
                $form = StoriSerieController::pinOnTop($serie_ID);
            }
            Redirect::to(DNADMIN.'/app/serie/list');
            
        break;
            
        // Episode
            
            
        case 'episode-new':
            
            $serie_ID = Input::get('id','post');
            
            $form = StoriEpisodeController::add($serie_ID);
            if($form->ERRORS == false){
                //$subscriber_data = $form->ERRORS_SCRIPT['data'];
                
                Session::put('success','Episode added entry added successfully');
                Redirect::to(DNADMIN.'/app/serie-episode/'.$serie_ID.'/list');
            }else{
                //echo errors
            }
        break;
        case 'episode-edit':
            
            $serie_ID = Input::get('id','post');
            
            $episode_ID = Input::get('episode_id','get');
            $storiEpisodeTable = new StoriEpisode();

            if($storiEpisodeTable->find($episode_ID)){

                $stori_episode_data = $storiEpisodeTable->data();
                            
                $form = StoriEpisodeController::edit($stori_episode_data);
                if($form->ERRORS == false){
                    //$subscriber_data = @$form->ERRORS_SCRIPT['data'];

                    Session::put('success','Episode edited successfully');
                    Redirect::to(DNADMIN.'/app/serie-episode/'.$serie_ID.'/list');
                }else{
                    //echo errors
                }
            }
        break; 
            
            
		case 'episode-status':
          
            $episode_ID = Input::get('episode-id','post');
            //$serie_ID = Input::get('serie_id','get');
            
            if(Input::checkInput('Published','post','0')){
                 $state = 'Published';
                
                 $form = StoriEpisodeController::changeState($state,$episode_ID);
                 
             }elseif(Input::checkInput('Pending','post','0')){
                 $state = 'Pending';
                 $form = StoriEpisodeController::changeState($state,$episode_ID);
                 
             }elseif(Input::checkInput('Deleted','post','0')){
                 $state = 'Deleted';
                 $form = StoriEpisodeController::changeState($state,$episode_ID);
             }
            
        break;
            
            
            // Slider
            
            
        case 'slide-new':
            
            $episode_ID = Input::get('id','post');
            
            $form = StoriSlideController::add($episode_ID);
            if($form->ERRORS == false){
                //$subscriber_data = $form->ERRORS_SCRIPT['data'];
                
                Session::put('success','Slide added successfully');
                Redirect::to(DNADMIN.'/app/serie-episode-slide/'.$episode_ID.'/list');
            }else{
                //echo errors
            }
        break; 
            
        case 'slide-edit':
            
            $episode_ID = Input::get('episode_id','get');
            
            $slide_ID = Input::get('slide_id','get');
            $storiSlideTable = new StoriSlide();

            if($storiSlideTable->find($slide_ID)){

                $stori_slide_data = $storiSlideTable->data();
                
                $form = StoriSlideController::edit($stori_slide_data);
                if($form->ERRORS == false){
                    //$subscriber_data = @$form->ERRORS_SCRIPT['data'];

                    Session::put('success','Slide added successfully');
                    Redirect::to(DNADMIN.'/app/serie-episode-slide/'.$episode_ID.'/list');
                }else{
                    //echo errors
                }
            }
        break; 
            
        case 'slide-status':
          
            $slide_ID = Input::get('slide-id','post');
            
            if(Input::checkInput('Published','post','0')){
                 $state = 'Published';
                
                 $form = StoriSlideController::changeState($state,$slide_ID);
             }elseif(Input::checkInput('Pending','post','0')){
                 $state = 'Pending';
                 $form = StoriSlideController::changeState($state,$slide_ID);
             }elseif(Input::checkInput('Deleted','post','0')){
                 $state = 'Deleted';
                 $form = StoriSlideController::changeState($state,$slide_ID);
             }
            
        break; 
            
            
            
            
            
		case 'subscriber-update':
            if(Input::checkInput('id','get','1')){
                $user_ID = Input::get('id','get');
                $subscriberTable = new Subscriber();
                $subscriberTable->selectQuery("SELECT * FROM `subscriber` WHERE `ID`= ?",array($user_ID));
                if(!$subscriberTable->count()){
                    Functions::errorPage(404);
                }else{
                    $user_data = $subscriberTable->first();
                    $user_ID = $user_data->ID;
                
                    $user_ID = Str::sanAsID(Input::get('id','get'));
                    if($url_struc['branch-sub1'] == 'password'){
                        $form = SubscriberController::updatePassword($user_ID);
                    }else{
                        $form = SubscriberController::update($user_ID);
                    }
                    
                    if($form->ERRORS == false){
				        Session::put('success','User account updated successfully');
                        Redirect::to(DNADMIN.'/company/subscriber/list');
                    }else{
                        //echo errors
                    }
                }
			}else{
				Session::put('errors','Bad request! Please, contact the Admin'); 
                Redirect::to(DNADMIN.'/company/subscriber/list');
			}
		break;
		case 'subscateg-update':
            if(Input::checkInput('id','get','1')){
                $subscriber_ID = Input::get('id','get');
                $subscriberTable = new Subscriber();
                $subscriberTable->selectQuery("SELECT * FROM `subscriber` WHERE `ID`= ?",array($subscriber_ID));
                if(!$subscriberTable->count()){
                    Functions::errorPage(404);
                }else{
                    $subscriber_data = $subscriberTable->first();
                    $subscriber_ID = $subscriber_data->ID;
                
                    $subscriber_ID = Str::sanAsID(Input::get('id','get'));
                    
                    $form = SubscriberCategoryController::add($subscriber_ID);
                    
                    if($form->ERRORS == false){
                        Session::put('success','Record successful');
                        Redirect::to(DNADMIN."/company/subscriber/$subscriber_ID/category");
                    }else{
                        //echo errors
                    }
                }
			}else{
				Session::put('errors','Bad request! Please, contact the Admin'); 
                Redirect::to(DNADMIN.'/company/subscriber/list');
			}
		break;
            
		case 'subscriber-password_reset':
            if(Input::checkInput('id','get','1')){
                $user_ID = Input::get('id','get');
                $userTable = new User();
                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `ID`= ?",array($user_ID));
                if(!$userTable->count()){
                   // Redirect::to(DNADMIN.'/404');
                }else{
                    $user_data = $userTable->first();
                    $user_ID = $user_data->ID;
                
                    $form = UserController::resetPassword($user_ID);
                    
                    if($form->ERRORS == false){
				        Session::put('success','Password changed successfully');
                        Redirect::to(DNADMIN.'/login/resetpassword/success');
                    }else{
                        //echo errors
                    }
                }
			}else{
                Redirect::to(DNADMIN.'/404');
			}
		break;
            
		case 'subscriber-state':
            $user_ID = Str::sanAsID(Input::get('user-id','post'));
            $userTable = new User();
            $userTable->selectQuery("SELECT * FROM `app_users` WHERE `company_ID`=? AND `ID`= ?",array($session_company_ID,$user_ID));
            if(!$userTable->count()){
                Functions::errorPage(404);
            }else{
                $user_data = $userTable->first();
                if(Input::checkInput('block','post','0')){
                     $state = 'Block';
                     $form = UserController::changeState($state,$user_ID);
                 }elseif(Input::checkInput('activate','post','0')){
                     $state = 'Activate';
                     $form = UserController::changeState($state,$user_ID);
                     if($form){
                         
                     }
                    
                    if($form->ERRORS == false){
                       Redirect::to(DNADMIN.'/company/subscriber/list');
                    }else{
                        //echo errors
                    }
                }

			}
        break;
            
    }
}

?>