<?php
   $page = "shop";
   require_once "admin/core/init.php";
   $_display = Input::get('page','get');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body class="template-color-1">
<div class="wrapper nb-shop-wrap">

    <!-- Fixed elements -->
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

    <!-- Hero Strip -->
    <div class="nb-shop-hero">
        <div class="container">
            <span class="nb-hero-tag">Naomi Beauty Collection</span>
            <h1>Shop All Products</h1>
            <p>Premium wigs, bundles, makeup &amp; professional beauty courses — curated for you.</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area">
        <div class="container">
            <ol class="breadcrumb breadcrumb-list mb-0">
                <li class="breadcrumb-item"><a href="index">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </div>
    </div>

    <!-- Category Tab Bar (sticky) -->
    <nav class="nb-cat-bar">
        <div class="container">
            <ul class="nb-cat-tabs">
                <li><a href="#" class="active"><i class="ti ti-layout-grid"></i>All Products</a></li>
                <li><a href="#section-wigs"><i class="ti ti-crown"></i>Human Hair</a></li>
                <li><a href="#section-makeup"><i class="ti ti-droplet"></i>Makeup</a></li>
                <li><a href="#section-courses"><i class="ti ti-school"></i>Courses</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Shop Content -->
    <div class="nb-shop-main">
        <div class="container">
            <div class="row">

                <!-- ===== SIDEBAR ===== -->
                <div class="col-lg-3 order-2 order-lg-1 mt-4 mt-lg-0">
                    <aside class="nb-sidebar">

                        <!-- Price Filter -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Price range</h3>
                            <input type="range" class="nb-price-range" min="0" max="300" value="150" id="priceRange"
                                oninput="document.getElementById('priceVal').textContent='$'+this.value">
                            <div class="nb-price-display">
                                <span>$0</span>
                                <span id="priceVal">$150</span>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Category</h3>
                            <ul class="nb-filter-list">
                                <li><label><input type="checkbox" checked>Human Hair Wigs<span class="nb-count">14</span></label></li>
                                <li><label><input type="checkbox">Hair Bundles<span class="nb-count">9</span></label></li>
                                <li><label><input type="checkbox">Clip-On Extensions<span class="nb-count">6</span></label></li>
                                <li><label><input type="checkbox">Crochet Hair<span class="nb-count">5</span></label></li>
                                <li><label><input type="checkbox">Makeup Products<span class="nb-count">12</span></label></li>
                                <li><label><input type="checkbox">Beauty Courses<span class="nb-count">3</span></label></li>
                            </ul>
                        </div>

                        <!-- Hair Type -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Hair type</h3>
                            <ul class="nb-filter-list">
                                <li><label><input type="checkbox">Lace Front<span class="nb-count">8</span></label></li>
                                <li><label><input type="checkbox">HD Lace<span class="nb-count">5</span></label></li>
                                <li><label><input type="checkbox">360 Lace<span class="nb-count">4</span></label></li>
                                <li><label><input type="checkbox">Glueless<span class="nb-count">6</span></label></li>
                            </ul>
                        </div>

                        <!-- Hair Length -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Length</h3>
                            <ul class="nb-filter-list">
                                <li><label><input type="checkbox">12" – 14"<span class="nb-count">4</span></label></li>
                                <li><label><input type="checkbox">16" – 18"<span class="nb-count">6</span></label></li>
                                <li><label><input type="checkbox">20" – 22"<span class="nb-count">5</span></label></li>
                                <li><label><input type="checkbox">24" – 26"<span class="nb-count">3</span></label></li>
                            </ul>
                        </div>

                        <!-- Color Swatches -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Color</h3>
                            <div class="nb-color-swatches">
                                <div class="nb-swatch active" title="Natural Black" style="background:#1a1a1a;"></div>
                                <div class="nb-swatch" title="Dark Brown" style="background:#4a2c17;"></div>
                                <div class="nb-swatch" title="Honey Brown" style="background:#9a6b3a;"></div>
                                <div class="nb-swatch" title="Blonde" style="background:#e0c882;"></div>
                                <div class="nb-swatch" title="Burgundy" style="background:#6b1a2a;"></div>
                                <div class="nb-swatch" title="Ombre" style="background:linear-gradient(#2a1a0f,#c9a96e);"></div>
                            </div>
                        </div>

                        <!-- Course Level -->
                        <div class="nb-sidebar-section">
                            <h3 class="nb-sidebar-title">Course level</h3>
                            <ul class="nb-filter-list">
                                <li><label><input type="checkbox">Beginner<span class="nb-count">1</span></label></li>
                                <li><label><input type="checkbox">Intermediate<span class="nb-count">1</span></label></li>
                                <li><label><input type="checkbox">Advanced<span class="nb-count">1</span></label></li>
                            </ul>
                        </div>

                    </aside>

                    <!-- Promo Banner -->
                    <div class="nb-sidebar-banner"> 
                        <h4>Makeup Courses</h4>
                        <p>Learn from professional artists. Bridal, Glam &amp; everyday looks.</p>
                        <a href="courses">Enroll Now</a>
                    </div>
                </div>
                <!-- End Sidebar -->

                <!-- ===== MAIN PRODUCT AREA ===== -->
                <div class="col-lg-9 order-1 order-lg-2">

                    <!-- Toolbar -->
                    <div class="nb-toolbar">
                        <span class="nb-result-count">Showing <strong>1–12</strong> of <strong>49</strong> products</span>
                        <div class="nb-search-input">
                            <i class="ti ti-search"></i>
                            <input type="text" placeholder="Search products…" aria-label="Search products">
                        </div>
                        <select class="nb-sort-select" aria-label="Sort products">
                            <option>Relevance</option>
                            <option>Newest first</option>
                            <option>Price: low to high</option>
                            <option>Price: high to low</option>
                            <option>Best rated</option>
                        </select>
                        <div class="nb-view-btns" role="group" aria-label="View mode">
                            <a class="nb-view-btn active" id="btnGrid" href="#" title="Grid view" aria-label="Grid view">
                                <i class="ti ti-layout-grid"></i>
                            </a>
                            <a class="nb-view-btn" id="btnList" href="#" title="List view" aria-label="List view">
                                <i class="ti ti-list"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Active filters -->
                    <div class="nb-active-filters">
                        <span>Active filters:</span>
                        <div class="nb-filter-tag">Human Hair Wigs <i class="ti ti-x"></i></div>
                        <div class="nb-filter-tag">Natural Black <i class="ti ti-x"></i></div>
                        <span class="nb-clear-all">Clear all</span>
                    </div>

                    <!-- ===== HUMAN HAIR SECTION ===== -->
                    <section id="section-wigs">
                        <div class="nb-section-head">
                            <h2>Human Hair</h2>
                            <a href="#">View all <i class="ti ti-arrow-right"></i></a>
                        </div>

                        <!-- Sub-category tabs -->
                        <div class="nb-shop-tabs">
                            <button class="nb-shop-tab active">All</button>
                            <button class="nb-shop-tab">Wigs</button>
                            <button class="nb-shop-tab">Bundles</button>
                            <button class="nb-shop-tab">Clip-On</button>
                            <button class="nb-shop-tab">Crochet</button>
                        </div>

                        <!-- Grid view -->
                        <div id="gridView">
                            <div class="nb-product-grid">

                                <!-- Product 1 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/wigs/wig1.jpg" alt="Lace Front Body Wave Wig 18 inch" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-new">New</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Add to wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                            <a class="nb-overlay-btn" href="compare" title="Compare" aria-label="Compare">
                                                <i class="ti ti-arrows-diff"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">Lace Front Wig</p>
                                        <h4 class="nb-card-title"><a href="product-details">Body Wave Wig 18"</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$189.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                                <!-- Product 2 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/wigs/wig1.jpg" alt="HD Glueless Straight Wig 22 inch" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-new">New</span>
                                            <span class="nb-badge nb-badge-sale">-10%</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">HD Lace Wig</p>
                                        <h4 class="nb-card-title"><a href="product-details">HD Glueless Straight 22"</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$215.00</span>
                                            <span class="nb-price-was">$239.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                                <!-- Product 3 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/wigs/wig1.jpg" alt="Deep Curl Wig 20 inch" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-new">New</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">Deep Curl Wig</p>
                                        <h4 class="nb-card-title"><a href="product-details">Curl &amp; Go Deep Curl 20"</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$175.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                                <!-- Product 4 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/wigs/wig1.jpg" alt="360 Lace Frontal Water Wave Wig 16 inch" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-sale">-5%</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">360 Lace Wig</p>
                                        <h4 class="nb-card-title"><a href="product-details">360 Lace Water Wave 16"</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-half-filled"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$189.00</span>
                                            <span class="nb-price-was">$199.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                                <!-- Product 5 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/cosmetic/3.webp" alt="3-Bundle Deal Body Wave" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-new">New</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">Hair Bundle</p>
                                        <h4 class="nb-card-title"><a href="product-details">3-Bundle Deal — Body Wave</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$135.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                                <!-- Product 6 -->
                                <div class="nb-product-card">
                                    <div class="nb-card-img">
                                        <a href="product-details">
                                            <img src="img/products/cosmetic/4.webp" alt="Clip-On Ponytail Extension" loading="lazy">
                                        </a>
                                        <div class="nb-badge-row">
                                            <span class="nb-badge nb-badge-new">New</span>
                                        </div>
                                        <div class="nb-card-overlay">
                                            <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#product-window">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist">
                                                <i class="ti ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="nb-card-body">
                                        <p class="nb-card-category">Clip-On</p>
                                        <h4 class="nb-card-title"><a href="product-details">Clip-On Ponytail Extension</a></h4>
                                        <div class="nb-stars">
                                            <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                        </div>
                                        <div class="nb-card-price">
                                            <span class="nb-price-now">$65.00</span>
                                        </div>
                                        <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>

                            </div><!-- /nb-product-grid -->
                        </div>

                        <!-- List view (hidden by default) -->
                        <div id="listView" style="display:none;">
                            <div class="nb-product-list">

                                <div class="nb-list-card">
                                    <div class="nb-list-img">
                                        <img src="img/products/wigs/wig1.jpg" alt="Body Wave Wig" loading="lazy">
                                    </div>
                                    <div class="nb-list-body">
                                        <div>
                                            <p class="nb-card-category">Lace Front Wig</p>
                                            <h4 class="nb-card-title"><a href="product-details">Body Wave Wig 18"</a></h4>
                                            <div class="nb-stars">
                                                <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                            </div>
                                            <p class="nb-list-desc">100% human hair lace front wig. Pre-plucked hairline, baby hair included. Available in multiple lengths. Natural black, ready to colour.</p>
                                        </div>
                                        <div class="nb-list-actions">
                                            <div class="nb-card-price">
                                                <span class="nb-price-now">$189.00</span>
                                            </div>
                                            <a href="cart" class="nb-btn-cart nb-btn-cart--auto">
                                                <i class="ti ti-shopping-cart"></i> Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="nb-list-card">
                                    <div class="nb-list-img">
                                        <img src="img/products/wigs/wig2.jpg" alt="HD Glueless Straight Wig" loading="lazy">
                                    </div>
                                    <div class="nb-list-body">
                                        <div>
                                            <p class="nb-card-category">HD Lace Wig</p>
                                            <h4 class="nb-card-title"><a href="product-details">HD Glueless Straight 22"</a></h4>
                                            <div class="nb-stars">
                                                <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                                            </div>
                                            <p class="nb-list-desc">HD transparent lace melts seamlessly into any skin tone. Glueless installation for maximum comfort. Tangle-free &amp; long-lasting.</p>
                                        </div>
                                        <div class="nb-list-actions">
                                            <div class="nb-card-price">
                                                <span class="nb-price-now">$215.00</span>
                                                <span class="nb-price-was">$239.00</span>
                                            </div>
                                            <a href="cart" class="nb-btn-cart nb-btn-cart--auto">
                                                <i class="ti ti-shopping-cart"></i> Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </section>

                    <hr class="nb-section-divider">

                    <!-- ===== MAKEUP SECTION ===== -->
                    <section id="section-makeup">
                        <div class="nb-section-head">
                            <h2>Makeup Products</h2>
                            <a href="#">View all <i class="ti ti-arrow-right"></i></a>
                        </div>

                        <div class="nb-product-grid">

                            <!-- Makeup 1 -->
                            <div class="nb-product-card">
                                <div class="nb-card-img">
                                    <a href="product-details">
                                        <img src="img/products/cosmetic/1.webp" alt="Modern Eye Brush Set" loading="lazy">
                                    </a>
                                    <div class="nb-badge-row"><span class="nb-badge nb-badge-new">New</span></div>
                                    <div class="nb-card-overlay">
                                        <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#product-window">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <a class="nb-overlay-btn" href="wishlist" aria-label="Wishlist"><i class="ti ti-heart"></i></a>
                                    </div>
                                </div>
                                <div class="nb-card-body">
                                    <p class="nb-card-category">Brushes &amp; Tools</p>
                                    <h4 class="nb-card-title"><a href="product-details">Modern Eye Brush Set</a></h4>
                                    <div class="nb-stars">
                                        <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i><i class="ti ti-star empty"></i>
                                    </div>
                                    <div class="nb-card-price"><span class="nb-price-now">$45.50</span></div>
                                    <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                </div>
                            </div>

                            <!-- Makeup 2 -->
                            <div class="nb-product-card">
                                <div class="nb-card-img">
                                    <a href="product-details">
                                        <img src="img/products/cosmetic/2.webp" alt="Flat Velvet Lipstick" loading="lazy">
                                    </a>
                                    <div class="nb-badge-row">
                                        <span class="nb-badge nb-badge-new">New</span>
                                        <span class="nb-badge nb-badge-sale">-5%</span>
                                    </div>
                                    <div class="nb-card-overlay">
                                        <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#product-window">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <a class="nb-overlay-btn" href="wishlist" aria-label="Wishlist"><i class="ti ti-heart"></i></a>
                                    </div>
                                </div>
                                <div class="nb-card-body">
                                    <p class="nb-card-category">Lip Colour</p>
                                    <h4 class="nb-card-title"><a href="product-details">Flat Velvet Lipstick</a></h4>
                                    <div class="nb-stars">
                                        <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i><i class="ti ti-star empty"></i>
                                    </div>
                                    <div class="nb-card-price">
                                        <span class="nb-price-now">$61.75</span>
                                        <span class="nb-price-was">$65.00</span>
                                    </div>
                                    <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                </div>
                            </div>

                            <!-- Makeup 3 -->
                            <div class="nb-product-card">
                                <div class="nb-card-img">
                                    <a href="product-details">
                                        <img src="img/products/cosmetic/3.webp" alt="Voyage Face Cleanser" loading="lazy">
                                    </a>
                                    <div class="nb-card-overlay">
                                        <button class="nb-overlay-btn" title="Quick view" aria-label="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#product-window">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <a class="nb-overlay-btn" href="wishlist" aria-label="Wishlist"><i class="ti ti-heart"></i></a>
                                    </div>
                                </div>
                                <div class="nb-card-body">
                                    <p class="nb-card-category">Skincare</p>
                                    <h4 class="nb-card-title"><a href="product-details">Voyage Face Cleanser</a></h4>
                                    <div class="nb-stars">
                                        <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i><i class="ti ti-star empty"></i>
                                    </div>
                                    <div class="nb-card-price">
                                        <span class="nb-price-now">$61.21</span>
                                        <span class="nb-price-was">$64.50</span>
                                    </div>
                                    <a href="cart" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>Add to Cart</a>
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- Pagination -->
                    <nav class="nb-pagination" aria-label="Product pagination">
                        <a class="nb-page-btn" href="#" aria-label="Previous page"><i class="ti ti-chevron-left"></i></a>
                        <a class="nb-page-btn active" href="#">1</a>
                        <a class="nb-page-btn" href="#">2</a>
                        <a class="nb-page-btn" href="#">3</a>
                        <span class="nb-page-ellipsis">…</span>
                        <a class="nb-page-btn" href="#">8</a>
                        <a class="nb-page-btn" href="#" aria-label="Next page"><i class="ti ti-chevron-right"></i></a>
                    </nav>

                </div>
                <!-- End main product area -->

            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /nb-shop-main -->

    <!-- Footer -->
    <footer class="pb-35 bck-footer">
        <?php include 'includes/footer.php'; ?>
    </footer>

    <!-- Quick View Modal -->
    <div class="main-product-thumbnail quick-thumb-content">
        <div class="container">
            <div class="modal fade" id="product-window">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content nb-modal-content">
                        <div class="modal-header nb-modal-header">
                            <h5 class="nb-modal-title">Quick View</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body nb-modal-body">
                            <div class="row">
                                <div class="col-lg-5 col-md-6 mb-all-40">
                                    <div class="tab-content">
                                        <div id="pro-1" class="tab-pane fade show active">
                                            <a data-fancybox="images" href="img/products/cosmetic/1.webp">
                                                <img src="img/products/cosmetic/1.webp" alt="product-view" class="nb-modal-img">
                                            </a>
                                        </div>
                                        <div id="pro-2" class="tab-pane fade">
                                            <a data-fancybox="images" href="img/products/cosmetic/2.webp">
                                                <img src="img/products/cosmetic/2.webp" alt="product-view" class="nb-modal-img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-thumbnail mt-3">
                                        <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                                            <a class="active" data-bs-toggle="tab" href="#pro-1">
                                                <img src="img/thumbnail/cosmetic/1.webp" alt="thumb" class="nb-thumb-img">
                                            </a>
                                            <a data-bs-toggle="tab" href="#pro-2">
                                                <img src="img/thumbnail/cosmetic/2.webp" alt="thumb" class="nb-thumb-img">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="thubnail-desc fix">
                                        <h3 class="nb-modal-product-title">Body Wave Lace Front Wig</h3>
                                        <div class="nb-stars nb-stars--modal">
                                            <i class="ti ti-star-filled"></i>
                                            <i class="ti ti-star-filled"></i>
                                            <i class="ti ti-star-filled"></i>
                                            <i class="ti ti-star-filled"></i>
                                            <i class="ti ti-star empty"></i>
                                        </div>
                                        <div class="nb-card-price nb-modal-price">
                                            <span class="nb-price-now">$189.00</span>
                                        </div>
                                        <p class="nb-modal-desc">
                                            100% human hair lace front wig with pre-plucked hairline. Baby hairs included. Natural black — can be coloured. Tangle-free and long-lasting.
                                        </p>
                                        <div class="nb-modal-field">
                                            <label class="nb-modal-label">Length</label>
                                            <select class="nb-sort-select nb-sort-select--full">
                                                <option>16 inches</option>
                                                <option>18 inches</option>
                                                <option>20 inches</option>
                                                <option>22 inches</option>
                                            </select>
                                        </div>
                                        <div class="nb-modal-field">
                                            <label class="nb-modal-label">Color</label>
                                            <div class="nb-color-swatches">
                                                <div class="nb-swatch active" title="Natural Black" style="background:#1a1a1a;"></div>
                                                <div class="nb-swatch" title="Dark Brown" style="background:#4a2c17;"></div>
                                                <div class="nb-swatch" title="Honey Brown" style="background:#9a6b3a;"></div>
                                                <div class="nb-swatch" title="Burgundy" style="background:#6b1a2a;"></div>
                                            </div>
                                        </div>
                                        <div class="nb-modal-cart-row">
                                            <input type="number" min="1" value="1" class="nb-sort-select nb-qty-input" aria-label="Quantity">
                                            <button class="nb-btn-cart nb-btn-cart--flex">
                                                <i class="ti ti-shopping-cart"></i> Add to Cart
                                            </button>
                                        </div>
                                        <p class="nb-stock-status">
                                            <i class="ti ti-check nb-stock-icon"></i>In stock — ships within 2–3 business days
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /wrapper -->

<?php include 'includes/scripts.php'; ?>

<script>
/* ---- View toggle (Grid / List) ---- */
document.getElementById('btnGrid').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('gridView').style.display = '';
    document.getElementById('listView').style.display = 'none';
    this.classList.add('active');
    document.getElementById('btnList').classList.remove('active');
});
document.getElementById('btnList').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('gridView').style.display = 'none';
    document.getElementById('listView').style.display = '';
    this.classList.add('active');
    document.getElementById('btnGrid').classList.remove('active');
});

/* ---- Sub-category tabs ---- */
document.querySelectorAll('.nb-shop-tab').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.nb-shop-tab').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
    });
});

/* ---- Filter tag remove ---- */
document.querySelectorAll('.nb-filter-tag').forEach(function(tag) {
    tag.addEventListener('click', function() { this.remove(); });
});
document.querySelector('.nb-clear-all').addEventListener('click', function() {
    document.querySelectorAll('.nb-filter-tag').forEach(function(t) { t.remove(); });
});

/* ---- Color swatches ---- */
document.querySelectorAll('.nb-swatch').forEach(function(sw) {
    sw.addEventListener('click', function() {
        this.closest('.nb-color-swatches').querySelectorAll('.nb-swatch').forEach(function(s) { s.classList.remove('active'); });
        this.classList.add('active');
    });
});
</script>

</body>
</html>