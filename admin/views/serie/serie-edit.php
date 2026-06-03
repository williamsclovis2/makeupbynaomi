<section class="content-header">
	<div class="page_header">
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				<h3 class="content-title">
                    <a href="<?=DNADMIN?>"><i class="fa fa-book fa-lg pink-col"></i></a> <small> <i class="fa fa-angle-double-right"></i> </small> Edit serie
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
                      <a href="<?=DNADMIN?>/app/serie/list"><i class="fa fa-chevron-left"></i> Back</a>
                </li>
                
                
                
                <li class="dropdown notifications-menu">
                      <a href="<?=DNADMIN?>/app/serie/new"><i class="fa fa-plus"></i> Add new</a>
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

                      <h3 class="box-title">Modifier l'offre d'emploi</h3>

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
                                        <h4 class="fieldset-header">Informations sur le poste <span class="req"></span></h4>
                                     <hr class="halfLine">
                                  </div>
                                </div>
                                
                                
                                <br/>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="serie_title">Titre du poste vacant <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['serie_title'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-serie_title" id="serie_title" placeholder="Titre du poste" value="<?=@$stori_serie_data->serie_title?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="company_name">Nom de l'entreprise <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['company_name'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-company_name" id="company_name" placeholder="Nom de l'entreprise" value="<?=@$stori_serie_data->company_name?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="job_type">Type d'emploi <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['job_type'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="register-job_type" id="job_type" class="form-control bordered" required="required">
                                            <option value="" selected>Sélectionnez ici</option>
                                            <option value="tempsplein" <?php if(@$stori_serie_data->job_type == 'tempsplein'){echo 'selected="selected"';}?>>Temps plein</option>
                                            <option value="tempspartiel" <?php if(@$stori_serie_data->job_type == 'tempspartiel'){echo 'selected="selected"';}?>>Temps partiel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h4 class="fieldset-header">Informations sur les Compétences <span class="req"></span></h4>
                                        <hr class="halfLine">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_1">Compétences 1 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_1'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_1" id="comp_1" placeholder="Compétences 1" value="<?=@$stori_serie_data->comp_1?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_2">Compétences 2 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_2'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_2" id="comp_2" placeholder="Compétences 2" value="<?=@$stori_serie_data->comp_2?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_3">Compétences 3 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_3'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_3" id="comp_3" placeholder="Compétences 3" value="<?=@$stori_serie_data->comp_3?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_4">Compétences 4 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_4'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_4" id="comp_4" placeholder="Compétences 4" value="<?=@$stori_serie_data->comp_4?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_5">Compétences 5 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_5'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_5" id="comp_5" placeholder="Compétences 5" value="<?=@$stori_serie_data->comp_5?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_6">Compétences 6 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_6'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_6" id="comp_6" placeholder="Compétences 6" value="<?=@$stori_serie_data->comp_6?>" required="required" maxlength="50">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="comp_7">Compétences 7 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['comp_7'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-comp_7" id="comp_7" placeholder="Compétences 7" value="<?=@$stori_serie_data->comp_7?>" required="required" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h4 class="fieldset-header">Informations sur l'Éducation et Les Expériences <span class="req"></span></h4>
                                        <hr class="halfLine">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="education">Éducation <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['education'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-education" id="education" placeholder="Éducation" value="<?=@$stori_serie_data->education?>" required="required" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="exp_1">Expérience 1 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['exp_1'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-exp_1" id="exp_1" placeholder="Expérience 1" value="<?=@$stori_serie_data->exp_1?>" required="required" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="exp_2">Expérience 2 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['exp_2'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-exp_2" id="exp_2" placeholder="Expérience 2" value="<?=@$stori_serie_data->exp_2?>" required="required" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="exp_3">Expérience 3 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['exp_3'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-exp_3" id="exp_3" placeholder="Expérience 3" value="<?=@$stori_serie_data->exp_3?>" required="required" maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="exp_4">Expérience 4 <span class="req">*</span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['exp_4'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="register-exp_4" id="exp_4" placeholder="Expérience 4" value="<?=@$stori_serie_data->exp_4?>" required="required" maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h4 class="fieldset-header">Descriptions <span class="req"></span></h4>
                                        <hr class="halfLine">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="serie_description">Courte description <span class="req"></span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['serie_description'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="register-serie_description" id="serie_description" rows="5" cols="40" maxlength="150" placeholder="Courte description..."><?=@$stori_serie_data->serie_description?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="dtserie_description">Description détaillée <span class="req"></span>
                                        <span style="color: red; font-size: 12px; display: block">
                                            <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['dtserie_description'][0];}?>
                                        </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="register-dtserie_description" id="dtserie_description" placeholder="Description détaillée ..." style="height: 180px;"><?=@$stori_serie_data->dtserie_description?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="featuredImageInner">Photo
                                    <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['featuredImage'][0];}?> </span>
                                    </label>
                                  <div class="col-sm-9">
                                        <div class="fileinput fileinput-new" id="featuredImageInner" data-provides="fileinput">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="img-rounded">
                                                        <img src="<?=DNADMIN.'/'.$stori_serie_data->photo?>" style="height: 80px;" class="img img-responsive block-center">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                                </div>
                                            </div>
                                          <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input id="featuredImage" type="file" name="featuredImage" ></span>
                                          </div>
                                        </div>
                                  </div>
                                </div>


                                 <div class="form-group">
                                  <div class="col-sm-12">
                                      <h4 class="fieldset-header">Setting Information <span class="req"></span></h4>
                                     <hr class="halfLine">
                                  </div>
                                </div>


                                <div class="form-group hidden">
                                  <label class="control-label col-sm-3" for="language">Language
                                    <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['language'][0];}?> </span>
                                    </label>
                                    <div class="col-sm-9">
                                      <select name="register-language" id="language" class="form-control bordered">
                                            <option value="" <?php if($stori_serie_data->language == ''){ echo 'selected="selected"';}?>> [--Select--] </option>

                                            <option value="KINYARWANDA" <?php if($stori_serie_data->language == 'KINYARWANDA'){ echo 'selected="selected"';}?>>KINYARWANDA</option>

                                            <option value="ENGLISH" <?php if($stori_serie_data->language == 'ENGLISH'){ echo 'selected="selected"';}?>>ENGLISH</option>

                                      </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="package">Blog Emplacement
                                        <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if ($form->ERRORS) {
                                            echo @$form->ERRORS_SCRIPT['package'][0];
                                        } ?> </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="register-package" id="package" class="form-control bordered" required="required">
                                            <option value="" <?php if ($form->ERRORS && Input::get('register-package', 'post') == '') {
                                            echo 'selected="selected"';
                                        } ?>> [--Select--] </option>
                                        <option value="Normal_Blog">Blogs-page</option>
                                        <option value="To_home_Page">home-Page</option>
   
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="package_type">Type
                                        <span  class="req">*</span> 
                                        <span style="color: red; font-size: 12px; display: block"> <?php if ($form->ERRORS) { echo @$form->ERRORS_SCRIPT['package_type'][0]; } ?> </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="register-package_type" id="package_type" class="form-control bordered" required="required">
                                            <option value="" <?php if ($form->ERRORS && Input::get('register-package_type', 'post') == '') { echo 'selected="selected"';} ?>> [--Select--] </option>

                                            <option value="Public" <?php if ($form->ERRORS && Input::get('register-package_type', 'post') == 'NEW') {echo 'selected="selected"';} ?>>Public</option>

                                            <option value="Private" <?php if ($form->ERRORS && Input::get('register-package_type', 'post') == 'USED') { echo 'selected="selected"';} ?>>Private</option>

                                        </select>
                                    </div>
                                </div>
                                
                                
                            </fieldset>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">



                            <a href="<?=DNADMIN?>/app/serie/list" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                            
                            
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
                            
                            
                            <input type="hidden" name="request" value="serie-edit">
                            <input type="hidden" name="id" value="<?=$stori_serie_data->ID?>">
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
                  <!--END NEW PARTICIPANT-->
              </form>
          </div>
          <div class="col-sm-1 col-md-2"></div>

	  </div><!-- /.row -->
    
    
</section>



