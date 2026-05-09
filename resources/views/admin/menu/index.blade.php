<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — NestBrew</title>
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
      padding: 1rem 2.5rem;
      display: flex; align-items: center; justify-content: space-between;
      box-shadow: 0 4px 20px rgba(44,26,14,0.25);
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-logo { font-family: var(--serif); font-size: 1.5rem; font-weight: 700; color: var(--cream); text-decoration: none; }
    .topbar-logo span { color: var(--gold); font-style: italic; }
    .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
    .topbar-user { font-size: 0.8rem; color: var(--beige); }
    .topbar-btn {
      font-family: var(--sans); font-size: 0.72rem; letter-spacing: 0.1em;
      text-transform: uppercase; padding: 0.45rem 1rem;
      border: 1px solid rgba(196,168,130,0.35); border-radius: 2px;
      color: var(--beige); background: transparent; cursor: pointer;
      text-decoration: none; transition: all 0.2s;
    }
    .topbar-btn:hover { background: rgba(255,255,255,0.1); color: var(--cream); }

    /* ── Page ── */
    .page { max-width: 1080px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

    /* ── Page Header ── */
    .page-header { margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-family: var(--serif); font-size: 1.9rem; font-weight: 700; color: var(--espresso); }
    .page-title em { font-style: italic; color: var(--brown); }

    /* ── Flash ── */
    .flash {
      background: rgba(46,204,113,0.12); border: 1px solid rgba(46,204,113,0.3);
      color: #15803d; border-radius: 6px; padding: 0.75rem 1.25rem;
      font-size: 0.88rem; margin-bottom: 1.5rem;
    }

    /* ── Tabs ── */
    .tabs { display: flex; gap: 0; border-bottom: 2px solid var(--cream-dark); margin-bottom: 2rem; }
    .tab-btn {
      font-family: var(--sans); font-size: 0.82rem; font-weight: 400;
      letter-spacing: 0.1em; text-transform: uppercase;
      padding: 0.8rem 1.75rem; border: none; background: transparent;
      color: var(--text-light); cursor: pointer; transition: all 0.2s;
      border-bottom: 2px solid transparent; margin-bottom: -2px;
      display: flex; align-items: center; gap: 0.5rem;
    }
    .tab-btn:hover { color: var(--brown); }
    .tab-btn.active { color: var(--brown-dark); border-bottom-color: var(--gold); font-weight: 500; }
    .tab-badge {
      background: var(--gold); color: var(--espresso);
      font-size: 0.65rem; font-weight: 600;
      border-radius: 10px; padding: 1px 7px; min-width: 20px; text-align: center;
    }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Buttons ── */
    .btn {
      padding: 0.55rem 1.2rem; border-radius: 4px; border: none;
      cursor: pointer; font-family: var(--sans); font-size: 0.82rem;
      text-decoration: none; display: inline-block; transition: all 0.2s; letter-spacing: 0.04em;
    }
    .btn-dark   { background: var(--brown-dark); color: var(--cream); }
    .btn-dark:hover { background: var(--brown); }
    .btn-mid    { background: var(--brown-light); color: white; }
    .btn-mid:hover { background: var(--brown); }
    .btn-danger { background: #9e3f4e; color: white; }
    .btn-danger:hover { background: #7f2f3e; }
    .btn-ghost  { background: transparent; border: 1px solid var(--brown-light); color: var(--brown-light); }
    .btn-ghost:hover { background: var(--brown-light); color: white; }

    /* ── Alert ── */
    .alert { background: #d4edda; color: #155724; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1.25rem; }

    /* ══════════════════════════════════
       MENU TAB
    ══════════════════════════════════ */
    .menu-toolbar { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; flex-wrap: wrap; }

    table { width: 100%; background: white; border-radius: 8px; overflow: hidden; border-collapse: collapse; box-shadow: 0 2px 12px rgba(44,26,14,0.07); }
    th { background: var(--brown-dark); color: var(--cream); padding: 0.9rem 1rem; text-align: left; font-weight: 500; font-size: 0.82rem; letter-spacing: 0.06em; text-transform: uppercase; }
    td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--cream-dark); font-size: 0.9rem; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--warm-white); }
    .actions { display: flex; gap: 0.5rem; }

    .cat-badge { padding: 2px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 500; }
    .badge-coffee    { background: #D9C9B0; color: #4E2E14; }
    .badge-noncoffee { background: #D4EDDA; color: #155724; }
    .badge-pastry    { background: #FDE8D0; color: #7B3F00; }
    .badge-food      { background: #D0E8FD; color: #00407B; }

    /* ══════════════════════════════════
       ORDERS TAB
    ══════════════════════════════════ */

    /* Stats Row */
    .stats { display: flex; gap: 1rem; margin-bottom: 1.75rem; flex-wrap: wrap; }
    .stat-card {
      background: var(--warm-white); border: 1px solid var(--cream-dark);
      border-radius: 8px; padding: 1rem 1.4rem; flex: 1; min-width: 120px;
    }
    .stat-label { font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-light); margin-bottom: 0.3rem; }
    .stat-value { font-family: var(--serif); font-size: 1.7rem; font-weight: 700; color: var(--brown-dark); }

    /* Filter bar */
    .filter-bar { display: flex; gap: 0.4rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .filter-btn {
      font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase;
      padding: 0.4rem 1rem; border: 1px solid var(--beige);
      background: transparent; color: var(--text-light); border-radius: 2px;
      cursor: pointer; transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active { background: var(--brown); color: var(--cream); border-color: var(--brown); }

    /* Order cards */
    .orders-list { display: flex; flex-direction: column; gap: 0.85rem; }

    .order-card {
      background: var(--warm-white); border: 1px solid var(--cream-dark);
      border-radius: 8px; overflow: hidden;
      transition: box-shadow 0.2s;
    }
    .order-card:hover { box-shadow: 0 6px 24px rgba(44,26,14,0.09); }

    .order-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0.95rem 1.4rem; cursor: pointer; gap: 1rem; flex-wrap: wrap;
      user-select: none;
    }

    .order-id { font-family: var(--serif); font-size: 1rem; font-weight: 700; color: var(--brown-dark); }
    .order-user { font-size: 0.85rem; color: var(--text-mid); }
    .order-user strong { color: var(--text-dark); }
    .order-meta { font-size: 0.76rem; color: var(--text-light); text-align: center; }
    .order-total { font-family: var(--serif); font-size: 1.1rem; font-weight: 700; color: var(--brown); white-space: nowrap; }

    /* Status badges */
    .status-badge {
      display: inline-flex; align-items: center; gap: 0.35rem;
      font-size: 0.7rem; letter-spacing: 0.08em; text-transform: uppercase;
      font-weight: 500; padding: 0.28rem 0.75rem; border-radius: 20px; white-space: nowrap;
    }
    .sdot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .s-pending        { background: rgba(201,145,58,0.15); color: #92600a; border: 1px solid rgba(201,145,58,0.3); }
    .s-pending .sdot  { background: #C9913A; }
    .s-preparing      { background: rgba(59,130,246,0.12); color: #1d4ed8; border: 1px solid rgba(59,130,246,0.25); }
    .s-preparing .sdot { background: #3b82f6; }
    .s-out_for_delivery { background: rgba(139,92,246,0.12); color: #6d28d9; border: 1px solid rgba(139,92,246,0.25); }
    .s-out_for_delivery .sdot { background: #8b5cf6; }
    .s-delivered      { background: rgba(34,197,94,0.12); color: #15803d; border: 1px solid rgba(34,197,94,0.25); }
    .s-delivered .sdot { background: #22c55e; }
    .s-cancelled      { background: rgba(239,68,68,0.1); color: #b91c1c; border: 1px solid rgba(239,68,68,0.2); }
    .s-cancelled .sdot { background: #ef4444; }

    /* Collapsible body */
    .order-body { display: none; padding: 1.25rem 1.4rem; border-top: 1px solid var(--cream-dark); }
    .order-body.open { display: block; }

    .body-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media(max-width: 640px){ .body-grid { grid-template-columns: 1fr; } }

    .section-label { font-size: 0.68rem; letter-spacing: 0.14em; text-transform: uppercase; color: var(--text-light); margin-bottom: 0.6rem; }

    .items-table { width: 100%; border-collapse: collapse; font-size: 0.86rem; }
    .items-table th { background: none; color: var(--text-light); padding: 0.35rem 0.4rem; font-size: 0.66rem; letter-spacing: 0.1em; text-transform: uppercase; border-bottom: 1px solid var(--cream-dark); text-align: left; }
    .items-table td { padding: 0.5rem 0.4rem; color: var(--text-mid); border-bottom: 1px solid rgba(217,201,176,0.4); }
    .items-table tr:last-child td { border-bottom: none; }
    .items-table .sub { font-family: var(--serif); color: var(--brown); font-weight: 600; text-align: right; }

    .addr-block { font-size: 0.87rem; color: var(--text-mid); line-height: 1.75; }
    .addr-block strong { color: var(--text-dark); }

    .status-form { display: flex; gap: 0.5rem; align-items: center; margin-top: 1.1rem; flex-wrap: wrap; }
    .status-select {
      flex: 1; min-width: 150px; padding: 0.5rem 0.8rem;
      border: 1px solid var(--beige); border-radius: 4px;
      background: var(--cream); color: var(--text-dark);
      font-family: var(--sans); font-size: 0.83rem; outline: none;
      transition: border-color 0.2s;
    }
    .status-select:focus { border-color: var(--brown-light); }
    .status-submit {
      padding: 0.5rem 1.1rem; background: var(--brown-dark); color: var(--cream);
      border: none; border-radius: 4px; font-family: var(--sans);
      font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase;
      cursor: pointer; transition: background 0.2s; white-space: nowrap;
    }
    .status-submit:hover { background: var(--brown); }

    .chevron { font-size: 0.7rem; color: var(--text-light); transition: transform 0.25s; flex-shrink: 0; }
    .chevron.open { transform: rotate(180deg); }

    .empty-state { text-align: center; padding: 3.5rem 2rem; color: var(--text-light); }
    .empty-state .ei { font-size: 3rem; opacity: 0.3; margin-bottom: 0.6rem; }
    .empty-state p { font-family: var(--serif); font-size: 1rem; }
  </style>
</head>
<body>

<!-- ── Top Bar ── -->
<div class="topbar">
  <a href="{{ route('home') }}" class="topbar-logo">Nest<span>Brew</span></a>
  <div class="topbar-right">
    <span class="topbar-user">👋 {{ Auth::user()->name }}</span>
    <a href="{{ route('home') }}" class="topbar-btn">← Back to Site</a>
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
      @csrf
      <button type="submit" class="topbar-btn">Log Out</button>
    </form>
  </div>
</div>

<div class="page">

  <div class="page-header">
    <h1 class="page-title">Admin <em>Dashboard</em></h1>
  </div>

  @if(session('success'))
    <div class="flash">✓ {{ session('success') }}</div>
  @endif

  <!-- ── Tabs ── -->
  @php
    $pendingCount = $orders->where('status','pending')->count();
    $activeTab    = request('tab', 'menu');
  @endphp

  <div class="tabs">
    <button class="tab-btn {{ $activeTab === 'menu' ? 'active' : '' }}"
            onclick="switchTab('menu', this)">
      🍽️ Menu Items
    </button>
    <button class="tab-btn {{ $activeTab === 'orders' ? 'active' : '' }}"
            onclick="switchTab('orders', this)">
      📋 Orders
      @if($pendingCount > 0)
        <span class="tab-badge">{{ $pendingCount }}</span>
      @endif
    </button>
  </div>

  <!-- ══════════════════════════════════
       MENU ITEMS TAB
  ══════════════════════════════════ -->
  <div class="tab-panel {{ $activeTab === 'menu' ? 'active' : '' }}" id="panel-menu">

    <div class="menu-toolbar">
      <a href="{{ route('admin.menu.create') }}" class="btn btn-dark">+ Add New Item</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>Emoji</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Available</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($menuItems as $item)
        <tr>
          <td style="font-size:1.4rem;">{{ $item->emoji }}</td>
          <td>{{ $item->name }}</td>
          <td>
            <span class="cat-badge badge-{{ $item->category }}">
              {{ ucfirst($item->category) }}
            </span>
          </td>
          <td>₱{{ number_format($item->price, 2) }}</td>
          <td>{{ $item->available ? '✅ Yes' : '❌ No' }}</td>
          <td>
            <div class="actions">
              <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-mid">Edit</a>
              <form method="POST" action="{{ route('admin.menu.destroy', $item) }}"
                    onsubmit="return confirm('Delete {{ $item->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-light); padding:2.5rem;">
              No menu items yet. Add your first item!
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- ══════════════════════════════════
       ORDERS TAB
  ══════════════════════════════════ -->
  <div class="tab-panel {{ $activeTab === 'orders' ? 'active' : '' }}" id="panel-orders">

    @php
      $totalOrders = $orders->count();
      $preparing   = $orders->where('status','preparing')->count();
      $delivered   = $orders->where('status','delivered')->count();
      $revenue     = $orders->whereNotIn('status',['cancelled'])->sum('total');

      $statusLabels = [
        'pending'          => 'Pending',
        'preparing'        => 'Preparing',
        'out_for_delivery' => 'Out for Delivery',
        'delivered'        => 'Delivered',
        'cancelled'        => 'Cancelled',
      ];
    @endphp

    <!-- Stats -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $totalOrders }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value" style="color:var(--gold);">{{ $pendingCount }}</div>
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
        <div class="stat-label">Revenue</div>
        <div class="stat-value">₱{{ number_format($revenue, 2) }}</div>
      </div>
    </div>

    <!-- Filter -->
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
      <div class="order-card" data-status="{{ $order->status }}">

        <!-- Header (click to expand) -->
        <div class="order-head" onclick="toggleOrder({{ $order->id }})">
          <div>
            <div class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
            <div class="order-user">
              <strong>{{ $order->user->name }}</strong>
              <span style="color:var(--text-light);"> · {{ $order->user->email }}</span>
            </div>
          </div>

          <div class="order-meta">
            <div>{{ $order->created_at->format('M d, Y') }}</div>
            <div>{{ $order->created_at->format('h:i A') }}</div>
          </div>

          <span class="status-badge s-{{ $order->status }}">
            <span class="sdot"></span>
            {{ $statusLabels[$order->status] ?? $order->status }}
          </span>

          <div class="order-total">₱{{ number_format($order->total, 2) }}</div>
          <span class="chevron" id="chevron-{{ $order->id }}">▼</span>
        </div>

        <!-- Expanded Body -->
        <div class="order-body" id="body-{{ $order->id }}">
          <div class="body-grid">

            <!-- Items -->
            <div>
              <div class="section-label">🛒 Items Ordered</div>
              <table class="items-table">
                <thead>
                  <tr>
                    <th>Item</th><th>Qty</th><th>Price</th><th style="text-align:right;">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->items as $item)
                  <tr>
                    <td>{{ $item->emoji }} {{ $item->name }}</td>
                    <td>x{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->price, 2) }}</td>
                    <td class="sub">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Delivery + Status Update -->
            <div>
              <div class="section-label">📍 Delivery Details</div>
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
        <div class="empty-state">
          <div class="ei">📋</div>
          <p>No orders yet.</p>
        </div>
      @endforelse
    </div>

  </div><!-- /panel-orders -->

</div><!-- /page -->

<script>
  // ── Tab switching ──
  function switchTab(name, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('panel-' + name).classList.add('active');
  }

  // ── Open active tab on page load if ?tab=orders ──
  (function() {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');
    if (tab === 'orders') {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.tab-btn')[1].classList.add('active');
      document.getElementById('panel-orders').classList.add('active');
    }
  })();

  // ── Expand/collapse order ──
  function toggleOrder(id) {
    const body    = document.getElementById('body-' + id);
    const chevron = document.getElementById('chevron-' + id);
    body.classList.toggle('open');
    chevron.classList.toggle('open');
  }

  // ── Filter orders by status ──
  function filterOrders(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.order-card').forEach(card => {
      card.style.display = (status === 'all' || card.dataset.status === status) ? '' : 'none';
    });
  }
</script>
</body>
</html>