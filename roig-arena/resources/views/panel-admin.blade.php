<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de administración de Roig Arena.">
    <title>Roig Arena — Panel de Administración</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-page="admin">
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="navbar-brand">ROIG<span>·</span>ARENA</a>
            <div class="navbar-links">
                <a href="/" class="nav-link">Volver a eventos</a>
                <a href="#" id="btn-logout-nav" class="btn btn-ghost btn-sm">Salir</a>
            </div>
        </div>
    </nav>

    <main class="section" style="padding-top: 104px;">
        <div class="container">
            <section id="admin-panel" class="admin-panel is-active" style="margin-top: 0;">
                <div class="admin-hero">
                    <div>
                        <div class="admin-badge">Funciones reservadas</div>
                        <h1 class="display-text" style="font-size: var(--text-5xl);">Panel de Control</h1>
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
</body>
</html>