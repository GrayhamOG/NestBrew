<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Edit Menu Item</title>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Jost', sans-serif; background: #F5EFE6; color: #2C1A0E; padding: 2rem; }
    .container { max-width: 600px; margin: 0 auto; }
    h1 { font-size: 1.8rem; margin-bottom: 1.5rem; color: #4E2E14; }
    .card { background: white; padding: 2rem; border-radius: 8px; }
    .form-group { margin-bottom: 1.25rem; }
    label { display: block; font-size: 0.8rem; letter-spacing: 0.1em; text-transform: uppercase; color: #8A6748; margin-bottom: 0.5rem; }
    input, select, textarea {
      width: 100%; padding: 0.75rem 1rem; border: 1px solid #D9C9B0;
      border-radius: 4px; font-family: 'Jost', sans-serif; font-size: 0.95rem;
      background: #FAF6F1; color: #2C1A0E; outline: none;
    }
    input:focus, select:focus, textarea:focus { border-color: #A0785A; }
    textarea { height: 100px; resize: vertical; }
    .error { color: #9e3f4e; font-size: 0.8rem; margin-top: 4px; }
    .btn { padding: 0.75rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-family: 'Jost', sans-serif; font-size: 0.9rem; text-decoration: none; display: inline-block; }
    .btn-save   { background: #4E2E14; color: #F5EFE6; }
    .btn-cancel { background: transparent; border: 1px solid #A0785A; color: #A0785A; margin-left: 8px; }
    .row { display: flex; gap: 1rem; }
    .row .form-group { flex: 1; }
  </style>
</head>
<body>
<div class="container">
  <h1>✏️ Edit — {{ $menuItem->name }}</h1>
  <div class="card">
    <form method="POST" action="{{ route('admin.menu.update', $menuItem) }}">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="form-group">
          <label>Item Name</label>
          <input type="text" name="name"
                 value="{{ old('name', $menuItem->name) }}" required/>
          @error('name')<p class="error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label>Emoji</label>
          <input type="text" name="emoji"
                 value="{{ old('emoji', $menuItem->emoji) }}" maxlength="10"/>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label>Category</label>
          <select name="category" required>
            <option value="coffee"    {{ old('category', $menuItem->category)=='coffee'    ? 'selected':'' }}>Coffee</option>
            <option value="noncoffee" {{ old('category', $menuItem->category)=='noncoffee' ? 'selected':'' }}>Non-Coffee</option>
            <option value="pastry"    {{ old('category', $menuItem->category)=='pastry'    ? 'selected':'' }}>Pastry</option>
            <option value="food"      {{ old('category', $menuItem->category)=='food'      ? 'selected':'' }}>Food</option>
          </select>
        </div>
        <div class="form-group">
          <label>Price (₱)</label>
          <input type="number" name="price"
                 value="{{ old('price', $menuItem->price) }}"
                 min="0" step="0.01" required/>
          @error('price')<p class="error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description">{{ old('description', $menuItem->description) }}</textarea>
      </div>

      <div class="form-group">
        <label>Available</label>
        <select name="available">
          <option value="1" {{ old('available', $menuItem->available)=='1' ? 'selected':'' }}>Yes</option>
          <option value="0" {{ old('available', $menuItem->available)=='0' ? 'selected':'' }}>No</option>
        </select>
      </div>

      <button type="submit" class="btn btn-save">Update Item</button>
      <a href="{{ route('admin.menu.index') }}" class="btn btn-cancel">Cancel</a>
    </form>
  </div>
</div>
</body>
</html>