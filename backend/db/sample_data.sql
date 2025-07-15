-- Sample data for the bus ticket system
-- drop database SISTEMADEBUSES;
USE SISTEMADEBUSES;

-- Insert sample users (with hashed passwords)
INSERT INTO Usuario (Nombre, Correo, Contraseña, Rol) VALUES
('Admin Principal', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- password: password
('Juan Pérez', 'juan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'), -- password: password
('María García', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'), -- password: password
('Carlos López', 'carlos@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario'); -- password: password

-- Insert sample terminals
INSERT INTO Terminal (Nombre, Direccion) VALUES
('Terminal Lima Norte', 'Av. Túpac Amaru 1234, Lima'),
('Terminal Lima Sur', 'Av. Pachacútec 5678, Lima'),
('Terminal Arequipa', 'Av. Andrés Avelino Cáceres 910, Arequipa'),
('Terminal Cusco', 'Av. Velasco Astete 1112, Cusco'),
('Terminal Trujillo', 'Av. España 1314, Trujillo');

-- Insert sample companies
INSERT INTO Empresa (Nombre, RUC) VALUES
('Transportes PAKA S.A.', '20123456789'),
('Buses del Norte', '20987654321'),
('Expreso Sur', '20456789123');

-- Insert sample drivers
INSERT INTO Conductor (Nombres, Apellidos, Telefono, DNI, Licencia, FechaVencLicencia) VALUES
('Juan Carlos', 'Pérez García', '987654321', '12345678', 'A-IIa-123456', '2025-12-31'),
('María Elena', 'Rodríguez López', '987654322', '23456789', 'A-IIa-234567', '2025-11-30'),
('Carlos Alberto', 'Mendoza Silva', '987654323', '34567890', 'A-IIa-345678', '2025-10-31'),
('Ana Lucía', 'Torres Vega', '987654324', '45678901', 'A-IIa-456789', '2025-09-30');

-- Insert sample buses
INSERT INTO Bus (Placa, CapacidadBus, TipoBus, Piso1Capacidad, Piso2Capacidad, IdEmpresa) VALUES
('ABC-123', 40, 'Semi Cama', 20, 20, 1),
('DEF-456', 35, 'Ejecutivo', 35, 0, 1),
('GHI-789', 45, 'Cama', 22, 23, 2),
('JKL-012', 38, 'Semi Cama', 19, 19, 2),
('MNO-345', 42, 'VIP', 21, 21, 3);

-- Insert sample routes
INSERT INTO Ruta (IdTerminalOrigen, IdTerminalDestino, DistanciaKM) VALUES
(1, 3, 1015.5), -- Lima Norte → Arequipa
(1, 4, 1165.2), -- Lima Norte → Cusco
(2, 5, 558.7),  -- Lima Sur → Trujillo
(3, 4, 320.8),  -- Arequipa → Cusco
(1, 2, 25.3);   -- Lima Norte → Lima Sur

-- Insert sample schedules (next 7 days)
INSERT INTO Horario (FechaSalida, HoraSalida, HoraLlegada, PrecioBase, IdBus, IdRuta, IdConductor) VALUES
-- Lima Norte → Arequipa
(CURDATE(), '08:00:00', '22:00:00', 85.00, 1, 1, 1),
(CURDATE(), '15:00:00', '05:00:00', 85.00, 3, 1, 2),
(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '08:00:00', '22:00:00', 85.00, 1, 1, 1),
(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '15:00:00', '05:00:00', 85.00, 3, 1, 2),

-- Lima Norte → Cusco
(CURDATE(), '09:00:00', '23:30:00', 95.00, 2, 2, 3),
(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', '23:30:00', 95.00, 2, 2, 3),
(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '09:00:00', '23:30:00', 95.00, 5, 2, 4),

-- Lima Sur → Trujillo
(CURDATE(), '10:00:00', '18:00:00', 65.00, 4, 3, 1),
(CURDATE(), '16:00:00', '00:00:00', 65.00, 4, 3, 2),
(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:00:00', '18:00:00', 65.00, 4, 3, 1),

-- Arequipa → Cusco
(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '07:00:00', '12:00:00', 45.00, 3, 4, 3),
(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '07:00:00', '12:00:00', 45.00, 5, 4, 4),

-- Lima Norte → Lima Sur (local)
(CURDATE(), '06:00:00', '07:00:00', 5.00, 2, 5, 1),
(CURDATE(), '12:00:00', '13:00:00', 5.00, 2, 5, 2),
(CURDATE(), '18:00:00', '19:00:00', 5.00, 2, 5, 1);