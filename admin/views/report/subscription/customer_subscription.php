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
                    <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small> <i class="fa fa-angle-double-right"></i> </small> Customer Subscription Report
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
                    if(@empty($_SESSION['cust_subscript_sort'])){
                        $_SESSION['cust_subscript_sort'] = "`ID` DESC";  
                         Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }

                    $search_sql = "";
                    $search_form = false;
                    $sql_val_array = array('APPROVED');
                   
                    if(Input::checkInput('search','get','1')){
                        $search_form = true;
                        
                        $keyword = urldecode(Input::get('keyword','get'));

                        if(Input::checkInput('keyword','get','1')){
                            $search_sql .= " 
                                AND (`transaction_status` LIKE '%{$keyword}%' || 
                                    `activation_status` LIKE '%{$keyword}%' ||
                                    `customer_ID` LIKE '%{$keyword}%' || 
                                    `serie_ID` LIKE '%{$keyword}%' ||
                                    `episode_ID` LIKE '%{$keyword}%' ||
                                    `telephone` LIKE '%{$keyword}%' ||
                                    `ID` = '{$keyword}')";
                        }
                    }
                    ?>
                      
                    
                </div>
              
              
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Report</h3>

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
                                <th><button type="submit" name="sort-id">Entry No.</button></th>
                                <th><button type="submit" name="sort-request_date">Date</button></th>
                                <th>Customer</th>
                                <th><button type="submit" name="sort-serie_ID">Serie</button></th>
                                <th>Episode</th>
                                <th><button type="submit" name="sort-telephone">Telephone</button></th>
                                <th><button type="submit" name="sort-language">Amount</button></th>
                                <th><button type="submit" name="sort-date_activation">Activation</button></th>
                                <th><button type="submit" name="sort-date_expiration">Expiration</button></th>
                                <th><button type="submit" name="sort-activation_status">Activation Status</button></th>
                                <th><button type="submit" name="sort-transaction_status">Transaction Status</button></th>
                                  <th style="width: 60px">Menu</th>
                              </tr>
                            </form>
                          </thead>
                          <tbody>
                              
                            <?php
                              
                                $seconds = \Config::get('time/seconds');
                                
                                $storiSubscriptionTable = new StoriSubscription();
           
                                $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=?  $search_sql ORDER BY {$_SESSION['cust_subscript_sort']}  ",$sql_val_array);
                                

                                /*Start Pagination Setting*/
                                    $rowsLimit = 50;
                                    $pageNumber = 0;
                                    if(Input::checkInput('page','get','1')){
                                        $pageNumber = (int)sanAsID(Input::get('page','get'));
                                    }
                                    $requesturl = "?check";

                                    $totalStore=$storiSubscriptionTable->count();
                                    $totalPages = upfloat($totalStore/$rowsLimit);
                                    $offsetNumber = $pageNumber*$rowsLimit;
                                    if($offsetNumber >= $totalStore){
                                        $pageNumber=0;
                                        $offsetNumber = $pageNumber*$rowsLimit;
                                    }
                                /*End Pagination Setting*/

                                $dataArr = array();

                                if(Input::checkInput('keyword','get','0') ){

                                    $storiSubscriptionTable = new StoriSubscription();
           
                                    $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=?  $search_sql ORDER BY {$_SESSION['cust_subscript_sort']}  LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                
                                }else{
                                 
                                    $storiSubscriptionTable = new StoriSubscription();
           
                                    $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=?  $search_sql ORDER BY {$_SESSION['cust_subscript_sort']}  LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                
                                    
                                 }
                              
                              
								if($storiSubscriptionTable->count()){
									$i = 0;
									foreach($storiSubscriptionTable->data() as $participant_data){
										$i++;
                                        $participant_ID = $participant_data->ID;
                                        
                                        $stateColor =  "#dddddd";
                                        
                                      ?>

                                      <tr class="row_layout">
                                        <td>
                                            <a style="border-color: <?=$stateColor?>" class="id popover-el participant-menu-popover-<?=$participant_data->ID?>"><?=$participant_data->ID;?> <i class="fa fa-angle-down pull-right menu_icon"></i></a>
                                        </td>
                                        <td>
                                            <?=$participant_data->request_date?>
                                        </td>
                                        <td>
                                            <?=$participant_data->customer_ID?>
                                        </td>
                                        <td>
                                            <a href="<?=DNADMIN?>/app/serie-episode/<?=$participant_data->serie_ID?>/list">
                                                <?=$participant_data->serie_ID?>
                                            </a>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>" ><?php echo $participant_data->episode_ID;?></span>
                                        </td>
                                        <td><?=$participant_data->telephone?></td>
                                        <td><?=$participant_data->amount?></td>
                                        <td><?=$participant_data->date_activation?></td>
                                          
                                        <td><?=$participant_data->date_expiration?></td>
                                          
                                        <td ><?=$participant_data->activation_status?></td>
                                          
                                        <td><?=$participant_data->transaction_status?></td>
                                        <td>
                                            <div>
                                              <a class="participant-menu-popover-<?=$participant_data->ID?> popover-el" tabindex="0" role="button" >More</a>
                                            </div>
                                            
                                            <div id="participant-menu-content-<?=$participant_data->ID?>" class="hidden">
                                                
                                                <form method="post">
                                                    
                                                    <input type="hidden" name="request" value="subscription-status">
                                                    <input type="hidden" name="subscription-id" value="<?=$participant_data->ID?>">
                                                       
                                                    <ul class="popover-menu-list">
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".participant-menu-popover-<?=$participant_data->ID?>" data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>"><i class="fa fa-eye icon"></i> View</a></li>
                                                        
                                                        
                                                        <!--<li><a class="menu" href="<?=DNADMIN?>/app/serie-episode/<?=$participant_data->ID?>/list"><i class="fa fa-list icon"></i>  Episodes list</a></li>-->
                                                        
                                                        <?php if($participant_data->transaction_status=='APPROVED'){?>
                                                            <!--<li><button class="menu" type="submit" name="Published"><i class="fa fa-upload icon"></i>  Published</button></li> -->
                                                        <?php }?>
                                                        
                                                        <!--<li><button class="menu" type="submit" name="Deleted"><i class="fa fa-trash icon"></i>  Deleted</button></li>-->
                                                        
                                                        <?php if($participant_data->transaction_status=='REQUESTED'){?>
                                                            <li><button class="menu" type="submit" name="CheckPaymentStatus" class="btn btn-success pull-right" ><i class="fa fa-upload icon"></i> Check Payment</button></li>
                                                         <?php }?>
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".participant-menu-popover-<?=$participant_data->ID?>"><i class="fa fa-times icon"></i> Close</a></li>
                                                        
                                                    </ul>
                                                    
                                                </form>
                                                
                                            </div>
                                            
                                            <script>
                                                $(function(){
                                                    // Enables popover #1
                                                    $(".participant-menu-popover-<?=$participant_data->ID?>").popover({
                                                        html : true, 
                                                        placement : 'bottom', 
                                                        trigger: 'manual',
                                                        content: function() {
                                                          return $("#participant-menu-content-<?=$participant_data->ID?>").html();
                                                        },
                                                        title: function() {
                                                          return $("#participant-menu-title-<?=$participant_data->ID?>").html();
                                                        }
                                                    });
                                                });
                                            </script>
                                        </td>
                                      </tr>	
                                    <!-- Modal -->
                                            <div class="modal fade" id="myModal_<?=$participant_data->ID?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog modal-md" role="document" style="width: 400px">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">More Details</h4>
                                                  </div>
                                                  <div class="modal-body" style="background: #dedede">
                                                      
                                                        <div class="box" style="border-top: 0px;">
                                
                                                          
                                                            <div class="box-body" style="padding: 0px;">


                                                            </div>
                                                            <div class="box-body">
                                                                <p>
                                                                    <label class="product_title">Transaction ID: </label> <?=$participant_data->transaction_ID?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Customer Telephone: </label> <?=$participant_data->telephone?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Package: </label> <?=$participant_data->package?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Amount: </label> <?=$participant_data->amount?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Transaction Status: </label> <?=$participant_data->transaction_status?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                      
                                                  </div>
                                                  <div class="modal-footer" style="text-align: left">
                                                     <form method="post">
                                                        <input type="hidden" name="request" value="subscription-status">
                                                        <input type="hidden" name="serie-id" value="<?=$participant_data->ID?>">
                                                        
                                                        
                                                         <?php if($participant_data->transaction_status=='REQUESTED'){?>
                                                        <button type="submit" name="CheckPaymentStatus" class="btn btn-success pull-right" >Check Payment</button>
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
                                    <td colspan="7"><br/>No Subscription recorded</td>
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
    
	  <div class="row">
		<div class="col-md-8 col-xs-12">
           
		</div><!-- ./col -->
		<div class="col-md-4 col-xs-12">
           
		</div><!-- ./col -->
	  </div><!-- /.row -->
    
</section>