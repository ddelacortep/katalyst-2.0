ALTER TABLE "Tarea" ADD "id_usuario_creador" BIGINT NULL;

ALTER TABLE "Tarea" ADD "id_usuario_asignado" BIGINT NULL;

ALTER TABLE "Tarea" 
ADD CONSTRAINT "tarea_id_usuario_creador_foreign" 
FOREIGN KEY("id_usuario_creador") REFERENCES "Usuario"("id");

ALTER TABLE "Tarea" 
ADD CONSTRAINT "tarea_id_usuario_asignado_foreign" 
FOREIGN KEY("id_usuario_asignado") REFERENCES "Usuario"("id");

UPDATE "Tarea" 
SET "id_usuario_creador" = "id_usuario" 
WHERE "id_usuario" IS NOT NULL;
