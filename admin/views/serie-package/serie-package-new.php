<section class="content-header">
	<div class="page_header">
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				<h3 class="content-title">
            <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small> <i class="fa fa-angle-double-right"></i> </small> New package
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
                      <a href="<?=DNADMIN?>/app/serie-package/list"><i class="fa fa-chevron-left"></i> Back</a>
                </li>
                
                <li class="dropdown notifications-menu">
                      <a href="<?=DNADMIN?>/app/serie-package/new"><i class="fa fa-plus"></i> New package</a>
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
                 <!--RECENT NEW PACKAGE -->
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                      <i class="fa fa fa-ellipsis-v"></i>

                      <h3 class="box-title">New package</h3>

                      <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                        <div class="btn-group" data-toggle="btn-toggle">
                          
                        </div>
                      </div>
                    </div>
                    <br>
                    <?php if($form->ERRORS && (@$form->ERRORS_SCRIPT['code'][0] == 'NOTUNIQUE' )){ ?>
                    
                        <div class="box-body" style="padding: 10px 25px 10px 25px; ">
                            <?php include 'email_used'.PL;?>
                        </div>
                    <?php }else{ ?>
                    
                        <div class="box-body" style="padding: 10px 25px 10px 25px; ">
                            <fieldset class="panel-reg">


                                 <div class="form-group">
                                  <div class="col-sm-12">
                                      <h4 class="fieldset-header">Serie Package Info <span class="req"></span></h4>
                                     <hr class="halfLine">
                                  </div>
                                </div>
                                
                                
                                <br/>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="code">Code 
                                        <span  class="req">*</span>  
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['code'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="register-code" id="code" placeholder="Serie title" 
                                           <?php if($form->ERRORS && Input::get('register-code','post')){?> value="<?php echo Input::get('register-code','post');?>" <?php }?>  required="required" maxlength="50">
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="description">Description 
                                        <span  class="req"></span>  
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['description'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="register-description" id="description" placeholder="Description" ><?php if($form->ERRORS && Input::get('register-description','post')){?> <?php echo Input::get('register-description','post');?> <?php }?></textarea>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="featuredImageInner">Featured photo
                                    <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['featuredImage'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                        <div class="fileinput fileinput-new" id="featuredImageInner" data-provides="fileinput">
                                          <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                          <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input id="featuredImage" type="file" name="featuredImage" required="required"></span>
                                          </div>
                                        </div>
                                  </div>
                                </div>

                            </fieldset>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">

                            <a href="<?=DNADMIN?>/app/serie/list" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                                                         
                            
                            <input type="hidden" name="request" value="serie-package-new">
                            <input type="hidden" name="webToken" value="<?=Config::get('time/seconds');?>">
                            <input type="hidden" name="register_submited" value="1">
                            <input type="hidden" name="register-event_token" value="de220168957bd2ccff08f88e9939b95f">

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
                  <!--END NEW PACKAGE-->
              </form>
          </div>
          <div class="col-sm-1 col-md-2"></div>

	  </div><!-- /.row -->
    
    
</section>



