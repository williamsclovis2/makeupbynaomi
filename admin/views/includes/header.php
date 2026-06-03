<!-- ================== TOP HEADER ================== -->
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?=DNADMIN?>/assets/images/fav.png" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=DNADMIN?>/assets/images/fav.png" alt="" height="70">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?=DNADMIN?>/assets/images/fav.png" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=DNADMIN?>/assets/images/fav.png" alt="" height="70">
                    </span>
                </a>
            </div>

            <button type="button"
                    class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <div class="d-flex">
            <!-- Search -->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="fa fa-search"></span>
                </div>
            </form>

            <!-- Fullscreen -->
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button"
                        class="btn header-item noti-icon waves-effect"
                        data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <!-- USER DROPDOWN -->
            <div class="dropdown d-inline-block">
                <button type="button"
                        class="btn header-item waves-effect"
                        id="page-header-user-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                    <?php if (!empty($session_user_data->profile) && file_exists($session_user_data->profile)) { ?>
                        <img class="rounded-circle header-profile-user"
                             src="<?= $session_user_data->profile ?>"
                             alt="Header Avatar">
                    <?php } else { ?>
                        <span class="rounded-circle header-profile-user d-inline-flex align-items-center justify-content-center"
                              style="background:orange;color:#fff;font-weight:600;">
                            <?= substr($session_user_data->firstname, 0, 1); ?>
                        </span>
                    <?php } ?>

                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-account-circle me-1"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-wallet me-1"></i> My Wallet
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <i class="mdi mdi-cog me-1"></i> Settings
                        <span class="badge bg-success ms-auto">11</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-lock-open-outline me-1"></i> Lock screen
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= DNADMIN ?>/logout">
                        <i class="bx bx-power-off me-1 text-danger"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================== LEFT SIDEBAR ================== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Main</li>

                <li>
                    <a href="<?=DNADMIN?>/dashboard" class="waves-effect">
                        <i class="ti-home"></i>
                        <span class="badge rounded-pill bg-primary float-end">1</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ti-pie-chart"></i>
                        <span>Manage Entries</span>
                    </a>
                    <ul class="sub-menu">
                        <?php if($session_user_data->groups !== 'Worker'): ?>
                        <li><a href="<?=DNADMIN?>/app/entries/new">Add Entry</a></li>
                        <li><a href="<?=DNADMIN?>/app/entries/list">Entries List</a></li>
                        <?php endif; ?>
                        <li><a href="<?=DNADMIN?>/app/entries/matrix">Entries Matrix</a></li>
                    </ul>
                </li>
                <?php if($session_user_data->groups !== 'Worker'): ?>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ti-pie-chart"></i>
                        <span>Manage Bookings</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?=DNADMIN?>/app/booking/new">New Booking</a></li>
                        <li><a href="<?=DNADMIN?>/app/booking/list">Booking List</a></li>
                    </ul>
                </li>
                 <?php endif; ?>
                <?php if(!in_array($session_user_data->groups, ['Worker', 'Sub-Admin'])): ?>
                    <li>
                        <a href="<?=DNADMIN?>/app/liquidations/list" class="waves-effect">
                            <i class="ti-wallet"></i>
                            <span>Liquidations</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if($session_user_data->groups !== 'Worker'): ?>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ti-wallet"></i>
                        <span>Manage Expenses</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?=DNADMIN?>/app/expenses/new">Expenses new</a></li>
                        <li><a href="<?=DNADMIN?>/app/expenses/list">Expenses List</a></li>
                    </ul>
                </li>

                

                <li class="menu-title">Services</li>

                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ti-view-grid"></i>
                        <span>Manage Services</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?=DNADMIN?>/app/services/new">New Service</a></li>
                        <li><a href="<?=DNADMIN?>/app/services/list">Services</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ti-archive"></i>
                        <span>Manage Stocks</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="list-stock">Stock List</a></li>
                    </ul>
                </li>
                 <?php endif; ?>
                
                
                <?php  if(!in_array($session_user_data->groups, ['Worker', 'Sub-Admin'])): ?>
                <li class="menu-title">Users</li>

                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect ">
                        <i class="ion ion-md-person-add"></i>
                        <span>Manage users</span>
                    </a>
                    <ul class="sub-menu <?php if($url_struc['tree']=="company" && $url_struc['trunk']=="users"){ echo 'actived';}?></ul>">
                        <li><a href="<?=DNADMIN?>/company/users/list">All users</a></li>
                        <li><a href="#">View Reports</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
