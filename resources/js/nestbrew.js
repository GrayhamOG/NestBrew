// ── Menu Data ──────────────────────────────────────────────────
const menuItems = [
  { name:'Signature Nest Latte',   emoji:'☕', desc:'Espresso, steamed oat milk & our secret house syrup.',      price:'₱145', cat:'coffee'    },
  { name:'Caramel Flat White',     emoji:'🥛', desc:'Double ristretto with silky caramel-infused steamed milk.',  price:'₱155', cat:'coffee'    },
  { name:'Cold Brew Float',        emoji:'🧊', desc:'18-hour cold brew topped with salted cream foam.',           price:'₱165', cat:'coffee'    },
  { name:'Hazelnut Americano',     emoji:'☕', desc:'Bold espresso shots with hazelnut and hot water.',           price:'₱135', cat:'coffee'    },
  { name:'Matcha Latte',           emoji:'🍵', desc:'Ceremonial-grade matcha with steamed milk & honey.',         price:'₱150', cat:'noncoffee' },
  { name:'Strawberry Milk Tea',    emoji:'🍓', desc:'Fresh strawberry puree blended with creamy milk tea.',       price:'₱145', cat:'noncoffee' },
  { name:'Brown Sugar Taro',       emoji:'🧋', desc:'Taro milk tea with brown sugar pearls and fresh cream.',     price:'₱155', cat:'noncoffee' },
  { name:'Honey Chamomile',        emoji:'🌼', desc:'Calming chamomile with wildflower honey and lemon.',         price:'₱120', cat:'noncoffee' },
  { name:'Almond Croissant',       emoji:'🥐', desc:'Buttery laminated dough filled with almond frangipane.',    price:'₱95',  cat:'pastry'   },
  { name:'Cinnamon Roll',          emoji:'🍩', desc:'Soft-baked with cream cheese glaze and cinnamon sugar.',    price:'₱110', cat:'pastry'   },
  { name:'Blueberry Scone',        emoji:'🫐', desc:'Crumbly scone bursting with fresh blueberries & lemon.',    price:'₱90',  cat:'pastry'   },
  { name:'Chocolate Lava Cake',    emoji:'🍫', desc:'Warm chocolate cake with a molten dark chocolate center.',  price:'₱135', cat:'pastry'   },
  { name:'Avocado Toast',          emoji:'🥑', desc:'Sourdough, smashed avocado, poached egg & chili flakes.',   price:'₱185', cat:'food'     },
  { name:'Eggs Benedict',          emoji:'🍳', desc:'Poached eggs on brioche with hollandaise & smoked bacon.',  price:'₱220', cat:'food'     },
  { name:'Nest Club Sandwich',     emoji:'🥪', desc:'Grilled chicken, bacon, egg & greens on toasted bread.',    price:'₱195', cat:'food'     },
  { name:'Mushroom Pasta',         emoji:'🍝', desc:'Creamy garlic pasta with wild mushrooms & parmesan.',       price:'₱210', cat:'food'     },
];

function renderMenu(items) {
  const grid = document.getElementById('menu-grid');
  grid.innerHTML = items.map(item => `
    <div class="menu-card">
      <span class="menu-card-emoji">${item.emoji}</span>
      <div class="menu-card-name">${item.name}</div>
      <div class="menu-card-desc">${item.desc}</div>
      <div class="menu-card-footer">
        <span class="menu-card-price">${item.price}</span>
        <button class="menu-card-add" onclick="addToCart('${item.name}')" title="Add to cart">+</button>
      </div>
    </div>
  `).join('');
}

function filterMenu(cat, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  const filtered = cat === 'all' ? menuItems : menuItems.filter(i => i.cat === cat);
  renderMenu(filtered);
}

function addToCart(name) {
  showToast(`Added "${name}" to your cart ☕`);
}

renderMenu(menuItems);

// ── Modal ──────────────────────────────────────────────────────
function openModal(tab) {
  document.getElementById('modal-overlay').classList.add('open');
  document.body.style.overflow = 'hidden';
  switchTab(tab);
}
function closeModal() {
  document.getElementById('modal-overlay').classList.remove('open');
  document.body.style.overflow = '';
}
function handleOverlayClick(e) {
  if (e.target === document.getElementById('modal-overlay')) closeModal();
}
function switchTab(tab) {
  document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + tab).classList.add('active');
  document.getElementById('panel-' + tab).classList.add('active');
}
function handleAuth(type) {
  const msg = type === 'signin'
    ? 'Welcome back to NestBrew! ☕'
    : 'Account created! Welcome to NestBrew 🎉';
  closeModal();
  showToast(msg);
}

// ── Toast ──────────────────────────────────────────────────────
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}

// ── Nav scroll ─────────────────────────────────────────────────
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
});

// ── Keyboard close ─────────────────────────────────────────────
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});
