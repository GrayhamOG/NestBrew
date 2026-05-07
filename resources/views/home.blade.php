<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>NestBrew — Your Cozy Corner</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/FinalProject.css') }}">
</head>
<body>

<!-- Nav -->
<nav id="navbar">
  <a href="#home" class="nav-logo">Nest<span>Brew</span></a>
  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#menu">Menu</a></li>
    <li><a href="#info">Visit Us</a></li>
  </ul>
  <div class="nav-actions">
    <button class="btn-outline" onclick="openModal('signin')">Sign In</button>
    <button class="btn-fill"    onclick="openModal('signup')">Sign Up</button>
  </div>
</nav>

<!-- Hero -->
<section id="home">
  <div class="hero-bg-text">NestBrew</div>
  <div class="hero-content">
    <div class="hero-eyebrow">Est. 2026 — Cagayan de Oro</div>
    <h1 class="hero-title">
      Where Every Cup<br>Feels Like <em>Home</em>
    </h1>
    <p class="hero-sub">
      Handcrafted coffee, freshly baked pastries, and a warm corner
      to call your own. NestBrew is your cozy everyday escape.
    </p>
    <div class="hero-cta">
      <a href="#menu" class="btn-hero">Explore Our Menu</a>
      <a href="#info" class="btn-hero-ghost">Find Us</a>
    </div>
  </div>
  <div class="hero-image">
    <div class="hero-image-inner">☕</div>
  </div>
  <div class="hero-stats">
    <div class="stat">
      <span class="stat-num">40+</span>
      <span class="stat-label">Menu Items</span>
    </div>
    <div class="stat">
      <span class="stat-num">100%</span>
      <span class="stat-label">Fresh Daily</span>
    </div>
    <div class="stat">
      <span class="stat-num">5★</span>
      <span class="stat-label">Customer Love</span>
    </div>
  </div>
</section>

<!-- Menu -->
<section id="menu">
  <div class="menu-header">
    <div class="section-eyebrow">Crafted With Care</div>
    <h2 class="section-title">Our <em>Menu</em></h2>
    <div class="divider"></div>
    <p class="section-sub" style="margin: 0 auto;">From our signature espresso blends to golden pastries — every item is made fresh in our kitchen each morning.</p>
  </div>
  <div class="menu-tabs">
    <button class="tab-btn active" onclick="filterMenu('all', this)">All</button>
    <button class="tab-btn" onclick="filterMenu('coffee', this)">Coffee</button>
    <button class="tab-btn" onclick="filterMenu('noncoffee', this)">Non-Coffee</button>
    <button class="tab-btn" onclick="filterMenu('pastry', this)">Pastries</button>
    <button class="tab-btn" onclick="filterMenu('food', this)">Food</button>
  </div>
  <div class="menu-grid" id="menu-grid"></div>
</section>

<!-- Info -->
<section id="info">
  <div>
    <div class="section-eyebrow">We're Open</div>
    <h2 class="section-title">Opening <em>Hours</em></h2>
    <div class="divider"></div>
    <ul class="hours-list">
      <li class="hours-item">
        <span class="hours-day">Monday – Friday</span>
        <span class="hours-time">7:00 AM – 9:00 PM</span>
      </li>
      <li class="hours-item">
        <span class="hours-day">Saturday</span>
        <span class="hours-time">8:00 AM – 10:00 PM</span>
      </li>
      <li class="hours-item">
        <span class="hours-day">Sunday</span>
        <span class="hours-time">8:00 AM – 8:00 PM</span>
      </li>
      <li class="hours-item">
        <span class="hours-day">Public Holidays</span>
        <span class="hours-time closed">Closed</span>
      </li>
    </ul>
    <div class="contact-items" style="margin-top:2.5rem;">
      <div class="contact-item"><span class="contact-icon">📞</span> +63 997 257 0287</div>
      <div class="contact-item"><span class="contact-icon">✉️</span> hello@nestbrew.ph</div>
      <div class="contact-item"><span class="contact-icon">📸</span> @nestbrew.cafe</div>
    </div>
  </div>
  <div>
    <div class="section-eyebrow">Come Visit</div>
    <h2 class="section-title">Find <em>Us</em></h2>
    <div class="divider"></div>
    <p class="location-address">
      Food Haus Mercado,<br>
      Kauswagan Diversion Road<br>
      Cagayan de Oro City,<br>
      Misamis Oriental 9000
    </p>
    <div class="location-map" onclick="showToast('Opening maps...')">
      🗺️
      <p>View on Google Maps</p>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="footer-logo">Nest<span>Brew</span></div>
  <p class="footer-copy">© 2026 NestBrew Cafe. All rights reserved.</p>
  <div class="footer-links">
    <a href="#">Privacy</a>
    <a href="#">Terms</a>
    <a href="#">Contact</a>
  </div>
</footer>

<!-- Auth Modal -->
<div class="modal-overlay" id="modal-overlay" onclick="handleOverlayClick(event)">
  <div class="modal">
    <div class="modal-header">
      <button class="modal-close" onclick="closeModal()">✕</button>
      <div class="modal-logo">Nest<span>Brew</span></div>
      <div class="modal-tagline">Your cozy corner awaits</div>
    </div>
    <div class="modal-tabs">
      <button class="modal-tab active" id="tab-signin" onclick="switchTab('signin')">Sign In</button>
      <button class="modal-tab" id="tab-signup" onclick="switchTab('signup')">Sign Up</button>
    </div>
    <div class="modal-body">
      <!-- Sign In -->
      <div class="form-panel active" id="panel-signin">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input class="form-input" type="email" placeholder="you@example.com"/>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input class="form-input" type="password" placeholder="••••••••"/>
        </div>
        <button class="form-submit" onclick="handleAuth('signin')">Sign In to NestBrew</button>
        <p class="form-footer">
          Don't have an account? <a href="#" onclick="switchTab('signup'); return false;">Sign up here</a>
        </p>
      </div>
      <!-- Sign Up -->
      <div class="form-panel" id="panel-signup">
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input class="form-input" type="text" placeholder="Juan dela Cruz"/>
        </div>
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input class="form-input" type="email" placeholder="you@example.com"/>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input class="form-input" type="password" placeholder="At least 8 characters"/>
        </div>
        <div class="form-group">
          <label class="form-label">Confirm Password</label>
          <input class="form-input" type="password" placeholder="Repeat your password"/>
        </div>
        <button class="form-submit" onclick="handleAuth('signup')">Create My Account</button>
        <p class="form-footer">
          Already have an account? <a href="#" onclick="switchTab('signin'); return false;">Sign in here</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Your JS -->
<script src="{{ asset('js/FinalProject.js') }}"></script>

</body>
</html>