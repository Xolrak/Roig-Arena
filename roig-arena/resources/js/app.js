document.addEventListener('DOMContentLoaded', () => {
    
    // UI Elements
    const navbar = document.getElementById('navbar');
    const btnLoginNav = document.getElementById('btn-login-nav');
    const btnLogoutNav = document.getElementById('btn-logout-nav');
    const navEventos = document.getElementById('nav-eventos');
    const navMisEntradas = document.getElementById('nav-mis-entradas');
    const navAdmin = document.getElementById('nav-admin');
    
    const eventsGrid = document.getElementById('events-grid');
    const loadingEl = document.getElementById('events-loading');
    
    const detailContainer = document.getElementById('event-detail-container');
    const detailTitle = document.getElementById('detail-title');
    const btnBack = document.getElementById('btn-back');
    const seatMap = document.getElementById('seat-map');
    const btnCheckout = document.getElementById('btn-checkout');
    
    const ticketsSection = document.getElementById('tickets-section');
    const ticketsGrid = document.getElementById('tickets-grid');
    const ticketsLoading = document.getElementById('tickets-loading');

    const adminPanel = document.getElementById('admin-panel');
    const adminEventsList = document.getElementById('admin-events-list');
    const adminSectorsList = document.getElementById('admin-sectors-list');
    const adminEventForm = document.getElementById('admin-event-form');
    const adminSectorForm = document.getElementById('admin-sector-form');
    const adminEventCancel = document.getElementById('admin-event-cancel');
    const adminSectorCancel = document.getElementById('admin-sector-cancel');
    const adminFeedback = document.getElementById('admin-feedback');

    const authModal = document.getElementById('auth-modal');
    const closeModal = document.getElementById('close-modal');
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    let currentUser = null;
    let selectedEventId = null;
    let currentReservations = [];

    // Helper: Headers
    function getHeaders() {
        const headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
        const token = localStorage.getItem('auth_token');
        if (token) headers['Authorization'] = `Bearer ${token}`;
        return headers;
    }

    // Scroll Navbar
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) navbar.style.background = 'rgba(10,11,12,0.96)';
        else navbar.style.background = 'rgba(10,11,12,0.92)';
    });

    // 1. AUTH STATE
    async function checkAuth() {
        if (!localStorage.getItem('auth_token')) return updateNavState(false);
        try {
            const res = await fetch('/api/user', { headers: getHeaders() });
            if (res.ok) {
                const data = await res.json();
                currentUser = data.data || data;
                updateNavState(true);
                if (currentUser.is_admin) {
                    showView('admin');
                }
            } else {
                localStorage.removeItem('auth_token');
                updateNavState(false);
            }
        } catch (e) {
            console.error('Error fetching user', e);
        }
    }

    function updateNavState(isLogged) {
        if (isLogged) {
            btnLoginNav.style.display = 'none';
            btnLogoutNav.style.display = 'inline-flex';
            navMisEntradas.style.display = 'block';
            if (navAdmin) {
                navAdmin.style.display = currentUser && currentUser.is_admin ? 'block' : 'none';
            }
        } else {
            btnLoginNav.style.display = 'inline-flex';
            btnLogoutNav.style.display = 'none';
            navMisEntradas.style.display = 'none';
            if (navAdmin) {
                navAdmin.style.display = 'none';
            }
            showView('eventos');
        }
    }

    if (btnLogoutNav) {
        btnLogoutNav.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                await fetch('/api/logout', { method: 'POST', headers: getHeaders() });
            } catch(e) {}
            localStorage.removeItem('auth_token');
            currentUser = null;
            updateNavState(false);
        });
    }

    if (navAdmin) {
        navAdmin.addEventListener('click', (e) => {
            e.preventDefault();
            showView('admin');
        });
    }

    // Modal Logic
    if (btnLoginNav) {
        btnLoginNav.addEventListener('click', (e) => { 
            e.preventDefault(); 
            authModal.classList.add('active'); 
        });
    }
    
    if (closeModal) {
        closeModal.addEventListener('click', () => authModal.classList.remove('active'));
    }

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.getAttribute('data-target')).classList.add('active');
        });
    });

    // Forms
    const loginForm = document.getElementById('login-form');
    const loginError = document.getElementById('login-error');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            loginError.style.display = 'none';
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            try {
                const res = await fetch('/api/login', {
                    method: 'POST', headers: getHeaders(), body: JSON.stringify({ email, password })
                });
                const data = await res.json();
                if (res.ok) {
                    localStorage.setItem('auth_token', data.token);
                    authModal.classList.remove('active');
                    checkAuth();
                } else {
                    loginError.textContent = data.message || 'Error al iniciar sesión';
                    loginError.style.display = 'block';
                }
            } catch (err) {
                loginError.textContent = 'Error de conexión';
                loginError.style.display = 'block';
            }
        });
    }

    const registerForm = document.getElementById('register-form');
    const registerError = document.getElementById('register-error');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            registerError.style.display = 'none';
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            try {
                const res = await fetch('/api/register', {
                    method: 'POST', headers: getHeaders(), body: JSON.stringify({ name, email, password, password_confirmation: password })
                });
                const data = await res.json();
                if (res.ok) {
                    localStorage.setItem('auth_token', data.token);
                    authModal.classList.remove('active');
                    checkAuth();
                } else {
                    registerError.textContent = data.message || 'Error al registrarse';
                    registerError.style.display = 'block';
                }
            } catch (err) {
                registerError.textContent = 'Error de conexión';
                registerError.style.display = 'block';
            }
        });
    }

    // 2. EVENTS
    function formatDate(dateString, timeString) {
        const date = new Date(dateString);
        const days = ['DOM', 'LUN', 'MAR', 'MIÉ', 'JUE', 'VIE', 'SÁB'];
        const months = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
        return `${days[date.getDay()]} ${date.getDate()} ${months[date.getMonth()]} · ${timeString}`;
    }

    async function fetchEvents() {
        try {
            const res = await fetch('/api/eventos');
            const result = await res.json();
            renderEvents(result.data);
        } catch (e) {
            loadingEl.textContent = 'Error al cargar los eventos.';
        }
    }

    function renderEvents(events) {
        loadingEl.style.display = 'none';
        eventsGrid.style.display = 'grid';
        eventsGrid.innerHTML = '';
        if (!events || events.length === 0) {
            eventsGrid.innerHTML = '<p style="color: var(--color-arena-300); grid-column: 1/-1; text-align:center;">No hay eventos disponibles.</p>';
            return;
        }
        events.forEach(evento => {
            let minPrice = '0.00';
            if (evento.precios && evento.precios.length > 0) {
                minPrice = Math.min(...evento.precios.map(p => parseFloat(p.precio))).toFixed(2);
            }
            const card = document.createElement('article');
            card.className = 'event-card';
            card.innerHTML = `
                <div style="position: relative;">
                    <div class="badges-container">
                        <span class="badge badge-orange">Evento</span>
                        <span class="badge badge-free">✓ Disponible</span>
                    </div>
                    <img src="${evento.poster_url || 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&q=80&w=600&h=338'}" alt="${evento.nombre}" class="event-card-img">
                </div>
                <div class="event-card-content">
                    <div class="event-card-date">${formatDate(evento.fecha, evento.hora)}</div>
                    <h3 class="event-card-title">${evento.nombre}</h3>
                    <p class="event-card-subtitle">${evento.descripcion_corta || 'Ven a disfrutar del mejor espectáculo.'}</p>
                    <div class="event-card-footer">
                        <div class="event-card-price">${minPrice}€ <span>desde</span></div>
                        <button class="btn btn-primary btn-sm btn-comprar" data-id="${evento.id}">Entradas ▶</button>
                    </div>
                </div>
            `;
            eventsGrid.appendChild(card);
        });
        document.querySelectorAll('.btn-comprar').forEach(btn => {
            btn.addEventListener('click', (e) => showEventDetail(e.target.getAttribute('data-id')));
        });
    }

    // 3. EVENT DETAILS & SEATS
    async function showEventDetail(eventId) {
        if (!currentUser) {
            authModal.classList.add('active');
            return; // Require login first
        }
        selectedEventId = eventId;
        showView('detail');
        seatMap.innerHTML = '<p style="color:var(--color-arena-300); text-align:center;">Cargando mapa de asientos...</p>';
        btnCheckout.disabled = true;
        currentReservations = [];
        updateCheckoutBtn();

        try {
            const [evRes, seatsRes] = await Promise.all([
                fetch(`/api/eventos/${eventId}`, { headers: getHeaders() }),
                fetch(`/api/eventos/${eventId}/asientos`, { headers: getHeaders() })
            ]);
            const evData = await evRes.json();
            const seatsData = await seatsRes.json();
            
            detailTitle.textContent = evData.data.nombre;
            
            await syncReservations();
            renderSeatMap(seatsData.data);
            
        } catch (e) {
            seatMap.innerHTML = '<p style="color:var(--color-error); text-align:center;">Error cargando asientos.</p>';
        }
    }

    async function syncReservations() {
        try {
            const res = await fetch('/api/reservas', { headers: getHeaders() });
            const data = await res.json();
            currentReservations = data.data.filter(r => r.evento_id == selectedEventId);
        } catch (e) {}
    }

    function renderSeatMap(seats) {
        seatMap.innerHTML = '';
        // Group by fila just to render rows
        const grouped = seats.reduce((acc, curr) => {
            (acc[curr.fila] = acc[curr.fila] || []).push(curr);
            return acc;
        }, {});

        Object.keys(grouped).forEach(fila => {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'seat-row';
            grouped[fila].forEach(asiento => {
                const seatDiv = document.createElement('div');
                const existingRes = currentReservations.find(r => r.asiento_id == asiento.id);
                const isSelected = !!existingRes;
                const isSold = !asiento.disponible && !isSelected;
                
                seatDiv.className = `seat ${isSold ? 'sold' : isSelected ? 'selected' : 'available'}`;
                seatDiv.setAttribute('data-id', asiento.id);
                seatDiv.title = `Fila ${asiento.fila} Asiento ${asiento.numero} - ${asiento.precio}€`;

                if (!isSold) {
                    seatDiv.addEventListener('click', () => toggleSeat(asiento.id, seatDiv));
                }
                rowDiv.appendChild(seatDiv);
            });
            seatMap.appendChild(rowDiv);
        });
        updateCheckoutBtn();
    }

    async function toggleSeat(asientoId, element) {
        element.style.pointerEvents = 'none'; // debounce
        const existingRes = currentReservations.find(r => r.asiento_id == asientoId);
        
        try {
            if (existingRes) {
                // Cancel
                const res = await fetch(`/api/reservas/${existingRes.id}`, { method: 'DELETE', headers: getHeaders() });
                if (res.ok) {
                    currentReservations = currentReservations.filter(r => r.id != existingRes.id);
                    element.classList.remove('selected');
                    element.classList.add('available');
                }
            } else {
                // Reserve
                const res = await fetch('/api/reservas', {
                    method: 'POST', headers: getHeaders(), body: JSON.stringify({ evento_id: selectedEventId, asiento_id: asientoId })
                });
                const data = await res.json();
                if (res.ok) {
                    currentReservations.push(data.data);
                    element.classList.remove('available');
                    element.classList.add('selected');
                } else {
                    alert(data.error || 'Error al reservar. El asiento podría estar ocupado.');
                }
            }
        } catch (e) {
            console.error(e);
        }
        element.style.pointerEvents = 'auto';
        updateCheckoutBtn();
    }

    function updateCheckoutBtn() {
        btnCheckout.disabled = currentReservations.length === 0;
        btnCheckout.textContent = `Proceder al Pago (${currentReservations.length} asientos)`;
    }

    btnBack.addEventListener('click', () => showView('eventos'));

    // 4. CHECKOUT
    btnCheckout.addEventListener('click', async () => {
        btnCheckout.disabled = true;
        btnCheckout.textContent = 'Procesando...';
        
        const reservasIds = currentReservations.map(r => r.id);
        try {
            const res = await fetch('/api/compras', {
                method: 'POST', headers: getHeaders(), body: JSON.stringify({ reservas: reservasIds })
            });
            if (res.ok) {
                showView('entradas');
            } else {
                const data = await res.json();
                alert(data.error || 'Error al procesar el pago');
                btnCheckout.disabled = false;
                updateCheckoutBtn();
            }
        } catch (e) {
            alert('Error de conexión');
            btnCheckout.disabled = false;
            updateCheckoutBtn();
        }
    });

    // 5. MIS ENTRADAS
    navMisEntradas.addEventListener('click', (e) => {
        e.preventDefault();
        showView('entradas');
    });
    navEventos.addEventListener('click', (e) => {
        showView('eventos'); // Smooth scroll is handled natively or we just switch view
    });

    async function loadTickets() {
        ticketsLoading.style.display = 'block';
        ticketsGrid.style.display = 'none';
        
        try {
            const res = await fetch('/api/entradas', { headers: getHeaders() });
            const data = await res.json();
            const entradas = data.data || [];
            
            ticketsLoading.style.display = 'none';
            ticketsGrid.style.display = 'grid';
            ticketsGrid.innerHTML = '';
            
            if (entradas.length === 0) {
                ticketsGrid.innerHTML = '<p style="color: var(--color-arena-300); grid-column: 1/-1; text-align:center;">No tienes entradas compradas todavía.</p>';
                return;
            }
            
            entradas.forEach(entrada => {
                const eventoNombre = entrada.evento?.nombre || 'ROIG ARENA';
                const sectorNombre = entrada.asiento?.sector || 'Principal';
                const fila = entrada.asiento?.fila || 'N/D';
                const numero = entrada.asiento?.numero || 'N/D';
                const card = document.createElement('div');
                card.style.background = 'var(--color-arena-800)';
                card.style.borderRadius = 'var(--radius-xl)';
                card.style.border = '1px solid rgba(255,255,255,0.06)';
                card.style.borderLeft = '4px solid var(--color-taronja-500)';
                card.style.padding = 'var(--space-6)';
                card.innerHTML = `
                    <div style="font-family: var(--font-display); font-size: 12px; font-weight: 700; color: var(--color-taronja-500); text-transform: uppercase;">
                        ${eventoNombre}
                    </div>
                    <div style="font-family: var(--font-display); font-size: 24px; font-weight: 900; color: var(--color-white); text-transform: uppercase; margin-bottom: 8px;">
                        TICKET VIRTUAL
                    </div>
                    <div style="font-size: 14px; color: var(--color-arena-200); margin-bottom: 16px;">
                        Sector ${sectorNombre} · Fila ${fila} Asiento ${numero}
                    </div>
                    <div style="background: white; padding: 16px; text-align: center; border-radius: 8px; margin-bottom: 12px;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${entrada.codigo_qr}" alt="QR" style="max-width: 100%; height: auto;">
                    </div>
                    <div style="font-family: var(--font-mono); font-size: 10px; color: var(--color-arena-400); text-align: center; letter-spacing: 0.1em;">
                        ${entrada.codigo_qr}
                    </div>
                `;
                ticketsGrid.appendChild(card);
            });
        } catch (e) {
            ticketsLoading.textContent = 'Error cargando las entradas';
        }
    }

    function setAdminFeedback(message, type = 'info') {
        if (!adminFeedback) return;
        adminFeedback.textContent = message;
        adminFeedback.dataset.type = type;
    }

    function resetAdminEventForm() {
        if (!adminEventForm) return;
        adminEventForm.reset();
        adminEventForm.dataset.editingId = '';
        adminEventForm.dataset.mode = 'create';
        const title = adminEventForm.querySelector('[data-admin-form-title]');
        const submit = adminEventForm.querySelector('button[type="submit"]');
        if (title) title.textContent = 'Crear evento';
        if (submit) submit.textContent = 'Crear evento';
    }

    function resetAdminSectorForm() {
        if (!adminSectorForm) return;
        adminSectorForm.reset();
        adminSectorForm.dataset.editingId = '';
        adminSectorForm.dataset.mode = 'create';
        const title = adminSectorForm.querySelector('[data-admin-form-title]');
        const submit = adminSectorForm.querySelector('button[type="submit"]');
        if (title) title.textContent = 'Crear sector';
        if (submit) submit.textContent = 'Crear sector';
    }

    async function loadAdminData() {
        if (!adminPanel) return;
        setAdminFeedback('Cargando datos...', 'info');
        try {
            const [eventsRes, sectorsRes] = await Promise.all([
                fetch('/api/eventos'),
                fetch('/api/sectores'),
            ]);

            const eventsData = await eventsRes.json();
            const sectorsData = await sectorsRes.json();

            renderAdminEvents(eventsData.data || []);
            renderAdminSectors(sectorsData.data || []);
            setAdminFeedback('Panel listo.', 'success');
        } catch (e) {
            setAdminFeedback('Error cargando datos del panel.', 'error');
        }
    }

    function renderAdminEvents(events) {
        if (!adminEventsList) return;
        adminEventsList.innerHTML = '';
        if (!events.length) {
            adminEventsList.innerHTML = '<div class="admin-empty">No hay eventos futuros.</div>';
            return;
        }

        events.forEach(evento => {
            const row = document.createElement('div');
            row.className = 'admin-row';
            row.innerHTML = `
                <div>
                    <div class="admin-row-title">${evento.nombre}</div>
                    <div class="admin-row-meta">${evento.fecha} · ${evento.hora || '00:00'}</div>
                </div>
                <div class="admin-row-actions">
                    <button class="btn btn-ghost btn-sm" data-action="edit" data-id="${evento.id}">Editar</button>
                    <button class="btn btn-secondary btn-sm" data-action="delete" data-id="${evento.id}">Eliminar</button>
                </div>
            `;
            row.dataset.event = JSON.stringify(evento);
            adminEventsList.appendChild(row);
        });
    }

    function renderAdminSectors(sectores) {
        if (!adminSectorsList) return;
        adminSectorsList.innerHTML = '';
        if (!sectores.length) {
            adminSectorsList.innerHTML = '<div class="admin-empty">No hay sectores activos.</div>';
            return;
        }

        sectores.forEach(sector => {
            const row = document.createElement('div');
            row.className = 'admin-row';
            row.innerHTML = `
                <div>
                    <div class="admin-row-title">${sector.nombre}</div>
                    <div class="admin-row-meta">${sector.descripcion || 'Sin descripcion'} · ${sector.asientos_count || 0} asientos</div>
                </div>
                <div class="admin-row-actions">
                    <button class="btn btn-ghost btn-sm" data-action="edit" data-id="${sector.id}">Editar</button>
                    <button class="btn btn-secondary btn-sm" data-action="delete" data-id="${sector.id}">Eliminar</button>
                </div>
            `;
            row.dataset.sector = JSON.stringify(sector);
            adminSectorsList.appendChild(row);
        });
    }

    if (adminEventForm) {
        adminEventForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const mode = adminEventForm.dataset.mode || 'create';
            const editingId = adminEventForm.dataset.editingId;

            const nombre = document.getElementById('admin-event-nombre').value.trim();
            const fecha = document.getElementById('admin-event-fecha').value.trim();
            const hora = document.getElementById('admin-event-hora').value.trim();
            const poster = document.getElementById('admin-event-poster').value.trim();
            const descCorta = document.getElementById('admin-event-desc-corta').value.trim();
            const descLarga = document.getElementById('admin-event-desc-larga').value.trim();

            if (mode === 'create' && (!nombre || !fecha || !hora)) {
                setAdminFeedback('Nombre, fecha y hora son obligatorios.', 'error');
                return;
            }

            const payload = {};
            if (nombre) payload.nombre = nombre;
            if (fecha) payload.fecha = fecha;
            if (hora) payload.hora = hora;
            if (poster) payload.poster_url = poster;
            if (descCorta) payload.descripcion_corta = descCorta;
            if (descLarga) payload.descripcion_larga = descLarga;

            try {
                const url = mode === 'edit' ? `/api/admin/eventos/${editingId}` : '/api/admin/eventos';
                const method = mode === 'edit' ? 'PUT' : 'POST';
                const res = await fetch(url, {
                    method,
                    headers: getHeaders(),
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (res.ok) {
                    setAdminFeedback(data.message || 'Evento guardado.', 'success');
                    resetAdminEventForm();
                    loadAdminData();
                } else {
                    setAdminFeedback(data.error || data.message || 'Error guardando el evento.', 'error');
                }
            } catch (e) {
                setAdminFeedback('Error de conexion con el servidor.', 'error');
            }
        });
    }

    if (adminSectorForm) {
        adminSectorForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const mode = adminSectorForm.dataset.mode || 'create';
            const editingId = adminSectorForm.dataset.editingId;

            const nombre = document.getElementById('admin-sector-nombre').value.trim();
            const descripcion = document.getElementById('admin-sector-descripcion').value.trim();
            const activo = document.getElementById('admin-sector-activo').checked;

            if (mode === 'create' && !nombre) {
                setAdminFeedback('El nombre del sector es obligatorio.', 'error');
                return;
            }

            const payload = {};
            if (nombre) payload.nombre = nombre;
            if (descripcion) payload.descripcion = descripcion;
            payload.activo = activo;

            try {
                const url = mode === 'edit' ? `/api/admin/sectores/${editingId}` : '/api/admin/sectores';
                const method = mode === 'edit' ? 'PUT' : 'POST';
                const res = await fetch(url, {
                    method,
                    headers: getHeaders(),
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (res.ok) {
                    setAdminFeedback(data.message || 'Sector guardado.', 'success');
                    resetAdminSectorForm();
                    loadAdminData();
                } else {
                    setAdminFeedback(data.error || data.message || 'Error guardando el sector.', 'error');
                }
            } catch (e) {
                setAdminFeedback('Error de conexion con el servidor.', 'error');
            }
        });
    }

    if (adminEventsList) {
        adminEventsList.addEventListener('click', async (e) => {
            const action = e.target.dataset.action;
            const id = e.target.dataset.id;
            if (!action || !id) return;

            if (action === 'edit') {
                const row = e.target.closest('.admin-row');
                const evento = JSON.parse(row.dataset.event);
                adminEventForm.dataset.mode = 'edit';
                adminEventForm.dataset.editingId = id;
                document.getElementById('admin-event-nombre').value = evento.nombre || '';
                document.getElementById('admin-event-fecha').value = evento.fecha || '';
                document.getElementById('admin-event-hora').value = evento.hora || '';
                document.getElementById('admin-event-poster').value = evento.poster_url || '';
                document.getElementById('admin-event-desc-corta').value = evento.descripcion_corta || '';
                document.getElementById('admin-event-desc-larga').value = evento.descripcion_larga || '';
                const title = adminEventForm.querySelector('[data-admin-form-title]');
                const submit = adminEventForm.querySelector('button[type="submit"]');
                if (title) title.textContent = 'Editar evento';
                if (submit) submit.textContent = 'Guardar cambios';
                setAdminFeedback('Editando evento.', 'info');
            }

            if (action === 'delete') {
                if (!confirm('Eliminar este evento?')) return;
                try {
                    const res = await fetch(`/api/admin/eventos/${id}`, {
                        method: 'DELETE',
                        headers: getHeaders(),
                    });
                    const data = await res.json();
                    if (res.ok) {
                        setAdminFeedback(data.message || 'Evento eliminado.', 'success');
                        loadAdminData();
                    } else {
                        setAdminFeedback(data.error || 'No se pudo eliminar.', 'error');
                    }
                } catch (e) {
                    setAdminFeedback('Error de conexion con el servidor.', 'error');
                }
            }
        });
    }

    if (adminSectorsList) {
        adminSectorsList.addEventListener('click', async (e) => {
            const action = e.target.dataset.action;
            const id = e.target.dataset.id;
            if (!action || !id) return;

            if (action === 'edit') {
                const row = e.target.closest('.admin-row');
                const sector = JSON.parse(row.dataset.sector);
                adminSectorForm.dataset.mode = 'edit';
                adminSectorForm.dataset.editingId = id;
                document.getElementById('admin-sector-nombre').value = sector.nombre || '';
                document.getElementById('admin-sector-descripcion').value = sector.descripcion || '';
                document.getElementById('admin-sector-activo').checked = !!sector.activo;
                const title = adminSectorForm.querySelector('[data-admin-form-title]');
                const submit = adminSectorForm.querySelector('button[type="submit"]');
                if (title) title.textContent = 'Editar sector';
                if (submit) submit.textContent = 'Guardar cambios';
                setAdminFeedback('Editando sector.', 'info');
            }

            if (action === 'delete') {
                if (!confirm('Eliminar este sector?')) return;
                try {
                    const res = await fetch(`/api/admin/sectores/${id}`, {
                        method: 'DELETE',
                        headers: getHeaders(),
                    });
                    const data = await res.json();
                    if (res.ok) {
                        setAdminFeedback(data.message || 'Sector eliminado.', 'success');
                        loadAdminData();
                    } else {
                        setAdminFeedback(data.error || 'No se pudo eliminar.', 'error');
                    }
                } catch (e) {
                    setAdminFeedback('Error de conexion con el servidor.', 'error');
                }
            }
        });
    }

    if (adminEventCancel) {
        adminEventCancel.addEventListener('click', (e) => {
            e.preventDefault();
            resetAdminEventForm();
            setAdminFeedback('Edicion cancelada.', 'info');
        });
    }

    if (adminSectorCancel) {
        adminSectorCancel.addEventListener('click', (e) => {
            e.preventDefault();
            resetAdminSectorForm();
            setAdminFeedback('Edicion cancelada.', 'info');
        });
    }

    // View Routing
    function showView(view) {
        const h2Eventos = document.querySelector('#eventos > .container > h2');
        eventsGrid.style.display = 'none';
        detailContainer.style.display = 'none';
        ticketsSection.style.display = 'none';
        if (h2Eventos) h2Eventos.style.display = 'none';

        if (view === 'eventos') {
            eventsGrid.style.display = 'grid';
            if (h2Eventos) h2Eventos.style.display = 'block';
            if (adminPanel) adminPanel.style.display = 'none';
            window.scrollTo({top: 0, behavior: 'smooth'});
        } else if (view === 'detail') {
            detailContainer.style.display = 'block';
            if (adminPanel) adminPanel.style.display = 'none';
            detailContainer.scrollIntoView({behavior: 'smooth'});
        } else if (view === 'entradas') {
            ticketsSection.style.display = 'block';
            if (adminPanel) adminPanel.style.display = 'none';
            loadTickets();
            window.scrollTo({top: 0, behavior: 'smooth'});
        } else if (view === 'admin') {
            if (adminPanel) {
                adminPanel.style.display = 'block';
                adminPanel.classList.add('is-active');
                loadAdminData();
                adminPanel.scrollIntoView({behavior: 'smooth'});
            }
        }
    }

    // Init
    checkAuth();
    fetchEvents();
});
