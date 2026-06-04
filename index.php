<?php
   $page = "index";
   require_once "admin/core/init.php";
   $_display = Input::get('page','get');
?>
<!doctype html>
<html class="no-js" lang="zxx">
   <head>
      <?php include 'includes/head.php'; ?>
   </head>
   <body class="template-color-1">
      <!-- Main Wrapper Start Here -->
      <div class="wrapper">
         <!-- Main Header Area Three Start Here -->
         <header class="header-style-five">
            <?php include 'includes/header.php'; ?>
         </header>
         <!-- Slider Area Start -->
         <!-- SOCIAL MEDIA (RIGHT MIDDLE) -->
         <div class="fixed-social">
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
         </div>
         <!-- CHAT BUTTON (BOTTOM RIGHT) -->
         <div class="chatbot-btn">
            <i class=""><img src="img/message.png"></i>
            <span class="chat-badge">1</span>
         </div>
         <!-- PROMO BUTTON (LEFT SIDE) -->
         <div class="promo-btn">
            <span>10% OFF</span>
         </div>
         <div class="slider-area slider-style-three">
            <div class="slider-activation owl-carousel">
               <!-- Slide 1: Human Hair -->
               <div class="slide align-center-left fullscreen animation-style-01 bg-image-9">
                  <div class="slider-progress"></div>
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="slider-content">
                              <h1>
                                 <span class="h1-small">Premium Collection</span><br>
                                 Wigs &amp; Hair Extensions
                              </h1>
                              <p>From sleek bundles to voluminous wigs, clip-ons, and crochet styles — find the perfect match for your look. 100% human hair, beautifully crafted for every occasion.</p>
                              <div class="slide-btn white-color">
                                 <a href="shop ">Shop Hair</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Slide 2: Makeup Services -->
               <div class="slide align-center-left fullscreen animation-style-02 bg-image-10">
                  <div class="slider-progress"></div>
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="slider-content">
                              <h1>
                                 <span class="h1-small">Glow Up With Us</span><br>
                                 Professional Makeup Services
                              </h1>
                              <p>Step into Naomi Beauty and let our artists transform you. Bridal glam, evening looks, or everyday elegance — we bring out your most radiant self.</p>
                              <div class="slide-btn white-color">
                                 <a href="booking ">Book a Session</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Slide 3: Online Courses -->
               <div class="slide align-center-left fullscreen animation-style-01 bg-image-12">
                  <div class="slider-progress"></div>
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="slider-content">
                              <h1>
                                 <span class="h1-small">Learn From Professionals</span><br>
                                 Master Your Makeup Skills
                              </h1>
                              <p>Enroll in our online makeup courses — Bridal Makeup, Glam, and Simple Everyday. Learn at your own pace, anywhere, from beginner to pro.</p>
                              <div class="slide-btn white-color">
                                 <a href="courses ">Enroll Now</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Slide 4: Brand Story -->
               <!-- <div class="slide align-center-left fullscreen animation-style-02 bg-image-11">
                  <div class="slider-progress"></div>
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="slider-content">
                              <h1>
                                 <span class="h1-small">Your Ultimate Beauty House</span><br>
                                 Beauty, Hair &amp; Confidence
                              </h1>
                              <p>Naomi Beauty is your one-stop destination for makeup products, human hair, professional beauty services, and expert-led courses — beauty made for every woman.</p>
                              <div class="slide-btn white-color">
                                 <a href="about ">Discover Naomi Beauty</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  </div> -->
            </div>
         </div>
         <!-- Slider Area End -->
         <section class="banner-section">
            <!-- New Product Banner Start Here -->
            <div class="promo-banner-area ptb-90">
               <div class="container">
                  <div class="row g-0">
                     <!-- Banner 1 -->
                     <div class="col-md-6">
                        <div class="promo-banner-card" style="background-image: url('img/banner/cosmetic/banner1.webp');">
                           <div class="promo-banner-overlay"></div>
                           <div class="promo-banner-content">
                              <span class="promo-tag">Professional Beauty</span>
                              <h2 class="promo-title">The Brighter Way<br>To Better Skin</h2>
                              <p class="promo-desc">
                                 Transform your look with our premium makeup collection <br>
                                 flawless coverage, long-lasting wear, all-day confidence.
                              </p>
                              <a href="shop.php" class="promo-buy-btn">
                              BUY NOW &nbsp;<span class="promo-price">$193.77</span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <!-- Banner 2 -->
                     <div class="col-md-6">
                        <div class="promo-banner-card" style="background-image: url('img/banner/cosmetic/wigs.webp');">
                           <div class="promo-banner-overlay"></div>
                           <div class="promo-banner-content wigs-section-col">
                              <span class="promo-tag">Wig Installation</span>
                              <h2 class="promo-title">Luminous, Instar-Ready<br>Hair In Minutes</h2>
                              <p class="promo-desc">
                                 Expert wig fixing & installation for a natural,<br>
                                 secure hold that lasts all day  every day.
                              </p>
                              <a href="shop.php" class="promo-buy-btn">
                              BOOK NOW &nbsp;<span class="promo-price">$193.77</span>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- New Product Banner End Here -->
         </section>
         <!-- New Arrival Products Start Here -->
         <div class="new-arrival no-border-style ptb-90 new-a">
            <div class="container">
               <!-- Section Title Start -->
               <div class="section-title text-center">
                  <h2>New Makeup / Arrivals</h2>
                  <p>Fresh wigs & makeup drops — be the first to own them</p>
               </div>
               <!-- Section Title End -->
               <!-- Filter Tabs Start -->
               <div class="arrival-filter-tabs text-center mb-40">
                  <button class="arrival-tab" data-filter="all">All</button>
                  <button class="arrival-tab active" data-filter="makeup">Makeup</button>
                  <button class="arrival-tab" data-filter="wigs">Wigs</button>
               </div>
               <!-- Filter Tabs End -->
               <!-- All Products Wrapper -->
               <?php include 'includes/products.php'; ?>
            </div>
         </div>
         <!-- Course Features Support Area Start -->
         <div class="support-area bg-snow ptb-60">
            <div class="container support-div">
               <div class="col-sm-12">
                  <div class="support-nav">
                     <div class="row">
                        <!-- Point 1 — Live Streaming -->
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-all-30">
                           <div class="single-support">
                              <div class="pe-7s-video icon"></div>
                              <div class="support-desc">
                                 <h6>Live Streaming Classes</h6>
                                 <span>Watch our expert artists teach in real time from our salon  join live or catch the full replay anytime</span>
                              </div>
                           </div>
                        </div>
                        <!-- Point 2 — Certificate -->
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-all-30">
                           <div class="single-support">
                              <div class="pe-7s-medal icon"></div>
                              <div class="support-desc">
                                 <h6>Certified on Completion</h6>
                                 <span>Earn an official beauty certificate once you complete your course  recognised by salons and studios</span>
                              </div>
                           </div>
                        </div>
                        <!-- Point 3 — All Levels Welcome -->
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-xsm-30">
                           <div class="single-support">
                              <div class="pe-7s-users icon"></div>
                              <div class="support-desc">
                                 <h6>All Levels Welcome</h6>
                                 <span>From total beginners to working artists  our courses are designed to grow your skills at every stage</span>
                              </div>
                           </div>
                        </div>
                        <!-- Point 4 — Salon Kit Included -->
                        <div class="col-lg-3 col-md-6 col-sm-6">
                           <div class="single-support">
                              <div class="pe-7s-box2 icon"></div>
                              <div class="support-desc">
                                 <h6>Salon Kit Included</h6>
                                 <span>Every enrollment comes with a professional makeup starter kit delivered straight to your door</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Row End -->
                  </div>
               </div>
            </div>
            <!-- Container End -->
         </div>
         <!-- Course Features Support Area End -->
         <!-- Online Makeup Courses Banner Start -->
         <div class="hero-banner-area hb-div">
            <div class="container">
               <div class="row">
                  <!-- LEFT — Big Hero Course Card (Bridal Makeup Masterclass) -->
                  <div class="col-md-6 col-sm-6 mb-xsm-30">
                     <div class="course-banner-card course-banner-large zoom" data-course="Bridal Makeup Masterclass" data-price="199">
                        <div class="course-banner-bg course-bg-bridal"></div>
                        <div class="course-banner-overlay"></div>
                        <div class="live-badge-wrap">
                           <span class="live-dot"></span>
                           <span class="live-label">LIVE STREAMING</span>
                           <span class="live-viewers"><i class="fa fa-eye"></i> 2.4k watching</span>
                        </div>
                        <div class="play-overlay" onclick="openEnrollModal('Bridal Makeup Masterclass', '$199')">
                           <div class="play-circle">
                              <i class="fa fa-play"></i>
                           </div>
                           <span class="play-hint">Enroll to Watch</span>
                        </div>
                        <div class="course-banner-content">
                           <span class="course-tag">🎓 Signature Course</span>
                           <h2 class="course-script">Bridal<br><span>Makeup Masterclass</span></h2>
                           <p class="course-desc">From flawless base to dramatic finish — learn the art of bridal beauty directly from Naomi's certified artists in a hands-on salon setting.</p>
                           <div class="course-badge-row">
                              <span class="course-badge"><i class="fa fa-clock-o"></i> 12 Lessons</span>
                              <span class="course-badge"><i class="fa fa-wifi"></i> Live + Replay</span>
                              <span class="course-badge"><i class="fa fa-certificate"></i> Certificate</span>
                           </div>
                           <button class="course-btn" onclick="openEnrollModal('Bridal Makeup Masterclass', '$199')">
                           <i class="fa fa-play-circle"></i> &nbsp;Enroll Now
                           </button>
                        </div>
                     </div>
                  </div>
                  <!-- RIGHT COLUMN -->
                  <div class="col-md-6 col-sm-6">
                     <!-- TOP ROW — 2 small cards -->
                     <div class="row">
                        <!-- Top Right 1 — Glam Makeup -->
                        <div class="col-md-6 col-sm-6 col-6">
                           <div class="course-banner-card course-banner-small zoom">
                              <div class="course-banner-bg course-bg-glam"></div>
                              <div class="course-banner-overlay"></div>
                              <div class="live-badge-wrap live-badge-sm">
                                 <span class="live-dot"></span>
                                 <span class="live-label">LIVE</span>
                              </div>
                              <div class="play-overlay play-overlay-sm" onclick="openEnrollModal('Glam Makeup Course', '$49')">
                                 <div class="play-circle play-circle-sm">
                                    <i class="fa fa-play"></i>
                                 </div>
                                 <span class="play-hint">Enroll to Watch</span>
                              </div>
                              <div class="course-banner-content">
                                 <span class="course-tag-sm">Glam Makeup</span>
                                 <h3 class="course-title-sm">Full Glam<br>Look Class</h3>
                                 <button class="course-link-btn" onclick="openEnrollModal('Glam Makeup Course', '$49')">
                                 Enroll &nbsp;<span class="course-price">$49</span>
                                 </button>
                              </div>
                           </div>
                        </div>
                        <!-- Top Right 2 — Simple Makeup -->
                        <div class="col-md-6 col-sm-6 col-6">
                           <div class="course-banner-card course-banner-small zoom">
                              <div class="course-banner-bg course-bg-simple"></div>
                              <div class="course-banner-overlay"></div>
                              <div class="live-badge-wrap live-badge-sm">
                                 <span class="live-dot live-dot-orange"></span>
                                 <span class="live-label">UPCOMING</span>
                              </div>
                              <div class="play-overlay play-overlay-sm" onclick="openEnrollModal('Simple Makeup Course', '$24')">
                                 <div class="play-circle play-circle-sm">
                                    <i class="fa fa-play"></i>
                                 </div>
                                 <span class="play-hint">Enroll to Watch</span>
                              </div>
                              <div class="course-banner-content">
                                 <span class="course-tag-sm">Simple Makeup</span>
                                 <h3 class="course-title-sm">Everyday<br>Glow Routine</h3>
                                 <button class="course-link-btn" onclick="openEnrollModal('Simple Makeup Course', '$24')">
                                 Enroll &nbsp;<span class="course-price">$24</span>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Top Row End -->
                     <!-- BOTTOM — Wide card (Full Beauty Bundle) -->
                     <div class="row">
                        <div class="col-12">
                           <div class="course-banner-card course-banner-wide zoom">
                              <div class="course-banner-bg course-bg-beauty"></div>
                              <div class="course-banner-overlay course-overlay-dark"></div>
                              <div class="live-badge-wrap">
                                 <span class="live-dot"></span>
                                 <span class="live-label">LIVE STREAMING</span>
                                 <span class="live-viewers"><i class="fa fa-users"></i> 847 enrolled</span>
                              </div>
                              <div class="play-overlay play-overlay-wide" onclick="openEnrollModal('Full Beauty Course', '$89')">
                                 <div class="play-circle">
                                    <i class="fa fa-play"></i>
                                 </div>
                                 <span class="play-hint">Enroll to Watch</span>
                              </div>
                              <div class="course-banner-content course-content-wide">
                                 <p class="course-be-your">BE YOUR OWN KIND OF</p>
                                 <h2 class="course-script-lg">Beautiful</h2>
                                 <p class="course-wide-desc">Full glam, everyday looks & skincare routines — taught live at our salon by Naomi Beauty certified professionals.</p>
                                 <button class="course-btn course-btn-outline" onclick="openEnrollModal('Full Beauty Course', '$89')">
                                 <i class="fa fa-play-circle"></i> &nbsp;ENROLL NOW
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Right Column End -->
               </div>
            </div>
         </div>
         <!-- Online Makeup Courses Banner End -->
         <!-- Online Makeup Courses Banner End -->
         <!-- New Arrival Products End Here -->
         <section class="daily-deals">
            <div class="deal-pro bg-image-18">
               <div class="container">
                  <div class="row align-items-center">
                     <div class="offset-lg-6 col-lg-6">
                        <div class="main-deal-pro">
                           <!-- SECTION TITLE -->
                           <div class="section-title deal-header">
                              <h2>daily deals</h2>
                              <p>
                                 Deals <span>30%</span> for all Jackets Products
                              </p>
                           </div>
                           <!-- OWL CAROUSEL -->
                           <div class="daily-deal-active owl-carousel">
                              <!-- PRODUCT 1 -->
                              <div class="single-makal-product">
                                 <div class="countdown"
                                    data-countdown="2026/12/31">
                                 </div>
                                 <div class="pro-img">
                                    <a href="product-details ">
                                    <img src="img/products/cosmetic/1.webp"
                                       alt="product-img">
                                    </a>
                                    <span class="sticker-new">
                                    new
                                    </span>
                                    <div class="quick-view-pro">
                                       <a href="#"
                                          class="quick-view"
                                          data-bs-toggle="modal"
                                          data-bs-target="#product-window">
                                       </a>
                                    </div>
                                 </div>
                                 <div class="pro-content">
                                    <h4 class="pro-title">
                                       <a href="product-details ">
                                       Modern Eye Brush
                                       </a>
                                    </h4>
                                    <p>
                                       <span class="price">$45.50</span>
                                    </p>
                                    <div class="pro-actions">
                                       <div class="actions-primary">
                                          <a href="cart "
                                             class="add-to-cart">
                                          Add To Cart
                                          </a>
                                       </div>
                                       <div class="actions-secondary">
                                          <div class="rating">
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star-o"></i>
                                             <i class="fa fa-star-o"></i>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- PRODUCT 2 -->
                              <div class="single-makal-product">
                                 <div class="countdown"
                                    data-countdown="2027/05/01">
                                 </div>
                                 <div class="pro-img">
                                    <a href="product-details ">
                                    <img src="img/products/cosmetic/3.webp"
                                       alt="product-img">
                                    </a>
                                    <span class="sticker-new">
                                    new
                                    </span>
                                    <div class="quick-view-pro">
                                       <a href="#"
                                          class="quick-view"
                                          data-bs-toggle="modal"
                                          data-bs-target="#product-window">
                                       </a>
                                    </div>
                                 </div>
                                 <div class="pro-content">
                                    <h4 class="pro-title">
                                       <a href="product-details ">
                                       Voyage Face Cleaner
                                       </a>
                                    </h4>
                                    <p>
                                       <span class="price">$61.21</span>
                                       <span class="prev-price">$64.50</span>
                                    </p>
                                    <div class="pro-actions">
                                       <div class="actions-primary">
                                          <a href="cart "
                                             class="add-to-cart">
                                          Add To Cart
                                          </a>
                                       </div>
                                       <div class="actions-secondary">
                                          <div class="rating">
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star-o"></i>
                                             <i class="fa fa-star-o"></i>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- PRODUCT 3 -->
                              <div class="single-makal-product">
                                 <div class="countdown"
                                    data-countdown="2026/11/15">
                                 </div>
                                 <div class="pro-img">
                                    <a href="product-details ">
                                    <img src="img/products/cosmetic/11.webp"
                                       alt="product-img">
                                    </a>
                                    <span class="sticker-new">
                                    new
                                    </span>
                                    <span class="sticker-sale">
                                    -5%
                                    </span>
                                    <div class="quick-view-pro">
                                       <a href="#"
                                          class="quick-view"
                                          data-bs-toggle="modal"
                                          data-bs-target="#product-window">
                                       </a>
                                    </div>
                                 </div>
                                 <div class="pro-content">
                                    <h4 class="pro-title">
                                       <a href="product-details ">
                                       Sprite Yoga Straps
                                       </a>
                                    </h4>
                                    <p>
                                       <span class="price">$65.00</span>
                                    </p>
                                    <div class="pro-actions">
                                       <div class="actions-primary">
                                          <a href="cart "
                                             class="add-to-cart">
                                          Add To Cart
                                          </a>
                                       </div>
                                       <div class="actions-secondary">
                                          <div class="rating">
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                             <i class="fa fa-star-o"></i>
                                             <i class="fa fa-star-o"></i>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- END OWL -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Best Seller Products End Here -->
         <section class="best-sales">
            <?php include 'includes/best-sales.php'; ?>
         </section>
         <!-- history section -->
         <section class="history-section ">
            <?php include 'includes/history.php'; ?>
         </section>
         <!-- Brand Activation Start Here -->
         <div class="brand-area ptb-70">
            <div class="container">
               <!-- Brand Logo Active Start Here -->
               <div class="brand-logo-active owl-carousel">
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b1.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b2.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b3.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b5.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b4.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b1.webp" alt="brand-image"></a>
                  </div>
                  <div class="single-brand">
                     <a href="#"><img src="img/brand/b2.webp" alt="brand-image"></a>
                  </div>
               </div>
               <!-- Brand Logo Active End Here -->
            </div>
         </div>
         <!-- Brand Activation End Here -->
         <!-- Footer Area Start Here -->
         <footer class="pb-35 bck-footer">
            <?php include 'includes/footer.php'; ?>
         </footer>
         <!-- Footer Area End Here -->
         <!-- Quick View Content Start -->
         <div class="main-product-thumbnail quick-thumb-content">
            <div class="container">
               <!-- The Modal -->
               <div class="modal fade" id="product-window">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                     <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                           <div class="row">
                              <!-- Main Thumbnail Image Start -->
                              <div class="col-lg-5 col-md-6 mb-all-40">
                                 <!-- Thumbnail Large Image start -->
                                 <div class="tab-content">
                                    <div id="pro-1" class="tab-pane fade show active">
                                       <a data-fancybox="images" href="img/products/cosmetic/1.webp">
                                       <img src="img/products/cosmetic/1.webp" alt="product-view">
                                       </a>
                                    </div>
                                    <div id="pro-2" class="tab-pane fade">
                                       <a data-fancybox="images" href="img/products/cosmetic/2.webp">
                                       <img src="img/products/cosmetic/2.webp" alt="product-view">
                                       </a>
                                    </div>
                                    <div id="pro-3" class="tab-pane fade">
                                       <a data-fancybox="images" href="img/products/cosmetic/3.webp">
                                       <img src="img/products/cosmetic/3.webp" alt="product-view">
                                       </a>
                                    </div>
                                    <div id="pro-4" class="tab-pane fade">
                                       <a data-fancybox="images" href="img/products/cosmetic/4.webp">
                                       <img src="img/products/cosmetic/4.webp" alt="product-view">
                                       </a>
                                    </div>
                                 </div>
                                 <!-- Thumbnail Large Image End -->
                                 <!-- Thumbnail Image End -->
                                 <div class="product-thumbnail">
                                    <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                                       <a class="active" data-bs-toggle="tab" href="#pro-1">
                                       <img src="img/thumbnail/cosmetic/1.webp" alt="product-thumbnail">
                                       </a>
                                       <a data-bs-toggle="tab" href="#pro-2">
                                       <img src="img/thumbnail/cosmetic/2.webp" alt="product-thumbnail">
                                       </a>
                                       <a data-bs-toggle="tab" href="#pro-3">
                                       <img src="img/thumbnail/cosmetic/3.webp" alt="product-thumbnail">
                                       </a>
                                       <a data-bs-toggle="tab" href="#pro-4">
                                       <img src="img/thumbnail/cosmetic/4.webp" alt="product-thumbnail">
                                       </a>
                                    </div>
                                 </div>
                                 <!-- Thumbnail image end -->
                              </div>
                              <!-- Main Thumbnail Image End -->
                              <!-- Thumbnail Description Start -->
                              <div class="col-lg-7 col-md-6">
                                 <div class="thubnail-desc fix">
                                    <h3 class="product-header">New Look eye Material</h3>
                                    <ul class="rating-summary">
                                       <li class="rating-pro">
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star-o"></i>
                                          <i class="fa fa-star-o"></i>
                                          <i class="fa fa-star-o"></i>
                                       </li>
                                       <li class="read-review">
                                          <a href="#">read reviews (1)</a>
                                       </li>
                                       <li class="write-review">
                                          <a href="#">write review</a>
                                       </li>
                                    </ul>
                                    <div class="pro-thumb-price mt-10">
                                       <p class="d-flex align-items-center">
                                          <span class="prev-price">16.51</span>
                                          <span class="price">$15.19</span>
                                          <span class="saving-price">-5%</span>
                                       </p>
                                    </div>
                                    <p class="pro-desc-details">New Look eye Material with high neckline. Soft
                                       and stretchy material for
                                       a comfortable fit. Accessorize with a straw hat and you're ready for
                                       summer!
                                    </p>
                                    <div class="product-size mtb-30 clearfix">
                                       <label>Size</label>
                                       <select class="">
                                          <option>S</option>
                                          <option>M</option>
                                          <option>L</option>
                                       </select>
                                    </div>
                                    <div class="color clearfix mb-30">
                                       <label>color</label>
                                       <ul class="color-list">
                                          <li>
                                             <a class="white" href="#"></a>
                                          </li>
                                          <li>
                                             <a class="orange active" href="#"></a>
                                          </li>
                                          <li>
                                             <a class="paste" href="#"></a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="quatity-stock">
                                       <label>Quantity</label>
                                       <ul class="d-flex flex-wrap  align-items-center">
                                          <li class="box-quantity">
                                             <form action="#">
                                                <input class="quantity" type="number" min="1" value="1">
                                             </form>
                                          </li>
                                          <li>
                                             <button class="pro-cart">add to cart</button>
                                          </li>
                                          <li class="pro-ref">
                                             <p>
                                                <span class="in-stock">
                                                <i class="ion-checkmark-round"></i> in stock</span>
                                             </p>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="social-sharing mt-30">
                                       <ul>
                                          <li>
                                             <label>share</label>
                                          </li>
                                          <li>
                                             <a href="#">
                                             <i class="fa fa-facebook" aria-hidden="true"></i>
                                             </a>
                                          </li>
                                          <li>
                                             <a href="#">
                                             <i class="fa fa-twitter" aria-hidden="true"></i>
                                             </a>
                                          </li>
                                          <li>
                                             <a href="#">
                                             <i class="fa fa-google-plus" aria-hidden="true"></i>
                                             </a>
                                          </li>
                                          <li>
                                             <a href="#">
                                             <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <!-- Thumbnail Description End -->
                           </div>
                        </div>
                        <!-- Modal footer -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Quick View Content End -->
      </div>
      <!-- Main Wrapper End Here -->
      <?php include 'includes/scripts.php'; ?>
   </body>
</html>