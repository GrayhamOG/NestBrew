<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NestBrew — Your Cozy Corner</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<!-- ── Nav ── -->
<nav id="navbar">
  <a href="#home" class="nav-logo">Nest<span>Brew</span></a>
  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#menu">Menu</a></li>
    <li><a href="#info">Visit Us</a></li>
    @auth
      @if(Auth::user()->isAdmin())
        <li>
          <a href="{{ route('admin.menu.index') }}" class="nav-admin-link">
            ⚙️ Admin
          </a>
        </li>
      @endif
    @endauth
  </ul>

  <div class="nav-actions">
    @auth
      <span class="nav-greeting">Hi, {{ Auth::user()->name }} 👋</span>

      <!-- Cart button -->
      <button class="btn-outline" id="cart-btn" onclick="openCart()">
        🛒 Cart <span id="cart-count" class="cart-count-badge">0</span>
      </button>

      <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="btn-outline">Log Out</button>
      </form>
    @else
      <button class="btn-outline" onclick="openModal('signin')">Sign In</button>
      <button class="btn-fill"    onclick="openModal('signup')">Sign Up</button>
    @endauth
  </div>

  <div id="nav-user-info" class="nav-user nav-user-hidden">
    <span id="nav-username" class="nav-username"></span>
    <button class="btn-outline" onclick="handleSignOut()">Sign Out</button>
  </div>
</nav>

<!-- ── Cart Backdrop ── -->
<div id="cart-backdrop" class="cart-backdrop" onclick="closeCart()"></div>

<!-- ── Cart Panel (Draggable) ── -->
<div id="cart-panel" class="cart-panel">

  <!-- Drag Handle / Header -->
  <div id="cart-drag-handle" class="cart-panel-header">
    <div class="cart-panel-title-group">
      <span class="cart-panel-icon">🛒</span>
      <h3 class="cart-panel-title">Your Cart</h3>
    </div>
    <div class="cart-panel-header-right">
      <span class="cart-drag-hint">drag to move</span>
      <button onclick="closeCart()" class="cart-panel-close">✕</button>
    </div>
  </div>

  <!-- Items Area -->
  <div id="cart-items" class="cart-panel-items"></div>

  <!-- Divider -->
  <div class="cart-panel-divider"></div>

  <!-- Summary Footer -->
  <div class="cart-panel-footer">

    <!-- Total -->
    <div class="cart-panel-total-row">
      <span class="cart-panel-total-label">Total</span>
      <span id="cart-total" class="cart-panel-total-amount">₱0.00</span>
    </div>

    <!-- Clear + Proceed buttons -->
    <div class="cart-panel-actions">
      <button onclick="clearCart()" class="cart-panel-clear-btn">Clear</button>
      <button onclick="handleCheckout()" class="cart-panel-checkout-btn">
        <span>Proceed to Payment</span>
        <span class="cart-panel-arrow">→</span>
      </button>
    </div>
  </div>
</div>

<!-- ── Hero ── -->
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
      <a href="#info"  class="btn-hero-ghost">Find Us</a>
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

<!-- ── Menu ── -->
<section id="menu">
  <div class="menu-header">
    <div class="section-eyebrow">Crafted With Care</div>
    <h2 class="section-title">Our <em>Menu</em></h2>
    <div class="divider"></div>
    <p class="section-sub section-sub--centered">From our signature espresso blends to golden pastries — every item is made fresh in our kitchen each morning.</p>
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

<!-- ── Info ── -->
<section id="info">
  <!-- Hours -->
  <div>
    <div class="section-eyebrow">We're Open</div>
    <h2 class="section-title">Opening <em>Hours</em></h2>
    <div class="divider"></div>
    <div id="open-status-badge" class="open-status-badge"></div>
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

    <div class="contact-items contact-items--spaced">
      <div class="contact-item"><span class="contact-icon">📞</span> +63 997 257 0287</div>
      <div class="contact-item"><span class="contact-icon">✉️</span> hello@nestbrew.ph</div>
      <div class="contact-item"><span class="contact-icon">📸</span> @nestbrew.cafe</div>
    </div>
  </div>

  <!-- Location -->
  <div>
    <div class="section-eyebrow">Come Visit</div>
    <h2 class="section-title">Find <em>Us</em></h2>
    <div class="divider"></div>
    <p class="location-address">
      Caza Azucena,<br>
      Pabayo<br>
      Cagayan de Oro City,<br>
      Misamis Oriental 9000
    </p>
    <a href="https://www.google.com/maps/place/Casa+Azucena/@8.4753147,124.6426706,17.25z/data=!4m9!3m8!1s0x32fff2d691653b01:0xe474664defcf32bf!5m2!4m1!1i2!8m2!3d8.4752697!4d124.6451107!16s%2Fg%2F1ptzbh4bf?entry=ttu&g_ep=EgoyMDI2MDUwNi4wIKXMDSoASAFQAw%3D%3D" 
   target="_blank" 
   rel="noopener noreferrer"
   class="location-map" 
   style="text-decoration:none; display:block;">
  🗺️
  <p>View on Google Maps</p>
</a>
  </div>
</section>

<!-- ── Footer ── -->
<footer>
  <div class="footer-logo">Nest<span>Brew</span></div>
  <p class="footer-copy">© 2026 NestBrew Cafe. All rights reserved.</p>
  <div class="footer-links">
    <a href="#">Privacy</a>
    <a href="#">Terms</a>
    <a href="#">Contact</a>
  </div>
</footer>

<!-- ── Auth Modal ── -->
<div class="modal-overlay" id="modal-overlay" onclick="handleOverlayClick(event)">
  <div class="modal">
    <div class="modal-header">
      <button class="modal-close" onclick="closeModal()">✕</button>
      <div class="modal-logo">Nest<span>Brew</span></div>
      <div class="modal-tagline">Your cozy corner awaits</div>
    </div>

    <div class="modal-tabs">
      <button class="modal-tab active" id="tab-signin" onclick="switchTab('signin')">Sign In</button>
      <button class="modal-tab"        id="tab-signup" onclick="switchTab('signup')">Sign Up</button>
    </div>

    <div class="modal-body">

      <!-- Sign In -->
      <div class="form-panel active" id="panel-signin">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input class="form-input" type="email" name="email"
                   placeholder="you@example.com"
                   value="{{ old('email') }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-input" type="password" name="password"
                   placeholder="••••••••" required/>
          </div>
          <div class="form-group" style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.5rem;">
  <input type="checkbox" name="remember" id="remember"
         style="width:16px; height:16px; accent-color:var(--brown); cursor:pointer;"/>
  <label for="remember" class="form-label" style="margin-bottom:0; cursor:pointer;">
    Remember Me
  </label>
</div>
          @if ($errors->login->any())
            <p class="form-error">{{ $errors->login->first() }}</p>
          @endif
          <button class="form-submit" type="submit">Sign In to NestBrew</button>
          <p class="form-footer">
            Don't have an account?
            <a href="#" onclick="switchTab('signup'); return false;">Sign up here</a>
          </p>
        </form>
      </div>

      <!-- Sign Up -->
      <div class="form-panel" id="panel-signup">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input class="form-input" type="text" name="name"
                   placeholder="Juan dela Cruz"
                   value="{{ old('name') }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input class="form-input" type="email" name="email"
                   placeholder="you@example.com"
                   value="{{ old('email') }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-input" type="password" name="password"
                   placeholder="At least 8 characters" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input class="form-input" type="password"
                   name="password_confirmation"
                   placeholder="Repeat your password" required/>
          </div>
          @if ($errors->signup->any())
            <p class="form-error">{{ $errors->signup->first() }}</p>
          @endif
          <button class="form-submit" type="submit">Create My Account</button>
          <p class="form-footer">
            Already have an account?
            <a href="#" onclick="switchTab('signin'); return false;">Sign in here</a>
          </p>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- ── Delivery Address Modal ── -->
<div id="address-overlay" class="overlay-backdrop">
  <div class="addr-modal">

    <!-- Header -->
    <div class="addr-modal-header">
      <div>
        <div class="addr-modal-title">📍 Delivery Details</div>
        <div class="addr-modal-subtitle">Where should we deliver your order?</div>
      </div>
      <button onclick="closeAddress()" class="modal-icon-close">✕</button>
    </div>

    <!-- Form -->
    <div class="addr-modal-body">
      <div class="addr-form-stack">

        <div class="addr-field">
          <label class="addr-label">Full Name</label>
          <input id="addr-name" type="text" placeholder="Juan dela Cruz" class="addr-input"/>
        </div>

        <div class="addr-field">
          <label class="addr-label">Phone Number</label>
          <input id="addr-phone" type="tel" placeholder="09XX XXX XXXX" class="addr-input"/>
        </div>

        <div class="addr-field">
          <label class="addr-label">Street / Purok / Subdivision</label>
          <input id="addr-street" type="text" placeholder="e.g. 123 Rizal St., Purok 4" class="addr-input"/>
        </div>

        <div class="addr-field">
          <label class="addr-label">Barangay</label>
          <input id="addr-barangay" type="text" placeholder="e.g. Bulua" class="addr-input"/>
        </div>

        <div class="addr-field">
          <label class="addr-label">Landmark <span class="addr-label-optional">(optional)</span></label>
          <input id="addr-landmark" type="text" placeholder="e.g. Near 7-Eleven, beside blue gate" class="addr-input"/>
        </div>

        <div id="addr-error" class="addr-error" style="display:none;"></div>

        <div class="addr-btn-row">
          <button onclick="closeAddress()" class="modal-btn-secondary">Cancel</button>
          <button onclick="proceedToSummary()" class="modal-btn-primary">Next — Review Order →</button>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ── Order Summary Modal ── -->
<div id="order-summary-overlay" class="overlay-backdrop">
  <div class="summary-modal">

    <!-- Header -->
    <div class="summary-modal-header">
      <div>
        <div class="summary-modal-title">📋 Order Summary</div>
        <div class="summary-modal-subtitle">Review your order before confirming</div>
      </div>
      <button onclick="closeOrderSummary()" class="modal-icon-close">✕</button>
    </div>

    <!-- Payment + Address info -->
    <div class="summary-meta">
      <div class="cod-badge">💵 Cash on Delivery</div>
      <div id="summary-address-display" class="summary-address"></div>
    </div>

    <!-- Items List -->
    <div id="order-summary-items" class="summary-items-list"></div>

    <!-- Divider -->
    <div class="summary-divider"></div>

    <!-- Total + Buttons -->
    <div class="summary-footer">
      <div class="summary-total-row">
        <span class="summary-total-label">Total Amount</span>
        <span id="order-summary-total" class="summary-total-amount">₱0.00</span>
      </div>
      <p class="summary-note">🍽️ Your order will be prepared once confirmed.</p>
      <div class="summary-btn-row">
        <button onclick="backToAddress()" class="modal-btn-secondary">← Back</button>
        <button id="confirm-order-btn" onclick="placeOrder()" class="modal-btn-primary">
          <span>✓ Confirm Order</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ── Order Success Modal ── -->
<div id="order-success-overlay" class="overlay-backdrop">
  <div class="success-modal">
    <div class="success-icon">☕</div>
    <h2 class="success-title">Thank You for Ordering!</h2>
    <p class="success-message">
      Your order has been placed successfully.<br>We'll have it ready for you soon!
    </p>
    <div class="success-order-box">
      <span class="success-order-label">Order Number</span>
      <div id="order-success-number" class="success-order-number"></div>
    </div>
    <button onclick="closeOrderSuccess()" class="success-done-btn">Done ☕</button>
  </div>
</div>

<!-- ── Toast ── -->
<div class="toast" id="toast"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    const isLoggedIn  = {{ auth()->check() ? 'true' : 'false' }};
    const loginUrl    = "{{ url('/') }}";
    const authUserName = "{{ auth()->check() ? auth()->user()->name : '' }}";
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
@if ($errors->login->any())
  document.addEventListener('DOMContentLoaded', function() {
    openModal('signin');
  });
@elseif ($errors->signup->any())
  document.addEventListener('DOMContentLoaded', function() {
    openModal('signup');
  });
@endif
</script>
</body>
</html>