/* ============================================================
   NAOMI BEAUTY — PRODUCT CATALOG
   ------------------------------------------------------------
   Single source of truth for the shop grid AND the product
   details page. Edit prices/colors/images here only — both
   pages read from this file.

   IMAGE FOLDERS (put your real photos here, one folder per
   category, filenames matching the "image" field below):

     img/products/body-wave/
     img/products/pixie-bundle/
     img/products/ocean-bundle/
     img/products/freez-bundle/
     img/products/classic-wigs/
     img/products/pixie-glueless/
     img/products/wavy-glueless/

   TODO (things I could not price from what you sent — fill
   these in and the site updates everywhere automatically):
     1) Ocean bundle has no price yet — currently shows
        "Price on request".
     2) Pixie Glueless Wig: you gave prices for 16"–26" but
        described the range as 14"–28". 14" and 28" are
        currently disabled in the size picker until you send
        prices for them.
     3) Classic Wigs 22"–30": you gave one flat price ($450)
        for the whole line — every size in that range currently
        costs $450. Tell me if sizes should differ in price.
   ============================================================ */

const PRODUCTS = [
  {
    slug: "body-wave",
    category: "Human Hair Bundles",
    name: "Body Wave Super Double Drawn Bundle",
    folder: "img/products/body-wave/",
    description:
      "Soft, bouncy body wave texture with a super double drawn weft for maximum fullness from root to tip. 100% human hair, tangle-free and long-lasting with proper care.",
    sizeLabel: "Length",
    sizes: [
      { inch: 20, price: 80 },
      { inch: 22, price: 85 },
      { inch: 24, price: 90 },
      { inch: 26, price: 100 },
      { inch: 28, price: 110 },
      { inch: 30, price: 120 }
    ],
    colors: [
      { name: "Dark Brown", hex: "#4a2c17", image: "brown.jpeg" },
      { name: "Natural Black", hex: "#1a1a1a", image: "black.jpeg" },
      { name: "Burgundy", hex: "#6b1a2a", image: "burgundy.jpeg" }
    ]
  },
  {
    slug: "pixie-bundle",
    category: "Human Hair Bundles",
    name: "Pixie Super Double Drawn Bundle",
    folder: "img/products/pixie-bundle/",
    description:
      "Our signature Pixie curl pattern — tight, defined and full-bodied. Super double drawn so every bundle stays thick from the first inch to the last.",
    sizeLabel: "Length",
    sizes: [
      { inch: 14, price: 75 },
      { inch: 16, price: 80 },
      { inch: 18, price: 85 },
      { inch: 20, price: 90 },
      { inch: 22, price: 95 },
      { inch: 24, price: 100 }
    ],
    colors: [
      { name: "Natural Black", hex: "#1a1a1a", image: "black.jpeg" },
      { name: "Coffee Brown", hex: "#3b2415", image: "coffee-brown.jpeg" },
      { name: "Burgundy", hex: "#6b1a2a", image: "burgundy.jpeg" }
    ]
  },
  {
    slug: "ocean-bundle",
    category: "Human Hair Bundles",
    name: "Ocean Super Double Drawn Bundle",
    folder: "img/products/ocean-bundle/",
    description:
      "A relaxed, beach-wave finish with the same super double drawn fullness as the rest of our bundle line. Holds a curl beautifully and settles into a natural wave with heat.",
    sizeLabel: "Length",
    sizes: [], // TODO: no pricing sent yet — see notes at top of file
    priceOnRequest: true,
    colors: [
      { name: "Coffee Brown", hex: "#3b2415", image: "coffee-brown.jpeg" },
      { name: "Natural Black", hex: "#1a1a1a", image: "black.jpeg" },
      { name: "Burgundy", hex: "#6b1a2a", image: "burgundy.jpeg" }
    ]
  },
  {
    slug: "freez-bundle",
    category: "Human Hair Bundles",
    name: "Freez Super Double Drawn Hair",
    folder: "img/products/freez-bundle/",
    description:
      "A tight, textured freeze curl for a bold, low-maintenance look. Same super double drawn construction and pricing as our Body Wave line.",
    sizeLabel: "Length",
    sizes: [
      { inch: 20, price: 80 },
      { inch: 22, price: 85 },
      { inch: 24, price: 90 },
      { inch: 26, price: 100 },
      { inch: 28, price: 110 },
      { inch: 30, price: 120 }
    ],
    colors: [{ name: "Natural Black", hex: "#1a1a1a", image: "black.jpeg" }]
  },
  {
    slug: "classic-wigs",
    category: "Wigs",
    name: "Classic Wig",
    folder: "img/products/classic-wigs/",
    description:
      "A ready-to-wear full wig in a soft ash blonde tone. One flat price across the full length range — pick the length that suits you.",
    sizeLabel: "Length",
    sizes: [
      { inch: 22, price: 450 },
      { inch: 24, price: 450 },
      { inch: 26, price: 450 },
      { inch: 28, price: 450 },
      { inch: 30, price: 450 }
    ],
    colors: [{ name: "Ash Blonde", hex: "#d8c9a3", image: "ash-blonde.jpeg" }]
  },
  {
    slug: "pixie-glueless",
    category: "Wigs",
    name: "Pixie Glueless Wig",
    folder: "img/products/pixie-glueless/",
    description:
      "Glueless cap construction for a comfortable, secure fit with no adhesive needed. Pixie curl pattern, natural black.",
    sizeLabel: "Length",
    sizes: [
      { inch: 14, price: null },
      { inch: 16, price: 200 },
      { inch: 18, price: 250 },
      { inch: 20, price: 300 },
      { inch: 22, price: 350 },
      { inch: 24, price: 400 },
      { inch: 26, price: 450 },
      { inch: 28, price: null }
    ],
    colors: [{ name: "Natural Black", hex: "#1a1a1a", image: "black.jpeg" }]
  },
  {
    slug: "wavy-glueless",
    category: "Wigs",
    name: "Brown Wavy Glueless Wig (5×5 Closure)",
    folder: "img/products/wavy-glueless/",
    description:
      "5×5 closure wig with a soft, natural wave. Glueless cap for easy everyday installation. One length, one flat price.",
    sizeLabel: "Length",
    sizes: [{ inch: 28, price: 350 }],
    colors: [{ name: "Brown", hex: "#4a2c17", image: "brown.jpeg" }]
  }
];

/* Helpers used by both pages */
function nbFindProduct(slug) {
  return PRODUCTS.find(function (p) { return p.slug === slug; });
}

function nbPriceRangeLabel(product) {
  if (product.priceOnRequest || !product.sizes || !product.sizes.length) {
    return "Price on request";
  }
  var prices = product.sizes.map(function (s) { return s.price; }).filter(function (p) { return p !== null; });
  if (!prices.length) return "Price on request";
  var min = Math.min.apply(null, prices);
  var max = Math.max.apply(null, prices);
  return min === max ? ("$" + min) : ("$" + min + " – $" + max);
}
