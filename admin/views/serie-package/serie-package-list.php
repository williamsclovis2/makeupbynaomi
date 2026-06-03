<style>
    th button{
        border: 0;
        background: transparent;
    }
    hr{
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>

<section class="content-header">
	<div class="page_header">
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				<h3 class="content-title">
                    <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small> <i class="fa fa-angle-double-right"></i> </small> Serie Packages
				</h3>
			</div>
			<div class="col-xs-12 col-sm-4 hidden-xs">
				<!-- Main search form -->
				<form action="#" method="get" class="mainsearch-form">
					<div class="input-group">
						<input type="text" name="keyword" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" value="1" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<section class="content-header navbar_header">
	<div>
		 <nav class="navbar navbar-static-top navbar_content" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-branch-menu">
            <ul class="nav navbar-nav">
              <li class="">
                <a href="<?=DNADMIN?>/"> <i class="fa fa-home"></i> Home </a>
              </li>               
              <li class="dropdown notifications-menu">
                    <a href="<?=DNADMIN?>/app/serie-package/new"><i class="fa fa-plus"></i> Add new</a>
              </li>
            </ul>
          </div>
        </nav>
	</div>
</section>


<!-- Main content -->
<section class="content">
		
 <!-- Small boxes (Stat box) -->
	  <div class="row">
          <div class="col-sm-12 col-md-12">
                 <!--RECENT REGISTER -->
              <div>
                  
                <?php 
                    if(@empty($_SESSION['package_sort'])){
                        $_SESSION['package_sort'] = "`ID` DESC";  
                         Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
                    
                    if(Input::checkInput('sort-code','post','0')){
                        $_SESSION['package_sort'] = $_SESSION['package_sort'] == "`code` ASC" ? "`code` DESC" : "`code` ASC";
                          Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
					
                    // Sort PinTop
                    if(Input::checkInput('sort-pin_top','post','0')){
                        $_SESSION['package_sort'] = $_SESSION['package_sort'] == "`pin_top` ASC" ? "`pin_top` DESC" : "`pin_top` ASC";
                          Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
					          // Sort create_date
                    if(Input::checkInput('sort-created_date','post','0')){
                        $_SESSION['package_sort'] = $_SESSION['package_sort'] == "`created_date` ASC" ? "`created_date` DESC" : "`created_date` ASC";
                         Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
					
                    $search_sql = "";
                    $search_form = false;
                    $sql_val_array = array('Deleted');
                   
                    if(Input::checkInput('search','get','1')){
                        $search_form = true;
                        
                        $keyword = urldecode(Input::get('keyword','get'));

                        if(Input::checkInput('keyword','get','1')){
                            $search_sql .= " 
                                AND (`code` LIKE '%{$keyword}%' || 
                                    `description` LIKE '%{$keyword}%' || 
                                    `status` LIKE '%{$keyword}%' ||
                                    `ID` = '{$keyword}')";
                        }
                    }
                    ?>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Serie Package list</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    
                    <br>
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <thead>
                            <form method="post">
                              <tr>
                                <th><button type="submit" name="sort-id">No.</button></th>
                                <th>Image</th>
                                <th><button type="submit" name="sort-name">Code</button></th>
                                <th>Description</th>
                                <th><button type="submit" name="sort-pin_top">Pin Top</button></th>
                                <th><button type="submit" name="sort-created_date">Created Date</button></th>
                                <th><button type="submit" name="sort-status">Status</button></th>
                                  <th style="width: 60px">Menu</th>
                              </tr>
                            </form>
                          </thead>
                          <tbody>
                              
                            <?php
                              
                                $seconds = \Config::get('time/seconds');
                                $storiSeriePackage = new StoriSeriePackage();
                                $storiSeriePackage->selectQuery("SELECT* FROM `stori_package` WHERE `status`!=?  $search_sql ORDER BY {$_SESSION['package_sort']}",$sql_val_array);

                                /*Start Pagination Setting*/
                                    $rowsLimit = 50;
                                    $pageNumber = 0;
                                    if(Input::checkInput('page','get','1')){
                                        $pageNumber = (int)sanAsID(Input::get('page','get'));
                                    }
                                    $requesturl = "?check";

                                    $totalStore=$storiSeriePackage->count();
                                    $totalPages = upfloat($totalStore/$rowsLimit);
                                    $offsetNumber = $pageNumber*$rowsLimit;
                                    if($offsetNumber >= $totalStore){
                                        $pageNumber=0;
                                        $offsetNumber = $pageNumber*$rowsLimit;
                                    }
                                /*End Pagination Setting*/

                                $dataArr = array();

                                if(Input::checkInput('keyword','get','0') ){

                                  $storiSeriePackage = new StoriSeriePackage();
                                  $storiSeriePackage->selectQuery("SELECT * FROM `stori_package` WHERE `status`!=?  $search_sql ORDER BY {$_SESSION['package_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);

                                }else{
                                 
                                    
                                      $storiSeriePackage = new StoriSeriePackage();
                                      $storiSeriePackage->selectQuery("SELECT * FROM `stori_package` WHERE `status`!=?  $search_sql ORDER BY {$_SESSION['package_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                }
                              
                              
                                  if($storiSeriePackage->count()){
                                    $i = 0;
                                    foreach($storiSeriePackage->data() as $package_data){
                                      $i++;
                                      $package_ID = $package_data->ID;
                                        
                                      $stateColor =  "#dddddd";
                                        
                                      ?>

                                      <tr class="row_layout">
                                        <td>
                                            <a style="border-color: <?=$stateColor?>" class="id popover-el package-menu-popover-<?=$package_data->ID?>"><?=$package_data->ID;?> <i class="fa fa-angle-down pull-right menu_icon"></i></a>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$package_data->ID?>" >
                                                <img src="<?=DNADMIN.'/'.$package_data->photo?>" style="height: 30px; margin: auto" class="img img-responsive block-center">
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$package_data->ID?>" >
                                                <?=$package_data->code?>
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$package_data->ID?>" ><?php echo $package_data->description;?></span>
                                        </td>
                                       
                                        <td ><?=$package_data->pin_top?></td>
                                        <td ><?=$package_data->created_date?></td>

                                        <td><?=$package_data->status?></td>
                                        <td>
                                            <div>
                                              <a class="package-menu-popover-<?=$package_data->ID?> popover-el" tabindex="0" role="button" >More</a>
                                            </div>
                                            
                                            <div id="package-menu-content-<?=$package_data->ID?>" class="hidden">
                                                
                                                <form method="post">
                                                    
                                                    <input type="hidden" name="request" value="serie-package-status">
                                                    <input type="hidden" name="package-id" value="<?=$package_data->ID?>">
                                                        
                                                    
                                                    <ul class="popover-menu-list">
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".package-menu-popover-<?=$package_data->ID?>" data-toggle="modal" data-target="#myModal_<?=$package_data->ID?>"><i class="fa fa-eye icon"></i> View</a></li>
                                                        <li><a class="menu" href="<?=DNADMIN?>/app/serie-package/edit/<?=$package_data->ID?>"><i class="fa fa-pencil icon"></i> Edit</a></li>
                                                        <li><button class="menu" type="submit" name="PinTop"><i class="fa fa-map-pin icon"></i>  Pin on top</button></li>
                                                        
                                                        <?php if($package_data->status!='Published'){?>
                                                            <li><button class="menu" type="submit" name="Published"><i class="fa fa-upload icon"></i>  Published</button></li> 
                                                        <?php }?>
                                                        
                                                        <?php if($package_data->status!='Deleted'){?>
                                                            <li><button class="menu" type="submit" name="Deleted"><i class="fa fa-spinner icon"></i>  Deleted</button></li>
                                                        <?php }?>
                                                                                                                
                                                        <li><a class="menu popover-close" data-popoverid=".package-menu-popover-<?=$package_data->ID?>"><i class="fa fa-times icon"></i> Close</a></li>
                                                        
                                                    </ul>
                                                    
                                                </form>
                                                
                                            </div>
                                            
                                            <script>
                                                $(function(){
                                                    // Enables popover #1
                                                    $(".package-menu-popover-<?=$package_data->ID?>").popover({
                                                        html : true, 
                                                        placement : 'bottom', 
                                                        trigger: 'manual',
                                                        content: function() {
                                                          return $("#package-menu-content-<?=$package_data->ID?>").html();
                                                        },
                                                        title: function() {
                                                          return $("#package-menu-title-<?=$package_data->ID?>").html();
                                                        }
                                                    });
                                                });
                                            </script>
                                        </td>
                                      </tr>	
                                    <!-- Modal -->
                                            <div class="modal fade" id="myModal_<?=$package_data->ID?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog modal-md" role="document" style="width: 400px">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">More Details</h4>
                                                  </div>
                                                  <div class="modal-body" style="background: #dedede">
                                                      
                                                        <img src="<?=DNADMIN.'/'.$package_data->photo?>" style="height: 300px; margin: auto" class="img img-responsive block-center">
                                                        <br/>
                                                      
                                                        <div class="box" style="border-top: 0px;">
                                
                                                          
                                                            <div class="box-body" style="padding: 0px;">


                                                            </div>
                                                            <div class="box-body">
                                                                <p>
                                                                    <label class="product_title">Code: </label> <?=$package_data->code?>
                                                                </p>
                                                                <hr>
                                                                <label class="product_title">Description: </label>
                                                                <p>
                                                                      <?=$package_data->description?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                      
                                                  </div>
                                                  <div class="modal-footer" style="text-align: left">
                                                     <form method="post">
                                                        <input type="hidden" name="request" value="serie-package-status">
                                                        <input type="hidden" name="serie-id" value="<?=$package_data->ID?>">
                                                        
                                                                                                                  
                                                         <?php if($package_data->status!='Published'){?>
                                                        <button type="submit" name="Published" class="btn btn-success pull-right" >Publish</button>
                                                          <?php }?>
                                                          
                                                                
                                                         <?php if($package_data->status!='Deleted'){?>
                                                        <button type="submit" name="Deleted" class="btn btn-danger pull-right"  style="margin-right: 5px!important; ">Delete</button>
                                                         <?php }?>
                                                    </form>    
                                                    
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                    <!-- end of modal -->

                                  <?php }?>
                                <tr>
                                    <?php 
                                        if(Input::checkInput('keyword','get','0') || strlen(Input::get('keyword','get'))<3){?>
                                    <td colspan="9">
                                        <?php include 'views/pagination'.PL;?>
                                    </td>
                                    <?php }?>
                                </tr>
                            <?php }else{?>
                                <tr>
                                    <td colspan="7"><br/>No Package recorded</td>
                                </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                        
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
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        
                        
                    </div>
                    <!-- /.box-footer -->
                  </div>
              
              
                 <!--RECENT REGISTER -->
          </div>
	  </div><!-- /.row -->
    
    
    
</section>