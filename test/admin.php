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
                                    <h3><?= htmlspecialchars($user->username) ?></h3>
                                    <span class="badge <?= $user->stato == 'attivo' ? 'badge-success' : 'badge-danger' ?>">
                                        <?= ucfirst($user->stato) ?>
                                    </span>
                                </div>
                                <div class="user-info">
                                    <p class="user-email"> <?= htmlspecialchars($user->email) ?></p>
                                    <span class="badge badge-primary"> <?= ucfirst($user->ruolo) ?></span>
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
                    <h3><i class="fas fa-plus"></i> Add New Product</h3>
                    <form id="add-product-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product-title">Game Title</label>
                            <input type="text" id="product-title" name="nome" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-price">Price (€)</label>
                            <input type="number" id="product-price" name="prezzo" min="0" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-trade-price">Trade-in Price (€)</label>
                            <input type="number" id="product-trade-price" name="prezzo_ritiro_usato" min="0" step="0.01" required>
                            <small>Set to 0 if trade-in is not available</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-genre">Genre</label>
                            <select id="product-genre" name="genere" required>
                                <option value="">Select a genre</option>
                                <option value="azione">Azione</option>
                                <option value="gioco di ruolo">Giochi di Ruolo</option>
                                <option value="strategia">Strategia</option>
                                <option value="sport">Sport</option>
                                <option value="avventura">Avventura</option>
                                <option value="piattaforma">Piattaforme</option>
                                <option value="carta regalo">Carte Regalo</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-image">Product Image</label>
                            <input type="file" id="product-image" name="immagine" accept="image/*" required>
                            <div id="image-preview" class="image-preview">Image preview will appear here</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-description">Description</label>
                            <textarea id="product-description" name="descrizione" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Product</button>
                        </div>
                    </form>
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
