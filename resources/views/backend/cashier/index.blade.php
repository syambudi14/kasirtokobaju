<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier POS | Premium Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon-small">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.91 8.84 10 12l.91-9.16a1 1 0 0 1 1.62-.06L22.5 12h-12"></path><path d="M2 19h20"></path><path d="M9 19v-4.36a3 3 0 1 1 6 0V19"></path></svg>
                </div>
                <h2>POS System</h2>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ url('/dashboard') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/cashier') }}" class="nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <span>Cashier</span>
                </a>
                <a href="{{ url('/products') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <span>Products</span>
                </a>
                <a href="#" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                    <span>Reports</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ url('/logout') }}" class="nav-item logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content (POS Split) -->
        <main class="main-content pos-layout">
            <!-- Left: Products -->
            <div class="pos-products-area">
                <header class="top-bar pos-header">
                    <div class="search-bar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search products...">
                    </div>
                </header>

                <div class="categories-bar">
                    <button class="category-chip active">All Items</button>
                    <button class="category-chip">T-Shirts</button>
                    <button class="category-chip">Jeans</button>
                    <button class="category-chip">Jackets</button>
                    <button class="category-chip">Shoes</button>
                    <button class="category-chip">Accessories</button>
                </div>

                <div class="products-grid">
                    <!-- Product Card 1 -->
                    <div class="product-card">
                        <div class="product-image">
                            <!-- Placeholder for product image -->
                            <div class="img-placeholder" style="background: #4f46e5;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Denim Jacket</h4>
                            <p class="price">Rp 450,000</p>
                        </div>
                    </div>
                    <!-- Product Card 2 -->
                    <div class="product-card">
                        <div class="product-image">
                            <div class="img-placeholder" style="background: #ec4899;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Classic T-Shirt</h4>
                            <p class="price">Rp 120,000</p>
                        </div>
                    </div>
                    <!-- Product Card 3 -->
                    <div class="product-card">
                        <div class="product-image">
                            <div class="img-placeholder" style="background: #10b981;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Slim Fit Jeans</h4>
                            <p class="price">Rp 350,000</p>
                        </div>
                    </div>
                    <!-- Product Card 4 -->
                    <div class="product-card">
                        <div class="product-image">
                            <div class="img-placeholder" style="background: #f59e0b;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Running Shoes</h4>
                            <p class="price">Rp 650,000</p>
                        </div>
                    </div>
                    <!-- Product Card 5 -->
                    <div class="product-card">
                        <div class="product-image">
                            <div class="img-placeholder" style="background: #8b5cf6;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Cotton Cap</h4>
                            <p class="price">Rp 75,000</p>
                        </div>
                    </div>
                     <!-- Product Card 6 -->
                     <div class="product-card">
                        <div class="product-image">
                            <div class="img-placeholder" style="background: #06b6d4;"></div>
                        </div>
                        <div class="product-details">
                            <h4>Leather Wallet</h4>
                            <p class="price">Rp 250,000</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Cart -->
            <aside class="pos-cart-panel">
                <div class="cart-header">
                    <h3>Current Order</h3>
                    <button class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" x2="20" y1="8" y2="14"/><line x1="23" x2="17" y1="11" y2="11"/></svg>
                    </button>
                </div>

                <div class="cart-items">
                    <!-- Cart Item 1 -->
                    <div class="cart-item">
                        <div class="item-info">
                            <h4>Denim Jacket</h4>
                            <p>Rp 450,000</p>
                        </div>
                        <div class="item-qty">
                            <button class="btn-qty">-</button>
                            <span>1</span>
                            <button class="btn-qty">+</button>
                        </div>
                    </div>
                    <!-- Cart Item 2 -->
                    <div class="cart-item">
                        <div class="item-info">
                            <h4>Classic T-Shirt</h4>
                            <p>Rp 120,000</p>
                        </div>
                        <div class="item-qty">
                            <button class="btn-qty">-</button>
                            <span>2</span>
                            <button class="btn-qty">+</button>
                        </div>
                    </div>
                </div>

                <div class="cart-footer">
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp 690,000</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span>Rp 69,000</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>Rp 759,000</span>
                        </div>
                    </div>
                    <div class="cart-actions">
                        <button class="btn-action secondary">Hold Order</button>
                        <button class="btn-action primary">Pay Now</button>
                    </div>
                </div>
            </aside>
        </main>
    </div>
</body>
</html>
