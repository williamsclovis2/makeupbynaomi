/* NAOMI BEAUTY — shop.php logic
   Renders the Human Hair product grid from PRODUCTS (products-data.js)
   into your existing markup structure (nb-product-grid / nb-product-card /
   nb-btn-cart etc.), wires up the Bundles/Wigs sub-tabs, search, and the
   Quick View modal. */

(function () {
  var grid = document.getElementById('nbHumanHairGrid');
  var listGrid = document.getElementById('nbHumanHairList');
  var countEl = document.getElementById('nbResultCount');
  var searchInput = document.getElementById('nbShopSearch');
  var subTabs = document.querySelectorAll('.nb-shop-tab');

  // group = "bundle" for the 4 loose-hair products, "wig" for the 3 wig products
  var GROUPS = {
    "body-wave": "bundle", "pixie-bundle": "bundle", "ocean-bundle": "bundle", "freez-bundle": "bundle",
    "classic-wigs": "wig", "pixie-glueless": "wig", "wavy-glueless": "wig"
  };

  function cardHtml(p) {
    var img = p.folder + (p.colors[0] ? p.colors[0].image : 'placeholder.jpg');
    var priceLabel = nbPriceRangeLabel(p);
    var swatches = p.colors.map(function (c) { return '<span style="background:' + c.hex + '" title="' + c.name + '"></span>'; }).join('');
    return (
      '<div class="nb-product-card" data-group="' + GROUPS[p.slug] + '" data-slug="' + p.slug + '">' +
        '<div class="nb-card-img">' +
          '<a href="product-details.php?slug=' + p.slug + '"><img src="' + img + '" alt="' + p.name + '" loading="lazy" onerror="this.closest(\'.nb-card-img\').style.background=\'#e4dbca\'"></a>' +
          '<div class="nb-card-overlay">' +
            '<a class="nb-overlay-btn" href="product-details.php?slug=' + p.slug + '" title="View product" aria-label="View product"><i class="ti ti-eye"></i></a>' +
            '<a class="nb-overlay-btn" href="wishlist" title="Wishlist" aria-label="Wishlist"><i class="ti ti-heart"></i></a>' +
          '</div>' +
        '</div>' +
        '<div class="nb-card-body">' +
          '<p class="nb-card-category">' + p.category + '</p>' +
          '<h4 class="nb-card-title"><a href="product-details.php?slug=' + p.slug + '">' + p.name + '</a></h4>' +
          // '<div class="nb-card-swatches">' + swatches + '</div>' +
          '<div class="nb-card-price"><span class="nb-price-now">' + priceLabel + '</span></div>' +
          '<a href="product-details.php?slug=' + p.slug + '" class="nb-btn-cart"><i class="ti ti-shopping-cart"></i>View Options</a>' +
        '</div>' +
      '</div>'
    );
  }

  function listRowHtml(p) {
    var img = p.folder + (p.colors[0] ? p.colors[0].image : 'placeholder.jpg');
    var priceLabel = nbPriceRangeLabel(p);
    return (
      '<div class="nb-list-card" data-group="' + GROUPS[p.slug] + '" data-slug="' + p.slug + '">' +
        '<div class="nb-list-img"><img src="' + img + '" alt="' + p.name + '" loading="lazy" onerror="this.parentElement.style.background=\'#e4dbca\'"></div>' +
        '<div class="nb-list-body">' +
          '<div>' +
            '<p class="nb-card-category">' + p.category + '</p>' +
            '<h4 class="nb-card-title"><a href="product-details.php?slug=' + p.slug + '">' + p.name + '</a></h4>' +
            '<p class="nb-list-desc">' + p.description + '</p>' +
          '</div>' +
          '<div class="nb-list-actions">' +
            '<div class="nb-card-price"><span class="nb-price-now">' + priceLabel + '</span></div>' +
            '<a href="product-details.php?slug=' + p.slug + '" class="nb-btn-cart nb-btn-cart--auto"><i class="ti ti-shopping-cart"></i> View Options</a>' +
          '</div>' +
        '</div>' +
      '</div>'
    );
  }

  function render() {
    grid.innerHTML = PRODUCTS.map(cardHtml).join('');
    listGrid.innerHTML = PRODUCTS.map(listRowHtml).join('');
    updateCount();
  }

  function filter(group) {
    document.querySelectorAll('#nbHumanHairGrid .nb-product-card, #nbHumanHairList .nb-list-card').forEach(function (card) {
      var show = group === 'all' || card.getAttribute('data-group') === group;
      card.style.display = show ? '' : 'none';
    });
    applySearch();
  }

  function applySearch() {
    var q = (searchInput.value || '').trim().toLowerCase();
    document.querySelectorAll('#nbHumanHairGrid .nb-product-card, #nbHumanHairList .nb-list-card').forEach(function (card) {
      if (card.style.display === 'none') return;
      var title = card.querySelector('.nb-card-title').textContent.toLowerCase();
      card.style.display = (!q || title.indexOf(q) !== -1) ? '' : 'none';
    });
    updateCount();
  }

  function updateCount() {
    var visible = Array.prototype.filter.call(
      document.querySelectorAll('#nbHumanHairGrid .nb-product-card'),
      function (c) { return c.style.display !== 'none'; }
    ).length;
    countEl.innerHTML = 'Showing <strong>' + visible + '</strong> of <strong>' + PRODUCTS.length + '</strong> styles';
  }

  subTabs.forEach(function (btn) {
    btn.addEventListener('click', function () {
      subTabs.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      filter(btn.getAttribute('data-group'));
    });
  });

  searchInput.addEventListener('input', applySearch);

  /* ---- View toggle (Grid / List), same behaviour as your original ---- */
  var btnGrid = document.getElementById('btnGrid');
  var btnList = document.getElementById('btnList');
  var gridView = document.getElementById('gridView');
  var listView = document.getElementById('listView');
  btnGrid.addEventListener('click', function (e) {
    e.preventDefault();
    gridView.style.display = '';
    listView.style.display = 'none';
    btnGrid.classList.add('active');
    btnList.classList.remove('active');
  });
  btnList.addEventListener('click', function (e) {
    e.preventDefault();
    gridView.style.display = 'none';
    listView.style.display = '';
    btnList.classList.add('active');
    btnGrid.classList.remove('active');
  });

  render();
})();