<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Venta oficial de entradas para Roig Arena y Valencia Basket Club.">
    <title>Roig Arena — Venta de Entradas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="reservation-timer" class="reservation-timer" style="display:none;">
        <span class="reservation-timer-label">Reservas seleccionadas</span>
        <span id="reservation-timer-text" class="reservation-timer-text">Se liberarán en 02:00</span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="navbar-brand">ROIG<span>·</span>ARENA</a>
            <div class="navbar-links">
                <a href="#eventos" class="nav-link" id="nav-eventos">Eventos</a>
                <a href="#entradas" class="nav-link" id="nav-mis-entradas" style="display:none;">Mis Entradas</a>
                <a href="#admin" class="nav-link" id="nav-admin" style="display:none;">Panel</a>
                <a href="#" id="btn-login-nav" class="btn btn-primary btn-sm">Acceder</a>
                <a href="#" id="btn-logout-nav" class="btn btn-ghost btn-sm" style="display:none;">Salir</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero">
        <div class="container">
            <h1 class="hero-title">Siente la Energía</h1>
            <p class="hero-subtitle">Compra tus entradas para los mejores eventos de Valencia Basket y conciertos exclusivos en el nuevo Roig Arena.</p>
            <a href="#eventos" class="btn btn-primary btn-xl">Comprar Entradas</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="section" id="eventos">
        <div class="container">
            <h2 class="display-text mb-8" style="font-size: var(--text-5xl);">Próximos Eventos</h2>
            
            <div id="events-loading" class="text-center" style="color: var(--color-arena-400); padding: var(--space-12);">
                Cargando eventos...
            </div>
            
            <div id="events-grid" class="events-grid" style="display: none;">
                <!-- Las tarjetas de eventos se inyectarán aquí vía JS -->
            </div>
            
            <!-- Contenedor para Checkout / Detalles de Evento -->
            <div id="event-detail-container" style="display: none; margin-top: var(--space-16);">
                <div class="d-flex justify-between align-center mb-8">
                    <h2 class="display-text" id="detail-title" style="font-size: var(--text-4xl);">Detalle de Evento</h2>
                    <button id="btn-back" class="btn btn-ghost btn-sm">← Volver a eventos</button>
                </div>
                
                <div class="seat-map-container">
                    <div class="text-center mb-8">
                        <h3 class="display-text" style="font-size: var(--text-2xl);">Selecciona tus Asientos</h3>
                        <p style="color: var(--color-arena-400);">Haz click en los asientos disponibles para añadirlos a tu compra</p>
                    </div>

                    <div id="sector-selector" class="sector-selector" style="display:none;"></div>
                    
                    <!-- Mapa de asientos simplificado -->
                    <div id="seat-map">
                        <!-- Generado por JS -->
                    </div>
                    
                    <div class="mt-8 text-center">
                        <button id="btn-checkout" class="btn btn-primary btn-lg" disabled>Proceder al Pago</button>
                    </div>
                </div>
            </div>
            </div>
            
            <!-- Contenedor Mis Entradas -->
            <div id="tickets-section" style="display: none; margin-top: var(--space-16);">
                <div class="d-flex justify-between align-center mb-8">
                    <h2 class="display-text" style="font-size: var(--text-5xl);">Mis Entradas</h2>
                </div>
                <div id="tickets-loading" class="text-center" style="color: var(--color-arena-400); padding: var(--space-12);">
                    Cargando entradas...
                </div>
                <div id="tickets-grid" class="events-grid" style="display: none;">
                    <!-- Entradas inyectadas por JS -->
                </div>
            </div>

            <!-- Panel de Control Admin -->
            <section id="admin-panel" class="admin-panel" style="display: none; margin-top: var(--space-20);">
                <div class="admin-hero">
                    <div>
                        <div class="admin-badge">Funciones reservadas</div>
                        <h2 class="display-text" style="font-size: var(--text-5xl);">Panel de Control</h2>
                        <p class="admin-subtitle">Gestiona eventos y sectores con acciones exclusivas de administrador.</p>
                    </div>
                    <div class="admin-feedback" id="admin-feedback" data-type="info">Panel listo.</div>
                </div>

                <div class="admin-grid">
                    <article class="admin-card">
                        <div class="admin-card-header">
                            <h3 class="admin-card-title">Eventos</h3>
                            <span class="admin-card-tag">Crear / Editar</span>
                        </div>
                        <form id="admin-event-form" class="admin-form" data-mode="create" data-editing-id="">
                            <h4 class="admin-form-title" data-admin-form-title>Crear evento</h4>
                            <div class="admin-form-grid">
                                <label class="admin-field">
                                    <span>Nombre</span>
                                    <input type="text" id="admin-event-nombre" placeholder="Nombre del evento" required>
                                </label>
                                <label class="admin-field">
                                    <span>Fecha</span>
                                    <input type="date" id="admin-event-fecha" required>
                                </label>
                                <label class="admin-field">
                                    <span>Hora</span>
                                    <input type="time" id="admin-event-hora" required>
                                </label>
                                <label class="admin-field">
                                    <span>Poster URL</span>
                                    <input type="url" id="admin-event-poster" placeholder="https://">
                                </label>
                                <label class="admin-field admin-field-wide">
                                    <span>Descripcion corta</span>
                                    <input type="text" id="admin-event-desc-corta" placeholder="Resumen breve">
                                </label>
                                <label class="admin-field admin-field-wide">
                                    <span>Descripcion larga</span>
                                    <textarea id="admin-event-desc-larga" rows="3" placeholder="Detalle completo"></textarea>
                                </label>
                            </div>
                            <div class="admin-form-actions">
                                <button type="button" class="btn btn-ghost btn-sm" id="admin-event-cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary btn-sm">Crear evento</button>
                            </div>
                        </form>
                        <div class="admin-list" id="admin-events-list"></div>
                    </article>

                    <article class="admin-card">
                        <div class="admin-card-header">
                            <h3 class="admin-card-title">Sectores</h3>
                            <span class="admin-card-tag">Crear / Editar</span>
                        </div>
                        <form id="admin-sector-form" class="admin-form" data-mode="create" data-editing-id="">
                            <h4 class="admin-form-title" data-admin-form-title>Crear sector</h4>
                            <div class="admin-form-grid">
                                <label class="admin-field">
                                    <span>Nombre</span>
                                    <input type="text" id="admin-sector-nombre" placeholder="Sector Principal" required>
                                </label>
                                <label class="admin-field">
                                    <span>Descripcion</span>
                                    <input type="text" id="admin-sector-descripcion" placeholder="Zona baja">
                                </label>
                                <label class="admin-field">
                                    <span>Asientos disponibles</span>
                                    <input type="number" id="admin-sector-asientos-total" min="1" step="1" placeholder="120" required>
                                </label>
                                <label class="admin-field">
                                    <span>Precio base</span>
                                    <input type="number" id="admin-sector-precio-base" min="0.01" step="0.01" placeholder="50.00" required>
                                </label>
                                <label class="admin-field admin-field-inline">
                                    <input type="checkbox" id="admin-sector-activo" checked>
                                    <span>Activo</span>
                                </label>
                            </div>
                            <div class="admin-form-actions">
                                <button type="button" class="btn btn-ghost btn-sm" id="admin-sector-cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary btn-sm">Crear sector</button>
                            </div>
                        </form>
                        <div class="admin-list" id="admin-sectors-list"></div>
                    </article>
                </div>
            </section>
        </div>
    </main>
    
    <footer style="background: var(--color-arena-800); padding: var(--space-8) 0; margin-top: var(--space-16); border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container text-center" style="color: var(--color-arena-400);">
            <p class="mb-4">ROIG·ARENA © 2026</p>
            <p style="font-size: var(--text-sm);">Sistema oficial de ticketing de Valencia Basket</p>
        </div>
    </footer>
    </footer>

    <!-- Auth Modal -->
    <div class="modal-overlay" id="auth-modal">
        <div class="modal-content">
            <button class="modal-close" id="close-modal">✕</button>
            
            <div class="tabs">
                <button class="tab-btn active" data-target="login-form">Iniciar Sesión</button>
                <button class="tab-btn" data-target="register-form">Registrarse</button>
            </div>
            
            <!-- Login Form -->
            <form id="login-form" class="tab-content active">
                <div class="form-group">
                    <label class="form-label" for="login-email">Email</label>
                    <input type="email" id="login-email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="login-password">Contraseña</label>
                    <input type="password" id="login-password" class="form-input" required>
                </div>
                <div id="login-error" class="mb-4 text-center" style="color: var(--color-error); font-size: var(--text-sm); display:none;"></div>
                <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Entrar</button>
            </form>
            
            <!-- Register Form -->
            <form id="register-form" class="tab-content">
                <div class="form-group">
                    <label class="form-label" for="register-name">Nombre</label>
                    <input type="text" id="register-name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="register-email">Email</label>
                    <input type="email" id="register-email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="register-password">Contraseña</label>
                    <input type="password" id="register-password" class="form-input" required minlength="8">
                </div>
                <div id="register-error" class="mb-4 text-center" style="color: var(--color-error); font-size: var(--text-sm); display:none;"></div>
                <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Crear Cuenta</button>
            </form>
        </div>
    </div>
</body>
</html>
