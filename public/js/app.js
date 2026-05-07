$(document).ready(function () {

 function updateOpenStatus() {
  const now    = new Date();
  const day    = now.getDay();
  const hour   = now.getHours();
  const minute = now.getMinutes();
  const time   = hour + minute / 60;

  let isOpen = false;
  let closingTime = '';
  let opensAt = '';

  if (day >= 1 && day <= 5) {
    isOpen      = time >= 7 && time < 21;
    closingTime = '9:00 PM';
    opensAt     = '7:00 AM';
  } else if (day === 6) {
    isOpen      = time >= 8 && time < 22;
    closingTime = '10:00 PM';
    opensAt     = '8:00 AM';
  } else if (day === 0) {
    isOpen      = time >= 8 && time < 20;
    closingTime = '8:00 PM';
    opensAt     = '8:00 AM';
  }

  const badge = $('#open-status-badge');

  if (isOpen) {
    badge.html(`
      <span class="status-open">
        <span class="status-dot-open"></span>
        Open now — closes at ${closingTime}
      </span>
    `);
  } else {
    badge.html(`
      <span class="status-closed">
        <span class="status-dot-closed"></span>
        Closed now — opens at ${opensAt}
      </span>
    `);
  }
}

// Run on page load
updateOpenStatus();

// Update every minute so it stays accurate
setInterval(updateOpenStatus, 60000);

  // ── Load menu items from database ──────────────────────────
  function loadMenuItems(filterCat = 'all') {
    $.ajax({
      url: '/menu-items',
      method: 'GET',
      headers: { 'Accept': 'application/json' },
      success: function (items) {
        const filtered = filterCat === 'all'
          ? items
          : items.filter(i => i.category === filterCat);
        renderMenu(filtered);
      },
      error: function () {
        $('#menu-grid').html('<p style="text-align:center;color:red;">Could not load menu items.</p>');
      }
    });
  }

  // ── Render Menu from database items ───────────────────────
 function renderMenu(items) {
  const grid = $('#menu-grid');

  if (items.length === 0) {
    grid.html('<p class="menu-card-empty">No items in this category yet.</p>');
    return;
  }

  grid.html(items.map(item => `
    <div class="menu-card">
      <span class="menu-card-emoji">${item.emoji || '🍽️'}</span>
      <div class="menu-card-name">${item.name}</div>
      <div class="menu-card-desc">${item.description || ''}</div>
      <div class="menu-card-footer">
        <span class="menu-card-price">₱${parseFloat(item.price).toFixed(2)}</span>
        <button class="menu-card-add add-to-cart"
                data-name="${item.name}"
                data-emoji="${item.emoji || '🍽️'}"
                data-price="${item.price}"
                title="Add to cart">+</button>
      </div>
    </div>
  `).join(''));

  $('.add-to-cart').on('click', function () {
    const name  = $(this).data('name');
    const emoji = $(this).data('emoji');
    const price = $(this).data('price');
    addToCart(name, emoji, price);
  });
}
  // ── Filter Tabs ────────────────────────────────────────────
  $(document).on('click', '.tab-btn', function () {
    const cat = $(this).attr('onclick').match(/'([^']+)'/)[1];
    $('.tab-btn').removeClass('active');
    $(this).addClass('active');
    loadMenuItems(cat);
  });

  // ── Load menu on page load ─────────────────────────────────
  loadMenuItems();

  // ... rest of your existing code below (cart, modal, toast, etc.)

  // ── Add to Cart ────────────────────────────────────────────
  function addToCart(name, emoji, price) {
    if (!isLoggedIn) {
      window.location.href = loginUrl + '?signin=true';
      return;
    }

    $.ajax({
      url: '/cart',
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: { name, emoji, price },
      success: function (res) {
        showToast(res.message + ' ☕');
        loadCart();
      },
      error: function () {
        showToast('Something went wrong. Try again.');
      }
    });
  }

  // ── Load Cart from database ─────────────────────────────────
  function loadCart() {
  if (!isLoggedIn) return;

  $.ajax({
    url: '/cart',
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Accept': 'application/json'
    },
    success: function (res) {
      const items = res.items;
      const total = res.total;
      const count = items.reduce((sum, i) => sum + i.quantity, 0);

      $('#cart-count').text(count);

      const rawTotal  = String(total).replace(/,/g, '');
      const numeric   = parseFloat(rawTotal) || 0;
      const formatted = '₱' + numeric.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      $('#cart-total').text(formatted);

      const container = $('#cart-items');

      if (items.length === 0) {
        container.html('<p class="cart-empty">Your cart is empty ☕</p>');
        return;
      }

      container.html(items.map(item => `
        <div class="cart-item">
          <span class="cart-item-emoji">${item.emoji}</span>
          <div class="cart-item-info">
            <div class="cart-item-name">${item.name}</div>
            <div class="cart-item-price-each">₱${parseFloat(item.price).toFixed(2)} each</div>
          </div>
          <div class="cart-item-qty">
            <button class="cart-qty-btn"
                    onclick="updateQty(${item.id}, ${item.quantity - 1})">−</button>
            <span class="cart-qty-number">${item.quantity}</span>
            <button class="cart-qty-btn"
                    onclick="updateQty(${item.id}, ${item.quantity + 1})">+</button>
          </div>
          <div class="cart-item-subtotal">
            ₱${(parseFloat(item.price) * item.quantity).toFixed(2)}
          </div>
          <button class="cart-item-remove"
                  onclick="removeItem(${item.id})">✕</button>
        </div>
      `).join(''));
    },
    error: function (xhr) {
      console.log('Cart error:', xhr.status, xhr.responseText);
      $('#cart-items').html(
        '<p class="cart-empty">Could not load cart. Please refresh.</p>'
      );
    }
  });
}

  // ── Open Cart ──────────────────────────────────────────────
  window.openCart = function () {
    loadCart();
    $('#cart-panel').css({ display: 'flex', opacity: 0 }).animate({ opacity: 1 }, 220);
    $('#cart-backdrop').fadeIn(180);
  };

  // ── Close Cart ─────────────────────────────────────────────
  window.closeCart = function () {
    $('#cart-panel').fadeOut(180);
    $('#cart-backdrop').fadeOut(180);
  };

  // ── Draggable Cart Panel ───────────────────────────────────
  (function initDrag() {
    const panel = document.getElementById('cart-panel');
    const handle = document.getElementById('cart-drag-handle');
    if (!panel || !handle) return;

    let isDragging = false, startX, startY, origLeft, origTop;

    handle.addEventListener('mousedown', function (e) {
      if (e.target.closest('button')) return;
      isDragging = true;
      handle.style.cursor = 'grabbing';
      const rect = panel.getBoundingClientRect();
      startX = e.clientX;
      startY = e.clientY;
      origLeft = rect.left;
      origTop  = rect.top;
      e.preventDefault();
    });

    document.addEventListener('mousemove', function (e) {
      if (!isDragging) return;
      const dx = e.clientX - startX;
      const dy = e.clientY - startY;
      const newLeft = Math.max(0, Math.min(window.innerWidth  - panel.offsetWidth,  origLeft + dx));
      const newTop  = Math.max(0, Math.min(window.innerHeight - panel.offsetHeight, origTop  + dy));
      panel.style.left  = newLeft + 'px';
      panel.style.top   = newTop  + 'px';
      panel.style.right = 'auto';
    });

    document.addEventListener('mouseup', function () {
      if (isDragging) {
        isDragging = false;
        handle.style.cursor = 'grab';
      }
    });

    // Touch support
    handle.addEventListener('touchstart', function (e) {
      if (e.target.closest('button')) return;
      const t = e.touches[0];
      const rect = panel.getBoundingClientRect();
      isDragging = true;
      startX = t.clientX; startY = t.clientY;
      origLeft = rect.left; origTop = rect.top;
    }, { passive: true });

    document.addEventListener('touchmove', function (e) {
      if (!isDragging) return;
      const t = e.touches[0];
      const dx = t.clientX - startX;
      const dy = t.clientY - startY;
      const newLeft = Math.max(0, Math.min(window.innerWidth  - panel.offsetWidth,  origLeft + dx));
      const newTop  = Math.max(0, Math.min(window.innerHeight - panel.offsetHeight, origTop  + dy));
      panel.style.left  = newLeft + 'px';
      panel.style.top   = newTop  + 'px';
      panel.style.right = 'auto';
    }, { passive: true });

    document.addEventListener('touchend', function () { isDragging = false; });
  })();

  // ── Update Quantity ────────────────────────────────────────
  window.updateQty = function (id, qty) {
    if (qty <= 0) {
      removeItem(id);
      return;
    }
    $.ajax({
      url: '/cart/' + id,
      method: 'PATCH',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: { quantity: qty },
      success: function () { loadCart(); }
    });
  };

  // ── Remove Item ────────────────────────────────────────────
  window.removeItem = function (id) {
    $.ajax({
      url: '/cart/' + id,
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function () {
        loadCart();
        showToast('Item removed from cart');
      }
    });
  };

  // ── Clear Cart ─────────────────────────────────────────────
  window.clearCart = function () {
    $.ajax({
      url: '/cart',
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function () {
        loadCart();
        showToast('Cart cleared');
      }
    });
  };
  // ── Checkout — Step 1: Open Address Form ──────────────────
  window.handleCheckout = function () {
    if (!isLoggedIn) { window.location.href = loginUrl + '?signin=true'; return; }

    // Pre-fill name from nav if available
    const navName = $('nav span').first().text().replace('Hi,', '').replace('👋', '').trim();
    if (navName && !$('#addr-name').val()) {
      $('#addr-name').val(navName);
    }

    $('#address-overlay').css('display', 'flex').hide().fadeIn(200);
    $('body').css('overflow', 'hidden');
  };

  window.closeAddress = function () {
    $('#address-overlay').fadeOut(200);
    $('body').css('overflow', '');
  };

  // ── Step 2: Validate address and show order summary ────────
  window.proceedToSummary = function () {
    const name     = $('#addr-name').val().trim();
    const phone    = $('#addr-phone').val().trim();
    const street   = $('#addr-street').val().trim();
    const barangay = $('#addr-barangay').val().trim();

    // Validate required fields
    if (!name || !phone || !street || !barangay) {
      $('#addr-error').text('Please fill in all required fields.').show();
      return;
    }
    $('#addr-error').hide();

    // Fetch cart and show summary
    $.ajax({
      url: '/cart',
      method: 'GET',
      headers: { 'Accept': 'application/json' },
      success: function (res) {
        const items = res.items;
        const total = res.total;

        if (!items || items.length === 0) {
          showToast('Your cart is empty!');
          closeAddress();
          return;
        }

        // Build items HTML
        const itemsHtml = items.map(item => `
          <div style="display:flex; justify-content:space-between; align-items:center;
                      padding:0.75rem 0; border-bottom:1px solid var(--cream-dark);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
              <span style="font-size:1.5rem;">${item.emoji}</span>
              <div>
                <div style="font-family:var(--sans); font-size:0.9rem; font-weight:500;
                            color:var(--brown-dark);">${item.name}</div>
                <div style="font-family:var(--elegant); font-size:0.82rem;
                            color:var(--text-light);">x${item.quantity} @ ₱${parseFloat(item.price).toFixed(2)}</div>
              </div>
            </div>
            <div style="font-family:var(--serif); font-size:1rem; font-weight:600; color:var(--brown);">
              ₱${(parseFloat(item.price) * item.quantity).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}
            </div>
          </div>
        `).join('');

        // Format total
        const numeric   = parseFloat(String(total).replace(/,/g, '')) || 0;
        const formatted = '₱' + numeric.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Show address summary
        const landmark = $('#addr-landmark').val().trim();
        const addrLine = `📦 ${name} · ${phone}<br>📍 ${street}, Brgy. ${barangay}${landmark ? '<br>🏠 ' + landmark : ''}`;

        $('#order-summary-items').html(itemsHtml);
        $('#order-summary-total').text(formatted);
        $('#summary-address-display').html(addrLine);

        // Switch modals
        $('#address-overlay').fadeOut(150, function () {
          $('#order-summary-overlay').css('display', 'flex').hide().fadeIn(200);
        });
      },
      error: function () {
        showToast('Could not load cart. Please try again.');
      }
    });
  };

  // ── Back to address form ────────────────────────────────────
  window.backToAddress = function () {
    $('#order-summary-overlay').fadeOut(150, function () {
      $('#address-overlay').css('display', 'flex').hide().fadeIn(200);
    });
  };

  window.closeOrderSummary = function () {
    $('#order-summary-overlay').fadeOut(200);
    $('body').css('overflow', '');
  };

  $('#order-summary-overlay').on('click', function (e) {
    if ($(e.target).is('#order-summary-overlay')) closeOrderSummary();
  });

  // ── Step 3: Confirm and place the order ────────────────────
  window.placeOrder = function () {
    const $btn = $('#confirm-order-btn');
    $btn.prop('disabled', true).html('<span>Placing Order...</span>');

    $.ajax({
      url: '/orders',
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: {
        name:     $('#addr-name').val().trim(),
        phone:    $('#addr-phone').val().trim(),
        street:   $('#addr-street').val().trim(),
        barangay: $('#addr-barangay').val().trim(),
        landmark: $('#addr-landmark').val().trim(),
      },
      success: function (res) {
        closeOrderSummary();
        closeCart();

        // Clear address form
        $('#addr-name, #addr-phone, #addr-street, #addr-barangay, #addr-landmark').val('');

        // Show success
        $('#order-success-number').text('#' + String(res.order_id).padStart(4, '0'));
        $('#order-success-overlay').css('display', 'flex').hide().fadeIn(200);

        loadCart();
        $btn.prop('disabled', false).html('<span>✓ Confirm Order</span>');
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
        showToast(msg);
        $btn.prop('disabled', false).html('<span>✓ Confirm Order</span>');
      }
    });
  };

  // ── Close Success Modal ────────────────────────────────────
  window.closeOrderSuccess = function () {
    $('#order-success-overlay').fadeOut(200);
    $('body').css('overflow', '');
  };

  window.openModal = function (tab) {
    $('#modal-overlay').addClass('open');
    $('body').css('overflow', 'hidden');
    switchTab(tab);
  };

  window.closeModal = function () {
    $('#modal-overlay').removeClass('open');
    $('body').css('overflow', '');
  };

  $('#modal-overlay').on('click', function (e) {
    if ($(e.target).is('#modal-overlay')) closeModal();
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      closeModal();
      closeCart();
    }
  });

  // ── Switch Tabs ────────────────────────────────────────────
  window.switchTab = function (tab) {
    $('.modal-tab').removeClass('active');
    $('.form-panel').removeClass('active');
    $('#tab-' + tab).addClass('active');
    $('#panel-' + tab).addClass('active');
  };

  // ── Toast ──────────────────────────────────────────────────
  window.showToast = function (msg) {
    $('#toast').text(msg).addClass('show');
    setTimeout(function () {
      $('#toast').removeClass('show');
    }, 3000);
  };

  // ── Nav scroll ─────────────────────────────────────────────
  $(window).on('scroll', function () {
    $('#navbar').toggleClass('scrolled', $(this).scrollTop() > 40);
  });

  // ── Auto open modal if ?signin=true ───────────────────────
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('signin') === 'true') {
    openModal('signin');
  }

  // ── Load cart count on page load ───────────────────────────
  if (isLoggedIn) {
    loadCart();
  }

  

});