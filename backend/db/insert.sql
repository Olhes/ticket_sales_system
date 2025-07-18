INSERT INTO Terminal (Nombre, Direccion, IdTerminalOrigen, IdTerminalDestino) VALUES
('Terminal Terrestre Tacna', 'Av. Hipólito Unanue s/n, Tacna', 1, 1),
('Terminal Terrestre Arequipa', 'Av. Arturo Ibañez s/n, Arequipa', 2, 2),
('Gran Terminal Terrestre Plaza Norte', 'Av. Túpac Amaru 1056, Lima', 3, 3),
('Terminal Terrestre Cusco', 'Av. Pachacútec s/n, Cusco', 4, 4),
('Terminal Terrestre Puno', 'Jr. Primero de Mayo s/n, Puno', 5, 5);

UPDATE Terminal SET IdTerminalOrigen = 1, IdTerminalDestino = 1 WHERE IdTerminal = 1;
UPDATE Terminal SET IdTerminalOrigen = 2, IdTerminalDestino = 2 WHERE IdTerminal = 2;
UPDATE Terminal SET IdTerminalOrigen = 3, IdTerminalDestino = 3 WHERE IdTerminal = 3;
UPDATE Terminal SET IdTerminalOrigen = 4, IdTerminalDestino = 4 WHERE IdTerminal = 4;
UPDATE Terminal SET IdTerminalOrigen = 5, IdTerminalDestino = 5 WHERE IdTerminal = 5;

INSERT INTO Empresa (Nombre, RUC) VALUES
('Cruz del Sur', '20123456789'),
('Oltursa', '20987654321'),
('Civa', '20555444333');

INSERT INTO Conductor (Nombres, Apellidos, Telefono, DNI, Licencia, FechaVencLicencia) VALUES
('Carlos', 'Ramirez Lopez', '987654321', '78901234', 'A-IIIc-12345', '2028-05-15'),
('Maria', 'Gomez Perez', '912345678', '45678901', 'A-IIIc-67890', '2027-11-20'),
('Juan', 'Diaz Flores', '999888777', '12345678', 'A-IIIc-11223', '2029-03-10'),
('Ana', 'Soto Vargas', '955444333', '87654321', 'A-IIIc-44556', '2026-09-01');

INSERT INTO Bus (Placa, CapacidadBus, TipoBus, Piso1Capacidad, Piso2Capacidad, IdEmpresa) VALUES
('ABC-123', 40, 'Común', 40, NULL, 1),
('DEF-456', 60, 'Cómodo', 12, 48, 1),
('GHI-789', 50, 'Lujo', 10, 40, 2),
('JKL-012', 45, 'Común', 45, NULL, 3),
('MNO-345', 55, 'Cómodo', 15, 40, 2);

INSERT INTO Ruta (IdTerminalOrigen, IdTerminalDestino, DistanciaKM) VALUES
(1, 2, 350.50),
(2, 3, 1000.00),
(3, 4, 1100.20),
(4, 2, 600.80),
(1, 3, 1250.75),
(3, 1, 1250.75),
(2, 1, 350.50),
(3, 5, 1300.00);

INSERT INTO Horario (FechaSalida, HoraSalida, HoraLlegada, IdBus, IdRuta, IdConductor) VALUES
('2025-07-20', '08:00:00', '14:00:00', 1, 1, 1),
('2025-07-20', '19:00:00', '09:00:00', 2, 2, 2),
('2025-07-21', '07:30:00', '22:00:00', 3, 3, 3),
('2025-07-21', '10:00:00', '17:00:00', 4, 4, 4),
('2025-07-22', '20:00:00', '10:30:00', 5, 5, 1),
('2025-07-22', '15:00:00', '21:00:00', 1, 7, 2),
('2025-07-23', '22:00:00', '12:00:00', 3, 6, 3),
('2025-07-24', '09:00:00', '02:00:00', 2, 8, 4);