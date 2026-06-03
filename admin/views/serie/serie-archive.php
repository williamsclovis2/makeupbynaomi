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
                    <a href="<?=DNADMIN?>"><i class="fa fa-trash fa-lg pink-col"></i></a> <small> <i class="fa fa-angle-double-right"></i> </small> Archived Series
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
                    if(@empty($_SESSION['participant_sort'])){
                        $_SESSION['participant_sort'] = "`ID` DESC";  
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
                                AND (`serie_title` LIKE '%{$keyword}%' || 
                                    `serie_description` LIKE '%{$keyword}%' || 
                                    `package_type` LIKE '%{$keyword}%' ||
                                    `language` LIKE '%{$keyword}%' ||
                                    `state` LIKE '%{$keyword}%' ||
                                    `ID` = '{$keyword}')";
                        }
                    }
                    ?>
                      
                    
                </div>
              
              
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Archive</h3>

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
                                <th>Image</th>
                                <th><button type="submit" name="sort-name">Title</button></th>
                                <th>Description</th>
                                <th><button type="submit" name="sort-language">Language</button></th>
                                <th><button type="submit" name="sort-pass_type">Package</button></th>
                                <th><button type="submit" name="sort-pass_type">Display type</button></th>
                                <th><button type="submit" name="sort-create_date">Created Date</button></th>
                                <th><button type="submit" name="sort-state">Status</button></th>
                                  <th style="width: 60px">Menu</th>
                              </tr>
                            </form>
                          </thead>
                          <tbody>
                              
                            <?php
                              
                                $seconds = \Config::get('time/seconds');
                                $storiSerieTable = new StoriSerie();
                                $storiSerieTable->selectQuery("SELECT* FROM `stori_serie` WHERE `state`=?  $search_sql ORDER BY {$_SESSION['participant_sort']}",$sql_val_array);

                                /*Start Pagination Setting*/
                                    $rowsLimit = 50;
                                    $pageNumber = 0;
                                    if(Input::checkInput('page','get','1')){
                                        $pageNumber = (int)sanAsID(Input::get('page','get'));
                                    }
                                    $requesturl = "?check";

                                    $totalStore=$storiSerieTable->count();
                                    $totalPages = upfloat($totalStore/$rowsLimit);
                                    $offsetNumber = $pageNumber*$rowsLimit;
                                    if($offsetNumber >= $totalStore){
                                        $pageNumber=0;
                                        $offsetNumber = $pageNumber*$rowsLimit;
                                    }
                                /*End Pagination Setting*/

                                $dataArr = array();

                                if(Input::checkInput('keyword','get','0') ){

                                  $storiSerieTable = new StoriSerie();
                                  $storiSerieTable->selectQuery("SELECT * FROM `stori_serie` WHERE `state`=?  $search_sql ORDER BY {$_SESSION['participant_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);

                                }else{
                                 
                                    
                                      $storiSerieTable = new StoriSerie();
                                      $storiSerieTable->selectQuery("SELECT * FROM `stori_serie` WHERE `state`=?  $search_sql ORDER BY {$_SESSION['participant_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                }
                              
                              
								if($storiSerieTable->count()){
									$i = 0;
									foreach($storiSerieTable->data() as $participant_data){
										$i++;
                                        $participant_ID = $participant_data->ID;
                                        
                                        $stateColor =  "#dddddd";
                                        
                                      ?>

                                      <tr class="row_layout">
                                        <td>
                                            <a style="border-color: <?=$stateColor?>" class="id popover-el participant-menu-popover-<?=$participant_data->ID?>"><?=$participant_data->ID;?> <i class="fa fa-angle-down pull-right menu_icon"></i></a>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>" >
                                                <img src="<?=DNADMIN.'/'.$participant_data->photo?>" style="height: 30px; margin: auto" class="img img-responsive block-center">
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>" >
                                                <?=$participant_data->serie_title?>
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>" ><?php echo $participant_data->serie_description;?></span>
                                        </td>
                                        <td><?=$participant_data->language?></td>
                                        <td><?=$participant_data->package?></td>
                                          
                                        <td><?=$participant_data->package_type?></td>
                                          
                                        <td ><?=$participant_data->created_date?></td>
                                          
                                        <td><?=$participant_data->state?></td>
                                        <td>
                                            <div>
                                              <a class="participant-menu-popover-<?=$participant_data->ID?> popover-el" tabindex="0" role="button" >More</a>
                                            </div>
                                            
                                            <div id="participant-menu-content-<?=$participant_data->ID?>" class="hidden">
                                                
                                                <form method="post">
                                                    
                                                    <input type="hidden" name="request" value="serie-status">
                                                    <input type="hidden" name="serie-id" value="<?=$participant_data->ID?>">
                                                        
                                                    
                                                    <ul class="popover-menu-list">
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".participant-menu-popover-<?=$participant_data->ID?>" data-toggle="modal" data-target="#myModal_<?=$participant_data->ID?>"><i class="fa fa-eye icon"></i> View</a></li>
                                                        
                                                        
                                                        
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
                                                      
                                                        <img src="<?=DNADMIN.'/'.$participant_data->photo?>" style="height: 300px; margin: auto" class="img img-responsive block-center">
                                                        <br/>
                                                      
                                                        <div class="box" style="border-top: 0px;">
                                
                                                          
                                                            <div class="box-body" style="padding: 0px;">


                                                            </div>
                                                            <div class="box-body">
                                                                <p>
                                                                    <label class="product_title">Serie title: </label> <?=$participant_data->serie_title?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Package: </label> <?=$participant_data->package?>
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <label class="product_title">Package type: </label> <?=$participant_data->package_type?>
                                                                </p>
                                                                <hr>
                                                                <label class="product_title">Descriotion: </label>
                                                                <p>
                                                                      <?=$participant_data->serie_description?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                      
                                                  </div>
                                                  <div class="modal-footer" style="text-align: left">
                                                     <form method="post">
                                                        <input type="hidden" name="request" value="serie-status">
                                                        <input type="hidden" name="serie-id" value="<?=$participant_data->ID?>">
                                                        
                                                         
                                                        <button type="submit" name="Pending" class="btn btn-default pull-right"  style="margin-left: 5px!important; background: #595959; color: #eee">Re-Open</button>
                                                        
                                                        
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
                                    <td colspan="7"><br/>No StoriSerie recorded</td>
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