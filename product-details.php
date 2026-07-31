<?php
   $page = "shop";
   require_once "admin/core/init.php";
   $slug = Input::get('slug','get');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- Naomi Beauty shop styles — same file as shop.php -->
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
     


    <!-- Product content rendered by assets/js/product-details.js using
         ?slug= from the URL (e.g. product-details.php?slug=body-wave) -->
    <div class="nb-pd-wrap" id="nbPdRoot">
        <div class="container"><p style="padding:60px 0;text-align:center;color:rgba(27,20,16,.5)">Loading product…</p></div>
    </div>

    <!-- Footer -->
    <footer class="pb-35 bck-footer">
        <?php include 'includes/footer.php'; ?>
    </footer>

</div><!-- /wrapper -->

<?php include 'includes/scripts.php'; ?>

<!-- Product catalog + page logic -->
<script src="js/products-data.js"></script>
<script src="js/product-details.js"></script>

</body>
</html>
