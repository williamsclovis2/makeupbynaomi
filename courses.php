<?php
   $page = "courses";
   require_once "admin/core/init.php";
   $_display = Input::get('page','get');
   ?>
<!doctype html>
<html class="no-js" lang="en">
   <head>
      <?php include 'includes/head.php'; ?>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
   </head>
   <body class="template-color-1">
      <div class="wrapper courses-page">
         <!-- Fixed elements from index -->
         <div class="fixed-social">
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
         </div>
         <div class="chatbot-btn">
            <i class=""><img src="img/message.png"></i>
            <span class="chat-badge">1</span>
         </div>
         <div class="promo-btn"><span>10% OFF</span></div>
         <!-- Header -->
         <header class="header-style-five">
            <?php include 'includes/header.php'; ?>
         </header>
         <!-- ============================================================
            HERO
            ============================================================ -->
         <section class="courses-hero">
            <div class="h-dot h-dot-1"></div>
            <div class="h-dot h-dot-2"></div>
            <div class="h-dot h-dot-3"></div>
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <div class="hero-eyebrow">
                        <span class="live-pulse"></span>
                        Live &amp; On-Demand Classes
                     </div>
                     <h1>Master the Art of<br><span>Beauty</span> Online</h1>
                     <p class="hero-sub">Learn bridal glam, everyday looks, and professional techniques from certified artists  live from our Kampala studio or watch replays anytime.</p>
                     <div class="hero-stats">
                        <div class="hero-stat">
                           <div class="hero-stat-num">3</div>
                           <div class="hero-stat-lbl">Signature courses</div>
                        </div>
                        <div class="hero-stat">
                           <div class="hero-stat-num">847+</div>
                           <div class="hero-stat-lbl">Students enrolled</div>
                        </div>
                        <div class="hero-stat">
                           <div class="hero-stat-num">100%</div>
                           <div class="hero-stat-lbl">Certified completion</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6 d-none d-lg-block">
                     <div class="hero-card-stack">
                        <div class="hc hc-back">
                           <img src="img/makeup/glam.webp" alt="Glam Makeup Course">
                        </div>
                        <div class="hc hc-main">
                           <img src="img/makeup/bridal-makeup.jpg" alt="Bridal Makeup Masterclass">
                           <div class="hc-overlay"></div>
                           <div class="hc-info">
                              <p class="hc-tag">Now Streaming</p>
                              <p class="hc-title">Bridal Makeup Masterclass</p>
                              <span class="hc-live-pill">
                              <span class="dot"></span> Live · 2.4k watching
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Breadcrumb -->
         <div class="breadcrumb-area">
            <div class="container">
               <ol class="breadcrumb breadcrumb-list mb-0">
                  <li class="breadcrumb-item"><a href="index">Home</a></li>
                  <li class="breadcrumb-item active">Courses</li>
               </ol>
            </div>
         </div>
         <!-- ============================================================
            FILTER BAR (sticky)
            ============================================================ -->
         <div class="courses-filter-bar">
            <div class="container">
               <div class="filter-bar-inner">
                  <div class="filter-tab-group" id="filterTabs">
                     <button class="filter-tab active" data-filter="all">All Courses</button>
                     <button class="filter-tab" data-filter="bridal">Bridal</button>
                     <button class="filter-tab" data-filter="glam">Glam</button>
                     <button class="filter-tab" data-filter="simple">Simple / Everyday</button>
                     <button class="filter-tab" data-filter="live">🔴 Live Now</button>
                  </div>
                  <div class="filter-bar-right">
                     <div class="filter-search">
                        <i class="ti ti-search"></i>
                        <input type="text" placeholder="Search courses…" id="courseSearch" aria-label="Search courses">
                     </div>
                     <select class="filter-sort" aria-label="Sort courses">
                        <option>Most Popular</option>
                        <option>Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Top Rated</option>
                     </select>
                     <span class="courses-count">Showing <strong>3</strong> courses</span>
                  </div>
               </div>
            </div>
         </div>
         <!-- ============================================================
            MAIN CONTENT
            ============================================================ -->
         <div class="courses-main">
            <div class="container">
               <!-- Perks bar -->
               <div class="perks-bar">
                  <div class="perk">
                     <div class="perk-icon"><i class="ti ti-video"></i></div>
                     <div class="perk-text">
                        <h6>Live Streaming</h6>
                        <p>Watch our artists teach in real time from the salon</p>
                     </div>
                  </div>
                  <div class="perk">
                     <div class="perk-icon"><i class="ti ti-certificate"></i></div>
                     <div class="perk-text">
                        <h6>Certificate on Completion</h6>
                        <p>Officially recognised by salons &amp; studios</p>
                     </div>
                  </div>
                  <div class="perk">
                     <div class="perk-icon"><i class="ti ti-replay"></i></div>
                     <div class="perk-text">
                        <h6>Full Replay Access</h6>
                        <p>Catch every lesson on demand, forever</p>
                     </div>
                  </div>
                  <div class="perk">
                     <div class="perk-icon"><i class="ti ti-package"></i></div>
                     <div class="perk-text">
                        <h6>Salon Kit Included</h6>
                        <p>Professional starter kit delivered to your door</p>
                     </div>
                  </div>
               </div>
               <!-- ---- FEATURED: Bridal banner ---- -->
               <div class="cs-section-head">
                  <h2>
                     <span>Signature Course</span>
                     Featured Masterclass
                  </h2>
               </div>
               <div class="featured-banner" onclick="openEnrollModal('Bridal Makeup Masterclass','$199','img/makeup/bridal-makeup.jpg')">
                  <div class="fb-bg" style="background-image:url('img/makeup/bridal-makeup.jpg');"></div>
                  <div class="fb-overlay"></div>
                  <div class="fb-live">
                     <span class="dot"></span>
                     <span>Live Streaming</span>
                     <span class="viewers"><i class="ti ti-eye" style="font-size:11px;"></i> 2.4k watching</span>
                  </div>
                  <div class="fb-play"><i class="ti ti-player-play-filled"></i></div>
                  <div class="fb-content">
                     <p class="fb-tag">🎓 Signature Course</p>
                     <h2 class="fb-title">Bridal<br><em>Makeup Masterclass</em></h2>
                     <p class="fb-desc">From flawless base to dramatic finish — learn the art of bridal beauty directly from Naomi's certified artists in a hands-on salon setting.</p>
                     <div class="fb-badges">
                        <span class="fb-badge"><i class="fa fa-clock-o"></i> 12 Lessons</span>
                        <span class="fb-badge"><i class="fa fa-wifi"></i> Live + Replay</span>
                        <span class="fb-badge"><i class="fa fa-certificate"></i> Certificate</span>
                        <span class="fb-badge"><i class="fa fa-users"></i> 847 enrolled</span>
                     </div>
                     <button class="fb-enroll-btn">
                     <i class="ti ti-player-play"></i> Enroll Now — $199
                     </button>
                  </div>
               </div>
               <div class="cs-divider"></div>
               <!-- ---- ALL COURSES GRID ---- -->
               <div class="cs-section-head">
                  <h2>
                     <span>All Courses</span>
                     Learn at Your Own Pace
                  </h2>
                  <a href="#">View all <i class="ti ti-arrow-right"></i></a>
               </div>
               <div class="courses-grid" id="coursesGrid">
                  <!-- CARD 1 — Bridal (duplicate compact) -->
                  <div class="course-card course-item" data-category="bridal live"
                     onclick="openEnrollModal('Bridal Makeup Masterclass','$199','img/makeup/bridal-makeup.jpg')">
                     <div class="cc-thumb">
                        <img src="img/makeup/bridal-makeup.jpg" alt="Bridal Makeup Masterclass">
                        <div class="cc-overlay"></div>
                        <div class="cc-status live"><span class="dot"></span><span>Live</span></div>
                        <div class="cc-price-pill">$199</div>
                        <div class="cc-play"><i class="ti ti-player-play-filled"></i></div>
                        <div class="cc-thumb-info">
                           <span class="cc-watchers"><i class="ti ti-eye"></i> 2.4k watching</span>
                        </div>
                        <div class="cc-progress">
                           <div class="cc-progress-fill" style="width:0%"></div>
                        </div>
                     </div>
                     <div class="cc-body">
                        <span class="cc-level intermediate">Intermediate</span>
                        <h3 class="cc-title"><a href="course-detail">Bridal Makeup Masterclass</a></h3>
                        <div class="cc-instructor">
                           <span class="avatar">NA</span>
                           Naomi Aisha · Certified Artist
                        </div>
                        <div class="cc-rating">
                           <div class="cc-stars">
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star-filled"></i>
                           </div>
                           <span class="cc-rating-num">5.0</span>
                           <span class="cc-rating-count">(214 reviews)</span>
                        </div>
                        <div class="cc-meta">
                           <span class="cc-meta-item"><i class="ti ti-book"></i> 12 lessons</span>
                           <span class="cc-meta-item"><i class="ti ti-clock"></i> 8 weeks</span>
                           <span class="cc-meta-item"><i class="ti ti-certificate"></i> Certificate</span>
                        </div>
                        <div class="cc-price-row">
                           <div>
                              <span class="cc-price">$199</span>
                           </div>
                           <button class="cc-enroll-btn">Enroll Now</button>
                        </div>
                     </div>
                  </div>
                  <!-- CARD 2 — Full Glam -->
                  <div class="course-card course-item" data-category="glam live"
                     onclick="openEnrollModal('Full Glam Look Class','$49','img/makeup/glam.webp')">
                     <div class="cc-thumb">
                        <img src="img/makeup/glam.webp" alt="Full Glam Look Class">
                        <div class="cc-overlay"></div>
                        <div class="cc-status live"><span class="dot"></span><span>Live</span></div>
                        <div class="cc-price-pill">$49</div>
                        <div class="cc-play"><i class="ti ti-player-play-filled"></i></div>
                        <div class="cc-thumb-info">
                           <span class="cc-watchers"><i class="ti ti-eye"></i> 1.1k watching</span>
                        </div>
                     </div>
                     <div class="cc-body">
                        <span class="cc-level advanced">Advanced</span>
                        <h3 class="cc-title"><a href="course-detail">Full Glam Look Class</a></h3>
                        <div class="cc-instructor">
                           <span class="avatar">NA</span>
                           Naomi Aisha · Certified Artist
                        </div>
                        <div class="cc-rating">
                           <div class="cc-stars">
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star empty"></i>
                           </div>
                           <span class="cc-rating-num">4.8</span>
                           <span class="cc-rating-count">(98 reviews)</span>
                        </div>
                        <div class="cc-meta">
                           <span class="cc-meta-item"><i class="ti ti-book"></i> 8 lessons</span>
                           <span class="cc-meta-item"><i class="ti ti-clock"></i> 6 weeks</span>
                           <span class="cc-meta-item"><i class="ti ti-certificate"></i> Certificate</span>
                        </div>
                        <div class="cc-price-row">
                           <div>
                              <span class="cc-price">$49</span>
                              <span class="cc-price-original">$79</span>
                           </div>
                           <button class="cc-enroll-btn">Enroll Now</button>
                        </div>
                     </div>
                  </div>
                  <!-- CARD 3 — Everyday Glow -->
                  <div class="course-card course-item" data-category="simple"
                     onclick="openEnrollModal('Everyday Glow Routine','$24','img/makeup/simple-makeup.jpg')">
                     <div class="cc-thumb">
                        <img src="img/makeup/simple-makeup.jpg" alt="Everyday Glow Routine">
                        <div class="cc-overlay"></div>
                        <div class="cc-status upcoming"><span class="dot"></span><span>Upcoming</span></div>
                        <div class="cc-price-pill">$24</div>
                        <div class="cc-play"><i class="ti ti-player-play-filled"></i></div>
                        <div class="cc-thumb-info">
                           <span class="cc-watchers"><i class="ti ti-users"></i> 320 enrolled</span>
                        </div>
                     </div>
                     <div class="cc-body">
                        <span class="cc-level beginner">Beginner</span>
                        <h3 class="cc-title"><a href="course-detail">Everyday Glow Routine</a></h3>
                        <div class="cc-instructor">
                           <span class="avatar">NA</span>
                           Naomi Aisha · Certified Artist
                        </div>
                        <div class="cc-rating">
                           <div class="cc-stars">
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                              <i class="ti ti-star-half-filled"></i>
                           </div>
                           <span class="cc-rating-num">4.6</span>
                           <span class="cc-rating-count">(56 reviews)</span>
                        </div>
                        <div class="cc-meta">
                           <span class="cc-meta-item"><i class="ti ti-book"></i> 6 lessons</span>
                           <span class="cc-meta-item"><i class="ti ti-clock"></i> 4 weeks</span>
                           <span class="cc-meta-item"><i class="ti ti-certificate"></i> Certificate</span>
                        </div>
                        <div class="cc-price-row">
                           <div>
                              <span class="cc-price">$24</span>
                           </div>
                           <button class="cc-enroll-btn">Enroll Now</button>
                        </div>
                     </div>
                  </div>
                  <!-- CARD WIDE — Full Beauty Bundle -->
                  <div class="courses-grid-wide course-item" data-category="glam bridal simple">
                     <div class="course-card-wide" onclick="openEnrollModal('Full Beauty Bundle','$89','img/makeup/skin-care-hero.jpg')">
                        <div class="ccw-thumb">
                           <img src="img/makeup/skin-care-hero.jpg" alt="Full Beauty Course Bundle">
                           <div class="cc-overlay"></div>
                           <div class="cc-status live" style="position:absolute;top:14px;left:14px;">
                              <span class="dot"></span><span>Live Streaming</span>
                           </div>
                           <div class="cc-play" style="opacity:0;transition:opacity .25s;">
                              <i class="ti ti-player-play-filled"></i>
                           </div>
                        </div>
                        <div class="ccw-body">
                           <span class="cc-level all-levels">All Levels · Best Value</span>
                           <h3 class="cc-title" style="font-size:1.45rem;">Full Beauty Course Bundle</h3>
                           <p class="cc-desc">Everything in one — bridal, glam, and everyday looks. Full glam, everyday looks &amp; skincare routines taught live at our salon by Naomi Beauty certified professionals. Includes a professional starter kit.</p>
                           <div class="cc-rating">
                              <div class="cc-stars">
                                 <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                                 <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                                 <i class="ti ti-star-filled"></i>
                              </div>
                              <span class="cc-rating-num">5.0</span>
                              <span class="cc-rating-count">(847 students)</span>
                           </div>
                           <div class="cc-meta" style="margin-bottom:20px;">
                              <span class="cc-meta-item"><i class="ti ti-book"></i> 26 lessons</span>
                              <span class="cc-meta-item"><i class="ti ti-clock"></i> 18 weeks total</span>
                              <span class="cc-meta-item"><i class="ti ti-certificate"></i> Certificate</span>
                              <span class="cc-meta-item"><i class="ti ti-package"></i> Kit included</span>
                           </div>
                           <div class="cc-price-row">
                              <div>
                                 <span class="cc-price" style="font-size:1.4rem;">$89</span>
                                 <span class="cc-price-original">$272</span>
                                 <span style="font-size:11px;background:var(--nb-rose);color:#fff;padding:2px 8px;border-radius:20px;margin-left:6px;font-family:'Jost',sans-serif;font-weight:700;">Save 67%</span>
                              </div>
                              <button class="cc-enroll-btn" style="padding:10px 24px;font-size:12px;">
                              <i class="ti ti-player-play" style="margin-right:5px;font-size:14px;"></i> Enroll Now
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /courses-grid -->
               <div class="cs-divider"></div>
               <!-- ---- INSTRUCTOR STRIP ---- -->
               <div class="instructor-strip">
                  <div class="is-photo">
                     <img src="img/team/Naomi.png" alt="Naomi Aisha — Lead Instructor" onerror="this.src='img/logo/nlogo.png'">
                  </div>
                  <div class="is-info">
                     <p class="is-tag">Your Instructor</p>
                     <h3 class="is-name">Naomi Aisha</h3>
                     <p class="is-bio">Certified makeup artist with 10+ years of experience. Creator of Naomi Beauty  Kampala's premier beauty studio. Every course is taught live from our salon, packed with real techniques you can use today.</p>
                  </div>
                  <div class="is-cta">
                     <a href="about" class="is-cta-btn">
                     <i class="ti ti-user"></i> Meet the team
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- Footer -->
         <footer class="pb-35 bck-footer">
            <?php include 'includes/footer.php'; ?>
         </footer>
      </div>
      <!-- /wrapper -->
      <!-- ============================================================
         ENROLL MODAL
         ============================================================ -->
      <div class="enroll-modal-backdrop" id="enrollBackdrop" onclick="closeEnrollModal()"></div>
      <div class="enroll-modal" id="enrollModal">
         <div class="em-header" id="emHeader">
            <img src="img/makeup/bridal-makeup.jpg" id="emImage" alt="Course">
            <button class="em-close" onclick="closeEnrollModal()"><i class="ti ti-x"></i></button>
            <div class="em-header-text">
               <p class="em-header-tag" id="emTag">Naomi Beauty Course</p>
               <p class="em-header-title" id="emTitle">Bridal Makeup Masterclass</p>
            </div>
         </div>
         <div class="em-body">
            <div class="em-perks">
               <span class="em-perk"><i class="fa fa-wifi"></i> Live + Replay</span>
               <span class="em-perk"><i class="fa fa-certificate"></i> Certificate</span>
               <span class="em-perk"><i class="fa fa-box"></i> Kit Included</span>
               <span class="em-perk"><i class="fa fa-clock-o"></i> Lifetime Access</span>
            </div>
            <div class="em-price-row">
               <div>
                  <p class="em-price-label">Course fee</p>
                  <p style="margin:0;font-family:'Jost',sans-serif;font-size:11px;color:var(--nb-muted);">One-time payment · all-inclusive</p>
               </div>
               <span class="em-price-val" id="emPrice">$199</span>
            </div>
            <button class="em-enroll-btn" onclick="closeEnrollModal()">
            <i class="ti ti-player-play"></i> Enroll &amp; Start Learning
            </button>
            <button class="em-cancel" onclick="closeEnrollModal()">Maybe later</button>
         </div>
      </div>
      <?php include 'includes/scripts.php'; ?>
      <script>
         /* ---- Enroll modal ---- */
         function openEnrollModal(title, price, img) {
             document.getElementById('emTitle').textContent = title;
             document.getElementById('emPrice').textContent = price;
             if(img) document.getElementById('emImage').src = img;
             document.getElementById('enrollModal').classList.add('open');
             document.getElementById('enrollBackdrop').classList.add('open');
             document.body.style.overflow = 'hidden';
         }
         function closeEnrollModal() {
             document.getElementById('enrollModal').classList.remove('open');
             document.getElementById('enrollBackdrop').classList.remove('open');
             document.body.style.overflow = '';
         }
         document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeEnrollModal(); });
         
         /* ---- Filter tabs ---- */
         document.querySelectorAll('.filter-tab').forEach(function(btn) {
             btn.addEventListener('click', function() {
                 document.querySelectorAll('.filter-tab').forEach(function(b){ b.classList.remove('active'); });
                 this.classList.add('active');
                 var filter = this.dataset.filter;
                 document.querySelectorAll('.course-item').forEach(function(card) {
                     var cats = (card.dataset.category || '').toLowerCase();
                     if(filter === 'all' || cats.includes(filter)) {
                         card.style.display = '';
                     } else {
                         card.style.display = 'none';
                     }
                 });
             });
         });
         
         /* ---- Search ---- */
         document.getElementById('courseSearch').addEventListener('input', function() {
             var q = this.value.toLowerCase();
             document.querySelectorAll('.course-item').forEach(function(card) {
                 var text = card.textContent.toLowerCase();
                 card.style.display = text.includes(q) ? '' : 'none';
             });
         });
         
         /* ---- Wide card play icon hover ---- */
         document.querySelectorAll('.course-card-wide').forEach(function(c) {
             var play = c.querySelector('.cc-play');
             if(!play) return;
             c.addEventListener('mouseenter', function(){ play.style.opacity = '1'; });
             c.addEventListener('mouseleave', function(){ play.style.opacity = '0'; });
         });
      </script>
   </body>
</html>
