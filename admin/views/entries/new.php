 
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
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Matrix List</h4>
                <div class="col-xs-12 col-sm-12 mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk" value="entries">
                        <input type="hidden" name="branch" value="list">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">Service type</label>
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by service type" value="<?= @$_GET['keyword'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="<?= @$_GET['from_date'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="<?= @$_GET['to_date'] ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="submit" name="search" class="btn btn-primary waves-effect waves-light">
                                        <i class="ti-search"></i> Search
                                    </button>
                                    <a href="<?=DNADMIN?>/app/entries/list" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-hover table-bordered table-centered table-nowrap mb-0">
                            <thead id="table-head">
                                <tr>
                                    <th>SERVICES</th>
                                    <th>Worker 1</th>
                                    <th>Worker 2</th>
                                    <th>Worker 3</th>
                                    <th>Worker 4</th>
                                    <th>Worker 5</th>
                                    <th>Worker 6</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="group-row">
                                    <td><span class="services-td">Gell Nail</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td">acrylic both</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td">Gell Nail</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td"> acrylic feet and hands</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td"> Gel Nails</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td"> Bridal Nails</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td"> acrylic feet and hands</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td><span class="services-td">Gell Nail</span></td>
                                    <td>100.000UGX</td>
                                    <td>---</td>
                                    <td>50.000UGX (collaboration )</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>120.000 UGX</td>
                                </tr>
                            </tbody>
                            <tbody class="tfooter">
                                <tr class="group-row">
                                    <td class="totals"><span class="services-td"> GENERAL TOTAL</span></td>
                                    <td>800.000UGX</td>
                                    <td>---</td>
                                    <td>400.000UGX</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>960.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td class="totals"><span class="services-td"> (TOTAL 40% WORKER)</span></td>
                                    <td>320.000 UGX</td>
                                    <td>---</td>
                                    <td>160.000UGX </td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>384.000 UGX</td>
                                </tr>
                                <tr class="group-row">
                                    <td class="totals"><span class="services-td">TOTAL (60% COMP)</span></td>
                                    <td>480.000 UGX</td>
                                    <td>---</td>
                                    <td>240.000UGX </td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>576.000 UGX</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                      