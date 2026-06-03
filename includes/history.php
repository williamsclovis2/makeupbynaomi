<style>
/* ============================================================
   HISTORY SECTION — scoped to .history-area-custom
   ============================================================ */

.history-area-custom {
  background-color: #b94253;
  position: relative;
  overflow: hidden;
  padding: 90px 0;
}

/* ── Motifs ─────────────────────────────────────────────── */
.history-area-custom .hst-motif {
  position: absolute;
  pointer-events: none;
  opacity: .13;
}
.history-area-custom .hst-motif-tl  { top: -40px; left: -40px; width: 300px; transform: rotate(-12deg); }
.history-area-custom .hst-motif-tr  { top: -30px; right: -30px; width: 240px; transform: rotate(18deg); }
.history-area-custom .hst-motif-bl  { bottom: -50px; left: 30px; width: 200px; transform: rotate(8deg); }
.history-area-custom .hst-motif-br  { bottom: -40px; right: -30px; width: 270px; transform: rotate(-8deg); }
.history-area-custom .hst-motif-mid {
  top: 50%; left: 50%;
  width: 520px;
  transform: translate(-50%, -50%);
  opacity: .04;
}

.history-area-custom .hst-dot-layer {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}
.history-area-custom .hst-dot {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,.18);
}

/* ── Main row ────────────────────────────────────────────
   Left col  = photo (normal flow, contained)
   Right col = pale card with text
   The card's left edge starts where the photo ends,
   but the photo slightly overlaps inward — like the screenshot
   ──────────────────────────────────────────────────────── */

/* Outer row: no gap, so the photo and card touch */
.history-area-custom .hst-row {
  display: flex;
  align-items: stretch;
  gap: 0;
}

/* ── Left photo column ───────────────────────────────────
   The photo is "small" relative to the card — it sits inside
   the left half with padding around it (like the screenshot
   where the image has clear white/bg space above and below).
   We replicate this with a wrapper that has vertical padding
   on the rose background, so the photo floats inside the section.
*/
.history-area-custom .hst-img-col {
  width: 45%;
  flex-shrink: 0;
  padding: 30px 0 30px 0;   /* photo smaller than full height */
  position: relative;
  z-index: 2;
}

.history-area-custom .hst-img-col img {
  display: block;
  width: 92%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
  border-radius: 3px;
  box-shadow: 12px 12px 0 rgba(0,0,0,.18);
  transition: transform .6s ease;
}
.history-area-custom .hst-img-col:hover img {
  transform: scale(1.03);
}

/* ── Right content card ──────────────────────────────────
   Starts from the mid-point. The card's left edge is pulled
   left by a negative margin so it slides under the photo's
   right side — recreating the "image enters the box" overlap.
*/
.history-area-custom .hst-card {
  flex: 1;
  background: #f5eced;
  border-radius: 3px;
  margin-left: -60px;        /* pull card left so photo overlaps its left edge */
  padding: 50px 48px 50px 80px; /* extra left pad clears the overlap zone */
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  z-index: 1;                /* photo is z-index:2, card is z-index:1 — photo on top */
}

/* ── Typography ──────────────────────────────────────────── */
.history-area-custom .hst-eyebrow {
  display: block;
  font-size: .68rem;
  font-weight: 500;
  letter-spacing: .22em;
  text-transform: uppercase;
  color: #b94253;
  margin-bottom: 8px;
}

.history-area-custom .hst-card h2 {
  font-size: 1.95rem;
  font-weight: 700;
  color: #1e1226;
  line-height: 1.2;
  margin-bottom: 0;
}

.history-area-custom .hst-divider {
  width: 44px;
  height: 3px;
  background: linear-gradient(90deg, #b94253, #d4a96a);
  border-radius: 2px;
  margin: 14px 0 18px;
}

.history-area-custom .hst-desc {
  font-size: .93rem;
  line-height: 1.8;
  color: #3d2535;
  margin-bottom: 22px;
}

.history-area-custom .hst-touch-title {
  font-size: 1.22rem;
  font-weight: 600;
  color: #1e1226;
  margin-bottom: 10px;
}

.history-area-custom .hst-card ul {
  list-style: none;
  padding: 0;
  margin-bottom: 32px;
}
.history-area-custom .hst-card ul li {
  font-size: .9rem;
  line-height: 1.75;
  color: #3d2535;
  padding-left: 18px;
  position: relative;
  margin-bottom: 8px;
}
.history-area-custom .hst-card ul li::before {
  content: '';
  position: absolute;
  left: 0; top: 9px;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #b94253;
}

/* ── Button ──────────────────────────────────────────────── */
.history-area-custom .hst-btn {
  display: inline-block;
  font-size: .78rem;
  font-weight: 500;
  letter-spacing: .15em;
  text-transform: uppercase;
  color: #fff;
  background: #b94253;
  border: none;
  padding: 12px 34px;
  border-radius: 2px;
  box-shadow: 3px 3px 0 #9c3346;
  text-decoration: none;
  align-self: flex-start;
  transition: background .25s, transform .2s, box-shadow .2s;
}
.history-area-custom .hst-btn:hover {
  background: #9c3346;
  color: #fff;
  transform: translate(-2px, -2px);
  box-shadow: 5px 5px 0 #1e1226;
  text-decoration: none;
}

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 991px) {
  .history-area-custom .hst-row {
    flex-direction: column;
  }
  .history-area-custom .hst-img-col {
    width: 100%;
    height: 300px;
    padding: 0;
  }
  .history-area-custom .hst-img-col img {
    height: 300px;
    border-radius: 3px 3px 0 0;
    box-shadow: none;
  }
  .history-area-custom .hst-card {
    margin-left: 0;
    padding: 40px 28px;
    border-radius: 0 0 3px 3px;
  }
}
@media (max-width: 575px) {
  .history-area-custom .hst-img-col { height: 240px; }
  .history-area-custom .hst-img-col img { height: 240px; }
  .history-area-custom .hst-card { padding: 32px 18px; }
  .history-area-custom .hst-card h2 { font-size: 1.6rem; }
}
</style>

<!-- ═══════════════════════════════════════════════════════
     HISTORY SECTION  —  includes/history.php
     ═══════════════════════════════════════════════════════ -->
<div class="history-area-custom">

  <!-- Motif SVGs -->
  <svg class="hst-motif hst-motif-tl" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="90" stroke="white" stroke-width="1.5"/>
    <circle cx="100" cy="100" r="68" stroke="white" stroke-width="1"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(0   100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(45  100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(90  100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(135 100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(180 100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(225 100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(270 100 100)"/>
    <ellipse cx="100" cy="18" rx="10" ry="18" stroke="white" stroke-width="1.2" transform="rotate(315 100 100)"/>
    <circle cx="100" cy="100" r="12" stroke="white" stroke-width="1.5"/>
    <circle cx="100" cy="100" r="5" fill="white"/>
  </svg>

  <svg class="hst-motif hst-motif-tr" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="40" y="40" width="80" height="80" stroke="white" stroke-width="1.5" transform="rotate(45 80 80)"/>
    <rect x="54" y="54" width="52" height="52" stroke="white" stroke-width="1" transform="rotate(45 80 80)"/>
    <line x1="0"   y1="80"  x2="160" y2="80"  stroke="white" stroke-width=".7"/>
    <line x1="80"  y1="0"   x2="80"  y2="160" stroke="white" stroke-width=".7"/>
    <line x1="0"   y1="0"   x2="160" y2="160" stroke="white" stroke-width=".6"/>
    <line x1="160" y1="0"   x2="0"   y2="160" stroke="white" stroke-width=".6"/>
    <circle cx="80" cy="80" r="7" fill="white"/>
  </svg>

  <svg class="hst-motif hst-motif-bl" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M75 140 C20 100 20 40 75 10 C130 40 130 100 75 140Z" stroke="white" stroke-width="1.5"/>
    <line x1="75" y1="10" x2="75" y2="140" stroke="white" stroke-width="1"/>
    <path d="M45 60  Q60 55  75 60"  stroke="white" stroke-width=".8"/>
    <path d="M45 80  Q60 75  75 80"  stroke="white" stroke-width=".8"/>
    <path d="M45 100 Q60 95  75 100" stroke="white" stroke-width=".8"/>
    <path d="M105 60  Q90 55  75 60"  stroke="white" stroke-width=".8"/>
    <path d="M105 80  Q90 75  75 80"  stroke="white" stroke-width=".8"/>
    <path d="M105 100 Q90 95  75 100" stroke="white" stroke-width=".8"/>
  </svg>

  <svg class="hst-motif hst-motif-br" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g stroke="white" stroke-width="1.1">
      <line x1="100" y1="0"   x2="100" y2="200"/>
      <line x1="0"   y1="100" x2="200" y2="100"/>
      <line x1="0"   y1="0"   x2="200" y2="200"/>
      <line x1="200" y1="0"   x2="0"   y2="200"/>
      <line x1="50"  y1="0"   x2="150" y2="200"/>
      <line x1="150" y1="0"   x2="50"  y2="200"/>
      <line x1="0"   y1="50"  x2="200" y2="150"/>
      <line x1="0"   y1="150" x2="200" y2="50"/>
    </g>
    <circle cx="100" cy="100" r="42" stroke="white" stroke-width="1.5"/>
    <circle cx="100" cy="100" r="22" stroke="white" stroke-width="1"/>
    <circle cx="100" cy="100" r="7" fill="white"/>
  </svg>

  <svg class="hst-motif hst-motif-mid" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="200" cy="200" r="185" stroke="white" stroke-width="1"/>
    <circle cx="200" cy="200" r="145" stroke="white" stroke-width="1"/>
    <circle cx="200" cy="200" r="105" stroke="white" stroke-width="1"/>
    <circle cx="200" cy="200" r="65"  stroke="white" stroke-width="1"/>
    <circle cx="200" cy="200" r="28"  stroke="white" stroke-width="1.5"/>
    <g stroke="white" stroke-width=".7">
      <line x1="200" y1="15"  x2="200" y2="385"/>
      <line x1="15"  y1="200" x2="385" y2="200"/>
      <line x1="60"  y1="60"  x2="340" y2="340"/>
      <line x1="340" y1="60"  x2="60"  y2="340"/>
      <line x1="200" y1="15"  x2="200" y2="385" transform="rotate(22.5 200 200)"/>
      <line x1="15"  y1="200" x2="385" y2="200" transform="rotate(22.5 200 200)"/>
      <line x1="200" y1="15"  x2="200" y2="385" transform="rotate(45 200 200)"/>
      <line x1="15"  y1="200" x2="385" y2="200" transform="rotate(45 200 200)"/>
    </g>
  </svg>

  <div class="hst-dot-layer">
    <div class="hst-dot" style="width:8px;height:8px;top:10%;left:6%"></div>
    <div class="hst-dot" style="width:5px;height:5px;top:22%;left:14%"></div>
    <div class="hst-dot" style="width:11px;height:11px;top:7%;left:74%"></div>
    <div class="hst-dot" style="width:6px;height:6px;top:32%;left:88%"></div>
    <div class="hst-dot" style="width:9px;height:9px;top:74%;left:4%"></div>
    <div class="hst-dot" style="width:5px;height:5px;top:84%;left:22%"></div>
    <div class="hst-dot" style="width:10px;height:10px;top:80%;left:91%"></div>
    <div class="hst-dot" style="width:4px;height:4px;top:48%;left:2%"></div>
  </div>

  <!-- ── Content ── -->
  <div class="container">
    <div class="hst-row">

      <!-- Left: photo, contained & slightly smaller than section height -->
      <div class="hst-img-col">
        <img src="img/team/Naomi.png" alt="Our History">
      </div>

      <!-- Right: pale card, photo's right edge overlaps into it -->
      <div class="hst-card">
        <span class="hst-eyebrow">Business introduction</span>
        <h2>No More Firecracker</h2>
        <div class="hst-divider"></div>
        <p class="hst-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus
          mauris scelerisque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus
          faucibus finibus.</p>
        <p class="hst-touch-title">A Personal Touch</p>
        <ul>
          <li>Aliquam vitae molestie at quisque sapien volutpat and justo, aliquet molestie purus efficitur ipsum</li>
          <li>Sagittis congue augue magna risus mauris volutpat and egestas magna suscipit egestas a vitae purus</li>
        </ul>
        <a href="courses" class="hst-btn">Keep shining </a>
      </div>

    </div>
  </div>

</div>