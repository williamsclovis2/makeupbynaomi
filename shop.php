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
    <!-- Naomi Beauty shop styles — built on this page's own class names -->
    <link rel="stylesheet" href="css/naomi-shop.css">
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
                <li><a href="#section-wigs" class="active"><i class="ti ti-layout-grid"></i>All Products</a></li>
                <li><a href="#section-wigs"><i class="ti ti-crown"></i>Human Hair</a></li>
                <li><a href="#section-makeup"><i class="ti ti-droplet"></i>Makeup</a></li>
                <li><a href="#section-courses"><i class="ti ti-school"></i>Courses</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Shop Content — sidebar removed, full width -->
    <div class="nb-shop-main">
        <div class="container">

            <!-- Toolbar -->
            <div class="nb-toolbar">
                <span class="nb-result-count" id="nbResultCount">Showing all styles</span>
                <div class="nb-search-input">
                    <i class="ti ti-search"></i>
                    <input type="text" id="nbShopSearch" placeholder="Search products…" aria-label="Search products">
                </div>
                <select class="nb-sort-select" aria-label="Sort products">
                    <option>Relevance</option>
                    <option>Newest first</option>
                    <option>Price: low to high</option>
                    <option>Price: high to low</option>
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

            <!-- ===== HUMAN HAIR SECTION ===== -->
            <section id="section-wigs">
                <div class="nb-section-head">
                    <h2>Human Hair</h2>
                    <span style="font-size:13px;color:rgba(27,20,16,.5)">Bundles &amp; ready-to-wear wigs</span>
                </div>

                <!-- Sub-category tabs: filters the grid below by product group -->
                <div class="nb-shop-tabs">
                    <button class="nb-shop-tab active" data-group="all">All</button>
                    <button class="nb-shop-tab" data-group="bundle">Hair Bundles</button>
                    <button class="nb-shop-tab" data-group="wig">Wigs</button>
                </div>

                <!-- Grid view (filled by shop.js from products-data.js) -->
                <div id="gridView">
                    <div class="nb-product-grid" id="nbHumanHairGrid"></div>
                </div>

                <!-- List view (hidden by default) -->
                <div id="listView" style="display:none;">
                    <div class="nb-product-list" id="nbHumanHairList"></div>
                </div>
            </section>


        </div><!-- /container -->
    </div><!-- /nb-shop-main -->

    <section class="history-section">
      
        <div class="history-area-custom">
            <!-- Motif SVGs -->
            <svg class="hst-motif hst-motif-tl" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" stroke="white" stroke-width="1.5"></circle>
                <circle cx="100" cy="100" r="68" stroke="white" stroke-width="1"></circle>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(0   100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(45  100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(90  100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(135 100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(180 100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(225 100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(270 100 100)"
                ></ellipse>
                <ellipse
                    cx="100"
                    cy="18"
                    rx="10"
                    ry="18"
                    stroke="white"
                    stroke-width="1.2"
                    transform="rotate(315 100 100)"
                ></ellipse>
                <circle cx="100" cy="100" r="12" stroke="white" stroke-width="1.5"></circle>
                <circle cx="100" cy="100" r="5" fill="white"></circle>
            </svg>

            <svg class="hst-motif hst-motif-tr" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect
                    x="40"
                    y="40"
                    width="80"
                    height="80"
                    stroke="white"
                    stroke-width="1.5"
                    transform="rotate(45 80 80)"
                ></rect>
                <rect
                    x="54"
                    y="54"
                    width="52"
                    height="52"
                    stroke="white"
                    stroke-width="1"
                    transform="rotate(45 80 80)"
                ></rect>
                <line x1="0" y1="80" x2="160" y2="80" stroke="white" stroke-width=".7"></line>
                <line x1="80" y1="0" x2="80" y2="160" stroke="white" stroke-width=".7"></line>
                <line x1="0" y1="0" x2="160" y2="160" stroke="white" stroke-width=".6"></line>
                <line x1="160" y1="0" x2="0" y2="160" stroke="white" stroke-width=".6"></line>
                <circle cx="80" cy="80" r="7" fill="white"></circle>
            </svg>

            <svg class="hst-motif hst-motif-bl" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M75 140 C20 100 20 40 75 10 C130 40 130 100 75 140Z" stroke="white" stroke-width="1.5"></path>
                <line x1="75" y1="10" x2="75" y2="140" stroke="white" stroke-width="1"></line>
                <path d="M45 60  Q60 55  75 60" stroke="white" stroke-width=".8"></path>
                <path d="M45 80  Q60 75  75 80" stroke="white" stroke-width=".8"></path>
                <path d="M45 100 Q60 95  75 100" stroke="white" stroke-width=".8"></path>
                <path d="M105 60  Q90 55  75 60" stroke="white" stroke-width=".8"></path>
                <path d="M105 80  Q90 75  75 80" stroke="white" stroke-width=".8"></path>
                <path d="M105 100 Q90 95  75 100" stroke="white" stroke-width=".8"></path>
            </svg>

            <svg class="hst-motif hst-motif-br" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g stroke="white" stroke-width="1.1">
                    <line x1="100" y1="0" x2="100" y2="200"></line>
                    <line x1="0" y1="100" x2="200" y2="100"></line>
                    <line x1="0" y1="0" x2="200" y2="200"></line>
                    <line x1="200" y1="0" x2="0" y2="200"></line>
                    <line x1="50" y1="0" x2="150" y2="200"></line>
                    <line x1="150" y1="0" x2="50" y2="200"></line>
                    <line x1="0" y1="50" x2="200" y2="150"></line>
                    <line x1="0" y1="150" x2="200" y2="50"></line>
                </g>
                <circle cx="100" cy="100" r="42" stroke="white" stroke-width="1.5"></circle>
                <circle cx="100" cy="100" r="22" stroke="white" stroke-width="1"></circle>
                <circle cx="100" cy="100" r="7" fill="white"></circle>
            </svg>

            <svg class="hst-motif hst-motif-mid" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="200" cy="200" r="185" stroke="white" stroke-width="1"></circle>
                <circle cx="200" cy="200" r="145" stroke="white" stroke-width="1"></circle>
                <circle cx="200" cy="200" r="105" stroke="white" stroke-width="1"></circle>
                <circle cx="200" cy="200" r="65" stroke="white" stroke-width="1"></circle>
                <circle cx="200" cy="200" r="28" stroke="white" stroke-width="1.5"></circle>
                <g stroke="white" stroke-width=".7">
                    <line x1="200" y1="15" x2="200" y2="385"></line>
                    <line x1="15" y1="200" x2="385" y2="200"></line>
                    <line x1="60" y1="60" x2="340" y2="340"></line>
                    <line x1="340" y1="60" x2="60" y2="340"></line>
                    <line x1="200" y1="15" x2="200" y2="385" transform="rotate(22.5 200 200)"></line>
                    <line x1="15" y1="200" x2="385" y2="200" transform="rotate(22.5 200 200)"></line>
                    <line x1="200" y1="15" x2="200" y2="385" transform="rotate(45 200 200)"></line>
                    <line x1="15" y1="200" x2="385" y2="200" transform="rotate(45 200 200)"></line>
                </g>
            </svg>

            <div class="hst-dot-layer">
                <div class="hst-dot" style="width: 8px; height: 8px; top: 10%; left: 6%"></div>
                <div class="hst-dot" style="width: 5px; height: 5px; top: 22%; left: 14%"></div>
                <div class="hst-dot" style="width: 11px; height: 11px; top: 7%; left: 74%"></div>
                <div class="hst-dot" style="width: 6px; height: 6px; top: 32%; left: 88%"></div>
                <div class="hst-dot" style="width: 9px; height: 9px; top: 74%; left: 4%"></div>
                <div class="hst-dot" style="width: 5px; height: 5px; top: 84%; left: 22%"></div>
                <div class="hst-dot" style="width: 10px; height: 10px; top: 80%; left: 91%"></div>
                <div class="hst-dot" style="width: 4px; height: 4px; top: 48%; left: 2%"></div>
            </div>

            <!-- ── Content ── -->
            <div class="container">
                <div class="hst-row">
                    <!-- Left: photo, contained & slightly smaller than section height -->
                    <div class="hst-img-col">
                        <img src="img/team/Naomi.png" alt="Our History" />
                    </div>

                    <!-- Right: pale card, photo's right edge overlaps into it -->
                    <div class="hst-card">
                        <span class="hst-eyebrow">Business introduction</span>
                        <h2>No More Firecracker</h2>
                        <div class="hst-divider"></div>
                        <p class="hst-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris
                            scelerisque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus.
                        </p>
                        <p class="hst-touch-title">A Personal Touch</p>
                        <ul>
                            <li>
                                Aliquam vitae molestie at quisque sapien volutpat and justo, aliquet molestie purus
                                efficitur ipsum
                            </li>
                            <li>
                                Sagittis congue augue magna risus mauris volutpat and egestas magna suscipit egestas a vitae
                                purus
                            </li>
                        </ul>
                        <a href="courses" class="hst-btn">Keep shining </a>
                    </div>
                </div>
            </div>
        </div>
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


    <!-- Footer -->
    <footer class="pb-35 bck-footer">
        <?php include 'includes/footer.php'; ?>
    </footer>

</div><!-- /wrapper -->

<?php include 'includes/scripts.php'; ?>

<!-- Product catalog + page logic -->
<script src="js/products-data.js"></script>
<script src="js/shop.js"></script>

<script>
/* ---- Filter tag remove (kept from your original, unused until filters are active) ---- */
document.querySelectorAll('.nb-filter-tag').forEach(function(tag) {
    tag.addEventListener('click', function() { this.remove(); });
});
var clearAllBtn = document.querySelector('.nb-clear-all');
if (clearAllBtn) {
  clearAllBtn.addEventListener('click', function() {
      document.querySelectorAll('.nb-filter-tag').forEach(function(t) { t.remove(); });
  });
}
</script>

</body>
</html>