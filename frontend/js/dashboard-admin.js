export function getUserFromSession() {
    let user = sessionStorage.getItem('user');
    if (!user) return null;
    try { user = JSON.parse(user); } catch { return null; }
    return {
        nombre: user.name || '',
        correo: user.email || '',
        rol: user.role || ''
    };
}

export function renderUserInfo() {
    const user = getUserFromSession();
    const userInfoDiv = document.getElementById('user-info');
    if (user && user.nombre && user.correo) {
        userInfoDiv.innerHTML = `<strong>${user.nombre}</strong><br><small>${user.correo}</small><div style='margin-top:8px; font-size:12px; color:#888;'>${user.rol === 'admin' ? 'Administrador' : 'Usuario'}</div>`;
    } else {
        userInfoDiv.innerHTML = `<em>No logueado</em>`;
    }
    if (!user || user.rol !== 'admin') {
        alert('Acceso solo para administradores');
        window.location.href = 'dashboard.php';
    }
}

const API_URL = '../backend/api/schedules/get.php';
const API_CREATE = '../backend/api/schedules/create.php';
const API_UPDATE = '../backend/api/schedules/update.php';
const API_DELETE = '../backend/api/schedules/delete.php';

let optionsCache = null;

export async function loadOptionsCache() {
    optionsCache = await fetchOptions();
}

export async function fetchHorarios() {
    const res = await fetch(API_URL);
    const data = await res.json();
    if (Array.isArray(data)) return data;
    if (data && Array.isArray(data.data)) return data.data;
    return [];
}

export function renderTable(horarios) {
    const tbody = document.getElementById('horario-tbody');
    tbody.innerHTML = '';
    if (!optionsCache) {
        horarios.forEach(h => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${h.IdHorario}</td>
                <td>${h.FechaSalida}</td>
                <td>${h.HoraSalida}</td>
                <td>${h.HoraLlegada || ''}</td>
                <td>${h.IdBus}</td>
                <td>${h.IdRuta}</td>
                <td>${h.IdConductor}</td>
                <td class='crud-actions'>
                    <button class='edit-btn'>Editar</button>
                    <button class='delete-btn'>Eliminar</button>
                </td>
            `;
            tr.querySelector('.edit-btn').onclick = () => renderForm(h);
            tr.querySelector('.delete-btn').onclick = () => deleteHorario(h.IdHorario);
            tbody.appendChild(tr);
        });
        return;
    }
    const { buses, rutas, conductores } = optionsCache;
    horarios.forEach(h => {
        const bus = buses.find(b => b.IdBus == h.IdBus);
        const ruta = rutas.find(r => r.IdRuta == h.IdRuta);
        const conductor = conductores.find(c => c.IdConductor == h.IdConductor);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${h.IdHorario}</td>
            <td>${h.FechaSalida}</td>
            <td>${h.HoraSalida}</td>
            <td>${h.HoraLlegada || ''}</td>
            <td>${bus ? bus.Placa : h.IdBus}</td>
            <td>${ruta ? (ruta.Origen && ruta.Destino ? ruta.Origen + ' - ' + ruta.Destino : 'Ruta #' + ruta.IdRuta) : h.IdRuta}</td>
            <td>${conductor ? conductor.Nombres + ' ' + conductor.Apellidos : h.IdConductor}</td>
            <td class='crud-actions'>
                <button class='edit-btn'>Editar</button>
                <button class='delete-btn'>Eliminar</button>
            </td>
        `;
        tr.querySelector('.edit-btn').onclick = () => renderForm(h);
        tr.querySelector('.delete-btn').onclick = () => deleteHorario(h.IdHorario);
        tbody.appendChild(tr);
    });
}

export async function fetchOptions() {
    const [busesRes, rutasRes, conductoresRes] = await Promise.all([
        fetch('../backend/api/bus/get.php'),
        fetch('../backend/api/ruta/get.php'),
        fetch('../backend/api/conductor/get.php')
    ]);
    let buses = await busesRes.json();
    let rutas = await rutasRes.json();
    let conductores = await conductoresRes.json();
    buses = Array.isArray(buses) ? buses : (buses && Array.isArray(buses.data) ? buses.data : []);
    rutas = Array.isArray(rutas) ? rutas : (rutas && Array.isArray(rutas.data) ? rutas.data : []);
    conductores = Array.isArray(conductores) ? conductores : (conductores && Array.isArray(conductores.data) ? conductores.data : []);
    return { buses, rutas, conductores };
}

export function renderForm(horario = null) {
    fetchOptions().then(options => {
        const buses = options.buses || [];
        const rutas = options.rutas || [];
        const conductores = options.conductores || [];
        const container = document.getElementById('crud-form-container');
        container.innerHTML = `
            <form id="horario-form" class="crud-form">
                <input type="hidden" name="IdHorario" value="${horario ? horario.IdHorario : ''}">
                <label>Fecha Salida: <input type="date" name="FechaSalida" value="${horario ? horario.FechaSalida : ''}" required></label>
                <label>Hora Salida: <input type="time" name="HoraSalida" value="${horario ? horario.HoraSalida : ''}" required></label>
                <label>Hora Llegada: <input type="time" name="HoraLlegada" value="${horario ? horario.HoraLlegada : ''}"></label>
                <label>Bus:
                    <select name="IdBus" required>
                        <option value="">Seleccione</option>
                        ${buses.map(b => `<option value="${b.IdBus}" ${horario && b.IdBus == horario.IdBus ? 'selected' : ''}>${b.Placa}</option>`).join('')}
                    </select>
                </label>
                <label>Ruta:
                    <select name="IdRuta" required>
                        <option value="">Seleccione</option>
                        ${rutas.map(r => `<option value="${r.IdRuta}" ${horario && r.IdRuta == horario.IdRuta ? 'selected' : ''}>Ruta #${r.IdRuta}</option>`).join('')}
                    </select>
                </label>
                <label>Conductor:
                    <select name="IdConductor" required>
                        <option value="">Seleccione</option>
                        ${conductores.map(c => `<option value="${c.IdConductor}" ${horario && c.IdConductor == horario.IdConductor ? 'selected' : ''}>${c.Nombres} ${c.Apellidos}</option>`).join('')}
                    </select>
                </label>
                <button type="submit">${horario ? 'Actualizar' : 'Añadir'}</button>
                ${horario ? '<button type="button" id="cancelEdit">Cancelar</button>' : ''}
            </form>
        `;
        document.getElementById('horario-form').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            let url, method;
            if (data.IdHorario) {
                url = API_UPDATE;
                method = 'PUT';
            } else {
                url = API_CREATE;
                method = 'POST';
            }
            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            if (result.success) {
                loadHorarios();
                renderForm();
            } else {
                alert(result.message || 'Error en la operación');
            }
        };
        if (horario) {
            document.getElementById('cancelEdit').onclick = () => renderForm();
        }
    });
}

export async function deleteHorario(id) {
    if (!confirm('¿Eliminar horario?')) return;
    const res = await fetch(API_DELETE, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ IdHorario: id })
    });
    const result = await res.json();
    if (result.success) {
        loadHorarios();
    } else {
        alert(result.message || 'Error al eliminar');
    }
}

export async function loadHorarios() {
    const horarios = await fetchHorarios();
    if (!optionsCache) await loadOptionsCache();
    renderTable(horarios);
}

renderUserInfo();
renderForm();
loadOptionsCache().then(loadHorarios());

const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
    logoutBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        sessionStorage.removeItem('user');
        window.location.href = 'form.php';
    });
}
