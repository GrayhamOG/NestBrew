<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Orders — NestBrew Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --cream: #F5EFE6; --cream-dark: #EDE0CE; --beige: #D9C9B0;
      --brown-light: #A0785A; --brown: #7B4F2E; --brown-dark: #4E2E14;
      --espresso: #2C1A0E; --warm-white: #FAF6F1; --gold: #C9913A;
      --text-dark: #2C1A0E; --text-mid: #5C3D22; --text-light: #8A6748;
      --serif: 'Playfair Display', serif; --sans: 'Jost', sans-serif;
    }
    body { background: var(--cream); font-family: var(--sans); color: var(--text-dark); min-height: 100vh; }

    /* ── Top Bar ── */
    .topbar {
      background: linear-gradient(135deg, var(--brown-dark), var(--espresso));
      padding: 1.1rem 2.5rem;
      display: flex; align-items: center; justify-content: space-between;
      box-shadow: 0 4px 20px rgba(44,26,14,0.25);
    }
    .topbar-logo { font-family: var(--serif); font-size: 1.5rem; font-weight: 700; color: var(--cream); text-decoration: none; }
    .topbar-logo span { color: var(--gold); font-style: italic; }
    .topbar-nav { display: flex; gap: 0.75rem; align-items: center; }
    .nav-pill {
      font-family: var(--sans); font-size: 0.75rem; letter-spacing: 0.1em;
      text-transform: uppercase; padding: 0.5rem 1.2rem;
      border-radius: 2px; text-decoration: none; transition: all 0.25s;
    }
    .nav-pill-ghost { color: var(--beige); border: 1px solid rgba(196,168,130,0.3); }
    .nav-pill-ghost:hover { background: rgba(255,255,255,0.1); color: var(--cream); }
    .nav-pill-active { background: var(--gold); color: var(--espresso); font-weight: 500; }

    /* ── Page ── */
    .page { max-width: 1100px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    .page-header { margin-bottom: 2rem; }
    .page-eyebrow {
      font-size: 0.72rem; letter-spacing: 0.2em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 0.5rem;
      display: flex; align-items: center; gap: 0.75rem;
    }
    .page-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--gold); display: block; }
    .page-title { font-family: var(--serif); font-size: 2rem; font-weight: 700; color: var(--espresso); }
    .page-title em { font-style: italic; color: var(--brown); }

    /* ── Flash ── */
    .flash {
      background: rgba(46,204,113,0.12); border: 1px solid rgba(46,204,113,0.3);
      color: #15803d; border-radius: 6px; padding: 0.75rem 1.25rem;
      font-size: 0.88rem; margin-bottom: 1.5rem;
    }

    /* ── Stats row ── */
    .stats { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .stat-card {
      background: var(--warm-white); border: 1px solid var(--cream-dark);
      border-radius: 8px; padding: 1.1rem 1.5rem; flex: 1; min-width: 140px;
    }
    .stat-label { font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-light); margin-bottom: 0.3rem; }
    .stat-value { font-family: var(--serif); font-size: 1.8rem; font-weight: 700; color: var(--brown-dark); }

    /* ── Filter bar ── */
    .filter-bar { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-btn {
      font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase;
      padding: 0.45rem 1.1rem; border: 1px solid var(--beige);
      background: transparent; color: var(--text-light); border-radius: 2px;
      cursor: pointer; transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active { background: var(--brown); color: var(--cream); border-color: var(--brown); }

    /* ── Orders ── */
    .orders-list { display: flex; flex-direction: column; gap: 1rem; }

    .order-card {
      background: var(--warm-white); border: 1px solid var(--cream-dark);
      border-radius: 8px; overflow: hidden;
      transition: box-shadow 0.25s;
    }
    .order-card:hover { box-shadow: 0 8px 28px rgba(44,26,14,0.1); }

    .order-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 1rem 1.5rem; cursor: pointer; gap: 1rem; flex-wrap: wrap;
      border-bottom: 1px solid transparent; transition: border-color 0.2s;
      user-select: none;
    }
    .order-head:hover { border-bottom-color: var(--cream-dark); }

    .order-id {
      font-family: var(--serif); font-size: 1.05rem; font-weight: 700;
      color: var(--brown-dark); white-space: nowrap;
    }
    .order-user { font-size: 0.88rem; color: var(--text-mid); }
    .order-user strong { color: var(--text-dark); }
    .order-meta { font-size: 0.78rem; color: var(--text-light); }
    .order-total { font-family: var(--serif); font-size: 1.15rem; font-weight: 700; color: var(--brown); white-space: nowrap; }

    /* Status badge */
    .badge {
      display: inline-flex; align-items: center; gap: 0.35rem;
      font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase;
      font-weight: 500; padding: 0.3rem 0.8rem; border-radius: 20px; white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-pending        { background: rgba(201,145,58,0.15); color: #92600a; border: 1px solid rgba(201,145,58,0.3); }
    .badge-pending .badge-dot { background: #C9913A; }
    .badge-preparing      { background: rgba(59,130,246,0.12); color: #1d4ed8; border: 1px solid rgba(59,130,246,0.25); }
    .badge-preparing .badge-dot { background: #3b82f6; }
    .badge-out_for_delivery { background: rgba(139,92,246,0.12); color: #6d28d9; border: 1px solid rgba(139,92,246,0.25); }
    .badge-out_for_delivery .badge-dot { background: #8b5cf6; }
    .badge-delivered      { background: rgba(34,197,94,0.12); color: #15803d; border: 1px solid rgba(34,197,94,0.25); }
    .badge-delivered .badge-dot { background: #22c55e; }
    .badge-cancelled      { background: rgba(239,68,68,0.1); color: #b91c1c; border: 1px solid rgba(239,68,68,0.2); }
    .badge-cancelled .badge-dot { background: #ef4444; }

    /* Collapsible body */
    .order-body { display: none; padding: 1.25rem 1.5rem; border-top: 1px solid var(--cream-dark); }
    .order-body.open { display: block; }

    .body-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media(max-width: 640px){ .body-grid { grid-template-columns: 1fr; } }

    .body-section-title {
      font-size: 0.7rem; letter-spacing: 0.14em; text-transform: uppercase;
      color: var(--text-light); margin-bottom: 0.6rem;
    }

    /* Items table */
    .items-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
    .items-table th {
      text-align: left; padding: 0.4rem 0.5rem; font-size: 0.68rem;
      letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-light);
      border-bottom: 1px solid var(--cream-dark);
    }
    .items-table td { padding: 0.55rem 0.5rem; color: var(--text-mid); border-bottom: 1px solid rgba(217,201,176,0.4); }
    .items-table tr:last-child td { border-bottom: none; }
    .items-table .subtotal { font-family: var(--serif); color: var(--brown); font-weight: 600; text-align: right; }

    /* Address block */
    .addr-block { font-size: 0.88rem; color: var(--text-mid); line-height: 1.7; }
    .addr-block strong { color: var(--text-dark); }

    /* Status form */
    .status-form { display: flex; gap: 0.5rem; align-items: center; margin-top: 1.25rem; flex-wrap: wrap; }
    .status-select {
      flex: 1; min-width: 160px; padding: 0.55rem 0.85rem;
      border: 1px solid var(--beige); border-radius: 4px;
      background: var(--cream); color: var(--text-dark);
      font-family: var(--sans); font-size: 0.85rem; outline: none;
      transition: border-color 0.2s;
    }
    .status-select:focus { border-color: var(--brown-light); }
    .status-submit {
      padding: 0.55rem 1.2rem; background: var(--brown-dark); color: var(--cream);
      border: none; border-radius: 4px; font-family: var(--sans);
      font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase;
      cursor: pointer; transition: background 0.2s; white-space: nowrap;
    }
    .status-submit:hover { background: var(--brown); }

    /* Empty state */
    .empty { text-align: center; padding: 4rem 2rem; color: var(--text-light); }
    .empty-icon { font-size: 3.5rem; opacity: 0.35; margin-bottom: 0.75rem; }
    .empty p { font-family: var(--serif); font-size: 1.1rem; }

    .chevron { font-size: 0.75rem; color: var(--text-light); transition: transform 0.25s; }
    .chevron.open { transform: rotate(180deg); }
  </style>
</head>
<body>

<!-- Top Bar -->
<div class="topbar">
  <a href="{{ url('/') }}" class="topbar-logo">Nest<span>Brew</span></a>
  <nav class="topbar-nav">
    <a href="{{ route('admin.menu.index') }}" class="nav-pill nav-pill-ghost">⚙️ Menu Items</a>
    <a href="{{ route('admin.orders.index') }}" class="nav-pill nav-pill-active">📋 Orders</a>
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
      @csrf
      <button type="submit" class="nav-pill nav-pill-ghost" style="cursor:pointer; border:1px solid rgba(196,168,130,0.3);">Log Out</button>
    </form>
  </nav>
</div>

<div class="page">

  <!-- Header -->
  <div class="page-header">
    <div class="page-eyebrow">Admin Panel</div>
    <h1 class="page-title">Customer <em>Orders</em></h1>
  </div>

  @if(session('success'))
    <div class="flash">✓ {{ session('success') }}</div>
  @endif

  <!-- Stats -->
  @php
    $total     = $orders->count();
    $pending   = $orders->where('status','pending')->count();
    $preparing = $orders->where('status','preparing')->count();
    $delivered = $orders->where('status','delivered')->count();
    $revenue   = $orders->whereNotIn('status',['cancelled'])->sum('total');
  @endphp
  <div class="stats">
    <div class="stat-card">
      <div class="stat-label">Total Orders</div>
      <div class="stat-value">{{ $total }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Pending</div>
      <div class="stat-value" style="color:var(--gold);">{{ $pending }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Preparing</div>
      <div class="stat-value" style="color:#3b82f6;">{{ $preparing }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Delivered</div>
      <div class="stat-value" style="color:#15803d;">{{ $delivered }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Revenue</div>
      <div class="stat-value">₱{{ number_format($revenue, 2) }}</div>
    </div>
  </div>

  <!-- Filter Buttons -->
  <div class="filter-bar">
    <button class="filter-btn active" onclick="filterOrders('all', this)">All</button>
    <button class="filter-btn" onclick="filterOrders('pending', this)">Pending</button>
    <button class="filter-btn" onclick="filterOrders('preparing', this)">Preparing</button>
    <button class="filter-btn" onclick="filterOrders('out_for_delivery', this)">Out for Delivery</button>
    <button class="filter-btn" onclick="filterOrders('delivered', this)">Delivered</button>
    <button class="filter-btn" onclick="filterOrders('cancelled', this)">Cancelled</button>
  </div>

  <!-- Orders List -->
  <div class="orders-list" id="orders-list">

    @forelse($orders as $order)
    @php
      $statusLabels = [
        'pending'          => 'Pending',
        'preparing'        => 'Preparing',
        'out_for_delivery' => 'Out for Delivery',
        'delivered'        => 'Delivered',
        'cancelled'        => 'Cancelled',
      ];
    @endphp

    <div class="order-card" data-status="{{ $order->status }}">

      <!-- Clickable Header -->
      <div class="order-head" onclick="toggleOrder({{ $order->id }})">
        <div>
          <div class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
          <div class="order-user">
            <strong>{{ $order->user->name }}</strong>
            <span style="color:var(--text-light);"> · {{ $order->user->email }}</span>
          </div>
        </div>
        <div class="order-meta" style="text-align:center;">
          <div>{{ $order->created_at->format('M d, Y') }}</div>
          <div>{{ $order->created_at->format('h:i A') }}</div>
        </div>
        <span class="badge badge-{{ $order->status }}">
          <span class="badge-dot"></span>
          {{ $statusLabels[$order->status] ?? $order->status }}
        </span>
        <div class="order-total">₱{{ number_format($order->total, 2) }}</div>
        <span class="chevron" id="chevron-{{ $order->id }}">▼</span>
      </div>

      <!-- Collapsible Body -->
      <div class="order-body" id="body-{{ $order->id }}">
        <div class="body-grid">

          <!-- Items -->
          <div>
            <div class="body-section-title">🛒 Items Ordered</div>
            <table class="items-table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th style="text-align:right;">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                <tr>
                  <td>{{ $item->emoji }} {{ $item->name }}</td>
                  <td>x{{ $item->quantity }}</td>
                  <td>₱{{ number_format($item->price, 2) }}</td>
                  <td class="subtotal">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Delivery Info + Status Update -->
          <div>
            <div class="body-section-title">📍 Delivery Details</div>
            <div class="addr-block">
              <strong>{{ $order->recipient_name }}</strong><br>
              📞 {{ $order->phone }}<br>
              {{ $order->street }}, Brgy. {{ $order->barangay }}<br>
              @if($order->landmark)
                🏠 {{ $order->landmark }}<br>
              @endif
              💵 {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
            </div>

            <form method="POST"
                  action="{{ route('admin.orders.updateStatus', $order->id) }}"
                  class="status-form">
              @csrf
              @method('PATCH')
              <select name="status" class="status-select">
                @foreach($statusLabels as $val => $label)
                  <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                @endforeach
              </select>
              <button type="submit" class="status-submit">Update</button>
            </form>
          </div>

        </div>
      </div>
    </div>
    @empty
      <div class="empty">
        <div class="empty-icon">📋</div>
        <p>No orders yet.</p>
      </div>
    @endforelse

  </div><!-- /orders-list -->
</div><!-- /page -->

<script>
  // Toggle expand/collapse
  function toggleOrder(id) {
    const body    = document.getElementById('body-' + id);
    const chevron = document.getElementById('chevron-' + id);
    body.classList.toggle('open');
    chevron.classList.toggle('open');
  }

  // Filter by status
  function filterOrders(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.order-card').forEach(card => {
      if (status === 'all' || card.dataset.status === status) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }
</script>
</body>
</html>