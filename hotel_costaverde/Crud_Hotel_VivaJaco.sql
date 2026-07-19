-- Crear Cliente
CREATE OR REPLACE PROCEDURE insertar_cliente (
    p_nombre IN VARCHAR2,
    p_email IN VARCHAR2,
    p_telefono IN VARCHAR2,
    p_cedula IN VARCHAR2
)
IS
BEGIN
    INSERT INTO clientes (nombre, email, telefono, cedula, fecha_registro)
    VALUES (p_nombre, p_email, p_telefono, p_cedula, SYSDATE);
END;
/


-- Leer Cliente (Mediante ID)

CREATE OR REPLACE PROCEDURE consultar_cliente (
    p_id_cliente IN NUMBER
)
IS
    v_nombre clientes.nombre%TYPE;
    v_email clientes.email%TYPE;
    v_telefono clientes.telefono%TYPE;
    v_cedula clientes.cedula%TYPE;
    v_fecha clientes.fecha_registro%TYPE;
BEGIN
    SELECT nombre, email, telefono, cedula, fecha_registro
    INTO v_nombre, v_email, v_telefono, v_cedula, v_fecha
    FROM clientes
    WHERE id_cliente = p_id_cliente;

    DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
    DBMS_OUTPUT.PUT_LINE('Email: ' || v_email);
    DBMS_OUTPUT.PUT_LINE('Teléfono: ' || v_telefono);
    DBMS_OUTPUT.PUT_LINE('Cédula: ' || v_cedula);
    DBMS_OUTPUT.PUT_LINE('Fecha Registro: ' || v_fecha);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Cliente no encontrado.');
END;
/


-- Actualizar Cliente

CREATE OR REPLACE PROCEDURE actualizar_cliente (
    p_id_cliente IN NUMBER,
    p_nombre IN VARCHAR2,
    p_email IN VARCHAR2,
    p_telefono IN VARCHAR2,
    p_cedula IN VARCHAR2
)
IS
BEGIN
    UPDATE clientes
    SET nombre = p_nombre,
        email = p_email,
        telefono = p_telefono,
        cedula = p_cedula
    WHERE id_cliente = p_id_cliente;
END;
/

-- Eliminar Cliente

CREATE OR REPLACE PROCEDURE eliminar_cliente (
    p_id_cliente IN NUMBER
)
IS
BEGIN
    DELETE FROM clientes
    WHERE id_cliente = p_id_cliente;
END;
/


-- Crear habitacion

CREATE OR REPLACE PROCEDURE insertar_habitacion (
    p_id_hotel IN NUMBER,
    p_numero IN VARCHAR2,
    p_tipo IN VARCHAR2,
    p_precio_por_noche IN DECIMAL,
    p_capacidad IN NUMBER,
    p_estado IN VARCHAR2
)
IS
BEGIN
    INSERT INTO habitaciones (
        id_hotel, numero, tipo, precio_por_noche, capacidad, estado
    ) VALUES (
        p_id_hotel, p_numero, p_tipo, p_precio_por_noche, p_capacidad, p_estado
    );
END;
/


-- Leer habitacion (por el ID)

CREATE OR REPLACE PROCEDURE consultar_habitacion (
    p_id_habitacion IN NUMBER
)
IS
    v_numero habitaciones.numero%TYPE;
    v_tipo habitaciones.tipo%TYPE;
    v_precio habitaciones.precio_por_noche%TYPE;
    v_capacidad habitaciones.capacidad%TYPE;
    v_estado habitaciones.estado%TYPE;
BEGIN
    SELECT numero, tipo, precio_por_noche, capacidad, estado
    INTO v_numero, v_tipo, v_precio, v_capacidad, v_estado
    FROM habitaciones
    WHERE id_habitacion = p_id_habitacion;

    DBMS_OUTPUT.PUT_LINE('Número: ' || v_numero);
    DBMS_OUTPUT.PUT_LINE('Tipo: ' || v_tipo);
    DBMS_OUTPUT.PUT_LINE('Precio/Noche: ' || v_precio);
    DBMS_OUTPUT.PUT_LINE('Capacidad: ' || v_capacidad);
    DBMS_OUTPUT.PUT_LINE('Estado: ' || v_estado);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Habitación no encontrada.');
END;
/


-- Actualizar habitacion 

CREATE OR REPLACE PROCEDURE actualizar_habitacion (
    p_id_habitacion IN NUMBER,
    p_numero IN VARCHAR2,
    p_tipo IN VARCHAR2,
    p_precio_por_noche IN DECIMAL,
    p_capacidad IN NUMBER,
    p_estado IN VARCHAR2
)
IS
BEGIN
    UPDATE habitaciones
    SET numero = p_numero,
        tipo = p_tipo,
        precio_por_noche = p_precio_por_noche,
        capacidad = p_capacidad,
        estado = p_estado
    WHERE id_habitacion = p_id_habitacion;
END;
/


-- Eliminar habitacion

CREATE OR REPLACE PROCEDURE eliminar_habitacion (
    p_id_habitacion IN NUMBER
)
IS
BEGIN
    DELETE FROM habitaciones
    WHERE id_habitacion = p_id_habitacion;
END;
/


-- Crear Reserva

CREATE OR REPLACE PROCEDURE insertar_reserva (
    p_id_cliente IN NUMBER,
    p_fecha_entrada IN DATE,
    p_fecha_salida IN DATE,
    p_estado IN VARCHAR2,
    p_id_habitacion IN NUMBER
)
IS
BEGIN
    INSERT INTO reservas (
        id_cliente, fecha_entrada, fecha_salida, estado, id_habitacion
    ) VALUES (
        p_id_cliente, p_fecha_entrada, p_fecha_salida, p_estado, p_id_habitacion
    );
END;
/

-- Leer Reserva (por el ID)

CREATE OR REPLACE PROCEDURE consultar_reserva (
    p_id_reserva IN NUMBER
)
IS
    v_id_cliente reservas.id_cliente%TYPE;
    v_fecha_entrada reservas.fecha_entrada%TYPE;
    v_fecha_salida reservas.fecha_salida%TYPE;
    v_estado reservas.estado%TYPE;
    v_id_habitacion reservas.id_habitacion%TYPE;
BEGIN
    SELECT id_cliente, fecha_entrada, fecha_salida, estado, id_habitacion
    INTO v_id_cliente, v_fecha_entrada, v_fecha_salida, v_estado, v_id_habitacion
    FROM reservas
    WHERE id_reserva = p_id_reserva;

    DBMS_OUTPUT.PUT_LINE('Cliente ID: ' || v_id_cliente);
    DBMS_OUTPUT.PUT_LINE('Entrada: ' || v_fecha_entrada);
    DBMS_OUTPUT.PUT_LINE('Salida: ' || v_fecha_salida);
    DBMS_OUTPUT.PUT_LINE('Estado: ' || v_estado);
    DBMS_OUTPUT.PUT_LINE('Habitación ID: ' || v_id_habitacion);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Reserva no encontrada.');
END;
/


-- Actualizar Reserva 

CREATE OR REPLACE PROCEDURE actualizar_reserva (
    p_id_reserva IN NUMBER,
    p_id_cliente IN NUMBER,
    p_fecha_entrada IN DATE,
    p_fecha_salida IN DATE,
    p_estado IN VARCHAR2,
    p_id_habitacion IN NUMBER
)
IS
BEGIN
    UPDATE reservas
    SET id_cliente = p_id_cliente,
        fecha_entrada = p_fecha_entrada,
        fecha_salida = p_fecha_salida,
        estado = p_estado,
        id_habitacion = p_id_habitacion
    WHERE id_reserva = p_id_reserva;
END;
/


-- Eliminar Reserva

CREATE OR REPLACE PROCEDURE eliminar_reserva (
    p_id_reserva IN NUMBER
)
IS
BEGIN
    DELETE FROM reservas
    WHERE id_reserva = p_id_reserva;
END;
/


-- Crear Usuario

CREATE OR REPLACE PROCEDURE insertar_usuario (
    p_nombre IN VARCHAR2,
    p_email IN VARCHAR2,
    p_password IN VARCHAR2,
    p_id_rol IN NUMBER
)
IS
BEGIN
    INSERT INTO usuarios (nombre, email, password, id_rol)
    VALUES (p_nombre, p_email, p_password, p_id_rol);
END;
/


-- Leer Usuario (por ID)

CREATE OR REPLACE PROCEDURE consultar_usuario (
    p_id_usuario IN NUMBER
)
IS
    v_nombre usuarios.nombre%TYPE;
    v_email usuarios.email%TYPE;
    v_id_rol usuarios.id_rol%TYPE;
BEGIN
    SELECT nombre, email, id_rol
    INTO v_nombre, v_email, v_id_rol
    FROM usuarios
    WHERE id_usuario = p_id_usuario;

    DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
    DBMS_OUTPUT.PUT_LINE('Email: ' || v_email);
    DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_id_rol);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Usuario no encontrado.');
END;
/


-- Actualizar Usuario

CREATE OR REPLACE PROCEDURE actualizar_usuario (
    p_id_usuario IN NUMBER,
    p_nombre IN VARCHAR2,
    p_email IN VARCHAR2,
    p_password IN VARCHAR2,
    p_id_rol IN NUMBER
)
IS
BEGIN
    UPDATE usuarios
    SET nombre = p_nombre,
        email = p_email,
        password = p_password,
        id_rol = p_id_rol
    WHERE id_usuario = p_id_usuario;
END;
/


-- Eliminar Usuario

CREATE OR REPLACE PROCEDURE eliminar_usuario (
    p_id_usuario IN NUMBER
)
IS
BEGIN
    DELETE FROM usuarios
    WHERE id_usuario = p_id_usuario;
END;
/


-- Crear Servicio

CREATE OR REPLACE PROCEDURE insertar_servicio (
    p_nombre IN VARCHAR2,
    p_precio IN NUMBER
)
IS
BEGIN
    INSERT INTO servicios (nombre, precio)
    VALUES (p_nombre, p_precio);
END;
/


-- Leer Servicio

CREATE OR REPLACE PROCEDURE consultar_servicio (
    p_id_servicio IN NUMBER
)
IS
    v_nombre servicios.nombre%TYPE;
    v_precio servicios.precio%TYPE;
BEGIN
    SELECT nombre, precio
    INTO v_nombre, v_precio
    FROM servicios
    WHERE id_servicio = p_id_servicio;

    DBMS_OUTPUT.PUT_LINE('Nombre del servicio: ' || v_nombre);
    DBMS_OUTPUT.PUT_LINE('Precio: ' || v_precio);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Servicio no encontrado.');
END;
/


-- Actualizar Servicio

CREATE OR REPLACE PROCEDURE actualizar_servicio (
    p_id_servicio IN NUMBER,
    p_nombre IN VARCHAR2,
    p_precio IN NUMBER
)
IS
BEGIN
    UPDATE servicios
    SET nombre = p_nombre,
        precio = p_precio
    WHERE id_servicio = p_id_servicio;
END;
/


-- Eliminar Servicio

CREATE OR REPLACE PROCEDURE eliminar_servicio (
    p_id_servicio IN NUMBER
)
IS
BEGIN
    DELETE FROM servicios
    WHERE id_servicio = p_id_servicio;
END;
/


-- Crear Factura

CREATE OR REPLACE PROCEDURE insertar_factura (
    p_id_reserva IN NUMBER,
    p_monto_total IN NUMBER,
    p_metodo_pago IN VARCHAR2,
    p_estado IN VARCHAR2
)
IS
BEGIN
    INSERT INTO facturas (
        id_reserva, fecha_emision, monto_total, metodo_pago, estado
    ) VALUES (
        p_id_reserva, SYSDATE, p_monto_total, p_metodo_pago, p_estado
    );
END;
/


-- Leer Factura

CREATE OR REPLACE PROCEDURE consultar_factura (
    p_id_factura IN NUMBER
)
IS
    v_id_reserva facturas.id_reserva%TYPE;
    v_fecha facturas.fecha_emision%TYPE;
    v_monto facturas.monto_total%TYPE;
    v_pago facturas.metodo_pago%TYPE;
    v_estado facturas.estado%TYPE;
BEGIN
    SELECT id_reserva, fecha_emision, monto_total, metodo_pago, estado
    INTO v_id_reserva, v_fecha, v_monto, v_pago, v_estado
    FROM facturas
    WHERE id_factura = p_id_factura;

    DBMS_OUTPUT.PUT_LINE('Reserva ID: ' || v_id_reserva);
    DBMS_OUTPUT.PUT_LINE('Fecha Emisión: ' || v_fecha);
    DBMS_OUTPUT.PUT_LINE('Monto Total: ' || v_monto);
    DBMS_OUTPUT.PUT_LINE('Método Pago: ' || v_pago);
    DBMS_OUTPUT.PUT_LINE('Estado: ' || v_estado);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Factura no encontrada.');
END;
/


-- Actualizar Factura

CREATE OR REPLACE PROCEDURE actualizar_factura (
    p_id_factura IN NUMBER,
    p_id_reserva IN NUMBER,
    p_monto_total IN NUMBER,
    p_metodo_pago IN VARCHAR2,
    p_estado IN VARCHAR2
)
IS
BEGIN
    UPDATE facturas
    SET id_reserva = p_id_reserva,
        monto_total = p_monto_total,
        metodo_pago = p_metodo_pago,
        estado = p_estado
    WHERE id_factura = p_id_factura;
END;
/


-- Eliminar Factura

CREATE OR REPLACE PROCEDURE eliminar_factura (
    p_id_factura IN NUMBER
)
IS
BEGIN
    DELETE FROM facturas
    WHERE id_factura = p_id_factura;
END;
/


-- Crear Rol

CREATE OR REPLACE PROCEDURE insertar_rol (
    p_nombre_rol IN VARCHAR2
)
IS
BEGIN
    INSERT INTO roles (nombre_rol)
    VALUES (p_nombre_rol);
END;
/


-- Leer Rol (Por ID)

CREATE OR REPLACE PROCEDURE consultar_rol (
    p_id_rol IN NUMBER
)
IS
    v_nombre roles.nombre_rol%TYPE;
BEGIN
    SELECT nombre_rol
    INTO v_nombre
    FROM roles
    WHERE id_rol = p_id_rol;

    DBMS_OUTPUT.PUT_LINE('Rol: ' || v_nombre);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Rol no encontrado.');
END;
/


-- Actualizar Rol

CREATE OR REPLACE PROCEDURE actualizar_rol (
    p_id_rol IN NUMBER,
    p_nombre_rol IN VARCHAR2
)
IS
BEGIN
    UPDATE roles
    SET nombre_rol = p_nombre_rol
    WHERE id_rol = p_id_rol;
END;
/


-- Eliminar Rol

CREATE OR REPLACE PROCEDURE eliminar_rol (
    p_id_rol IN NUMBER
)
IS
BEGIN
    DELETE FROM roles
    WHERE id_rol = p_id_rol;
END;
/


-- Crear Permiso

CREATE OR REPLACE PROCEDURE insertar_permiso (
    p_nombre_permiso IN VARCHAR2
)
IS
BEGIN
    INSERT INTO permisos (nombre_permiso)
    VALUES (p_nombre_permiso);
END;
/


-- Leer Permiso (Por ID)

CREATE OR REPLACE PROCEDURE consultar_permiso (
    p_id_permiso IN NUMBER
)
IS
    v_nombre permisos.nombre_permiso%TYPE;
BEGIN
    SELECT nombre_permiso
    INTO v_nombre
    FROM permisos
    WHERE id_permiso = p_id_permiso;

    DBMS_OUTPUT.PUT_LINE('Permiso: ' || v_nombre);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Permiso no encontrado.');
END;
/


-- Actualizar Permiso

CREATE OR REPLACE PROCEDURE actualizar_permiso (
    p_id_permiso IN NUMBER,
    p_nombre_permiso IN VARCHAR2
)
IS
BEGIN
    UPDATE permisos
    SET nombre_permiso = p_nombre_permiso
    WHERE id_permiso = p_id_permiso;
END;
/


-- Eliminar Permiso

CREATE OR REPLACE PROCEDURE eliminar_permiso (
    p_id_permiso IN NUMBER
)
IS
BEGIN
    DELETE FROM permisos
    WHERE id_permiso = p_id_permiso;
END;
/


-- Asignar Permiso a un Rol (Insertar)

CREATE TABLE rol_permiso (
    id_rol NUMBER,
    id_permiso NUMBER,
    PRIMARY KEY (id_rol, id_permiso)
);

-- Consultar Permisos de un Rol

CREATE OR REPLACE PROCEDURE consultar_permisos_por_rol (
    p_id_rol IN NUMBER
)
IS
    CURSOR c_permisos IS
        SELECT id_permiso
        FROM rol_permiso
        WHERE id_rol = p_id_rol;
BEGIN
    FOR r IN c_permisos LOOP
        DBMS_OUTPUT.PUT_LINE('Permiso ID asignado: ' || r.id_permiso);
    END LOOP;

    IF c_permisos%NOTFOUND THEN
        DBMS_OUTPUT.PUT_LINE('El rol no tiene permisos asignados.');
    END IF;
END;
/


-- Eliminar Permiso de un Rol (Eliminar)

CREATE OR REPLACE PROCEDURE eliminar_permiso_de_rol (
    p_id_rol IN NUMBER,
    p_id_permiso IN NUMBER
)
IS
BEGIN
    DELETE FROM rol_permiso
    WHERE id_rol = p_id_rol AND id_permiso = p_id_permiso;
END;
/


-- Eliminar todos los Permisos de un Rol

CREATE OR REPLACE PROCEDURE eliminar_todos_permisos_de_rol (
    p_id_rol IN NUMBER
)
IS
BEGIN
    DELETE FROM rol_permiso
    WHERE id_rol = p_id_rol;
END;
/


-- Asignar Servicio a una Reserva (Insertar)

CREATE OR REPLACE PROCEDURE asignar_servicio_a_reserva (
    p_id_reserva IN NUMBER,
    p_id_servicio IN NUMBER,
    p_cantidad IN NUMBER
)
IS
BEGIN
    INSERT INTO reserva_servicio (id_reserva, id_servicio, cantidad)
    VALUES (p_id_reserva, p_id_servicio, p_cantidad);
END;
/


-- Consultar Servicios de una reserva 

CREATE OR REPLACE PROCEDURE consultar_servicios_por_reserva (
    p_id_reserva IN NUMBER
)
IS
    CURSOR c_servicios IS
        SELECT id_servicio, cantidad
        FROM reserva_servicio
        WHERE id_reserva = p_id_reserva;
BEGIN
    FOR r IN c_servicios LOOP
        DBMS_OUTPUT.PUT_LINE('Servicio ID: ' || r.id_servicio || ' - Cantidad: ' || r.cantidad);
    END LOOP;

    IF c_servicios%NOTFOUND THEN
        DBMS_OUTPUT.PUT_LINE('La reserva no tiene servicios asignados.');
    END IF;
END;
/


-- Actualizar Servicio Asignado a una Reserva

CREATE OR REPLACE PROCEDURE actualizar_servicio_reserva (
    p_id_reserva IN NUMBER,
    p_id_servicio IN NUMBER,
    p_cantidad IN NUMBER
)
IS
BEGIN
    UPDATE reserva_servicio
    SET cantidad = p_cantidad
    WHERE id_reserva = p_id_reserva AND id_servicio = p_id_servicio;
END;
/


-- Eliminar Servicio de una Reserva

CREATE OR REPLACE PROCEDURE eliminar_servicio_de_reserva (
    p_id_reserva IN NUMBER,
    p_id_servicio IN NUMBER
)
IS
BEGIN
    DELETE FROM reserva_servicio
    WHERE id_reserva = p_id_reserva AND id_servicio = p_id_servicio;
END;
/


-- Vistas

CREATE OR REPLACE VIEW vista_reservas_detalle AS
SELECT r.id_reserva, c.nombre AS cliente, h.numero AS habitacion, r.fecha_entrada, r.fecha_salida, r.estado
FROM reservas r
JOIN clientes c ON r.id_cliente = c.id_cliente
JOIN habitaciones h ON r.id_habitacion = h.id_habitacion;

CREATE OR REPLACE VIEW vista_facturas_cliente AS
SELECT f.id_factura, c.nombre AS cliente, f.fecha_emision, f.monto_total, f.metodo_pago, f.estado
FROM facturas f
JOIN reservas r ON f.id_reserva = r.id_reserva
JOIN clientes c ON r.id_cliente = c.id_cliente;

CREATE OR REPLACE VIEW vista_habitaciones_disponibles AS
SELECT id_habitacion, numero, tipo, precio_por_noche, capacidad
FROM habitaciones
WHERE estado = 'Disponible';

CREATE OR REPLACE VIEW vista_servicios_reserva AS
SELECT r.id_reserva, s.nombre AS servicio, rs.cantidad
FROM reserva_servicio rs
JOIN reservas r ON rs.id_reserva = r.id_reserva
JOIN servicios s ON rs.id_servicio = s.id_servicio;

CREATE OR REPLACE VIEW vista_usuarios_roles AS
SELECT u.id_usuario, u.nombre, u.email, r.nombre_rol
FROM usuarios u
JOIN roles r ON u.id_rol = r.id_rol;

CREATE OR REPLACE VIEW vista_servicios_caros AS
SELECT nombre, precio
FROM servicios
WHERE precio > 50000
ORDER BY precio DESC;

CREATE OR REPLACE VIEW vista_reservas_activas_futuras AS
SELECT r.id_reserva, c.nombre AS cliente, r.fecha_entrada, r.fecha_salida, r.estado
FROM reservas r
JOIN clientes c ON r.id_cliente = c.id_cliente
WHERE r.estado IN ('Activa', 'Reservada');

CREATE OR REPLACE VIEW vista_conteo_habitaciones_por_tipo AS
SELECT tipo, COUNT(*) AS cantidad
FROM habitaciones
GROUP BY tipo;

CREATE OR REPLACE VIEW vista_servicios_por_cliente AS
SELECT c.nombre AS cliente, s.nombre AS servicio, rs.cantidad
FROM reserva_servicio rs
JOIN reservas r ON rs.id_reserva = r.id_reserva
JOIN clientes c ON r.id_cliente = c.id_cliente
JOIN servicios s ON rs.id_servicio = s.id_servicio;

CREATE OR REPLACE VIEW vista_promedio_monto_por_metodo_pago AS
SELECT metodo_pago, AVG(monto_total) AS promedio_monto
FROM facturas
GROUP BY metodo_pago;


BEGIN
    consultar_cliente(1);
END;
/


BEGIN
    actualizar_cliente(
        1,
        'Jorge Hernández',
        'jorge_nuevo@gmail.com',
        '88888888',
        '123456789'
    );
END;
/

