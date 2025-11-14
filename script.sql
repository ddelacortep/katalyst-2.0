-- Crear la base de datos Katalyst
CREATE DATABASE Katalyst;
GO

-- Usar la base de datos
USE Katalyst;
GO

-- Tabla Usuario
CREATE TABLE Usuario (
    id BIGINT NOT NULL,
    nombre_usuario VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    CONSTRAINT usuario_id_primary PRIMARY KEY (id)
);
GO

-- Tabla Rol
CREATE TABLE Rol (
    id BIGINT NOT NULL,
    nombre_rol VARCHAR(255) NOT NULL,
    CONSTRAINT rol_id_primary PRIMARY KEY (id)
);
GO

-- Tabla Prioridad
CREATE TABLE Prioridad (
    id BIGINT NOT NULL,
    nombre_prioridad VARCHAR(255) NOT NULL,
    CONSTRAINT prioridad_id_primary PRIMARY KEY (id)
);
GO

-- Tabla Estado
CREATE TABLE Estado (
    id BIGINT NOT NULL,
    nombre_estado VARCHAR(255) NOT NULL,
    CONSTRAINT estado_id_primary PRIMARY KEY (id)
);
GO

-- Tabla Tarea
CREATE TABLE Tarea (
    id BIGINT NOT NULL,
    nombre_tarea VARCHAR(255) NOT NULL,
    desc_tarea VARCHAR(MAX) NULL,
    fecha_creacion DATE NOT NULL,
    fecha_limite DATE NULL,
    id_prioridad BIGINT NULL,
    id_estado BIGINT NULL,
    id_usuario BIGINT NULL,
    CONSTRAINT tarea_id_primary PRIMARY KEY (id),
    CONSTRAINT tarea_id_prioridad_foreign FOREIGN KEY (id_prioridad) REFERENCES Prioridad(id),
    CONSTRAINT tarea_id_estado_foreign FOREIGN KEY (id_estado) REFERENCES Estado(id),
    CONSTRAINT tarea_id_usuario_foreign FOREIGN KEY (id_usuario) REFERENCES Usuario(id)
);
GO

-- Tabla Proyecto
CREATE TABLE Proyecto (
    id BIGINT NOT NULL,
    nombre_proyecto VARCHAR(255) NOT NULL,
    favorito BIT NULL,
    id_tarea BIGINT NOT NULL,
    CONSTRAINT proyecto_id_primary PRIMARY KEY (id),
    CONSTRAINT proyecto_id_tarea_foreign FOREIGN KEY (id_tarea) REFERENCES Tarea(id)
);
GO

-- Tabla Participa
CREATE TABLE Participa (
    id BIGINT NOT NULL,
    id_usuario BIGINT NOT NULL,
    id_rol BIGINT NOT NULL,
    id_proyecto BIGINT NOT NULL,
    CONSTRAINT participa_id_primary PRIMARY KEY (id),
    CONSTRAINT participa_id_usuario_foreign FOREIGN KEY (id_usuario) REFERENCES Usuario(id),
    CONSTRAINT participa_id_rol_foreign FOREIGN KEY (id_rol) REFERENCES Rol(id),
    CONSTRAINT participa_id_proyecto_foreign FOREIGN KEY (id_proyecto) REFERENCES Proyecto(id)
);
GO