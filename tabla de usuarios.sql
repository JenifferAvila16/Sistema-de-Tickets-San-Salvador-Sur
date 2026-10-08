-- =====================================================
-- 1. TABLA DE USUARIOS (para autenticación)
-- ====================================================
POSTGRESQL

CREATE OR REPLACE FUNCTION actualizar_fecha_modificacion()
RETURNS TRIGGER AS $$
BEGIN
    -- Se adapta para que sirva dinámicamente en ambas tablas detectando el nombre de la columna
    IF TG_TABLE_NAME = 'solicitantes' THEN
        NEW.fecha_de_actualizacion = CURRENT_TIMESTAMP;
    ELSE
        NEW.fecha_actualizacion = CURRENT_TIMESTAMP;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
Create Table solicitantes(

    id 						BIGINT  GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre 					VARCHAR(100) NOT NULL,
	apellido 				VARCHAR (100) NOT NULL,
	cargo  					VARCHAR (120),
	departamento_unidad 	VARCHAR (120),
	distrito 				VARCHAR(120)NOT NULL CHECK (distrito IN ('San Marcos', 'Santo Tomas', 'Panchimalco', 'Santiago Texacuangos', 'Rosario de Mora')),
	correo_institucional 	VARCHAR (254) NOT NULL UNIQUE,
	telefono 				VARCHAR(25),
	nombre_solicitante 		VARCHAR(50)NOT NULL UNIQUE,
	contrasena_hash 		TEXT NOT NULL,  -- Guardar hash con bcrypt
    rol 					VARCHAR(20) NOT NULL DEFAULT 'solicitante'
			CHECK (rol IN ('Administrador', 'agente', 'solicitante')),
    estado 					VARCHAR NOT NULL DEFAULT 'activo'
			CHECK(estado IN('activo','inactivo', 'bloqueado')),
    fecha_creacion 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   fecha_de_actualizacion 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE OR REPLACE FUNCTION actualizar_fecha_solicitante()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_de_actualizacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_solicitantes_fecha_actualizacion
BEFORE UPDATE ON solicitantes
FOR EACH ROW
EXECUTE FUNCTION actualizar_fecha_modificacion();

create table tickets(
	 id 						BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
	solicitante_id 			BIGINT NOT NULL REFERENCES solicitantes(id),
	categoria				VARCHAR(100) NOT NULL DEFAULT 'Hardware'
						CHECK(categoria IN ('Hardware', 'Software')),
	sub_categoria			VARCHAR(100),
	prioridad				VARCHAR(15) NOT NULL DEFAULT 'media'
						CHECK(prioridad IN('baja', 'media', 'alta', 'urgente')),
	asunto					VARCHAR(200) NOT NULL,
	descripcion_detallada 	TEXT NOT NULL,
	ubicacion				VARCHAR(200),
	edificio				VARCHAR(150),
	departamento_unidad		VARCHAR(150),
	equipo_afectado			VARCHAR(200),
	tipo_equipo				VARCHAR(200),
	numero_inventario		VARCHAR(100),
	telefono_extension		VARCHAR (30),
	estado					VARCHAR (20) NOT NULL DEFAULT 'abierto'
						check(estado IN ('abierto', 'pendiente','asignado', 'en progreso', 'resuelto', 'cerrado')),
	fecha_creacion			TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
	fecha_actualizacion		TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP

);
CREATE TABLE tickets_adjuntos (
    id                  BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ticket_id           BIGINT NOT NULL REFERENCES tickets(id) ON DELETE CASCADE,
    nombre_archivo      VARCHAR(255) NOT NULL,
    ruta_almacenamiento TEXT NOT NULL,
    tipo_mime           VARCHAR(150),
    tamano_bytes        BIGINT CHECK (tamano_bytes IS NULL OR tamano_bytes >= 0),
    fecha_creacion      TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_ticket_solicitante_id ON tickets(solicitante_id);
CREATE INDEX idx_ticket_estado ON tickets(estado);
CREATE INDEX idx_ticket_fecha_creacion ON tickets(fecha_creacion DESC);
CREATE INDEX idx_ticket_adjuntos_ticket_id ON tickets_adjuntos(ticket_id);

-- Actualiza automáticamente la fecha al modificar un ticket.
CREATE OR REPLACE FUNCTION actualizar_fecha_modificacion()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_actualizacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_tickets_fecha_actualizacion
BEFORE UPDATE ON tickets
FOR EACH ROW
EXECUTE FUNCTION actualizar_fecha_modificacion();

CREATE TABLE tickets_historial(
	id 				BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
	ticket_id		BIGINT NOT NULL REFERENCES tickets(id) ON DELETE CASCADE,
	solicitante_id	BIGINT REFERENCES solicitantes(id) ON DELETE SET NULL,
	estado_anterior	VARCHAR(20),
	estado_nuevo	VARCHAR(20) NOT NULL,
	comentario		TEXT,
	fecha_cambio	TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

	CHECK(
	 	estado_anterior IS NULL OR
		estado_anterior IN(

		'abierto', 'pendiente','asignado', 'en progreso', 'resuelto', 'cerrado'
		)

),
	CHECK(
		estado_nuevo IN(
		'abierto', 'pendiente','asignado', 'en progreso', 'resuelto', 'cerrado')
		)
);

CREATE INDEX idx_ticket_historial_ticket_id ON tickets_historial(ticket_id);
