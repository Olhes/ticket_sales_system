CREATE DATABASE SISTEMADEBUSES;
USE SISTEMADEBUSES;

CREATE TABLE Terminal (
    IdTerminal INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255)
);

CREATE TABLE Usuario (
    IdUsuario INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) NOT NULL,
    Correo VARCHAR(255) NOT NULL UNIQUE,
    Contraseña VARCHAR(255) NOT NULL,
    Rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    FechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    GoogleId VARCHAR(255) NULL,
    GithubId VARCHAR(255) NULL
);

CREATE TABLE Empresa (
    IdEmpresa INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) NOT NULL,
    RUC VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE Conductor (
    IdConductor INT PRIMARY KEY AUTO_INCREMENT,
    Nombres VARCHAR(255) NOT NULL,
    Apellidos VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20),
    DNI VARCHAR(15) NOT NULL UNIQUE,
    Licencia VARCHAR(50) NOT NULL,
    FechaVencLicencia DATE
);

CREATE TABLE Bus (
    IdBus INT PRIMARY KEY AUTO_INCREMENT,
    Placa VARCHAR(10) NOT NULL UNIQUE,
    CapacidadBus INT NOT NULL,
    TipoBus VARCHAR(50),
    Piso1Capacidad INT,
    Piso2Capacidad INT,
    IdEmpresa INT NOT NULL,
    FOREIGN KEY (IdEmpresa) REFERENCES Empresa(IdEmpresa)
);

CREATE TABLE Ruta (
    IdRuta INT PRIMARY KEY AUTO_INCREMENT,
    IdTerminalOrigen INT NOT NULL,
    IdTerminalDestino INT NOT NULL,
    DistanciaKM DECIMAL(10, 2),
    FOREIGN KEY (IdTerminalOrigen) REFERENCES Terminal(IdTerminal),
    FOREIGN KEY (IdTerminalDestino) REFERENCES Terminal(IdTerminal)
);

CREATE TABLE Horario (
    IdHorario INT PRIMARY KEY AUTO_INCREMENT,
    FechaSalida DATE NOT NULL,
    HoraSalida TIME NOT NULL,
    HoraLlegada TIME,
    PrecioBase DECIMAL(10, 2) NOT NULL,
    IdBus INT NOT NULL,
    IdRuta INT NOT NULL,
    IdConductor INT NOT NULL,
    FOREIGN KEY (IdBus) REFERENCES Bus(IdBus),
    FOREIGN KEY (IdRuta) REFERENCES Ruta(IdRuta),
    FOREIGN KEY (IdConductor) REFERENCES Conductor(IdConductor)
);

CREATE TABLE Reserva (
    IdReserva INT PRIMARY KEY AUTO_INCREMENT,
    FechaCreacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Estado VARCHAR(50) NOT NULL,
    IdUsuario INT NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario)
);

CREATE TABLE Pasajero (
    IdPasajero INT PRIMARY KEY AUTO_INCREMENT,
    Nombres VARCHAR(255) NOT NULL,
    Apellidos VARCHAR(255) NOT NULL,
    DNI VARCHAR(15),
    Edad INT,
    Telefono VARCHAR(20),
    Correo VARCHAR(255),
    IdReserva INT NOT NULL,
    FOREIGN KEY (IdReserva) REFERENCES Reserva(IdReserva)
);

CREATE TABLE Boleto (
    IdBoleto INT PRIMARY KEY AUTO_INCREMENT,
    NumAsiento VARCHAR(10) NOT NULL,
    PrecioFinal DECIMAL(10, 2),
    IdReserva INT NOT NULL,
    IdHorario INT NOT NULL,
    IdPasajero INT NOT NULL,
    FOREIGN KEY (IdHorario) REFERENCES Horario(IdHorario),
    FOREIGN KEY (IdPasajero) REFERENCES Pasajero(IdPasajero)
);