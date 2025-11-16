-- Usar la base de datos Katalyst
USE Katalyst;
GO

-- Crear tabla Usuario
CREATE TABLE Usuario (
    id BIGINT NOT NULL,
    nombre_usuario VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    CONSTRAINT PK_Usuario PRIMARY KEY (id)
);
GO

-- Crear tabla Proyecto
CREATE TABLE Proyecto (
    id BIGINT NOT NULL,
    nombre_proyecto VARCHAR(255) NOT NULL,
    favorito BIT NULL,
    CONSTRAINT PK_Proyecto PRIMARY KEY (id)
);
GO

-- Crear tabla Rol
CREATE TABLE Rol (
    id BIGINT NOT NULL,
    nombre_rol VARCHAR(255) NOT NULL,
    CONSTRAINT PK_Rol PRIMARY KEY (id)
);
GO

-- Crear tabla Prioridad
CREATE TABLE Prioridad (
    id BIGINT NOT NULL,
    nombre_prioridad VARCHAR(255) NOT NULL,
    CONSTRAINT PK_Prioridad PRIMARY KEY (id)
);
GO

-- Crear tabla Estado
CREATE TABLE Estado (
    id BIGINT NOT NULL,
    nombre_estado VARCHAR(255) NOT NULL,
    CONSTRAINT PK_Estado PRIMARY KEY (id)
);
GO

-- Crear tabla Tarea
CREATE TABLE Tarea (
    id BIGINT NOT NULL,
    nombre_tarea VARCHAR(255) NOT NULL,
    desc_tarea VARCHAR(MAX) NULL,
    fecha_creacion DATE NOT NULL,
    fecha_limite DATE NULL,
    id_prioridad BIGINT NULL,
    id_estado BIGINT NULL,
    id_usuario BIGINT NULL,
    id_proyecto BIGINT NOT NULL,
    CONSTRAINT PK_Tarea PRIMARY KEY (id)
);
GO

-- Crear tabla Participa
CREATE TABLE Participa (
    id BIGINT NOT NULL,
    id_usuario BIGINT NOT NULL,
    id_rol BIGINT NOT NULL,
    id_proyecto BIGINT NOT NULL,
    CONSTRAINT PK_Participa PRIMARY KEY (id)
);
GO

-- Agregar claves foráneas
ALTER TABLE Participa 
    ADD CONSTRAINT FK_Participa_Usuario FOREIGN KEY (id_usuario) 
    REFERENCES Usuario(id);
GO

ALTER TABLE Participa 
    ADD CONSTRAINT FK_Participa_Proyecto FOREIGN KEY (id_proyecto) 
    REFERENCES Proyecto(id);
GO

ALTER TABLE Participa 
    ADD CONSTRAINT FK_Participa_Rol FOREIGN KEY (id_rol) 
    REFERENCES Rol(id);
GO

ALTER TABLE Tarea 
    ADD CONSTRAINT FK_Tarea_Proyecto FOREIGN KEY (id_proyecto) 
    REFERENCES Proyecto(id);
GO

ALTER TABLE Tarea 
    ADD CONSTRAINT FK_Tarea_Estado FOREIGN KEY (id_estado) 
    REFERENCES Estado(id);
GO

ALTER TABLE Tarea 
    ADD CONSTRAINT FK_Tarea_Usuario FOREIGN KEY (id_usuario) 
    REFERENCES Usuario(id);
GO

ALTER TABLE Tarea 
    ADD CONSTRAINT FK_Tarea_Prioridad FOREIGN KEY (id_prioridad) 
    REFERENCES Prioridad(id);
GO