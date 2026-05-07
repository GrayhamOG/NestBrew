<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Admin — Menu Items</title>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Jost', sans-serif; background: #F5EFE6; color: #2C1A0E; padding: 2rem; }
    .container { max-width: 1000px; margin: 0 auto; }
    h1 { font-size: 1.8rem; margin-bottom: 1.5rem; color: #4E2E14; }
    .btn { padding: 0.5rem 1.2rem; border-radius: 4px; border: none; cursor: pointer; font-family: 'Jost', sans-serif; font-size: 0.85rem; text-decoration: none; display: inline-block; }
    .btn-add  { background: #4E2E14; color: #F5EFE6; margin-bottom: 1.5rem; }
    .btn-edit { background: #A0785A; color: white; }
    .btn-del  { background: #9e3f4e; color: white; }
    .alert    { background: #d4edda; color: #155724; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem; }
    table { width: 100%; background: white; border-radius: 8px; overflow: hidden; border-collapse: collapse; }
    th { background: #4E2E14; color: #F5EFE6; padding: 0.9rem 1rem; text-align: left; font-weight: 500; font-size: 0.85rem; }
    td { padding: 0.85rem 1rem; border-bottom: 1px solid #EDE0CE; font-size: 0.9rem; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #FAF6F1; }
    .actions { display: flex; gap: 0.5rem; }
    .badge { padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; }
    .badge-coffee    { background: #D9C9B0; color: #4E2E14; }
    .badge-noncoffee { background: #D4EDDA; color: #155724; }
    .badge-pastry    { background: #FDE8D0; color: #7B3F00; }
    .badge-food      { background: #D0E8FD; color: #00407B; }
  </style>
</head>
<body>
<div class="container">
  <h1>🍽️ Menu Items</h1>

  @if(session('success'))
    <div class="alert">{{ session('success') }}</div>
  @endif

  <a href="{{ route('admin.menu.create') }}" class="btn btn-add">+ Add New Item</a>
  <a href="{{ route('home') }}" class="btn" style="background:#A0785A;color:white;margin-left:8px;">← Back to Site</a>

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
        <td style="font-size:1.5rem;">{{ $item->emoji }}</td>
        <td>{{ $item->name }}</td>
        <td>
          <span class="badge badge-{{ $item->category }}">
            {{ ucfirst($item->category) }}
          </span>
        </td>
        <td>₱{{ number_format($item->price, 2) }}</td>
        <td>{{ $item->available ? '✅ Yes' : '❌ No' }}</td>
        <td>
          <div class="actions">
            <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-edit">Edit</a>
            <form method="POST" action="{{ route('admin.menu.destroy', $item) }}"
                  onsubmit="return confirm('Delete {{ $item->name }}?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-del">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center; color:#A0785A; padding:2rem;">
            No menu items yet. Add your first item!
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
</body>
</html>