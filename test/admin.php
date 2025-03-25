<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>


    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="test/adminStyle.css">
</head>
<body>
    <div class="admin-container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Admin</h2>
            </div>
            <ul class="nav-links">
                <li><a href="#users" class="active"><i class="fas fa-users"></i> Utenti</a></li>
                <li><a href="#products"><i class="fas fa-shopping-cart"></i> Articoli Shop</a></li>
                <li><a href="#statistics"><i class="fas fa-chart-bar"></i> Statistiche</a></li>
            </ul>
            <div class="user-info">
                <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin" class="avatar">
                <div class="user-details">
                    <h4>Admin User</h4>
                    <p>Super Admin</p>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="search" placeholder="Search...">
                </div>
            </header>

            <section id="users" class="section">
    <div class="section-header">
        <h2><i class="fas fa-users"></i> Gestione Utenti</h2>
        <p>Manage your system users</p>
    </div>
    <div class="card">
        <div class="action-bar">
            <div class="filter-group">
                <select class="filter-select">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <input type="search" placeholder="Search users...">
            </div>
        </div>
        <div class="users-grid">
            <?php foreach ($users as $user): ?>
                <div class="user-card">
                    <div class="user-header">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->username) ?>" alt="<?= htmlspecialchars($user->username) ?>" class="user-avatar">
                        <span class="badge <?= $user->stato == 'attivo' ? 'badge-success' : 'badge-danger' ?>">
                            <?= ucfirst($user->stato) ?>
                        </span>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($user->username) ?></h3>
                        <p class="user-email"><?= htmlspecialchars($user->email) ?></p>
                        <span class="badge badge-primary"><?= ucfirst($user->ruolo) ?></span>
                    </div>
                    <div class="user-actions">
                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                        <button class="btn-icon" title="More"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


            <section id="products" class="section hidden">
                <div class="section-header">
                    <h2><i class="fas fa-shopping-cart"></i> Shop Articles</h2>
                    <p>Manage your product inventory</p>
                </div>
                <div class="card">
                    <div class="action-bar">
                        <button class="btn-primary"><i class="fas fa-plus"></i> Add New Product</button>
                        <div class="filter-group">
                            <select class="filter-select">
                                <option value="">All Categories</option>
                                <option value="electronics">Electronics</option>
                                <option value="clothing">Clothing</option>
                            </select>
                            <input type="search" placeholder="Search products...">
                        </div>
                    </div>
                    <div class="products-grid">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="product-info">
                                <h3>Premium Headphones</h3>
                                <p class="product-category">Electronics</p>
                                <div class="product-price">
                                    <span class="current-price">$99.99</span>
                                    <span class="original-price">$129.99</span>
                                </div>
                                <div class="product-stats">
                                    <span><i class="fas fa-box"></i> Stock: 45</span>
                                    <span><i class="fas fa-star"></i> 4.5</span>
                                </div>
                            </div>
                            <div class="product-actions">
                                <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                <button class="btn-icon" title="More"><i class="fas fa-ellipsis-v"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="statistics" class="section hidden">
                <div class="section-header">
                    <h2><i class="fas fa-chart-bar"></i> Statistics</h2>
                    <p>Overview of your business metrics</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Users</h3>
                            <p class="stat-number">1,234</p>
                            <p class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Products</h3>
                            <p class="stat-number">567</p>
                            <p class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> 8.3%
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Sales</h3>
                            <p class="stat-number">$12,345</p>
                            <p class="stat-change negative">
                                <i class="fas fa-arrow-down"></i> 3.2%
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Active Users</h3>
                            <p class="stat-number">890</p>
                            <p class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> 5.7%
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script type="module" src="test/main.js"></script>
</body>
</html>
