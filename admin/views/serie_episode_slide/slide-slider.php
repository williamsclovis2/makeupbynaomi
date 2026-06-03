  
              
              
              <style>
	#homelightSlider.cS-hidden {
		height: 1px;
		opacity: 0;
		filter: alpha(opacity=0);
		overflow: hidden;
	}
	#homelightSlider {
		min-height: 250px!important;
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(0,0,0,.2)), to(rgba(0,0,0,.1)));
		background-image: -moz-linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.1));
		background-image: -webkit-linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.1));
		background-image: -o-linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.1));
	}
    @media(max-width: 768px){
        #homelightSlider {
            min-height: 286px!important;
        }
    }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		var pause_seconds = 10000;
		var textAdj = 50;
        var initialTime;

		$("#homelightSlider").lightSlider({
			item: 1,
			autoWidth: false,
			slideMove: 1, // slidemove will be 1 if loop is true
			slideMargin: 0,
	 
			addClass: '',
			mode: "fadeIn",
			useCSS: true,
			cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
			easing: 'linear', //'for jquery animation',////
	 
			speed: 2000, //ms'
			auto: true,
			loop: true,
			slideEndAnimation: false,
			pause: pause_seconds,
	 
			keyPress: true,
			controls: true,
	 
			rtl:false,
			adaptiveHeight:false,
	 
			vertical:false,
			verticalHeight:300,
			vThumbWidth:200,
	 
			thumbItem:8,
			pager: false,
			gallery: false,
			galleryMargin: 0,
			thumbMargin: 0,
			currentPagerPosition: 'middle',
	 
			enableTouch:true,
			enableDrag:true,
			freeMove:true,
			swipeThreshold: 1,
			
			responsive : [],
	 
			onBeforeStart: function (el) {},
			onSliderLoad: function (el) {
				$('#homelightSlider').removeClass('cS-hidden');
                
                initialTime = window.setTimeout( 
                    function() {
                       // $('.modern_caption').removeClass('fadeIn');
                       // $('.modern_caption').addClass('fadeOut'); 
                    }, pause_seconds-textAdj);
			},
			onBeforeSlide: function (el){
				//$('.modern_caption').addClass('fadeOut');
			},
			onAfterSlide: function (el){
				//$('.modern_caption').removeClass('fadeOut');
				//$('.modern_caption').addClass('fadeIn');
				initialTime = window.setTimeout( 
                    function() {
                       //$('.modern_caption').removeClass('fadeIn');
                       // $('.modern_caption').addClass('fadeOut'); 
                }, pause_seconds-textAdj);
			},
			onBeforeNextSlide: function (el) {
				//$('.modern_caption').removeClass('fadeIn');
                clearTimeout( initialTime)
			},
			onBeforePrevSlide: function (el) {
				//$('.modern_caption').removeClass('fadeIn');
                clearTimeout( initialTime )
			}
		});
	});
</script>

              
              
              
              <ul id="homelightSlider" class="cS-hidden" style=" position: relative">
                  <?php
                    $sql_val_array = array($stori_episode_data->ID,'Deleted');
                  
                      $storiSlideTable = new StoriSlide();
                      
                        $storiSlideTable = new StoriSlide();
                        $storiSlideTable->selectQuery("SELECT * FROM `stori_slide` WHERE `episode_ID`=? AND `state`!=? ",$sql_val_array);
                  
                        if($storiSlideTable->count()){
                            $i = 0;
                            foreach($storiSlideTable->data() as $stori_slide_data){
                                $i++;
                                $slide_ID = $stori_slide_data->ID;

                                $stateColor =  "#dddddd";

                              ?>
                                <li class="light_item" data-thumb="">
                                    <div style="position: relative;">
                                        <img class="img-responsive" style="width: 100%" src="<?=DNADMIN.'/'.$stori_slide_data->photo?>">
                                        <div class="carousel-caption hidden-xs" style="min-height: 60px; ">
                                            <div class="row">
                                                <div class="col col-xs-12" >
                                                    <div class="modern_caption animated" style=" width: 100%; padding: 30px 20px 20px 20px;">
                                                        <br>
                                                        <h2 class="intro-note text-muted"> <span class="color2">1</span>  </h2>

                                                        <div class="double_downdiv">
                                                            <a class="page-scroll" href="#about"><span class="fa fa-angle-double-down double_down"></span></a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                  
                  <?php }
                        
                        }?>
              </ul>
              