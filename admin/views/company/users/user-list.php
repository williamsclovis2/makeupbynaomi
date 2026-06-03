
<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">All Users</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <div class="dropdown">
                    <?php if($session_user_data->groups == 'Admin' || $session_user_data->groups == 'RG-SUPER-Admin'){ ?>
                        <a class="btn btn-primary " aria-expanded="false" href="<?=DNADMIN?>/company/users/new">
                            <i class="mdi mdi-plus me-2"></i> Add  User
                        </a>
                     <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
 <!-- start row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">User List</h4>
                <div class="table-responsive">
                    <div class="col-xs-12 col-sm-4 hidden-xs">
                        <!-- Main search form -->
                        <form action="#" method="get" class="mainsearch-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Quick search">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-primary waves-effect waves-light"><i class="ti-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th scope="col">#NO</th>
                                <th scope="col">Names </th>
                                <th scope="col">Email</th>
                                <th scope="col">Access type </th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $userTable = new User();
                            $userTable->selectQuery(
                                "SELECT * FROM `app_users` WHERE `company_ID`=? AND `state`!= 'Deleted'",
                                array($session_company_ID)
                            );

                            if(!$userTable->count()){
                                Functions::errorPage(404);
                            }else{
                                $i = 0;
                                foreach($userTable->data() as $user_data){
                                    $i++;
                                    $user_ID = $user_data->ID;

                                    if(
                                        $session_user_data->groups == "Admin" ||
                                        $session_user_ID == $user_ID ||
                                        $session_user_data->groups == "RG-Admin" ||
                                        $session_user_data->groups == "RG-SUPER-Admin"
                                    ){
                        ?>
                             <tr <?=($user_data->state=='Blocked'?'style="opacity:.6"':'')?>>
                                <td><?=$i?></td>
                                <td><?=$user_data->firstname.' '.$user_data->lastname?></td>
                                <td><?=$user_data->email?></td>

                                <!-- Access type -->
                                <td>
                                    <?php if($user_data->state!='Blocked'){ ?>
                                        <span class="badge bg-<?=$user_data->account_session=='1'?'success':'info'?>">
                                            <?=($user_data->groups=='End-User'?'Cube-Admin':$user_data->groups)?>
                                        </span>
                                    <?php }else{ ?>
                                        <span class="badge bg-secondary"><?=$user_data->groups?></span>
                                    <?php } ?>
                                </td>

                                 <td>
                                    <span class="badge bg-<?=$user_data->state=='Activated'?'success':'danger'?>">
                                        <?=$user_data->state?>
                                    </span>
                                </td>


                                <!-- Action dropdown -->
                                <td class="text-end">
                                    <div class="dropdown btn-group" role="group">

                                        <button id="btnGroupVerticalDrop1 " type="button" class="btn btn-primary dropdown-toggle three-dots" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Dropdown
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                               href="<?=DNADMIN."/company/users/$user_data->ID/edit";?>">
                                                <i class="fa fa-pencil me-2"></i>Edit
                                            </a>

                                            <a class="dropdown-item"
                                               href="<?=DNADMIN."/company/users/$user_data->ID/edit-password";?>">
                                                <i class="fa fa-unlock-alt me-2"></i>Change password
                                            </a>

                                            <?php if($session_user_data->ID != $user_data->ID){ ?>
                                                <form method="post" class="px-3">
                                                    <input type="hidden" name="webToken" value="56">
                                                    <input type="hidden" name="request" value="user-state">
                                                    <input type="hidden" name="user-id" value="<?=$user_data->ID?>">

                                                    <?php if($user_data->state!='Blocked'){ ?>
                                                        <button class="dropdown-item text-danger" name="block">
                                                            <i class="fa fa-times-circle me-2"></i>Block
                                                        </button>
                                                    <?php } ?>

                                                    <?php if($user_data->state!='Activated'){ ?>
                                                        <button class="dropdown-item text-success" name="activate">
                                                            <i class="fa fa-check-circle me-2"></i>Activate
                                                        </button>
                                                    <?php } ?>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- end row -->


  <script>
    $(document).on("click", ".popover-close", function(e) {
        $($(this).data('popoverid')).popover('hide');
        $($(this).data('popoverid')).removeClass('open');
    });

    $('.popover-el').click(function (e) {
        if(!$(this).hasClass('open')){
            $(this).popover('show');
            $(this).addClass('open');
        }else{
            $(this).popover('hide');
            $(this).removeClass('open');
        }
    });


    $(document).ready(function(){
        $('body').on('click', function (e) {
            $('.popover-el.open').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                    $(this).removeClass('open');
                }
            });
        });
    });
</script>



