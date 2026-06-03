<!-- jquery -->
    <script src="<?= DN ?>/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- jquery migrate -->
    <script src="<?= DN ?>/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <!-- Countdown js -->
    <script src="<?= DN ?>/js/jquery.countdown.min.js"></script>
    <!-- Mobile menu js -->
    <script src="<?= DN ?>/js/jquery.meanmenu.min.js"></script>
    <!-- ScrollUp js -->
    <script src="<?= DN ?>/js/jquery.scrollUp.js"></script>
    <!-- Fancybox js -->
    <script src="<?= DN ?>/js/jquery.fancybox.min.js"></script>
    <!-- Jquery nice select js -->
    <script src="<?= DN ?>/js/jquery.nice-select.min.js"></script>
    <!-- Jquery ui price slider js -->
    <script src="<?= DN ?>/js/jquery-ui.min.js"></script>
    <!-- Owl carousel -->
    <script src="<?= DN ?>/js/owl.carousel.min.js"></script>
    <!-- Bootstrap popper js -->
    <script src="<?= DN ?>/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="<?= DN ?>/js/bootstrap.min.js"></script>
    <!-- Plugin js -->
    <script src="<?= DN ?>/js/plugins.js"></script>
    <!-- Main activaion js -->
    <script src="<?= DN ?>/js/main.js"></script>
<!-- 
    <script>
document.addEventListener('DOMContentLoaded', function () {
   const tabs    = document.querySelectorAll('.arrival-tab');
   const items   = document.querySelectorAll('.arrival-item');

   tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {

         // Active tab highlight
         tabs.forEach(function (t) { t.classList.remove('active'); });
         this.classList.add('active');

         var filter = this.getAttribute('data-filter');

         items.forEach(function (item) {
            if (filter === 'all' || item.getAttribute('data-category') === filter) {
               item.classList.remove('hidden');
            } else {
               item.classList.add('hidden');
            }
         });
      });
   });
});
</script> -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  document.body.style.visibility = "visible";
});
function openEnrollModal(name, price) {
   document.getElementById('modalCourseName').textContent  = name;
   document.getElementById('modalCoursePrice').textContent = price;
   document.getElementById('enrollModal').classList.add('open');
   document.getElementById('enrollBackdrop').classList.add('open');
   document.body.style.overflow = 'hidden';
}
function closeEnrollModal() {
   document.getElementById('enrollModal').classList.remove('open');
   document.getElementById('enrollBackdrop').classList.remove('open');
   document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
   if (e.key === 'Escape') closeEnrollModal();
});
</script>

<script>
(function () {

   var ITEMS_PER_PAGE = 8;
   var currentPage   = 1;
   var currentFilter = 'all';

   var tabs  = document.querySelectorAll('.arrival-tab');
   var allItems = Array.from(document.querySelectorAll('.arrival-item'));

   /* ---- Filter ---- */
   tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
         tabs.forEach(function (t) { t.classList.remove('active'); });
         this.classList.add('active');
         currentFilter = this.getAttribute('data-filter');
         currentPage   = 1;
         render();
      });
   });

   /* ---- Get visible items by filter ---- */
   function getFiltered() {
      if (currentFilter === 'all') return allItems;
      return allItems.filter(function (item) {
         return item.getAttribute('data-category') === currentFilter;
      });
   }

   /* ---- Render page ---- */
   function render() {
      var filtered   = getFiltered();
      var totalPages = Math.ceil(filtered.length / ITEMS_PER_PAGE);
      var start      = (currentPage - 1) * ITEMS_PER_PAGE;
      var end        = start + ITEMS_PER_PAGE;

      /* Hide all, then show only current page slice */
      allItems.forEach(function (item) { item.classList.add('hidden'); });
      filtered.slice(start, end).forEach(function (item) { item.classList.remove('hidden'); });

      buildPagination(totalPages);
   }

   /* ---- Build pagination buttons ---- */
   function buildPagination(totalPages) {
      var prevBtn  = document.getElementById('pagePrev');
      var nextBtn  = document.getElementById('pageNext');
      var numWrap  = document.getElementById('pageNumbers');

      prevBtn.disabled = (currentPage === 1);
      nextBtn.disabled = (currentPage === totalPages || totalPages === 0);

      numWrap.innerHTML = '';
      for (var i = 1; i <= totalPages; i++) {
         (function (pageNum) {
            var btn = document.createElement('button');
            btn.className  = 'page-num' + (pageNum === currentPage ? ' active' : '');
            btn.textContent = pageNum;
            btn.addEventListener('click', function () {
               currentPage = pageNum;
               render();
               /* Scroll back to section top */
               document.querySelector('.new-arrival').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
            numWrap.appendChild(btn);
         })(i);
      }
   }

   /* ---- Prev / Next ---- */
   window.changePage = function (dir) {
      var totalPages = Math.ceil(getFiltered().length / ITEMS_PER_PAGE);
      currentPage = Math.min(Math.max(currentPage + dir, 1), totalPages);
      render();
      document.querySelector('.new-arrival').scrollIntoView({ behavior: 'smooth', block: 'start' });
   };

   /* ---- Init ---- */
   render();

})();




</script>
<script>
/* Grid / List toggle */
document.getElementById('btnGrid').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('gridView').style.display = '';
    document.getElementById('listView').style.display = 'none';
    this.classList.add('active');
    document.getElementById('btnList').classList.remove('active');
});
document.getElementById('btnList').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('listView').style.display = '';
    document.getElementById('gridView').style.display = 'none';
    this.classList.add('active');
    document.getElementById('btnGrid').classList.remove('active');
});

/* Sub-category tabs */
document.querySelectorAll('.nb-shop-tab').forEach(function(tab){
    tab.addEventListener('click', function(){
        this.closest('.nb-shop-tabs').querySelectorAll('.nb-shop-tab').forEach(function(t){ t.classList.remove('active'); });
        this.classList.add('active');
    });
});

/* Color swatches */
document.querySelectorAll('.nb-swatch').forEach(function(sw){
    sw.addEventListener('click', function(){
        this.closest('.nb-color-swatches').querySelectorAll('.nb-swatch').forEach(function(s){ s.classList.remove('active'); });
        this.classList.add('active');
    });
});

/* Sticky cat-bar highlight on scroll */
var sections = ['section-wigs','section-makeup','section-courses'];
var links = document.querySelectorAll('.nb-cat-tabs li a');
window.addEventListener('scroll', function(){
    var fromTop = window.scrollY + 80;
    sections.forEach(function(id, i){
        var el = document.getElementById(id);
        if(el && el.offsetTop <= fromTop && el.offsetTop + el.offsetHeight > fromTop){
            links.forEach(function(l){ l.classList.remove('active'); });
            if(links[i+1]) links[i+1].classList.add('active');
        }
    });
});
</script>