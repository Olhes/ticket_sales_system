// Dashboard functionality
class Dashboard {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    init() {
        this.checkAuth();
        this.setupEventListeners();
        this.loadInitialData();
    }

    async checkAuth() {
        try {
            // Check server-side authentication
            const response = await fetch('../backend/api/auth/check.php');
            const result = await response.json();
            
            if (!result.success || !result.data.is_authenticated) {
                window.location.href = 'form.php';
                return;
            }
            
            // Also check session storage for user data
            const userData = sessionStorage.getItem('user');
            if (userData) {
                this.currentUser = JSON.parse(userData);
            } else if (result.data.user_data) {
                this.currentUser = {
                    id: result.data.user_data.IdUsuario,
                    name: result.data.user_data.Nombre,
                    email: result.data.user_data.Correo,
                    role: result.data.user_data.Rol
                };
                sessionStorage.setItem('user', JSON.stringify(this.currentUser));
            }
            
            if (this.currentUser) {
                document.getElementById('userName').textContent = this.currentUser.name;
                
                // Show admin link if user is admin
                if (this.currentUser.role === 'admin') {
                    document.getElementById('adminLink').style.display = 'block';
                }
            }
        } catch (error) {
            console.error('Auth check failed:', error);
            window.location.href = 'form.php';
        }
    }

    setupEventListeners() {
        // Sidebar navigation
        document.querySelectorAll('.sidebar-menu a[data-section]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.showSection(e.target.dataset.section);
                this.setActiveMenuItem(e.target);
            });
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', () => {
            this.logout();
        });

        // Modal controls
        this.setupModals();
        
        // Forms
        this.setupForms();
    }

    showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show selected section
        document.getElementById(sectionId).classList.add('active');
        
        // Load section-specific data
        this.loadSectionData(sectionId);
    }

    setActiveMenuItem(activeItem) {
        document.querySelectorAll('.sidebar-menu a').forEach(item => {
            item.classList.remove('active');
        });
        activeItem.classList.add('active');
    }

    async loadInitialData() {
        try {
            await this.loadStats();
            await this.loadRoutes();
            await this.loadSchedules();
            await this.loadTickets();
        } catch (error) {
            console.error('Error loading initial data:', error);
        }
    }

    async loadSectionData(sectionId) {
        switch(sectionId) {
            case 'routes':
                await this.loadRoutes();
                break;
            case 'schedules':
                await this.loadSchedules();
                break;
            case 'tickets':
                await this.loadTickets();
                break;
            case 'booking':
                await this.loadBookingData();
                break;
        }
    }

    async loadStats() {
        try {
            const [routesRes, schedulesRes, ticketsRes] = await Promise.all([
                fetch('../backend/api/routes/list.php'),
                fetch('../backend/api/schedules/list.php'),
                fetch('../backend/api/tickets/user.php')
            ]);

            const routes = await routesRes.json();
            const schedules = await schedulesRes.json();
            const tickets = await ticketsRes.json();

            document.getElementById('totalRoutes').textContent = routes.data?.length || 0;
            document.getElementById('totalSchedules').textContent = schedules.data?.length || 0;
            document.getElementById('myTickets').textContent = tickets.data?.length || 0;
        } catch (error) {
            console.error('Error loading stats:', error);
        }
    }

    async loadRoutes() {
        try {
            const response = await fetch('../backend/api/routes/list.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderRoutesTable(result.data);
            }
        } catch (error) {
            console.error('Error loading routes:', error);
        }
    }

    renderRoutesTable(routes) {
        const tbody = document.querySelector('#routesTable tbody');
        tbody.innerHTML = '';
        
        routes.forEach(route => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${route.IdRuta}</td>
                <td>${route.origen}</td>
                <td>${route.destino}</td>
                <td>${route.DistanciaKM}</td>
                <td>
                    <button class="btn-secondary" onclick="dashboard.editRoute(${route.IdRuta})">Editar</button>
                    <button class="btn-danger" onclick="dashboard.deleteRoute(${route.IdRuta})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async loadSchedules() {
        try {
            const response = await fetch('../backend/api/schedules/list.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderSchedulesTable(result.data);
            }
        } catch (error) {
            console.error('Error loading schedules:', error);
        }
    }

    renderSchedulesTable(schedules) {
        const tbody = document.querySelector('#schedulesTable tbody');
        tbody.innerHTML = '';
        
        schedules.forEach(schedule => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${schedule.IdHorario}</td>
                <td>${schedule.ruta}</td>
                <td>${schedule.FechaSalida}</td>
                <td>${schedule.HoraSalida}</td>
                <td>$${schedule.PrecioBase}</td>
                <td>${schedule.bus}</td>
                <td>
                    <button class="btn-secondary" onclick="dashboard.editSchedule(${schedule.IdHorario})">Editar</button>
                    <button class="btn-danger" onclick="dashboard.deleteSchedule(${schedule.IdHorario})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async loadTickets() {
        try {
            const response = await fetch('../backend/api/tickets/user.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderTicketsGrid(result.data);
            }
        } catch (error) {
            console.error('Error loading tickets:', error);
        }
    }

    renderTicketsGrid(tickets) {
        const grid = document.getElementById('ticketsGrid');
        grid.innerHTML = '';
        
        if (tickets.length === 0) {
            grid.innerHTML = '<p>No tienes boletos reservados.</p>';
            return;
        }
        
        tickets.forEach(ticket => {
            const card = document.createElement('div');
            card.className = 'ticket-card';
            card.innerHTML = `
                <div class="ticket-header">
                    <span class="ticket-id">Boleto #${ticket.IdBoleto}</span>
                    <span class="ticket-status active">Activo</span>
                </div>
                <div class="ticket-info">
                    <p><strong>Ruta:</strong> ${ticket.ruta}</p>
                    <p><strong>Fecha:</strong> ${ticket.FechaSalida}</p>
                    <p><strong>Hora:</strong> ${ticket.HoraSalida}</p>
                    <p><strong>Asiento:</strong> ${ticket.NumAsiento}</p>
                    <p><strong>Precio:</strong> $${ticket.PrecioFinal}</p>
                    <p><strong>Pasajero:</strong> ${ticket.pasajero}</p>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    async loadBookingData() {
        try {
            const response = await fetch('../backend/api/routes/list.php');
            const result = await response.json();
            
            if (result.success) {
                const routeSelect = document.getElementById('routeSelect');
                routeSelect.innerHTML = '<option value="">Seleccionar ruta</option>';
                
                result.data.forEach(route => {
                    const option = document.createElement('option');
                    option.value = route.IdRuta;
                    option.textContent = `${route.origen} → ${route.destino}`;
                    routeSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading booking data:', error);
        }
    }

    setupModals() {
        // Route modal
        const routeModal = document.getElementById('routeModal');
        const closeBtn = routeModal.querySelector('.close');
        
        closeBtn.addEventListener('click', () => {
            routeModal.style.display = 'none';
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === routeModal) {
                routeModal.style.display = 'none';
            }
        });
    }

    setupForms() {
        // Booking form
        document.getElementById('bookingForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitBooking();
        });
        
        // Route selection change
        document.getElementById('routeSelect').addEventListener('change', async (e) => {
            if (e.target.value) {
                await this.loadSchedulesForRoute(e.target.value);
            }
        });
    }

    async loadSchedulesForRoute(routeId) {
        try {
            const response = await fetch(`../backend/api/schedules/by-route.php?route_id=${routeId}`);
            const result = await response.json();
            
            const scheduleSelect = document.getElementById('scheduleSelect');
            scheduleSelect.innerHTML = '<option value="">Seleccionar horario</option>';
            
            if (result.success && result.data) {
                result.data.forEach(schedule => {
                    const option = document.createElement('option');
                    option.value = schedule.IdHorario;
                    option.textContent = `${schedule.FechaSalida} - ${schedule.HoraSalida} ($${schedule.PrecioBase})`;
                    scheduleSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading schedules for route:', error);
        }
    }

    async submitBooking() {
        const formData = new FormData();
        formData.append('schedule_id', document.getElementById('scheduleSelect').value);
        formData.append('passenger_name', document.getElementById('passengerName').value);
        formData.append('passenger_dni', document.getElementById('passengerDNI').value);
        formData.append('seat_number', document.getElementById('seatNumber').value);
        
        try {
            const response = await fetch('../backend/api/tickets/create.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Boleto reservado exitosamente');
                document.getElementById('bookingForm').reset();
                await this.loadTickets();
                await this.loadStats();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error submitting booking:', error);
            alert('Error al procesar la reserva');
        }
    }

    async logout() {
        try {
            await fetch('../backend/api/auth/logout.php', {
                method: 'POST'
            });
            
            sessionStorage.removeItem('user');
            window.location.href = 'form.php';
        } catch (error) {
            console.error('Error during logout:', error);
            // Force logout even if request fails
            sessionStorage.removeItem('user');
            window.location.href = 'form.php';
        }
    }
}

// Initialize dashboard
const dashboard = new Dashboard();