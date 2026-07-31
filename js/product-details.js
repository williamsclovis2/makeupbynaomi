/* NAOMI BEAUTY — product-details.php logic
   Reads ?slug= from the URL and renders the product page using
   PRODUCTS (products-data.js) — square colour swatches (not circles),
   a length picker, quantity stepper, and live price. */

(function () {
  function getParam(name) {
    var url = new URL(window.location.href);
    return url.searchParams.get(name);
  }

  var slug = getParam('slug') || 'body-wave';
  var product = nbFindProduct(slug);
  var root = document.getElementById('nbPdRoot');
  var shopLink = window.location.pathname.indexOf('preview-') !== -1 ? 'preview-shop.html' : 'shop.php';

  if (!product) {
    root.innerHTML = '<div class="container"><p>We couldn\'t find that product. <a href="' + shopLink + '">Back to shop</a>.</p></div>';
    return;
  }

  var state = {
    color: product.colors[0],
    size: (product.sizes || []).find(function (s) { return s.price !== null; }) || null,
    qty: 1
  };

  function priceForState() {
    if (product.priceOnRequest || !state.size) return null;
    return state.size.price;
  }

  function imageFor(color) {
    return product.folder + color.image;
  }

  function render() {
    var priceNow = priceForState();

    var sizesHtml = (product.sizes || []).map(function (s) {
      var disabled = s.price === null;
      var active = state.size && state.size.inch === s.inch;
      return '<button type="button" class="nb-size-btn' + (active ? ' active' : '') + '" ' +
        (disabled ? 'disabled title="Price coming soon — contact us"' : '') +
        ' data-inch="' + s.inch + '">' + s.inch + '"</button>';
    }).join('');

    var colorsHtml = product.colors.map(function (c, i) {
      var active = state.color.name === c.name;
      return '<button type="button" class="nb-highlight-btn' + (active ? ' active' : '') + '" data-index="' + i + '">' + c.name + '</button>';
    }).join('');

    var thumbsHtml = product.colors.map(function (c, i) {
      var active = state.color.name === c.name;
      return '<div class="nb-pd-thumb' + (active ? ' active' : '') + '" data-index="' + i + '">' +
        '<img src="' + imageFor(c) + '" alt="' + product.name + ' — ' + c.name + '" onerror="this.parentElement.style.background=\'' + c.hex + '\'; this.remove();"></div>';
    }).join('');

    var priceHtml;
    if (product.priceOnRequest) {
      priceHtml = '<div class="nb-modal-price"><span class="nb-price-now">Price on request</span></div>';
    } else if (priceNow === null) {
      priceHtml = '<div class="nb-modal-price"><span class="nb-price-now">Select a length</span></div>';
    } else {
      priceHtml = '<div class="nb-modal-price"><span class="nb-price-now">$' + priceNow.toFixed(2) + '</span></div>';
    }

    root.innerHTML =
  
      '<div class="breadcrumb-area" >' +
        '<div class="container">' +
            '<ol class="breadcrumb breadcrumb-list mb-0">' +
                '<li class="breadcrumb-item"><a href="index">Home</a></li>' +
                '<li class="breadcrumb-item"><a href="' + shopLink + '">Shop</a></li>' +
                '<li class="breadcrumb-item active">' + product.name + '</li>' +
            '</ol>' +
        '</div>' +
      '</div>' +
      '<div class="container wrapper-section">' +
        '<div class="nb-pd-grid row">' +
          '<div class="nb-pd-left col-md-5">' +
            '<div class="nb-pd-main-img"><img id="nbPdMainImg" src="' + imageFor(state.color) + '" alt="' + product.name + '" onerror="this.style.display=\'none\'; this.parentElement.style.background=\'' + state.color.hex + '\'"></div>' +
            '<div class="nb-pd-thumbs">' + thumbsHtml + '</div>' +
          '</div>' +
          '<div class="nb-pd-info col-md-7">' +
            '<p class="nb-card-category">' + product.category + '</p>' +
            '<h1 class="nb-modal-product-title">' + product.name + '</h1>' +
            priceHtml +
            '<p class="nb-modal-desc">' + product.description + '</p>' +
            '<p class="nb-pd-shipping-note">Shipping calculated at checkout.</p>' +
            (product.priceOnRequest ? '<div class="nb-pd-request-note">This style is priced individually — message us on WhatsApp and we\'ll confirm the cost for your preferred length and colour.</div>' : '') +
            '<div class="nb-modal-field"><label class="nb-modal-label">Highlight</label><div class="nb-highlight-picker">' + colorsHtml + '</div></div>' +
            (product.sizes && product.sizes.length ? (
              '<div class="nb-modal-field"><label class="nb-modal-label">Sizes</label><div class="nb-size-picker">' + sizesHtml + '</div></div>'
            ) : '') +
            '<div class="nb-modal-field">' +
              '<label class="nb-modal-label">Quantity</label>' +
              '<div class="nb-qty-stepper">' +
                '<button type="button" id="nbQtyDown">–</button>' +
                '<input type="number" id="nbQtyInput" min="1" value="' + state.qty + '" aria-label="Quantity">' +
                '<button type="button" id="nbQtyUp">+</button>' +
              '</div>' +
            '</div>' +
            '<div class="nb-pd-action-row">' +
              '<button type="button" class="nb-btn-cart nb-btn-cart--flex" ' + (priceNow === null && !product.priceOnRequest ? 'disabled' : '') + '>' +
                '<i class="ti ti-shopping-cart"></i> ' + (product.priceOnRequest ? 'Enquire on WhatsApp' : 'Add to Cart') +
              '</button>' +
              '<button type="button" class="nb-btn-payother" ' + (priceNow === null && !product.priceOnRequest ? 'disabled' : '') + '>' +
                'Pay Another Way' +
              '</button>' +
            '</div>' +
            '<p class="nb-stock-status"><i class="ti ti-check nb-stock-icon"></i>In stock — ships within 2–3 business days</p>' +
          '</div>' +
        '</div>' +
      '</div>';

    wireEvents();
  }

  function wireEvents() {
    root.querySelectorAll('.nb-size-btn:not([disabled])').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var inch = Number(btn.getAttribute('data-inch'));
        state.size = product.sizes.find(function (s) { return s.inch === inch; });
        render();
      });
    });
    root.querySelectorAll('.nb-highlight-btn').forEach(function (el) {
      el.addEventListener('click', function () {
        state.color = product.colors[Number(el.getAttribute('data-index'))];
        render();
      });
    });
    root.querySelectorAll('.nb-pd-thumb').forEach(function (el) {
      el.addEventListener('click', function () {
        state.color = product.colors[Number(el.getAttribute('data-index'))];
        render();
      });
    });
    var qtyInput = document.getElementById('nbQtyInput');
    document.getElementById('nbQtyDown').addEventListener('click', function () {
      state.qty = Math.max(1, state.qty - 1);
      qtyInput.value = state.qty;
    });
    document.getElementById('nbQtyUp').addEventListener('click', function () {
      state.qty = state.qty + 1;
      qtyInput.value = state.qty;
    });
    qtyInput.addEventListener('change', function () {
      state.qty = Math.max(1, Number(qtyInput.value) || 1);
      qtyInput.value = state.qty;
    });
    var payOtherBtn = root.querySelector('.nb-btn-payother');
    if (payOtherBtn) {
      payOtherBtn.addEventListener('click', function () {
        // TODO: hook up to your real "pay another way" flow (e.g. WhatsApp checkout, invoice link, etc.)
        window.location.href = 'contact-us';
      });
    }
  }

  render();
})();