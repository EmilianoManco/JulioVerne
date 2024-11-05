/*CREATE DATABASE julioVerne;
USE julioVerne;*/
/*SELECT lib_id, lib_nombre, lib_anio_publicacion, lib_isbn, libros.gen_id, generos.gen_desc, libros.edi_id, editoriales.edi_desc FROM julioVerne.libros INNER JOIN
julioVerne.generos ON libros.gen_id = generos.gen_id
INNER JOIN julioVerne.editoriales ON libros.edi_id = editoriales.edi_id;

SELECT aut_x_libr.aut_id, autores.aut_id, autores.aut_desc, libros.lib_id FROM julioVerne.aut_x_libr INNER JOIN 
julioVerne.autores ON aut_x_libr.aut_id = autores.aut_id;

SELECT * FROM aut_x_libr;

SELECT * FROM libros;

SELECT * FROM usuarios;
SELECT 
    libros.lib_id, 
    libros.lib_nombre, 
    libros.lib_anio_publicacion, 
    libros.lib_isbn, 
    libros.gen_id, 
    generos.gen_desc, 
    libros.edi_id, 
    editoriales.edi_desc, 
    autores.aut_id, 
    autores.aut_desc
FROM 
    julioVerne.libros
INNER JOIN 
    julioVerne.generos ON libros.gen_id = generos.gen_id
INNER JOIN 
    julioVerne.editoriales ON libros.edi_id = editoriales.edi_id
LEFT JOIN 
    julioVerne.aut_x_libr ON libros.lib_id = aut_x_libr.lib_id
LEFT JOIN 
    julioVerne.autores ON aut_x_libr.aut_id = autores.aut_id;
*/

CREATE TABLE roles(

	rol_id INT,
    rol_desc VARCHAR(15),

	PRIMARY KEY(rol_id)
);

INSERT INTO roles(rol_id, rol_desc)
VALUES(1, "administrador"),
(2, "empleado"),
(3, "contador");





CREATE TABLE localidades(

	loc_id INT,
    loc_desc VARCHAR(30),

	PRIMARY KEY(loc_id)
);

INSERT INTO localidades(loc_id, loc_desc)
VALUES (01, "Almirante Brown"),
(02, "Avellaneda"),
(03, "Berazategui"),
(04, "Berisso"),
(05, "Canuelas"),
(06, "Ensenada"),
(07, "Esteban Echeverría"),
(08, "Ezeiza"),
(09, "Florencio Varela"),
(10, "La Plata"),
(11, "Lanus"),
(12, "Lomas de Zamora"),
(13, "Presidente Perón"),
(14, "Quilmes"),
(15, "San Vicente"); 




CREATE TABLE sucursales(

	suc_id INT AUTO_INCREMENT,
    suc_nombre VARCHAR(30),
    suc_calle VARCHAR(40),
    suc_calle_nro INT(4),
    suc_telefono INT(11),
    suc_codigo_postal INT(4),
    loc_id INT,
    
	PRIMARY KEY(suc_id),
	FOREIGN KEY (loc_id) REFERENCES localidades(loc_id)
);


INSERT INTO sucursales (suc_id, suc_nombre, suc_calle, suc_calle_nro, suc_telefono, suc_codigo_postal, loc_id)
VALUES(01, "JV - Berazategui", "calle 13", 1580, 1189874467, 1880, 03),
(02, "JV - Avellaneda", "belgrano", 2575, 1189745531, 1870, 02),
(03, "JV - Quilmes", "AV. Rivadavia", 334, 1143567800, 1818, 14); 

CREATE TABLE usuarios(

	usu_id INT NOT NULL AUTO_INCREMENT,
    usu_nombre VARCHAR(25),
    usu_apellido VARCHAR(25),
    usu_correo VARCHAR(35),
    usu_clave VARCHAR(20) NOT NULL,
    usu_telefono INT(10),
    usu_dni INT(8),
    usu_estado BOOL, /* 0 inactivo 1 activo*/
    rol_id INT,
    usu_token VARCHAR(6),
    suc_id INT,
    
    PRIMARY KEY (usu_id),
    FOREIGN KEY (rol_id) REFERENCES roles(rol_id),
    FOREIGN KEY (suc_id) REFERENCES sucursales(suc_id)
    ON UPDATE cascade ON DELETE cascade /* Esto sirve para modificar y eliminar sin errores*/

);

INSERT INTO usuarios(usu_nombre, usu_apellido, usu_correo, usu_clave, usu_telefono, usu_dni, usu_estado, rol_id, suc_id)
VALUES ("Roberto", "Perez", "roberto_perez@gmail.com", "perez321", 1184765583, 40895214, 1, 1, 3),
("matias", "villareal", "mati_villareal@gmail.com", "mati321", 1184765583, 40895214, 1, 2, 3),
("maria", "palacios", "mariapala@gmail.com", "maria321", 1184765583, 40895214, 1, 3, 3);




CREATE TABLE generos(

	gen_id INT NOT NULL,
    gen_desc VARCHAR(25),
    
    PRIMARY KEY(gen_id)
);

 INSERT INTO generos (gen_id, gen_desc)
VALUES (1, "Cuentos Infantiles"),
(2, "Novelas"),
(3, "Biografias"),
(4, "Comic"),
(5, "Thriller"),
(6, "Manga"),
(7, "Romantico"),
(8, "Ciencia Ficcion"),
(9, "Aventura"),
(10, "Poesia"); 



CREATE TABLE autores(

	aut_id INT NOT NULL,
    aut_desc VARCHAR(35),

	PRIMARY KEY(aut_id)
);

INSERT INTO autores (aut_id, aut_desc)
VALUES (01, "Julio Verne"),
(02, "Edgar Allan Poe"),
(03, "Agatha Chistie"),
(04, "García Lorca"),
(05, "Franz Kafka"),
(06, "Stephen King"),
(07, "Pablo Neruda"),
(08, "Mary Shelley"),
(09, "J.R.R. Tolkien"),
(10, "Alan Moore"),
(11, "Akira Toriyama"),
(12, "Masashi Kishimoto"),
(13, "Hajime Isayama "); 





CREATE TABLE editoriales(

	edi_id INT NOT NULL,
    edi_desc VARCHAR(30),
    
    PRIMARY KEY (edi_id)

);

INSERT INTO editoriales (edi_id, edi_desc)
VALUES (01, "Acantilado"),
(02, "Aguilar"),
(03, "Akal"),
(04, "Alba"),
(05, "Alfaguara"),
(06, "Alianza"),
(07, "Almadía"),
(08, "Anagrama"),
(09, "Atalanta"),
(10, "Caja Negra"),
(11, "Cátedra"),
(12, "Gallo Nero"),
(13, "Herder"),
(14, "Impedimenta"),
(15, "Joaquín Mortiz"),
(16, "Library of America"),
(17, "Lumen"),
(18, "Planeta"),
(19, "Salamandra"),
(20, "Satori"),
(21, "Sexto Piso"),
(22, "Siglo XXI"),
(23, "Siruela"),
(24, "Taurus"),
(25, "Urano"); 


/*select * from usuarios;*/

CREATE TABLE aut_x_libr(

	axl_id INT NOT NULL AUTO_INCREMENT,
    lib_id INT,
    aut_id INT,
    
    
	PRIMARY KEY(axl_id),
    FOREIGN KEY(lib_id) REFERENCES libros(lib_id),
    FOREIGN KEY(aut_id) REFERENCES autores(aut_id)

);



CREATE TABLE libros(

	lib_id INT NOT NULL AUTO_INCREMENT,
    lib_nombre VARCHAR(45),
    lib_sinopsis VARCHAR(150),
    lib_stock_disponible INT,
    lib_precio FLOAT,
    lib_foto_portada MEDIUMBLOB,
    lib_anio_publicacion DATE,
    lib_estado BOOL, /* 0 1 */
    lib_isbn INT(13),
    gen_id INT,
    edi_id INT,
    /*axl INT,*/
    suc_id INT,

	PRIMARY KEY (lib_id),
    FOREIGN KEY (gen_id) REFERENCES generos(gen_id),
    FOREIGN KEY (edi_id) REFERENCES editoriales(edi_id),
    /*FOREIGN KEY (axl_id) REFERENCES aut_x_libr(axl_id),*/
    FOREIGN KEY (suc_id) REFERENCES sucursales(suc_id)
    ON UPDATE cascade ON DELETE cascade /* Esto sirve para modificar y eliminar sin errores*/
);
/*ALTER TABLE julioVerne.libros ADD axl_id INT;
ALTER TABLE julioVerne.libros ADD constraint axl_id FOREIGN KEY (axl_id) REFERENCES aut_x_libr(axl_id); */






CREATE TABLE ventas_cabecera( /* TABLA CABECERA */

	cab_id INT NOT NULL AUTO_INCREMENT,
    usu_id INT,
    suc_id INT,
    cab_cantidad_total INT,
    cab_fecha DATE,
    cab_precio_total INT,

	PRIMARY KEY(cab_id, usu_id, suc_id),
    FOREIGN KEY(usu_id) REFERENCES usuarios(usu_id),
    FOREIGN KEY(suc_id) REFERENCES sucursales(suc_id)
    ON UPDATE cascade ON DELETE cascade /* Esto sirve para modificar y eliminar sin errores*/
);

/*select * from libros;*/



CREATE TABLE ventas_detalle( /* TABLA DETALLE */
	
    det_id INT AUTO_INCREMENT,
	cab_id INT,
    lib_id INT,
    det_cantidad INT,
    det_precio FLOAT,

	PRIMARY KEY(det_id),
    FOREIGN KEY(cab_id) REFERENCES ventas_cabecera(cab_id),
    FOREIGN KEY(lib_id) REFERENCES libros(lib_id)
    ON UPDATE cascade ON DELETE cascade /* Esto sirve para modificar y eliminar sin errores*/
);

/*update libros set lib_estado = 1 where lib_id > 0;*/

/* usuarios = 2 -> matias, sucursal quilmes 3*/

/*VENTAS SOLAMENTE EN LA SUCURSAL QUILMES 
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (35, 5, 3, 4, "2024-08-08", 1200);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(35, 2, 2, 250),
(35, 5, 2, 140);*/

/* OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (36, 5, 3, 4, "2024-08-08", 800);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(36, 3, 2, 400),
(36, 2, 2, 75)¨*/

/* OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (37, 5, 3, 4, "2024-08-10", 975);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(37, 6, 2, 300),
(37, 10, 2, 150);*/

/* OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (38, 5, 3, 4, "2024-08-10", 1400);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(38, 8, 2, 200),
(38, 3, 2, 170);*/

/* OTRA VENTA 
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (39, 5, 3, 4, "2024-08-12", 1200);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(39, 13, 2, 200),
(39, 1, 2, 170);

 OTRA VENTA 
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (40, 5, 3, 4, "2024-08-12", 1700);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(40, 9, 2, 750),
(40, 7, 2, 200);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (41, 5, 3, 4, "2024-08-14", 1000);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(41, 4, 2, 800),
(41, 10, 2, 240);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (42, 5, 3, 4, "2024-08-14", 800);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(42, 5, 2, 150),
(42, 11, 2, 850);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (43, 5, 3, 4, "2024-08-16", 950);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(43, 14, 2, 350),
(43, 9, 2, 850);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (44, 5, 3, 4, "2024-08-20", 1450);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(44, 6, 2, 500),
(44, 7, 2, 800);

 OTRA VENTA 
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (45, 5, 3, 4, "2024-08-20", 1700);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(45, 3, 2, 600),
(45, 5, 2, 350);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (46, 5, 3, 4, "2024-08-24", 2000);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(46, 8, 2, 1000),
(46, 5, 2, 1000);

 OTRA VENTA 
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (47, 5, 3, 4, "2024-08-24", 1375);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(47, 2, 2, 975),
(47, 14, 2, 475);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (48, 5, 3, 4, "2024-08-28", 875);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(48, 14, 2, 400),
(48, 11, 2, 475);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (49, 5, 3, 4, "2024-08-28", 990);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(49, 9, 2, 550),
(49, 11, 2, 450);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (50, 5, 3, 4, "2024-09-05", 2300);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(50, 13, 2, 1550),
(50, 10, 2, 1200);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (51, 5, 3, 4, "2024-09-05", 2300);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(51, 11, 2, 1500),
(51, 1, 2, 1450);

OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (52, 5, 3, 4, "2024-09-05", 1800);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(52, 8, 2, 1000),
(52, 12, 2, 800);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (53, 5, 3, 4, "2024-09-10", 2500);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(53, 9, 2, 1000),
(53, 4, 2, 1500);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (54, 5, 3, 4, "2024-09-10", 2000);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(54, 11, 2, 1000),
(54, 4, 2, 1000);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (55, 5, 3, 4, "2024-09-15", 1400);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(55, 6, 2, 400),
(55, 14, 2, 1000);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (56, 5, 3, 4, "2024-09-15", 975);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(56, 1, 2, 400),
(56, 13, 2, 900);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (57, 5, 3, 4, "2024-09-20", 1800);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(57, 10, 2, 1000),
(57, 14, 2, 800);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (58, 5, 3, 4, "2024-09-25", 1400);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(58, 5, 2, 900),
(58, 11, 2, 600);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (59, 5, 3, 4, "2024-09-25", 900);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(59, 3, 2, 400),
(59, 8, 2, 500);

OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (60, 5, 3, 4, "2024-09-30", 1200);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(60, 2, 2, 1000),
(60, 14, 2, 200);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (61, 5, 3, 4, "2024-09-30", 600);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(61, 8, 2, 300),
(61, 10, 2, 300);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (62, 5, 3, 4, "2024-10-03", 800);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(62, 5, 2, 400),
(62, 13, 2, 400);

 OTRA VENTA
INSERT INTO ventas_cabecera(cab_id, usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
VALUES (63, 5, 3, 4, "2024-10-01", 1400);

INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio)
VALUES(63, 11, 2, 400),
(63, 4, 2, 1000);*/