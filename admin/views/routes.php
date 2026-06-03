<?php 


if(@$url_struc['tree']!=""){
	switch($url_struc['tree']){
		case 'user':
			Functions::flashMsg();
            if(Input::checkInput('ID','get','1')){
                $profile_user_ID = Str::sanAsID(Input::get('ID','get'));  
            }else{
                $profile_user_ID = $session_user_data->ID;
            }
            
            $profile_user = new User();
            if($profile_user->find_user($profile_user_ID)){
                $profile_user_data = $profile_user->data();
                include 'views/user/profile'.PL;
            }else{
                include 'views/errors/404'.P;
            }
		break;
		case 'newuser':
			Functions::flashMsg();
			include 'views/user/new'.PL;
		break;
		case 'edituser':
			Functions::flashMsg();
			$user_ID = sanAsID(Input::get('id','get'));
			$userClass = new User();
			
			if($session_user_data->groups == "Admin" || $session_user_ID == $user_ID){
				if($userClass->find($user_ID)){
					$user_data = $userClass->data();
					include 'views/user/edit'.PL;
				}else{
					Redirect::to(404);
				}
			}else{
				Redirect::to(404);
			}
		break;
            
        // STORI
        
        case 'dashboard':
		
			Functions::actualisePaymentStatus();
			// ACTUALISE SUBSCRIPTION STATUS
            include 'views/home/dashboard'.PL;
			
        break;
            
        case 'app':
			Functions::flashMsg();

            $str = new Str();
            
            if(@$url_struc['trunk']!=""){
                switch($url_struc['trunk']){
                    case 'report':
                           
                        switch($url_struc['branch']){
                            case 'customersubscriptions':
                                include 'views/report/subscription/customer_subscription'.PL;
                            break;
                            case 'customersubscriptionslog':
                                include 'views/report/subscription/customer_subscription_log'.PL;
                            break;
                            case 'salesrevenuebyserie':
                                include 'views/report/sales/sales_revenue_by_serie'.PL;
                            break;
                        }
                    break;
                    case 'serie-package':
                           
                        switch($url_struc['branch']){
                            case 'new':
                                include 'views/serie-package/serie-package-new'.PL;
                            break;
                            case 'edit':
                                
                                $package_ID = Input::get('package_id','get');
                                $storiSeriePackageTable = new StoriSeriePackage();
                                
                                if($storiSeriePackageTable->find($package_ID)){

                                    $stori_serie_package_data = $storiSeriePackageTable->data();
                            
                                    include 'views/serie-package/serie-package-edit'.PL;
                                }
                                
                            break;
                            case 'list':
                                include 'views/serie-package/serie-package-list'.PL;
                            break;
                        }
                    break;
                    case 'serie':
                           
                        switch($url_struc['branch']){
                            case 'new':
                                include 'views/serie/serie-new'.PL;
                            break;
                            case 'edit':
                                
                                $serie_ID = Input::get('serie_id','get');
                                $storiSerieTable = new StoriSerie();
                                
                                if($storiSerieTable->find($serie_ID)){

                                    $stori_serie_data = $storiSerieTable->data();
                            
                                    include 'views/serie/serie-edit'.PL;
                                }
                                
                            break;
                            case 'list':
                                include 'views/serie/serie-list'.PL;
                            break;
                            case 'archive':
                                include 'views/serie/serie-archive'.PL;
                            break;
                            case 'statistics':
                                
                                $serie_ID = Input::get('serie_id','get');
                                $storiSerieTable = new StoriSerie();
                                
                                if($storiSerieTable->find($serie_ID)){

                                    $stori_serie_data = $storiSerieTable->data();
                            
                                    include 'views/serie/serie-statistics'.PL;
                                }
                                
                            break;
                            default:
                                include 'views/serie/serie-list'.PL;
                            break;
                        }
                    break;


                    // ENTRIES
                    
                    case 'entries':
                        switch($url_struc['branch']){

                            case 'matrix':
                                include 'views/entries/entries-matrix'.PL;
                            break;

                            case 'list':
                                include 'views/entries/entry-list'.PL;
                            break;

                            case 'new':
                                include 'views/entries/entry-new'.PL;
                            break;
                            

                            // case 'edit':

                            //     $entry_ID = Input::get('entry_id', 'get');
                            //     $entryTable = new Entry();

                            //     if($entryTable->find($entry_ID)){
                            //         $entry_data = $entryTable->data();
                            //         include 'views/entries/entry-edit'.PL;
                            //     }

                            // break;

                            default:
                                include 'views/entries/entry-list'.PL;
                            break;
                        }

                    break;

                    case 'entry-status':
                        $entry_ID = Input::get('entry-id', 'post');
                        
                        if (Input::checkInput('completed', 'post', '0')) {
                            $status = 'completed';
                            $form = NailEntryController::changeStatus($status, $entry_ID);
                        } elseif (Input::checkInput('paid', 'post', '0')) {
                            $status = 'paid';
                            $form = NailEntryController::changeStatus($status, $entry_ID);
                        } elseif (Input::checkInput('pending', 'post', '0')) {
                            $status = 'pending';
                            $form = NailEntryController::changeStatus($status, $entry_ID);
                        } elseif (Input::checkInput('cancelled', 'post', '0')) {
                            $status = 'cancelled';
                            $form = NailEntryController::changeStatus($status, $entry_ID);
                        }
                        
                        Redirect::to(DNADMIN . '/app/entries/list');
                    break;

                    // LIQUIDATIONS

                    case 'liquidations':
                        switch($url_struc['branch']){

                            case 'list':
                                include 'views/liquidation/liquidations'.PL;
                            break;


                            default:
                                include 'views/liquidation/liquidations'.PL;
                            break;
                        }

                    break;

                    // BOOKING
                    
                    case 'booking':
                        switch($url_struc['branch']){


                            case 'list':
                                include 'views/booking/booking-list'.PL;
                            break;

                            case 'new':
                                include 'views/booking/add-booking'.PL;
                            break;
                            

                            // case 'edit':

                            //     $entry_ID = Input::get('entry_id', 'get');
                            //     $entryTable = new Entry();

                            //     if($entryTable->find($entry_ID)){
                            //         $entry_data = $entryTable->data();
                            //         include 'views/entries/entry-edit'.PL;
                            //     }

                            // break;

                            default:
                                include 'views/entries/entry-list'.PL;
                            break;
                        }

                    break;

                    // Services
                    case 'services':
                        switch($url_struc['branch']){


                            case 'list':
                                include 'views/services/services-list'.PL;
                            break;

                            case 'new':
                                include 'views/services/services-new'.PL;
                            break;
                            

                            // case 'edit':

                            //     $entry_ID = Input::get('entry_id', 'get');
                            //     $entryTable = new Entry();

                            //     if($entryTable->find($entry_ID)){
                            //         $entry_data = $entryTable->data();
                            //         include 'views/entries/entry-edit'.PL;
                            //     }

                            // break;

                            default:
                                include 'views/services/services-list'.PL;
                            break;
                        }

                    break;
                   

                    // Expences
                    case 'expenses':
                        switch($url_struc['branch']){


                            case 'list':
                                include 'views/expenses/expenses-list'.PL;
                            break;

                            case 'new':
                                include 'views/expenses/expenses-new'.PL;
                            break;
                            

                            // case 'edit':

                            //     $entry_ID = Input::get('entry_id', 'get');
                            //     $entryTable = new Entry();

                            //     if($entryTable->find($entry_ID)){
                            //         $entry_data = $entryTable->data();
                            //         include 'views/entries/entry-edit'.PL;
                            //     }

                            // break;

                            default:
                                include 'views/services/services-list'.PL;
                            break;
                        }

                    break;

                    // if($trunk == 'liquidations') {
                    //     switch($branch) {
                    //         case 'list':
                    //             include 'views/liquidation/list.php';
                    //             break;
                                
                    //         // Add more liquidation views here if needed
                            
                    //         default:
                    //             include 'views/app/liquidations/list.php';
                    //             break;
                    //     }
                    // }




                    
                    case 'serie-episode':

                        $serie_ID = Input::get('serie_id','get');
                        
                        $storiSerieTable = new StoriSerie();

                        if($storiSerieTable->find($serie_ID)){

                            $stori_serie_data = $storiSerieTable->data();

                            switch($url_struc['branch']){
                                case 'list':
                                    include 'views/serie_episode/episode-list'.PL;
                                break;
                                case 'new':
                                    include 'views/serie_episode/episode-new'.PL;
                                break;
                                case 'edit':
                                    $episode_ID = Input::get('episode_id','get');
                                    $storiEpisodeTable = new StoriEpisode();

                                    if($storiEpisodeTable->find($episode_ID)){

                                        $stori_episode_data = $storiEpisodeTable->data();
                                        include 'views/serie_episode/episode-edit'.PL;
                                    }
                                break;
                                default:
                                break;
                            }
                        }

                    break;
                    case 'serie-episode-slide':
                                            
                        $episode_ID = Input::get('episode_id','get');
                        
                        $storiEpisodeTable = new StoriEpisode();

                        if($storiEpisodeTable->find($episode_ID)){

                            $stori_episode_data = $storiEpisodeTable->data();
                            
                            // Serie ID

                            $serie_ID = $stori_episode_data->serie_ID;

                            switch($url_struc['branch']){
                                case 'list':
                                    include 'views/serie_episode_slide/slide-list'.PL;
                                break;
                                case 'new':
                                    include 'views/serie_episode_slide/slide-new'.PL;
                                break;
                                case 'edit':
                                    $slide_ID = Input::get('slide_id','get');
                                    $storiSlideTable = new StoriSlide();

                                    if($storiSlideTable->find($slide_ID)){

                                        $stori_slide_data = $storiSlideTable->data();
                                        include 'views/serie_episode_slide/slide-edit'.PL;
                                    }
                                break;
                                default:
                                break;
                            }
                        }

                    break;
                }
            }
		break;
            
        // Company
            
        case 'company':
			Functions::flashMsg();
            if(@$url_struc['trunk']!=""){
                switch($url_struc['trunk']){
                    case 'profile':
                        include 'views/company/profile'.PL;
                    break;
                    case 'users':
                        switch($url_struc['branch']){    
                            case 'list':
                                switch($url_struc['branch-sub1']){
                                    case 'list':
                                        include 'views/company/users/user-list'.PL;
                                    break;
                                    default:
                                        include 'views/company/users/user-list'.PL;
                                    break;
                                }
                            break;
                            case 'new':
                                include 'views/company/users/user-new'.PL;
                            break; 
                            case 'edit':
                                $user_ID = Input::get('id','get');
                                $userTable = new User();
                                $userTable->selectQuery("SELECT * FROM `app_users` WHERE `company_ID`=? AND `ID`= ?",array($session_company_ID,$user_ID));
                                if(!$userTable->count()){
                                    Functions::errorPage(404);
                                }else{
                                    $user_data = $userTable->first();
                                    $user_ID = $user_data->ID;
                                    
                                    switch($url_struc['branch-sub1']){
                                        case 'password':
                                            include 'views/company/users/user-edit-password'.PL;
                                        break;
                                        default:
                                            include 'views/company/users/user-edit'.PL;
                                        break;
                                    }
                                }
                            break;
                         }
                        Functions::flashMsg();
                    break;
                    case 'subscriber':
                        switch($url_struc['branch']){    
                            case 'list':
                                switch($url_struc['branch']){
                                    case 'list':
                                        include 'views/company/subscriber/subscriber-list'.PL;    
                                    break;
                                    case 'admins':
                                        include 'views/company/subscriber/subscriber-list'.PL;    
                                    break;
                                    default:
                                        include 'views/company/subscriber/subscriber-list'.PL;
                                    break;
                                }
                            break;
                            case 'admins':
                                include 'views/company/subscriber/subscriber-admins'.PL;
                            break;
                            case 'new':
                                include 'views/company/subscriber/subscriber-new'.PL;
                            break; 
                            case 'newinvite':
                                include 'views/company/subscriber/subscriber-new-invite'.PL;
                            break; 
                            case 'edit':
                                $user_ID = Input::get('id','get');
                                $userTable = new User();
                                $userTable->selectQuery("SELECT * FROM `subscriber` WHERE `company_ID`=? AND `ID`= ?",array($session_company_ID,$user_ID));
                                if(!$userTable->count()){
                                    Functions::errorPage(404);
                                }else{
                                    $user_data = $userTable->first();
                                    $user_ID = $user_data->ID;
                                    
                                    switch($url_struc['branch-sub1']){
                                        case 'password':
                                            include 'views/company/subscriber/subscriber-edit-password'.PL;
                                        break;
                                        default:
                                            include 'views/company/subscriber/subscriber-edit'.PL;
                                        break;
                                    }
                                }
                            break;
                            case 'category':
                                $subscriber_ID = Input::get('id','get');
                                $subscriberTable = new Subscriber();
                                $subscriberTable->selectQuery("SELECT * FROM `subscriber` WHERE `ID`= ?",array($subscriber_ID));
                                if(!$subscriberTable->count()){
                                    Functions::errorPage(404);
                                }else{
                                    $subscriber_data = $subscriberTable->first();
                                    $subscriber_ID = $subscriber_data->ID;
                                    
                                    
                                    switch($url_struc['branch-sub1']){
                                        case 'password':
//                                            include 'views/company/subscriber/subscriber-edit-password'.PL;
                                        break;
                                        default:
                                            include 'views/company/subscriber/subscriber-category'.PL;
                                        break;
                                    }
                                }
                            break;
                            case 'categoryinvite':
                                $subscriber_ID = Input::get('id','get');
                                $subscriberTable = new Subscriber();
                                $subscriberTable->selectQuery("SELECT * FROM `subscriber` WHERE `ID`= ?",array($subscriber_ID));
                                if(!$subscriberTable->count()){
                                    Functions::errorPage(404);
                                }else{
                                    $subscriber_data = $subscriberTable->first();
                                    $subscriber_ID = $subscriber_data->ID;
                                    
                                    
                                    switch($url_struc['branch-sub1']){
                                        case 'password':
//                                            include 'views/company/subscriber/subscriber-edit-password'.PL;
                                        break;
                                        default:
                                            include 'views/company/subscriber/subscriber-categoryinvite'.PL;
                                        break;
                                    }
                                }
                            break;
                         }
                        Functions::flashMsg();
                    break;
                    case 'logs':
                         if($url_struc['branch'] == 'list'){
                            switch($url_struc['branch-sub1']){
                                case 'list':
                                    include 'views/company/users/user-access_log'.PL;
                                break;
                                default:
                                    include 'views/company/users/user-access_log'.PL;
                                break;
                            }
                         }
                        Functions::flashMsg();
                    break;
                    default:
                        include 'views/errors/404'.P;
                    break;
                }
            }else{
                include 'views/errors/404'.P;
            }
		break;
        

            
		//Events
		
		
		//Applicants
		
		
		default:	
			Session::put('errors','Page not found <a href="index">Go Back</a>');
			Functions::flashMsg();
			include 'views/errors/404'.P;
			$_GET['request'] = '404';
			$request = "404";
		break;
	}	
}else{
    Functions::flashMsg();
    include 'views/home/dashboard'.PL;

}

?>