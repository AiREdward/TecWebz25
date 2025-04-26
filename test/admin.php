<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pannello di amministrazione - Gestione utenti, prodotti e statistiche del sistema">
    <title>Pannello Amministratore</title>

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
        </nav>

        <main class="main-content">
            
            <section id="users" class="section">
                <div class="section-header">
                    <h2><i class="fas fa-users"></i> Gestione Utenti</h2>
                    <p>Gestisci gli utenti del sistema</p>
                </div>
                <div class="card">
                    <div class="action-bar">
                        <div class="filter-group">
                            <input type="search" placeholder="Cerca utenti...">
                        </div>
                    </div>
                    <div class="users-list">
                        <?php foreach ($users as $user): ?>
                            <div class="user-item">
                                <div class="user-info-main">
                                    <div class="user-name"><?= htmlspecialchars($user->username) ?></div>
                                    <div class="user-email"><?= htmlspecialchars($user->email) ?></div>
                                </div>
                                <div class="user-details">
                                    <div class="user-role"><?= ucfirst($user->ruolo) ?></div>
                                    <div class="user-status"><?= ucfirst($user->stato) ?></div>
                                </div>
                                <div class="user-actions">
                                    <button class="btn-icon delete-user" data-id="<?= $user->id ?>" title="Elimina"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    </div>
            </section>

            <section id="products" class="section hidden">
                <div class="section-header">
                    <h2><i class="fas fa-shopping-cart"></i> Articoli Shop</h2>
                    <p>Gestisci l'inventario dei prodotti</p>
                </div>
                <div class="card">
                    <div class="product-tabs">
                        <button class="tab-btn active" data-tab="add-product"><i class="fas fa-plus"></i> Aggiungi Nuovo Prodotto</button>
                        <button class="tab-btn" data-tab="edit-product"><i class="fas fa-edit"></i> Modifica Prodotto</button>
                        <button class="tab-btn" data-tab="delete-product"><i class="fas fa-trash"></i> Elimina Prodotto</button>
                    </div>
                    
                    <div id="add-product" class="tab-content active">
                        <form id="add-product-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product-title">Titolo Gioco</label>
                                <input type="text" id="product-title" name="nome" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="product-price">Prezzo (€)</label>
                                    <input type="number" id="product-price" name="prezzo" min="0" step="0.01" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product-trade-price">Prezzo Ritiro Usato (€)</label>
                                    <input type="number" id="product-trade-price" name="prezzo_ritiro_usato" min="0" step="0.01" required>
                                    <small>Imposta a 0 se il ritiro usato non è disponibile</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product-genre">Genere</label>
                                    <select id="product-genre" name="genere" required>
                                        <option value="">Seleziona un genere</option>
                                        <option value="azione">Azione</option>
                                        <option value="gioco di ruolo">Giochi di Ruolo</option>
                                        <option value="strategia">Strategia</option>
                                        <option value="sport">Sport</option>
                                        <option value="avventura">Avventura</option>
                                        <option value="piattaforma">Piattaforme</option>
                                        <option value="carta regalo">Carte Regalo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-image">Immagine Prodotto</label>
                                <input type="file" id="product-image" name="immagine" accept="image/*" required>
                                <div id="image-preview" class="image-preview">L'anteprima dell'immagine apparirà qui</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-description">Descrizione</label>
                                <textarea id="product-description" name="descrizione" rows="4" required></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Salva Prodotto</button>
                            </div>
                        </form>
                    </div>
                    
                    <div id="edit-product" class="tab-content">

                            <div class="product-grid">
                                    <div class="product-header">
                                        <div class="product-cell">Seleziona</div>
                                        <div class="product-cell"><abbr title="Identificatore">ID</abbr></div>
                                        <div class="product-cell">Nome</div>
                                        <div class="product-cell">Prezzo</div>
                                        <div class="product-cell">Genere</div>
                                    </div>
                                    <div id="edit-products-list" class="product-body">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" id="edit-selected-product" class="btn-primary">Modifica il prodotto selezionato</button>
                            </div>
                        </div>
                        

                        <div id="edit-form-container">

                            <form id="edit-product-form" enctype="multipart/form-data">
                                <input type="hidden" id="edit-product-id" name="id">
                                <input type="hidden" id="current-image-path" name="current_image">
                                
                                <div class="form-group">
                                    <label for="edit-product-title">Titolo Prodotto</label>
                                    <input type="text" id="edit-product-title" name="nome" required>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="edit-product-price">Prezzo (€)</label>
                                        <input type="number" id="edit-product-price" name="prezzo" step="0.01" min="0" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit-product-trade-price">Prezzo Ritiro Usato (€)</label>
                                        <input type="number" id="edit-product-trade-price" name="prezzo_ritiro_usato" step="0.01" min="0" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit-product-genre">Genere</label>
                                        <select id="edit-product-genre" name="genere" required>
                                            <option value="azione">Azione</option>
                                            <option value="avventura">Avventura</option>
                                            <option value="gioco di ruolo">Gioco di Ruolo</option>
                                            <option value="strategia">Strategia</option>
                                            <option value="sport">Sport</option>
                                            <option value="piattaforma">Piattaforma</option>
                                            <option value="carta regalo">Carta Regalo</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="edit-product-description">Descrizione</label>
                                    <textarea id="edit-product-description" name="descrizione" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="edit-product-image">Immagine Prodotto</label>
                                    <input type="file" id="edit-product-image" name="immagine" accept="image/*">
                                    <div id="edit-image-preview" class="image-preview"></div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="button" id="back-to-search" class="btn btn-secondary">Indietro</button>
                                    <button type="submit" class="btn btn-primary">Aggiorna Prodotto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div id="delete-product" class="tab-content">
                        <div class="form-group">
                            <label for="search-product-delete">Cerca Prodotto</label>
                            <input type="text" id="search-product-delete" name="search-product" placeholder="Inserisci il nome del prodotto da cercare">
                        </div>
                        
                        <div class="product-search-results">
                            <div class="product-grid">
                                <div class="product-header">
                                    <div class="product-cell">Seleziona</div>
                                    <div class="product-cell"><abbr title="Identificatore">ID</abbr></div>
                                    <div class="product-cell">Nome</div>
                                    <div class="product-cell">Prezzo</div>
                                    <div class="product-cell">Genere</div>
                                </div>
                                <div id="delete-products-list" class="product-body">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" id="delete-selected-products" class="btn-primary">Elimina gli elementi selezionati</button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="statistics" class="section hidden">
                <div class="section-header">
                    <h2><i class="fas fa-chart-bar"></i> Statistiche</h2>
                    <p>Panoramica delle metriche aziendali</p>
                </div>
                <div class="statistiche-container">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Utenti Totali</h3>
                            <p class="stat-number"><?php echo $statistics['total_users']; ?></p>
                            <p class="stat-change positive">
                                <i class="fa fa-circle" aria-hidden="true"></i> Attivi: <?php echo $statistics['active_users']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Prodotti Totali</h3>
                            <p class="stat-number"><?php echo $statistics['total_products']; ?></p>
                            <p class="stat-change positive">
                                <i class="fa fa-circle" aria-hidden="true"></i> In catalogo
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Vendite Totali</h3>
                            <p class="stat-number"><?php echo $statistics['total_sales']; ?></p>
                            <p class="stat-change positive">
                                <i class="fa fa-circle" aria-hidden="true"></i> Ordini completati
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Prodotti Venduti</h3>
                            <p class="stat-number"><?php echo $statistics['total_products_sold']; ?></p>
                            <p class="stat-change positive">
                                <i class="fa fa-circle" aria-hidden="true"></i> Articoli
                            </p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Incasso Totale</h3>
                            <p class="stat-number"><?php echo $statistics['total_revenue']; ?> €</p>
                            <p class="stat-change positive">
                                <i class="fa fa-circle" aria-hidden="true"></i> Fatturato
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
