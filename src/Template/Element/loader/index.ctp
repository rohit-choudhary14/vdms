<!-- 🌟 Loader Modal -->
<div id="loader-modal" class="loader-modal d-none">
  <div class="loader"></div>
</div>

<!-- 🌈 Loader Modal Styles -->
<style>
/* 🔲 Modal Overlay */
.loader-modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6); /* transparent dark background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

/* Hidden state */
.d-none {
  display: none !important;
}

/* 🌀 Loading Text Animation */
.loader {
  --w: 10ch;
  font-weight: bold;
  font-family: monospace;
  font-size: 30px;
  line-height: 1.4em;
  letter-spacing: var(--w);
  width: var(--w);
  overflow: hidden;
  white-space: nowrap;
  color: transparent;
  text-shadow:
    calc( 0*var(--w)) 0 #fff,
    calc(-1*var(--w)) 0 #fff,
    calc(-2*var(--w)) 0 #fff,
    calc(-3*var(--w)) 0 #fff,
    calc(-4*var(--w)) 0 #fff,
    calc(-5*var(--w)) 0 #fff,
    calc(-6*var(--w)) 0 #fff,
    calc(-7*var(--w)) 0 #fff,
    calc(-8*var(--w)) 0 #fff,
    calc(-9*var(--w)) 0 #fff;
  animation: loading-anim 2s infinite linear;
}

.loader:before {
  content: "Loading...";
  color: #fff;
}

/* ✨ Animation */
@keyframes loading-anim {
  9.09%  {text-shadow: calc(0*var(--w)) -10px #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  18.18% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) -10px #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  27.27% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) -10px #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  36.36% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) -10px #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  45.45% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) -10px #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  54.54% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) -10px #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  63.63% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) -10px #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  72.72% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) -10px #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) 0 #fff;}
  81.81% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) -10px #fff, calc(-9*var(--w)) 0 #fff;}
  90.90% {text-shadow: calc(0*var(--w)) 0 #fff, calc(-1*var(--w)) 0 #fff, calc(-2*var(--w)) 0 #fff, calc(-3*var(--w)) 0 #fff, calc(-4*var(--w)) 0 #fff, calc(-5*var(--w)) 0 #fff, calc(-6*var(--w)) 0 #fff, calc(-7*var(--w)) 0 #fff, calc(-8*var(--w)) 0 #fff, calc(-9*var(--w)) -10px #fff;}
}
</style>

<!-- ⚙️ Loader Control Script -->
<script>
function showLoader() {
  $('#loader-modal').removeClass('d-none');
}

function hideLoader() {
  $('#loader-modal').addClass('d-none');
}

// 🔄 Auto show/hide for AJAX
$(document).ajaxStart(function() { showLoader(); });
$(document).ajaxStop(function() { hideLoader(); });
</script>
