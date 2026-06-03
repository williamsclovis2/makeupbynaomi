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
                    <a href="<?=DNADMIN?>"><i class="fa fa-pie-chart fa-lg pink-col"></i></a> <small><i class="fa fa-angle-double-right"></i> </small>  
                    <a href="<?=DNADMIN?>/app/serie/list" class="pink-col"> <?=$stori_serie_data->serie_title?></a>  <small><i class="fa fa-angle-double-right"></i> </small> 
                     Statistics  
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
              
                <li class="dropdown notifications-menu">
                      <a href="<?=DNADMIN?>/app/serie/list"><i class="fa fa-chevron-left"></i> Back</a>
                </li>
                
                
            </ul>
          </div>
        </nav>
	</div>
</section>


<!-- Main content -->
<section class="content">
    
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Subscriptions</span>
              
                <?php 
                    $total_subscriptions_approved= 0;
                    $sql_val_array = array('APPROVED',$serie_ID);
                    $storiSubscriptionTable = new StoriSubscription();
                    $storiSubscriptionTable->selectQuery("SELECT `activation_status` FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=? ",$sql_val_array);
                    $total_subscriptions_approved = $storiSubscriptionTable->count();
                ?>
                
              <span class="info-box-number"><?=$total_subscriptions_approved?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Subscribers</span>
              
               <?php 
                    $total_subscribers_array = array();
                    $sql_val_array = array('APPROVED',$serie_ID);
                    $storiSubscriptionTable = new StoriSubscription();
                    $storiSubscriptionTable->selectQuery("SELECT `customer_ID` FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=? ",$sql_val_array);
                    if($storiSubscriptionTable->count()){
                        foreach($storiSubscriptionTable->data() as $stori_subscription_data){
                            $total_subscribers_array[] = $stori_subscription_data->customer_ID;
                        }
                    }
                    $total_subscribers_array = array_unique($total_subscribers_array);
                    $total_subscribers = count($total_subscribers_array);
                ?>
                
              <span class="info-box-number"><?=$total_subscribers?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Revenues</span>
               <?php 
                    $total_serie_revenue = 0;
                    $sql_val_array = array('APPROVED',$serie_ID);
                    $storiSubscriptionTable = new StoriSubscription();
                    $storiSubscriptionTable->selectQuery("SELECT `amount` FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=? ",$sql_val_array);
                    if($storiSubscriptionTable->count()){
                        foreach($storiSubscriptionTable->data() as $stori_subscription_data){
                            $total_serie_revenue += $stori_subscription_data->amount;
                        }
                    }
                ?>
                
              <span class="info-box-number"><?=$total_serie_revenue?> RWF</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-grey"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Declines</span>
              
                <?php 
                    $pie_subscription_declined = 0;
                    $sql_val_array = array('DECLINED',$serie_ID);
                    $storiSubscriptionTable = new StoriSubscription();
                    $storiSubscriptionTable->selectQuery("SELECT `activation_status` FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=? ",$sql_val_array);
                    $pie_subscription_declined = $storiSubscriptionTable->count();
                ?>
                
              <span class="info-box-number"><?=$pie_subscription_declined?></span>
            </div>
             <!--/.info-box-content -->
          </div>
           <!--/.info-box -->
        </div>
         <!--/.col -->
        
      </div>
      
      <br/>
		
 <!-- Small boxes (Stat box) -->
	  <div class="row">
          <div class="col-sm-8 col-md-8">
             
               
                <?php 
                    if(@empty($_SESSION['serie_subsription_sort'])){
                        $_SESSION['serie_subsription_sort'] = "`ID` DESC";  
                         Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }

                    $search_sql = "";
                    $search_form = false;
                    $sql_val_array = array('APPROVED',$serie_ID);
                   
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
             
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                      <i class="fa fa fa-ellipsis-v"></i>

                      <h3 class="box-title">Subscriptions</h3>

                      <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                        <div class="btn-group" data-toggle="btn-toggle">
                          
                        </div>
                      </div>
                    </div>
                    <br>
                    
                    <div class="box-body" style="padding: 10px 25px 10px 25px; ">
                        
                         <div class="table-responsive">
                            <table class="table no-margin">
                              <thead>
                                <form method="post">
                                  <tr>
                                    <th><button type="submit" name="sort-id">Entry No.</button></th>
                                    <th><button type="submit" name="sort-request_date">Date</button></th>
                                    <th>Customer</th>
                                    <th>Episode</th>
                                    <th><button type="submit" name="sort-telephone">Telephone</button></th>
                                    <th><button type="submit" name="sort-language">Amount</button></th>
                                    <th><button type="submit" name="sort-date_expiration">Expiration</button></th>
                                    <th><button type="submit" name="sort-activation_status">Activation</button></th>
                                  </tr>
                                </form>
                              </thead>
                              <tbody>
                                  
                                <?php
                                  
                                    $seconds = \Config::get('time/seconds');
                                    
                                    $storiSubscriptionTable = new StoriSubscription();
               
                                    $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=?  $search_sql ORDER BY {$_SESSION['serie_subsription_sort']}  ",$sql_val_array);
                                    
    
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
               
                                        $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=?  $search_sql ORDER BY {$_SESSION['serie_subsription_sort']}  LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                    
                                    }else{
                                     
                                        $storiSubscriptionTable = new StoriSubscription();
               
                                        $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=?  $search_sql ORDER BY {$_SESSION['serie_subsription_sort']}  LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                    
                                        
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
                                                <span data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>" ><?php echo $participant_data->episode_ID;?></span>
                                            </td>
                                            <td><?=$participant_data->telephone?></td>
                                            <td><?=$participant_data->amount?></td>
                                              
                                            <td><?=$participant_data->date_expiration?></td>
                                              
                                            <td ><?=$participant_data->activation_status?>
                                                
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
                  
          </div>
          <div class="col-sm-4 col-md-4">
              
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Subscription Status</h3>
    
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="pieChart" style="height: 287px; width: 575px;" width="575" height="287"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              
                <?php 
                    $pie_total_subscription_activated = 0;
                    $pie_total_subscription_expired = 0;
                    
                    $sql_val_array = array('APPROVED',$serie_ID);
                    $storiSubscriptionTable = new StoriSubscription();
                    $storiSubscriptionTable->selectQuery("SELECT `activation_status` FROM `stori_subscription` WHERE `transaction_status`=? AND `serie_ID`=? ",$sql_val_array);
                    if($storiSubscriptionTable->count()){
                        
    					foreach($storiSubscriptionTable->data() as $participant_data){
    					    if($participant_data->activation_status == 'ACTIVATED'){
    					        $pie_total_subscription_activated += 1;
    					    }else if($participant_data->activation_status == 'EXPIRED'){
    					        $pie_total_subscription_expired += 1;
    					    }
    					}
                        
                    }
                ?>
              
              <script>
                    //-------------
                    //- PIE CHART -
                    //-------------
                    // Get context with jQuery - using jQuery's .get() method.
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieChart       = new Chart(pieChartCanvas)
                    var PieData        = [
                      {
                        value    : <?=$pie_total_subscription_expired?>,
                        color    : '#f56954',
                        highlight: '#f56954',
                        label    : 'Expired'
                      },
                      {
                        value    : <?=$pie_total_subscription_activated?>,
                        color    : '#00a65a',
                        highlight: '#00a65a',
                        label    : 'Activated'
                      }
                    ]
                    var pieOptions     = {
                      //Boolean - Whether we should show a stroke on each segment
                      segmentShowStroke    : true,
                      //String - The colour of each segment stroke
                      segmentStrokeColor   : '#fff',
                      //Number - The width of each segment stroke
                      segmentStrokeWidth   : 2,
                      //Number - The percentage of the chart that we cut out of the middle
                      percentageInnerCutout: 50, // This is 0 for Pie charts
                      //Number - Amount of animation steps
                      animationSteps       : 100,
                      //String - Animation easing effect
                      animationEasing      : 'easeOutBounce',
                      //Boolean - Whether we animate the rotation of the Doughnut
                      animateRotate        : true,
                      //Boolean - Whether we animate scaling the Doughnut from the centre
                      animateScale         : false,
                      //Boolean - whether to make the chart responsive to window resizing
                      responsive           : true,
                      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                      maintainAspectRatio  : true,
                      //String - A legend template
                      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
                    }
                    //Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                    pieChart.Doughnut(PieData, pieOptions)
              </script>
              
              
          </div>

	  </div><!-- /.row -->
    
    
</section>



