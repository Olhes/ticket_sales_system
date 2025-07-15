// Admin Dashboard functionality
class AdminDashboard {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    init() {
        this.checkAdminAuth();
        this.setupEventListeners();
        this.loadInitialData();
    }

    async checkAdminAuth() {
        try {
            const response = await fetch('../backend/api/auth/check.php');
            const result = await response.json();
            
            if (!result.success || !result.data.is_authenticated) {
                window.location.href = 'form.php';
                return;
            }

            // Check if user is admin
            if (result.data.user_data && result.data.user_data.Rol !== 'admin') {
                alert('Acceso denegado. Solo administradores pueden acceder a este panel.');
                window.location.href = 'dashboard.php';
                return;
            }
            
            this.currentUser = {
                id: result.data.user_data.IdUsuario,
                name: result.data.user_data.Nombre,
                email: result.data.user_data.Correo,
                role: result.data.user_data.Rol
            };
            
            document.getElementById('userName').textContent = this.currentUser.name;
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

        // Filters
        this.setupFilters();
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
            await this.loadDashboardStats();
            await this.loadRecentActivity();
        } catch (error) {
            console.error('Error loading initial data:', error);
        }
    }

    async loadSectionData(sectionId) {
        switch(sectionId) {
            case 'users':
                await this.loadUsers();
                break;
            case 'companies':
                await this.loadCompanies();
                break;
            case 'terminals':
                await this.loadTerminals();
                break;
            case 'buses':
                await this.loadBuses();
                break;
            case 'drivers':
                await this.loadDrivers();
                break;
            case 'routes':
                await this.loadRoutes();
                break;
            case 'schedules':
                await this.loadSchedules();
                break;
            case 'reservations':
                await this.loadReservations();
                break;
            case 'reports':
                await this.loadReports();
                break;
        }
    }

    async loadDashboardStats() {
        try {
            const [usersRes, busesRes, routesRes, reservationsRes] = await Promise.all([
                fetch('../backend/api/admin/users.php'),
                fetch('../backend/api/admin/buses.php'),
                fetch('../backend/api/routes/list.php'),
                fetch('../backend/api/admin/reservations.php')
            ]);

            const users = await usersRes.json();
            const buses = await busesRes.json();
            const routes = await routesRes.json();
            const reservations = await reservationsRes.json();

            document.getElementById('totalUsers').textContent = users.data?.length || 0;
            document.getElementById('totalBuses').textContent = buses.data?.length || 0;
            document.getElementById('totalRoutes').textContent = routes.data?.length || 0;
            document.getElementById('totalReservations').textContent = reservations.data?.length || 0;
        } catch (error) {
            console.error('Error loading dashboard stats:', error);
        }
    }

    async loadRecentActivity() {
        try {
            const response = await fetch('../backend/api/admin/activity.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderRecentActivity(result.data);
            }
        } catch (error) {
            console.error('Error loading recent activity:', error);
        }
    }

    renderRecentActivity(activities) {
        const container = document.getElementById('recentActivity');
        container.innerHTML = '';
        
        if (activities.length === 0) {
            container.innerHTML = '<p>No hay actividad reciente.</p>';
            return;
        }
        
        activities.forEach(activity => {
            const item = document.createElement('div');
            item.className = 'activity-item';
            item.innerHTML = `
                <div class="activity-icon ${activity.type}">
                    <i class='bx ${this.getActivityIcon(activity.type)}'></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">${activity.title}</div>
                    <div class="activity-time">${activity.time}</div>
                </div>
            `;
            container.appendChild(item);
        });
    }

    getActivityIcon(type) {
        const icons = {
            user: 'bx-user',
            reservation: 'bx-ticket',
            route: 'bx-map',
            schedule: 'bx-time'
        };
        return icons[type] || 'bx-info-circle';
    }

    async loadUsers() {
        try {
            const response = await fetch('../backend/api/admin/users.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderUsersTable(result.data);
            }
        } catch (error) {
            console.error('Error loading users:', error);
        }
    }

    renderUsersTable(users) {
        const tbody = document.querySelector('#usersTable tbody');
        tbody.innerHTML = '';
        
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.IdUsuario}</td>
                <td>${user.Nombre}</td>
                <td>${user.Correo}</td>
                <td><span class="status-badge ${user.Rol}">${user.Rol}</span></td>
                <td>${new Date(user.FechaCreacion).toLocaleDateString()}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="adminDashboard.editUser(${user.IdUsuario})">Editar</button>
                        <button class="btn-delete" onclick="adminDashboard.deleteUser(${user.IdUsuario})">Eliminar</button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async loadCompanies() {
        try {
            const response = await fetch('../backend/api/admin/companies.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderCompaniesTable(result.data);
            }
        } catch (error) {
            console.error('Error loading companies:', error);
        }
    }

    renderCompaniesTable(companies) {
        const tbody = document.querySelector('#companiesTable tbody');
        tbody.innerHTML = '';
        
        companies.forEach(company => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${company.IdEmpresa}</td>
                <td>${company.Nombre}</td>
                <td>${company.RUC}</td>
                <td>${company.buses_count || 0}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="adminDashboard.editCompany(${company.IdEmpresa})">Editar</button>
                        <button class="btn-delete" onclick="adminDashboard.deleteCompany(${company.IdEmpresa})">Eliminar</button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async loadReservations() {
        try {
            const response = await fetch('../backend/api/admin/reservations.php');
            const result = await response.json();
            
            if (result.success) {
                this.renderReservationsTable(result.data);
            }
        } catch (error) {
            console.error('Error loading reservations:', error);
        }
    }

    renderReservationsTable(reservations) {
        const tbody = document.querySelector('#reservationsTable tbody');
        tbody.innerHTML = '';
        
        reservations.forEach(reservation => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${reservation.IdReserva}</td>
                <td>${reservation.usuario}</td>
                <td>${reservation.pasajero}</td>
                <td>${reservation.ruta}</td>
                <td>${reservation.FechaSalida}</td>
                <td>${reservation.NumAsiento}</td>
                <td>$${reservation.PrecioFinal}</td>
                <td><span class="status-badge ${reservation.Estado.toLowerCase()}">${reservation.Estado}</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-view" onclick="adminDashboard.viewReservation(${reservation.IdReserva})">Ver</button>
                        ${reservation.Estado === 'Confirmada' ? 
                            `<button class="btn-delete" onclick="adminDashboard.cancelReservation(${reservation.IdReserva})">Cancelar</button>` : 
                            ''
                        }
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    setupModals() {
        // User modal
        const userModal = document.getElementById('userModal');
        const closeBtn = userModal.querySelector('.close');
        
        closeBtn.addEventListener('click', () => {
            userModal.style.display = 'none';
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === userModal) {
                userModal.style.display = 'none';
            }
        });

        // Add user button
        document.getElementById('addUserBtn').addEventListener('click', () => {
            this.showUserModal();
        });
    }

    setupForms() {
        // User form
        document.getElementById('userForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitUserForm();
        });
    }

    setupFilters() {
        // Reservation filters
        document.getElementById('statusFilter').addEventListener('change', () => {
            this.filterReservations();
        });
        
        document.getElementById('dateFilter').addEventListener('change', () => {
            this.filterReservations();
        });
    }

    showUserModal(userId = null) {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');
        
        if (userId) {
            // Edit mode - load user data
            this.loadUserForEdit(userId);
        } else {
            // Add mode - clear form
            form.reset();
            document.getElementById('userId').value = '';
        }
        
        modal.style.display = 'block';
    }

    async submitUserForm() {
        const formData = new FormData();
        const userId = document.getElementById('userId').value;
        
        formData.append('name', document.getElementById('userName').value);
        formData.append('email', document.getElementById('userEmail').value);
        formData.append('role', document.getElementById('userRole').value);
        
        const password = document.getElementById('userPassword').value;
        if (password) {
            formData.append('password', password);
        }
        
        if (userId) {
            formData.append('id', userId);
        }
        
        try {
            const url = userId ? '../backend/api/admin/users/update.php' : '../backend/api/admin/users/create.php';
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert(userId ? 'Usuario actualizado exitosamente' : 'Usuario creado exitosamente');
                document.getElementById('userModal').style.display = 'none';
                await this.loadUsers();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error submitting user form:', error);
            alert('Error al procesar la solicitud');
        }
    }

    async editUser(userId) {
        this.showUserModal(userId);
    }

    async deleteUser(userId) {
        if (!confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
            return;
        }
        
        try {
            const response = await fetch('../backend/api/admin/users/delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: userId })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Usuario eliminado exitosamente');
                await this.loadUsers();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            alert('Error al eliminar usuario');
        }
    }

    async cancelReservation(reservationId) {
        if (!confirm('¿Estás seguro de que quieres cancelar esta reserva?')) {
            return;
        }
        
        try {
            const response = await fetch('../backend/api/admin/reservations/cancel.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: reservationId })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Reserva cancelada exitosamente');
                await this.loadReservations();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error canceling reservation:', error);
            alert('Error al cancelar reserva');
        }
    }

    filterReservations() {
        const statusFilter = document.getElementById('statusFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;
        
        const rows = document.querySelectorAll('#reservationsTable tbody tr');
        
        rows.forEach(row => {
            const status = row.cells[7].textContent.trim();
            const date = row.cells[4].textContent.trim();
            
            let showRow = true;
            
            if (statusFilter && !status.toLowerCase().includes(statusFilter.toLowerCase())) {
                showRow = false;
            }
            
            if (dateFilter && date !== dateFilter) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
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
            sessionStorage.removeItem('user');
            window.location.href = 'form.php';
        }
    }
}

// Initialize admin dashboard
const adminDashboard = new AdminDashboard();