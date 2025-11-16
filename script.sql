CREATE DATABASE Katalyst;
GO
USE Katalyst;

CREATE TABLE "Usuario"(
    "id" BIGINT NOT NULL,
    "nombre_usuario" VARCHAR(255) NOT NULL,
    "correo" VARCHAR(255) NOT NULL,
    "contrasena" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "Usuario" ADD CONSTRAINT "usuario_id_primary" PRIMARY KEY("id");
CREATE TABLE "Proyecto"(
    "id" BIGINT IDENTITY(1,1) NOT NULL,
    "nombre_proyecto" VARCHAR(255) NOT NULL,
    "favorito" BINARY(16) NULL
);
ALTER TABLE
    "Proyecto" ADD CONSTRAINT "proyecto_id_primary" PRIMARY KEY("id");
CREATE TABLE "Tarea"(
    "id" BIGINT NOT NULL,
    "nombre_tarea" VARCHAR(255) NOT NULL,
    "desc_tarea" BIGINT NULL,
    "fecha_creacion" DATE NOT NULL,
    "fecha_limite" DATE NULL,
    "id_prioridad" BIGINT NULL,
    "id_estado" BIGINT NULL,
    "id_usuario" BIGINT NULL,
    "id_proyecto" BIGINT NOT NULL
);
ALTER TABLE
    "Tarea" ADD CONSTRAINT "tarea_id_primary" PRIMARY KEY("id");
CREATE TABLE "Rol"(
    "id" BIGINT NOT NULL,
    "nombre_rol" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "Rol" ADD CONSTRAINT "rol_id_primary" PRIMARY KEY("id");
CREATE TABLE "Prioridad"(
    "id" BIGINT NOT NULL,
    "nombre_prioridad" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "Prioridad" ADD CONSTRAINT "prioridad_id_primary" PRIMARY KEY("id");
CREATE TABLE "Participa"(
    "id" BIGINT NOT NULL,
    "id_usuario" BIGINT NOT NULL,
    "id_rol" BIGINT NOT NULL,
    "id_proyecto" BIGINT NOT NULL
);
ALTER TABLE
    "Participa" ADD CONSTRAINT "participa_id_primary" PRIMARY KEY("id");
CREATE TABLE "Estado"(
    "id" BIGINT NOT NULL,
    "nombre_estado" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "Estado" ADD CONSTRAINT "estado_id_primary" PRIMARY KEY("id");
ALTER TABLE
    "Participa" ADD CONSTRAINT "participa_id_usuario_foreign" FOREIGN KEY("id_usuario") REFERENCES "Usuario"("id");
ALTER TABLE
    "Participa" ADD CONSTRAINT "participa_id_proyecto_foreign" FOREIGN KEY("id_proyecto") REFERENCES "Proyecto"("id");
ALTER TABLE
    "Tarea" ADD CONSTRAINT "tarea_id_proyecto_foreign" FOREIGN KEY("id_proyecto") REFERENCES "Proyecto"("id");
ALTER TABLE
    "Participa" ADD CONSTRAINT "participa_id_rol_foreign" FOREIGN KEY("id_rol") REFERENCES "Rol"("id");
ALTER TABLE
    "Tarea" ADD CONSTRAINT "tarea_id_estado_foreign" FOREIGN KEY("id_estado") REFERENCES "Estado"("id");
ALTER TABLE
    "Tarea" ADD CONSTRAINT "tarea_id_usuario_foreign" FOREIGN KEY("id_usuario") REFERENCES "Usuario"("id");
ALTER TABLE
    "Tarea" ADD CONSTRAINT "tarea_id_prioridad_foreign" FOREIGN KEY("id_prioridad") REFERENCES "Prioridad"("id");