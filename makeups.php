<?php
   $page = "makeups";
   require_once "admin/core/init.php";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
   <?php include 'includes/head.php'; ?>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>

/* ===========================
         DESIGN TOKENS
      =========================== */
:root {
	--nb-rose: #C8506A;
	--nb-rose-lt: #F2D9DE;
	--nb-blush: #F7EDE8;
	--nb-cream: #FDF8F5;
	--nb-gold: #C9A96E;
	--nb-dark: #1A1118;
	--nb-ink: #2E1F28;
	--nb-muted: #8A6B78;
	--nb-border: rgba(200, 80, 106, .12);

	--r: 14px;
	--shadow: 0 8px 40px rgba(26, 17, 24, .10);
	--shadow-lg: 0 20px 60px rgba(26, 17, 24, .18);
	--transition: .35s cubic-bezier(.4, 0, .2, 1);
}


html {
	scroll-behavior: smooth;
}

img {
	max-width: 100%;
}

a {
	text-decoration: none;
	color: inherit;
}













</style>
</head>
<body class="template-color-1">
<div class="wrapper makeup-page">

   <!-- Fixed UI -->
   <div class="fixed-social">
      <a href="https://www.instagram.com/makeup_by_naomi_ug/" target="_blank"><i class="fa fa-instagram"></i></a>
      <a href="https://www.youtube.com/@NaomiArt7" target="_blank"><i class="fa fa-youtube-play"></i></a>
   </div>
   <div class="chatbot-btn">
      <i class=""><img src="img/message.png" alt="chat"></i>
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
   <section class="makeup-hero">
      <div class="mh-bg">
         <img src="img/makeup/bridal-makeup.jpg" alt="Naomi Beauty Makeup">
      </div>
      <div class="mh-grain"></div>
      <div class="mh-overlay"></div>
      <div class="container mh-content">
         <div class="row">
            <div class="col-lg-7">
               <div class="mh-eyebrow">
                  <span class="dot"></span>
                  Kampala's Premier Makeup Studio
               </div>
               <h1 class="mh-title">Beauty Crafted<em> <br>With Precision &amp;Passion</em></h1>
               <p class="mh-sub">From luminous bridal looks to bold glam and effortless everyday finishes — Naomi Beauty uses only skin-safe, professional-grade products that celebrate every skin tone.</p>
               <div class="mh-actions">
                  <a href="#booking" class="btn-rose"><i class="ti ti-calendar"></i> Book a Session</a>
                  <a href="#our-work" class="btn-outline" style="border-color:rgba(255,255,255,.4);color:#fff;">
                     <i class="ti ti-photo"></i> View Our Work
                  </a>
               </div>
            </div>
         </div>
         <div class="mh-stats d-none d-lg-flex">
            <div class="mh-stat"><div class="mh-stat-num">2,000+</div><div class="mh-stat-lbl">Clients served</div></div>
            <div class="mh-stat"><div class="mh-stat-num">10 yrs</div><div class="mh-stat-lbl">Experience</div></div>
            <div class="mh-stat"><div class="mh-stat-num">100%</div><div class="mh-stat-lbl">Skin-safe products</div></div>
         </div>
         <div class="mh-scroll">
            <div class="mh-scroll-line"></div>
            <span>Scroll</span>
         </div>
      </div>
   </section>

   <!-- Breadcrumb -->
   <div class="breadcrumb-area">
      <div class="container">
         <ol class="breadcrumb-list mb-0">
            <li class="breadcrumb-item"><a href="index">Home</a></li>
            <li class="breadcrumb-item active">Makeup</li>
         </ol>
      </div>
   </div>

   <!-- ============================================================
      MAKEUP TYPES
   ============================================================ -->
   <section class="makeup-types" id="makeup-types">
      <div class="container">
         <div class="section-head">
            <p class="section-label">What We Do</p>
            <h2 class="section-title">Five Signature<br><em>Makeup Styles</em></h2>
            <p class="section-sub" style="margin: 16px auto 0; text-align:center;">Whether you're walking down the aisle or stepping out for the night, our certified artists tailor every look to your features, skin tone, and personality.</p>
         </div>
        <!-- ===== ROW 1: 2 × col-md-6 ===== -->
         <div class="types-row types-row-top">

            <!-- Card 1 — BRIDAL -->
            <div class="col-12 col-md-6">
               <div class="type-card" onclick="openLightbox('img/makeup/bridal-makeup.jpg', 'Bridal Makeup')">
                  <div class="tc-img">
                     <img src="img/makeup/bridal-makeup.jpg" alt="Bridal Makeup">
                     <div class="tc-overlay"></div>
                     <span class="tc-badge">Most Booked</span>
                  </div>
                  <div class="tc-content">
                     <h3 class="tc-title">Bridal<br><em>Makeup</em></h3>
                     <p class="tc-desc">Flawless, long-lasting bridal looks designed to photograph beautifully and stay perfect from morning ceremony to late-night reception. Airbrush-grade techniques and HD-friendly products for every Ugandan bride.</p>
                     <div class="tc-tags">
                        <span class="tc-tag">Airbrush finish</span>
                        <span class="tc-tag">Long-wear 16h+</span>
                        <span class="tc-tag">Trial session included</span>
                        <span class="tc-tag">Bridal party packages</span>
                     </div>
                     <button class="tc-cta"><i class="ti ti-calendar"></i> Book Bridal Session</button>
                  </div>
               </div>
            </div>

            <!-- Card 2 — FULL GLAM -->
            <div class="col-12 col-md-6">
               <div class="type-card" onclick="openLightbox('img/makeup/glam.webp', 'Full Glam Makeup')">
                  <div class="tc-img">
                     <img src="img/makeup/glam.webp" alt="Full Glam Makeup">
                     <div class="tc-overlay"></div>
                     <span class="tc-badge">Popular</span>
                  </div>
                  <div class="tc-content">
                     <h3 class="tc-title">Full<br><em>Glam Look</em></h3>
                     <p class="tc-desc">Bold, editorial-inspired looks for events, parties, photoshoots, and red-carpet occasions. Contouring, cut-crease eyes, and high-impact lips that command attention.</p>
                     <div class="tc-tags">
                        <span class="tc-tag">Contouring</span>
                        <span class="tc-tag">Dramatic eyes</span>
                        <span class="tc-tag">Studio lighting ready</span>
                     </div>
                     <button class="tc-cta"><i class="ti ti-calendar"></i> Book Glam Session</button>
                  </div>
               </div>
            </div>

         </div><!-- /row 1 -->

         <!-- ===== ROW 2: 3 × col-md-4 ===== -->
         <div class="types-row types-row-bottom">

            <!-- Card 3 — EVERYDAY GLOW -->
            <div class="col-12 col-md-4">
               <div class="type-card" onclick="openLightbox('img/makeup/simple-makeup.jpg', 'Everyday Glow Makeup')">
                  <div class="tc-img">
                     <img src="img/makeup/simple-makeup.jpg" alt="Everyday Glow Makeup">
                     <div class="tc-overlay"></div>
                  </div>
                  <div class="tc-content">
                     <h3 class="tc-title">Everyday<br><em>Glow Routine</em></h3>
                     <p class="tc-desc">Clean, natural-looking makeup that enhances your features without masking them. Perfect for office days, casual outings, or when you want to look effortlessly beautiful.</p>
                     <div class="tc-tags">
                        <span class="tc-tag">Skin-tint finish</span>
                        <span class="tc-tag">No-makeup makeup</span>
                        <span class="tc-tag">Sweat-proof</span>
                     </div>
                     <button class="tc-cta"><i class="ti ti-calendar"></i> Book Session</button>
                  </div>
               </div>
            </div>

            <!-- Card 4 — SKINCARE-FORWARD -->
            <div class="col-12 col-md-4">
               <div class="type-card" onclick="openLightbox('img/makeup/skin-care-hero.jpg', 'Skincare-Forward Makeup')">
                  <div class="tc-img">
                     <img src="img/makeup/skin-care-hero.jpg" alt="Skincare-Forward Makeup">
                     <div class="tc-overlay"></div>
                     <span class="tc-badge" style="background:var(--nb-gold);">New</span>
                  </div>
                  <div class="tc-content">
                     <h3 class="tc-title">Skincare-<br><em>Forward Glow</em></h3>
                     <p class="tc-desc">Makeup applied over a full prep ritual — cleanse, tone, hydrate — so your skin thrives underneath. Ideal for clients with sensitive or acne-prone skin.</p>
                     <div class="tc-tags">
                        <span class="tc-tag">Dermatologist-approved</span>
                        <span class="tc-tag">Sensitive-skin safe</span>
                        <span class="tc-tag">Hydrating finish</span>
                     </div>
                     <button class="tc-cta"><i class="ti ti-calendar"></i> Book Session</button>
                  </div>
               </div>
            </div>

            <!-- Card 5 — EDITORIAL / SPECIAL FX -->
            <div class="col-12 col-md-4">
               <div class="type-card" onclick="openLightbox('img/makeup/glam.webp', 'Editorial &amp; Special FX')">
                  <div class="tc-img">
                     <img src="img/makeup/glam.webp" alt="Editorial Makeup" style="filter:hue-rotate(20deg)">
                     <div class="tc-overlay"></div>
                  </div>
                  <div class="tc-content">
                     <h3 class="tc-title">Editorial &amp;<br><em>Special FX</em></h3>
                     <p class="tc-desc">Creative, concept-driven looks for fashion shoots, music videos, stage performances, and themed events. We push the boundaries of beauty art with colour, texture, and illusion.</p>
                     <div class="tc-tags">
                        <span class="tc-tag">Fashion shoots</span>
                        <span class="tc-tag">Stage performance</span>
                        <span class="tc-tag">Custom concepts</span>
                     </div>
                     <button class="tc-cta"><i class="ti ti-calendar"></i> Book Session</button>
                  </div>
               </div>
            </div>

         </div><!-- /row 2 -->
      </div>
   </section>

   <!-- ============================================================
      WHY NAOMI — PROFESSIONAL CREDENTIALS + SKIN SAFETY
   ============================================================ -->
   <section class="why-section" id="why-naomi">
      <div class="container">
         <div class="why-inner">
            <div class="why-gallery">
               <div class="why-img tall">
                  <img src="img/team/Naomi.png" alt="Naomi Aisha — Lead Artist" onerror="this.src='img/makeup/bridal-makeup.jpg'">
               </div>
               <div style="display:flex;flex-direction:column;gap:12px;">
                  <div class="why-img"><img src="img/makeup/glam.webp" alt="Glam look by Naomi Beauty"></div>
                  <div class="why-img"><img src="img/makeup/simple-makeup.jpg" alt="Everyday look by Naomi Beauty"></div>
               </div>
            </div>
            <div class="why-text">
               <p class="section-label" style="color:var(--nb-gold);">Why Naomi Beauty</p>
               <h2 class="section-title" style="color:#fff;">Professional, Safe &amp; <em>Perfectly You</em></h2>
               <p class="section-sub" style="color:rgba(255,255,255,.6);">With 10+ years of certified artistry and a studio built around hygiene and care, we make sure you always leave looking and feeling your absolute best.</p>
               <div class="why-points">
                  <div class="why-point">
                     <div class="wp-icon"><i class="ti ti-certificate"></i></div>
                     <div class="wp-info">
                        <h5>Certified Professional Artists</h5>
                        <p>Every artist on our team holds professional certification and attends ongoing masterclasses to stay ahead of trends and techniques.</p>
                     </div>
                  </div>
                  <div class="why-point">
                     <div class="wp-icon"><i class="ti ti-tool"></i></div>
                     <div class="wp-info">
                        <h5>Premium, Brand-Name Products Only</h5>
                        <p>We use internationally recognised brands — no counterfeit or diluted products ever enter our studio. What we use is what we sell.</p>
                     </div>
                  </div>
                  <div class="why-point">
                     <div class="wp-icon"><i class="ti ti-sparkles"></i></div>
                     <div class="wp-info">
                        <h5>Tailored to Your Skin Tone</h5>
                        <p>Uganda has the most beautiful range of skin tones on earth. We're trained to match, enhance, and celebrate every shade from the deepest ebony to the warmest caramel.</p>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>
      </div>
   </section>

   <!-- ============================================================
      SALON SHOWCASE
   ============================================================ -->
   <section class="salon-section" id="our-salon">
      <div class="container">
         <div class="row justify-content-between align-items-end mb-5">
            <div class="col-lg-6">
               <p class="section-label">Inside Our Studio</p>
               <h2 class="section-title">A Space Designed<br>for <em>Your Best Look</em></h2>
            </div>
            <div class="col-lg-5">
               <p style="font-size:14px;color:var(--nb-muted);line-height:1.7;">Our Kampala studio is a serene, hygienic, and beautifully designed space where every detail — from studio lighting to sanitation protocols — is crafted to deliver a premium experience.</p>
            </div>
         </div>
         <div class="salon-grid">
            <div class="sg-item tall">
               <img src="img/makeup/bridal-makeup.jpg" alt="Naomi Beauty Studio Main Space">
               <div class="sg-overlay"><span>Main Studio</span></div>
            </div>
            <div class="sg-item">
               <img src="img/makeup/glam.webp" alt="Makeup Stations">
               <div class="sg-overlay"><span>Makeup Stations</span></div>
            </div>
            <div class="sg-item">
               <img src="img/makeup/simple-makeup.jpg" alt="Product Display">
               <div class="sg-overlay"><span>Product Display</span></div>
            </div>
            <div class="sg-item">
               <img src="img/makeup/skin-care-hero.jpg" alt="Skincare Corner">
               <div class="sg-overlay"><span>Skincare Corner</span></div>
            </div>
            <div class="sg-item">
               <img src="img/makeup/glam.webp" alt="Photography Lighting Area">
               <div class="sg-overlay"><span>Photography Lighting</span></div>
            </div>
         </div>
         <div class="salon-copy">
            <div>
               <p class="section-label">Studio Standards</p>
               <h3 class="section-title" style="font-size:2rem;">Clean. Professional.<br><em>Welcoming.</em></h3>
            </div>
            <div>
               <div class="salon-bullets">
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Tools sterilised between every client session</div>
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Single-use applicators and brushes available</div>
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Professional ring lights and studio mirrors in every bay</div>
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Private consultation room for bridal bookings</div>
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Climate-controlled, air-purified environment</div>
                  <div class="salon-bullet"><i class="ti ti-circle-check"></i> Complimentary refreshments for all clients</div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- ============================================================
      OUR WORK — PORTFOLIO
   ============================================================ -->
   <section class="portfolio-section" id="our-work">
      <div class="container">
         <div class="section-head" style="text-align:left;">
            <p class="section-label">Portfolio</p>
            <h2 class="section-title" style="background: unset !important;">Work Done for<br><em>Our Clients</em></h2>
            <p class="section-sub">Real clients, real results. Every look was created at our Kampala studio by our certified team.</p>
         </div>
         <div class="portfolio-filter">
            <button class="pf-btn active" data-pf="all">All Work</button>
            <button class="pf-btn" data-pf="bridal">Bridal</button>
            <button class="pf-btn" data-pf="glam">Glam</button>
            <button class="pf-btn" data-pf="everyday">Everyday</button>
            <button class="pf-btn" data-pf="skincare">Skincare Glow</button>
            <button class="pf-btn" data-pf="editorial">Editorial</button>
         </div>
         <div class="portfolio-masonry" id="portfolioGrid">
            <div class="pm-item" data-pf="bridal" onclick="openLightbox('img/makeup/bridal-makeup.jpg','Bridal Look — Kampala Church Wedding')">
               <img src="img/makeup/bridal-makeup.jpg" alt="Bridal Makeup by Naomi Beauty">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Church Bridal Look</h5>
                  <span>Bridal · Kampala</span>
               </div>
            </div>
            <div class="pm-item" data-pf="glam" onclick="openLightbox('img/makeup/glam.webp','Full Glam — Night Event')">
               <img src="img/makeup/glam.webp" alt="Full Glam Look">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Night Event Glam</h5>
                  <span>Glam · Red Carpet</span>
               </div>
            </div>
            <div class="pm-item" data-pf="everyday" onclick="openLightbox('img/makeup/simple-makeup.jpg','Everyday Natural Glow')">
               <img src="img/makeup/simple-makeup.jpg" alt="Everyday Natural Makeup">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Natural Everyday Glow</h5>
                  <span>Everyday · Office</span>
               </div>
            </div>
            <div class="pm-item" data-pf="skincare" onclick="openLightbox('img/makeup/skin-care-hero.jpg','Skincare-Forward Glow')">
               <img src="img/makeup/skin-care-hero.jpg" alt="Skincare Glow Makeup">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Skincare Glow Look</h5>
                  <span>Skincare · Sensitive Skin</span>
               </div>
            </div>
            <div class="pm-item" data-pf="bridal" onclick="openLightbox('img/makeup/bridal-makeup.jpg','Traditional Ceremony Bridal')">
               <img src="img/makeup/bridal-makeup.jpg" alt="Traditional Bridal Makeup" style="filter:saturate(1.2) brightness(.95)">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Kwanjula Ceremony Look</h5>
                  <span>Bridal · Traditional</span>
               </div>
            </div>
            <div class="pm-item" data-pf="editorial" onclick="openLightbox('img/makeup/glam.webp','Editorial Shoot Look')">
               <img src="img/makeup/glam.webp" alt="Editorial Makeup" style="filter:contrast(1.1) saturate(1.3)">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Magazine Cover Editorial</h5>
                  <span>Editorial · Fashion Shoot</span>
               </div>
            </div>
            <div class="pm-item" data-pf="glam" onclick="openLightbox('img/makeup/glam.webp','Birthday Glam Look')">
               <img src="img/makeup/glam.webp" alt="Birthday Glam Makeup" style="filter:hue-rotate(10deg)">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Birthday Glam</h5>
                  <span>Glam · Party</span>
               </div>
            </div>
            <div class="pm-item" data-pf="everyday" onclick="openLightbox('img/makeup/simple-makeup.jpg','Work Ready Look')">
               <img src="img/makeup/simple-makeup.jpg" alt="Work Makeup" style="filter:brightness(1.05)">
               <div class="pm-item-overlay">
                  <i class="ti ti-heart pm-heart"></i>
                  <h5>Work-Ready Polish</h5>
                  <span>Everyday · Corporate</span>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- ============================================================
      PRODUCT SHOP
   ============================================================ -->
   <section class="products-section" id="shop">
      <div class="container">
         <div class="products-head">
            <div>
               <p class="section-label">Shop Our Products</p>
               <h2 class="section-title">Professional Makeup<br><em>Delivered to You</em></h2>
            </div>
            <a href="shop" class="btn-outline">
               <i class="ti ti-shopping-bag"></i> View Full Store
            </a>
         </div>
         <div class="products-grid">

            <!-- Product 1 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/1.webp" alt="Pro Foundation" onerror="this.src='img/makeup/skin-care-hero.jpg'">
                  <span class="pc-badge bestseller">Bestseller</span>
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('Pro Matte Foundation', '$45')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">Pro Matte Foundation — 40 Shades</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                     <span>(312)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$45</span><span class="pc-price-orig">$58</span></div>
                     <button class="pc-add-btn" onclick="addToCart('Pro Matte Foundation', '$45')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/2.webp" alt="Flat Velvet Lipstick" onerror="this.src='img/makeup/glam.webp'">
                  <span class="pc-badge new">New</span>
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('Flat Velvet Lipstick', '$28')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">Flat Velvet Lipstick — 24 Shades</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-half-filled"></i>
                     <span>(187)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$28</span></div>
                     <button class="pc-add-btn" onclick="addToCart('Flat Velvet Lipstick', '$28')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/3.webp" alt="Highlighter Palette" onerror="this.src='img/makeup/bridal-makeup.jpg'">
                  <span class="pc-badge sale">−30%</span>
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('Blinding Highlighter Palette', '$38')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">Blinding Highlighter Palette</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                     <span>(245)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$38</span><span class="pc-price-orig">$54</span></div>
                     <button class="pc-add-btn" onclick="addToCart('Blinding Highlighter Palette', '$38')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/4.webp" alt="Eye Brush Set" onerror="this.src='img/makeup/simple-makeup.jpg'">
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('Modern Eye Brush Set', '$27')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">Modern Eye Brush Set — 12pc</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-half-filled"></i>
                     <span>(98)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$27</span></div>
                     <button class="pc-add-btn" onclick="addToCart('Modern Eye Brush Set', '$27')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/5.webp" alt="Contour Kit" onerror="this.src='img/makeup/skin-care-hero.jpg'">
                  <span class="pc-badge bestseller">Bestseller</span>
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('Pro Sculpt Contour Kit', '$42')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">Pro Sculpt Contour &amp; Bronzer Kit</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                     <span>(421)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$42</span></div>
                     <button class="pc-add-btn" onclick="addToCart('Pro Sculpt Contour Kit', '$42')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card">
               <div class="pc-thumb">
                  <img src="img/products/cosmetic/6.webp" alt="Setting Spray" onerror="this.src='img/makeup/glam.webp'">
                  <span class="pc-badge new">New</span>
                  <div class="pc-wishlist" onclick="event.stopPropagation()"><i class="ti ti-heart"></i></div>
                  <button class="pc-quick-add" onclick="addToCart('All-Day Lock Setting Spray', '$22')"><i class="ti ti-shopping-cart-plus"></i> Add to Cart</button>
               </div>
               <div class="pc-body">
                  <p class="pc-brand">Naomi Beauty</p>
                  <h3 class="pc-name">All-Day Lock Setting Spray</h3>
                  <div class="pc-stars">
                     <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-half-filled"></i>
                     <span>(156)</span>
                  </div>
                  <div class="pc-price-row">
                     <div><span class="pc-price">$22</span></div>
                     <button class="pc-add-btn" onclick="addToCart('All-Day Lock Setting Spray', '$22')"><i class="ti ti-plus"></i></button>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </section>

   <!-- ============================================================
      COURSES + BOOKING CTA
   ============================================================ -->
   <section class="courses-cta" id="booking">
      <div class="cta-bg"><img src="img/makeup/bridal-makeup.jpg" alt=""></div>
      <div class="cta-overlay"></div>
      <div class="container">
         <div class="cta-inner">
            <div>
               <div class="cta-label"><i class="ti ti-sparkles"></i> Learn &amp; Transform</div>
               <h2 class="cta-title">Master Makeup<br><em>From Our Kampala Studio</em></h2>
               <p class="cta-sub">Join 847+ students who've learned professional makeup techniques live from Naomi Beauty. Stream from anywhere, earn a certificate, and get a professional kit delivered to your door.</p>
               <div class="cta-actions">
                  <a href="courses" class="btn-rose"><i class="ti ti-player-play"></i> Browse All Courses</a>
                  <a href="contact" class="btn-outline" style="border-color:rgba(255,255,255,.3);color:#fff;">
                     <i class="ti ti-calendar"></i> Book a Studio Session
                  </a>
               </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:16px;">
               <div class="cta-card">
                  <div class="cta-card-icon"><i class="ti ti-video"></i></div>
                  <h5>Online Makeup Courses</h5>
                  <p>Live-streamed from our studio or watch replays anytime. Three signature courses taught by Naomi Aisha, certified with 10+ years experience.</p>
                  <div class="cta-price">From $24</div>
                  <div class="cta-price-note">One-time payment · lifetime replay access</div>
                  <a href="courses" class="btn-rose" style="width:100%;justify-content:center;">
                     <i class="ti ti-arrow-right"></i> Explore Courses
                  </a>
               </div>
               <div class="cta-card">
                  <div class="cta-card-icon"><i class="ti ti-calendar-event"></i></div>
                  <h5>Book a Studio Session</h5>
                  <p>Come in to our Kampala studio for a personalised makeup session — bridal, glam, everyday, or skincare-forward. Same-day bookings available.</p>
                  <a href="contact" class="btn-outline" style="border-color:rgba(255,255,255,.2);color:#fff;width:100%;justify-content:center;">
                     <i class="ti ti-calendar"></i> Check Availability
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
  
   <!-- ============================================================
      BOOKING BAND
   ============================================================ -->
   <section class="booking-band">
      <div class="container">
         <div class="bb-inner">
            <div class="bb-copy">
               <h3>Ready for Your<br><em>Best Look Ever?</em></h3>
               <p>📍 Kampala · 📞 +256 755 250 754 · Open Mon–Sat, 8am–7pm</p>
            </div>
            <div class="bb-actions">
               <a href="tel:+256755250754" class="btn-rose"><i class="ti ti-phone"></i> Call Us Now</a>
               <a href="https://wa.me/256755250754" target="_blank" class="btn-outline"><i class="fa fa-whatsapp"></i> WhatsApp Us</a>
               <a href="contact" class="btn-outline"><i class="ti ti-calendar"></i> Book Online</a>
            </div>
         </div>
      </div>
   </section>

   <!-- Footer -->
   <footer class="pb-35 bck-footer">
      <?php include 'includes/footer.php'; ?>
   </footer>
</div>

<!-- Lightbox -->
<div class="lightbox-backdrop" id="lbBackdrop" onclick="closeLightbox()"></div>
<div class="lightbox" id="lightbox">
   <img src="" id="lbImg" alt="">
</div>
<button class="lb-close" id="lbClose" onclick="closeLightbox()" style="display:none;"><i class="ti ti-x"></i></button>

<!-- Cart Toast -->
<div class="cart-toast" id="cartToast">
   <i class="ti ti-shopping-bag"></i>
   <span id="cartToastMsg">Added to cart!</span>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
/* ===========================
   PORTFOLIO FILTER
=========================== */
document.querySelectorAll('.pf-btn').forEach(function(btn) {
   btn.addEventListener('click', function() {
      document.querySelectorAll('.pf-btn').forEach(function(b){ b.classList.remove('active'); });
      this.classList.add('active');
      var filter = this.dataset.pf;
      document.querySelectorAll('.pm-item').forEach(function(item) {
         if(filter === 'all' || item.dataset.pf === filter) {
            item.style.display = '';
         } else {
            item.style.display = 'none';
         }
      });
   });
});

/* ===========================
   LIGHTBOX
=========================== */
function openLightbox(src, alt) {
   document.getElementById('lbImg').src = src;
   document.getElementById('lbImg').alt = alt || '';
   document.getElementById('lightbox').classList.add('open');
   document.getElementById('lbBackdrop').classList.add('open');
   document.getElementById('lbClose').style.display = 'flex';
   document.body.style.overflow = 'hidden';
}
function closeLightbox() {
   document.getElementById('lightbox').classList.remove('open');
   document.getElementById('lbBackdrop').classList.remove('open');
   document.getElementById('lbClose').style.display = 'none';
   document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeLightbox(); });

/* ===========================
   ADD TO CART
=========================== */
function addToCart(name, price) {
   var toast = document.getElementById('cartToast');
   document.getElementById('cartToastMsg').textContent = name + ' (' + price + ') added to cart!';
   toast.classList.add('show');
   setTimeout(function(){ toast.classList.remove('show'); }, 3000);
}



/* ===========================
   SCROLL REVEAL
=========================== */
(function() {
   var items = document.querySelectorAll('.type-card, .product-card, .pm-item, .why-point, .salon-bullet, .cta-card');
   var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
         if(entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
         }
      });
   }, { threshold: 0.1 });
   items.forEach(function(item, i) {
      item.style.opacity = '0';
      item.style.transform = 'translateY(24px)';
      item.style.transition = 'opacity .55s ' + (i * 0.07) + 's ease, transform .55s ' + (i * 0.07) + 's ease';
      observer.observe(item);
   });
})();
</script>
</body>
</html>