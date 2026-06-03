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
                    <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small><i class="fa fa-angle-double-right"></i> </small>  
                    <a href="<?=DNADMIN?>/app/serie-episode/<?=$serie_ID?>/list" class="pink-col"> <?=$stori_episode_data->episode_title?></a>  <small><i class="fa fa-angle-double-right"></i> </small> 
                    Slides  
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
                      <a href="<?=DNADMIN?>/app/serie-episode/<?=$serie_ID?>/list"><i class="fa fa-chevron-left"></i> Back</a>
                </li>
                
                
                <li class="dropdown notifications-menu">
                      <a href="<?=DNADMIN?>/app/serie-episode-slide/<?=$episode_ID?>/new"><i class="fa fa-plus"></i> Add new</a>
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
          <div class="col-sm-12 col-md-4">
            
              <?php include 'slide-slider'.PL;?>
              
          </div>  
          <div class="col-sm-12 col-md-8">
              
              
                 <!--RECENT REGISTER -->
              <div>
                  
                <?php 
                    if(@empty($_SESSION['slide_sort'])){
                        $_SESSION['slide_sort'] = "`ID` DESC";  
                         Redirect::to("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }

                    $search_sql = "";
                    $search_form = false;
                    $sql_val_array = array($stori_episode_data->ID,'Deleted');
                   
                    if(Input::checkInput('search','get','1')){
                        $search_form = true;
                        
                        $keyword = urldecode(Input::get('keyword','get'));

                        if(Input::checkInput('keyword','get','1')){
                            $search_sql .= " 
                                AND (`slide_title` LIKE '%{$keyword}%' || 
                                    `state` LIKE '%{$keyword}%' ||
                                    `ID` = '{$keyword}')";
                        }
                    }
                    ?>
                      
                    
                </div>
              
              
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Slide list</h3>

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
                                <th><button type="submit" name="sort-name">Title</button></th>
                                <th><button type="submit" name="sort-create_date">Created Date</button></th>
                                <th><button type="submit" name="sort-status">Status</button></th>
                                  <th style="width: 60px">Menu</th>
                              </tr>
                            </form>
                          </thead>
                          <tbody>
                              
                            <?php
                              
                                $seconds = \Config::get('time/seconds');
                                $storiSlideTable = new StoriSlide();
                                $storiSlideTable->selectQuery("SELECT* FROM `stori_slide` WHERE `episode_ID`=? AND `state`!=?  $search_sql ORDER BY {$_SESSION['slide_sort']}",$sql_val_array);

                                /*Start Pagination Setting*/
                                    $rowsLimit = 50;
                                    $pageNumber = 0;
                                    if(Input::checkInput('page','get','1')){
                                        $pageNumber = (int)sanAsID(Input::get('page','get'));
                                    }
                                    $requesturl = "?check";

                                    $totalStore=$storiSlideTable->count();
                                    $totalPages = upfloat($totalStore/$rowsLimit);
                                    $offsetNumber = $pageNumber*$rowsLimit;
                                    if($offsetNumber >= $totalStore){
                                        $pageNumber=0;
                                        $offsetNumber = $pageNumber*$rowsLimit;
                                    }
                                /*End Pagination Setting*/

                                $dataArr = array();

                                if(Input::checkInput('keyword','get','0') ){

                                  $storiSlideTable = new StoriSlide();
                                  $storiSlideTable->selectQuery("SELECT * FROM `stori_slide` WHERE `episode_ID`=? AND `state`!=?  $search_sql ORDER BY {$_SESSION['slide_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);

                                }else{
                                 
                                    
                                      $storiSlideTable = new StoriSlide();
                                      $storiSlideTable->selectQuery("SELECT * FROM `stori_slide` WHERE `episode_ID`=? AND `state`!=?  $search_sql ORDER BY {$_SESSION['slide_sort']} LIMIT {$offsetNumber},{$rowsLimit}",$sql_val_array);
                                }
                               
								if($storiSlideTable->count()){
									$i = 0;
									foreach($storiSlideTable->data() as $stori_slide_data){
										$i++;
                                        $slide_ID = $stori_slide_data->ID;
                                        
                                        $stateColor =  "#dddddd";
                                        
                                        
                                        
                                        
                                      ?>

                                      <tr class="row_layout">
                                        <td>
                                            <a style="border-color: <?=$stateColor?>" class="id popover-el slide-menu-popover-<?=$stori_slide_data->ID?>"><?=$stori_slide_data->ID;?> <i class="fa fa-angle-down pull-right menu_icon"></i></a>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$stori_slide_data->ID?>" >
                                                <img src="<?=DNADMIN.'/'.$stori_slide_data->photo?>" style="height: 30px; margin: auto" class="img img-responsive block-center">
                                            </span>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#myModal_<?=$stori_slide_data->ID?>" >
                                                <?=$stori_slide_data->slide_title?>
                                            </span>
                                        </td>
                                        
                                        <td ><?=$stori_slide_data->created_date?></td>
                                          
                                        <td><?=$stori_slide_data->state?></td>
                                        <td>
                                            <div>
                                              <a class="slide-menu-popover-<?=$stori_slide_data->ID?> popover-el" tabindex="0" role="button" >More</a>
                                            </div>
                                            
                                            <div id="slide-menu-content-<?=$stori_slide_data->ID?>" class="hidden">
                                                
                                                <form method="post">
                                                    
                                                    <input type="hidden" name="request" value="slide-status">
                                                    <input type="hidden" name="slide-id" value="<?=$stori_slide_data->ID?>">
                                                    
                                                    <ul class="popover-menu-list">
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".slide-menu-popover-<?=$stori_slide_data->ID?>" data-toggle="modal" data-target="#myModal_<?=$stori_slide_data->ID?>"><i class="fa fa-eye icon"></i> View</a></li>
                                                        
                                                        <li><a class="menu" href="<?=DNADMIN?>/app/serie-episode-slide/<?=$stori_episode_data->ID?>/edit/<?=$stori_slide_data->ID?>"><i class="fa fa-pencil icon"></i> Edit</a></li>
                                                        
                                                        
                                                        <?php if($stori_slide_data->state!='Published'){?>
                                                            <li><button class="menu" type="submit" name="Published"><i class="fa fa-upload icon"></i>  Published</button></li> 
                                                        <?php }?>
                                                        
                                                        <?php if($stori_slide_data->state!='Pending'){?>
                                                            <li><button class="menu" type="submit" name="Pending"><i class="fa fa-spinner icon"></i>  Pending</button></li>
                                                        <?php }?>
                                                        
                                                        <!--<li><button class="menu" type="submit" name="Deleted"><i class="fa fa-trash icon"></i>  Deleted</button></li>-->
                                                        
                                                        
                                                        <li><a class="menu popover-close" data-popoverid=".slide-menu-popover-<?=$stori_slide_data->ID?>"><i class="fa fa-times icon"></i> Close</a></li>
                                                        
                                                    </ul>
                                                    
                                                </form>
                                                
                                            </div>
                                            
                                            <script>
                                                $(function(){
                                                    // Enables popover #1
                                                    $(".slide-menu-popover-<?=$stori_slide_data->ID?>").popover({
                                                        html : true, 
                                                        placement : 'bottom', 
                                                        trigger: 'manual',
                                                        content: function() {
                                                          return $("#slide-menu-content-<?=$stori_slide_data->ID?>").html();
                                                        },
                                                        title: function() {
                                                          return $("#slide-menu-title-<?=$stori_slide_data->ID?>").html();
                                                        }
                                                    });
                                                });
                                            </script>
                                        </td>
                                      </tr>	
                                    <!-- Modal -->
                                            <div class="modal fade" id="myModal_<?=$stori_slide_data->ID?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog modal-md" role="document" style="width: 400px">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">More Details</h4>
                                                  </div>
                                                  <div class="modal-body" style="background: #dedede">
                                                      
                                                        <img src="<?=DNADMIN.'/'.$stori_slide_data->photo?>" style="height: 300px; margin: auto" class="img img-responsive block-center">
                                                        <br/>
                                                      
                                                        <div class="box" style="border-top: 0px;">
                                
                                                          
                                                            <div class="box-body" style="padding: 0px;">


                                                            </div>
                                                            <div class="box-body">
                                                                <p>
<!--                                                                    <label class="product_title">Slide title: </label> <?=$stori_slide_data->slide_title?>-->
                                                                </p>
                                                            </div>
                                                        </div>
                                                      
                                                  </div>
                                                  <div class="modal-footer" style="text-align: left">
                                                     <form method="post">
                                                        <input type="hidden" name="request" value="slide-status">
                                                        <input type="hidden" name="slide-id" value="<?=$stori_slide_data->ID?>">
                                                        
                                                         <?php if($stori_slide_data->state!='Pending'){?>
                                                        <button type="submit" name="Pending" class="btn btn-default pull-right"  style="margin-left: 5px!important; background: #595959; color: #eee">Pending</button>
                                                         <?php }?>
                                                         
                                                         <?php if($stori_slide_data->state!='Published'){?>
                                                        <button type="submit" name="Published" class="btn btn-success pull-right" >Published</button>
                                                          <?php }?>
                                                          
                                                          <button type="submit" name="Deleted" class="btn btn-danger pull-right"  style="margin-right: 5px!important; ">Delete</button>
                                                          
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
                                    <td colspan="7"><br/>No StoriSlide recorded</td>
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