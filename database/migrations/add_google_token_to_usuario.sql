-- Script para añadir campos de Google Token a la tabla Usuario
-- Ejecutar en SQL Server / Azure SQL

ALTER TABLE "Usuario" ADD "google_token" NVARCHAR(MAX) NULL;
ALTER TABLE "Usuario" ADD "google_token_expires_at" DATETIME2 NULL;
