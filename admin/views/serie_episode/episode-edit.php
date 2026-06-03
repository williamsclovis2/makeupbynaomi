
<section class="content-header">
	<div class="page_header">
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				<h3 class="content-title">
                   <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small><i class="fa fa-angle-double-right"></i> </small>  
                    <a href="<?=DNADMIN?>/app/serie/list" class="pink-col"> <?=$stori_serie_data->serie_title?></a>  <small><i class="fa fa-angle-double-right"></i> </small> 
                     Edit episode
				</h3>
			</div>
			<div class="col-xs-12 col-sm-4 hidden-xs">
				<!-- Main search form -->
				<form action="#" method="get" class="mainsearch-form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
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
                
                
              <!-- New activities Menu -->
              <li class="dropdown notifications-menu">
                  <a href="<?=DNADMIN?>/app/serie-episode/<?=$serie_ID?>/new"><i class="fa fa-plus"></i> Add new</a>
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
          <div class="col-sm-10 col-md-8">
              <form method="post" id="reg-form" class="form-horizontal" enctype="multipart/form-data">
                 <!--RECENT NEW PARTICIPANT -->
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                      <i class="fa fa fa-ellipsis-v"></i>

                      <h3 class="box-title">Edit episode</h3>

                      <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                        <div class="btn-group" data-toggle="btn-toggle">
                          
                        </div>
                      </div>
                    </div>
                    <br>
                    <?php if($form->ERRORS && (@$form->ERRORS_SCRIPT['email'][0] == 'NOTUNIQUE' || @$form->ERRORS_SCRIPT['document_number'][0] == 'NOTUNIQUE')){ ?>
                    
                        <div class="box-body" style="padding: 10px 25px 10px 25px; ">
                            <?php include 'email_used'.PL;?>
                        </div>
                    <?php }else{ ?>
                    
                        <div class="box-body" style="padding: 10px 25px 10px 25px; ">
                            <fieldset class="panel-reg">


                                 <div class="form-group">
                                  <div class="col-sm-12">
                                      <h4 class="fieldset-header">Episode Information <span class="req"></span></h4>
                                     <hr class="halfLine">
                                  </div>
                                </div>
                                
                                
                                <br/>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="episode_title">Title 
                                        <span  class="req">*</span>  
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['episode_title'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="register-episode_title" id="episode_title" placeholder="Episode title" 
                                         value="<?=$stori_episode_data->episode_title?>" required maxlength="50">
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="episode_description">Description 
                                        <span  class="req"></span>  
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['episode_description'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="register-episode_description" id="episode_description" placeholder="Description" ><?=$stori_episode_data->episode_description?></textarea>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="featuredImageInner">Photo
                                    <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['featuredImage'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                        <div class="fileinput fileinput-new" id="featuredImageInner" data-provides="fileinput">
                                          <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                          <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input id="featuredImage" type="file" name="featuredImage" ></span>
                                          </div>
                                        </div>
                                  </div>
                                </div>
								
				
                                
                            </fieldset>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">



                            <a href="<?=DNADMIN?>/app/serie-episode/<?=$serie_ID?>/list" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                            
                            
                            <script>

                                var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
                                var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
                                var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
                                var is_safari = navigator.userAgent.indexOf("Safari") > -1;
                                var is_opera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
                                if ((is_chrome)&&(is_safari)) {is_safari=false;}
                                if ((is_chrome)&&(is_opera)) {is_chrome=false;}

                                if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
                                    $('.submit_btn').on('click', function(e){
                                         $('.submit_btn .loading_icon').css({'display': 'inline-block'});
                                         $('.submit_btn .glyphicon').css({'display': 'none'});
                                    });
                                }else{
                                    $('#reg-form').on('submit', function(e){
                                         $('.submit_btn .loading_icon').css({'display': 'inline-block'});
                                         $('.submit_btn .glyphicon').css({'display': 'none'});
                                    });
                                }

                            </script>
                            
                            
                            <input type="hidden" name="request" value="episode-edit">
                            <input type="hidden" name="id" value="<?=$serie_ID;?>">
                            <input type="hidden" name="episode_id" value="<?=$stori_episode_data->ID?>">
                            <input type="hidden" name="webToken" value="<?=Config::get('time/seconds');?>">
                            <input type="hidden" name="register_submited" value="1">

                            <button type="submit" class="submit_btn btn btn-sm btn-info btn-flat pull-right"> <img class="loading_icon" src="<?=DNADMIN?>/img/loading.gif" style="width: 14px; display: none"> <i class="glyphicon glyphicon-share"></i> Submit</button>




                            <script>

                                var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
                                var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
                                var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
                                var is_safari = navigator.userAgent.indexOf("Safari") > -1;
                                var is_opera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
                                if ((is_chrome)&&(is_safari)) {is_safari=false;}
                                if ((is_chrome)&&(is_opera)) {is_chrome=false;}

                                if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
                                    $('.submit_btn').on('click', function(e){
                                         $('.submit_btn .loading_icon').css({'display': 'inline-block'});
                                         $('.submit_btn .glyphicon').css({'display': 'none'});
                                    });
                                }else{
                                    $('#reg-form').on('submit', function(e){
                                         $('.submit_btn .loading_icon').css({'display': 'inline-block'});
                                         $('.submit_btn .glyphicon').css({'display': 'none'});
                                    });
                                }

                            </script>

                        </div>

                            
                    <?php }?>
           
                    <!-- /.box-footer -->
                  </div>
                  <!--END NEW PARTICIPANT-->
              </form>
          </div>
          <div class="col-sm-1 col-md-2"></div>

	  </div><!-- /.row -->
    
    
</section>



