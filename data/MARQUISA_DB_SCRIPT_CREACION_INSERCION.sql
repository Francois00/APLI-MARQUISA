CREATE DATABASE orden_de_compra_marquisa;
USE orden_de_compra_marquisa;
CREATE TABLE proveedor
(
    ruc CHAR(11) PRIMARY KEY NOT NULL,
    nom VARCHAR(150),
    dir VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE moneda
(
    cod INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(40),
    tipo VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cliente
(
    ruc CHAR(11) PRIMARY KEY NOT NULL,
    nom VARCHAR(150),
    dir VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articulo
(
    cod CHAR(20) PRIMARY KEY NOT NULL,
    nom VARCHAR(80),
    und VARCHAR(40),
    prec_uni FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cabecera_orden_compra
(
    nro_oc CHAR(8) PRIMARY KEY NOT NULL,
    solic_por VARCHAR(40),
    autor_por VARCHAR(40),
    fec_emi DATE,
    nota VARCHAR(500),
    obra VARCHAR(40),
    
    nro_req_ori VARCHAR(20),
    obs VARCHAR(500),
    ruc_prov CHAR(11),
    ruc_cli CHAR(11),
    cod_mon INT,
    padrones VARCHAR(40),
    representante VARCHAR(30),
    form_pago VARCHAR(40),
    subtotal FLOAT,
    igv FLOAT,
    total FLOAT,
    ret_tot FLOAT,
    det_tot FLOAT,
    per_tot FLOAT,
    tot_giro FLOAT,	
    FOREIGN KEY (ruc_prov) REFERENCES proveedor(ruc),
    FOREIGN KEY (ruc_cli) REFERENCES cliente(ruc),
    FOREIGN KEY (cod_mon) REFERENCES moneda(cod),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cuerpo_orden_compra
(
    nro_oc CHAR(8),
    cod_art CHAR(20),
    cantidad INT,    
    subtotal_uni FLOAT,
    PRIMARY KEY (nro_oc, cod_art),
    FOREIGN KEY (nro_oc) REFERENCES cabecera_orden_compra(nro_oc),
    FOREIGN KEY (cod_art) REFERENCES articulo(cod),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*INSERTANDO A LA TABLA PROVEEDOR*/
INSERT INTO proveedor VALUES('20514058203','A & L SOLUCIONES EMPRESARIALES S.A.C.','Puerto Maldonado',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20449471611','A & M  SERVICIOS M LTIPLES E.I.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20604029768','A & M BATERIAS AREQUIPA S.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20603544855','A & M CONSORCIO MORAN S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20534637030','A & M CONSULTORES FINANCIEROS E.I.R.L.','Lima', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20603348819','A & M ENGLAND TRUCKS S.R.L.','Lima', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20546656447','A & M LEXA EXPORT S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20601784093','A & M MULTISERVICIOS S.A.C.','Lima', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20529418737','A & M OBRAS CIVILES Y SERVICIOS GENERALES E.I.R.L','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20602491863','A & M OFINEX E.I.R.L.','Lima', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20601551030','A & M SYSTEM SOLUTIONS S.A.C.','Trujillo', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20602699898','A & M TEXTILE S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20552596405','A & N GROUP S.A.C.','Ucayali', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20523801890','A & O CONSULTORES S.A.C.','Ucayali', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20604069352','A & P CARGO LOGISTICS S.A.C.','Ucayali', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20605128557','A & P CONSPRO INGENIERIA E INNOVACION S.A.C.','Ucayali', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20602889239','A & P FIERROS Y ACEROS S.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20605083359','A & P GRUPO MONTERO S.A.C.','Huancavelica', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20547208073','A & P LLONA CATERING & SERVICE E.I.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20486682249','A & P SERVITEL SOCIEDAD ANONIMA CERRADA','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20550775761','A & Q INVERSIONES IMPORT EXPORT S.A.C.','Lima', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20535720739','A & R ASESORES S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO proveedor VALUES('20522989542','A & R BEST CORPORACION SOCIEDAD ANONMA CERRADA','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
/*INSERTANDO A LA TABLA MONEDA*/
INSERT INTO moneda VALUES('1','DÓLAR','3.86', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO moneda VALUES('2','EURO','4.09', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO moneda VALUES('3','PESO MEXICANO','0.21', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO moneda VALUES('4','LIBRA ESTERLINA','4.68', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO moneda VALUES('5','BOLIVAR','1.79', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
/*INSERTANDO A LA TABLA CLIENTE*/
INSERT INTO cliente VALUES('20552103816','AGROLIGHT PERU S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20538856674','ARTROSCOPICTRAUMA S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20553856451','BI GRAND CONFECCIONES S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20480316259','DAROMAS E.I.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20547825781','DMG DRILLING E.I.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20603498799','ESCUELA DE DETECTIVES PRIVADOS DEL PERU E.I.R.L. - ESDEPRIP','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20606106883','FINE ART SOLUTIONS SOCIEDAD ANONIMA CERRADA','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20606422793','INTENTIONS ENGINEERING LEADERSHIP SERVICES SOCIEDAD ANONIMA CERRADA- INTENTIONS ENGINEERING LEADERS','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20604915351','MEN GRAPH S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20605100016','RVM MAQUINARIAS S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20525994741',' COMERCIAL FERRETERA PRISMA S.A.C. ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20494156211',' CONSTRUCTORES Y CONSULTORES BAUPER  E. I. R. L. ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20494099153',' CORPORACION ROANKA SOCIEDAD ANONIMA CERRADA ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20538995364',' D & L TECNOLOGIA Y AUDIO S.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20603049684',' ESTUDIO CONTABLE O & RM S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20494074169',' FERRETERIA E INVERSIONES A & G  E.I.R.L..','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20494100186',' IMPORTACIONES FVC EIRL ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20525926665',' INVERSIONES Y SERVICIOS DEL ROSARIO  S.A.C.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20542259117',' NEGOCIO Y ALOJAMIENTO QUINTA GUZMAN E.I.R.L. ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20480674414',' NEGOCIOS WAIMAKU  E.I.R.L.','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20542245671',' SELVA INDUSTRIAS MELITA E.I.R.L. ','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20604895988','AGRICOLA Y SERVICIOS GENERALES COROCAS SOCIEDAD COMERCIAL DE RESPONSABILIDAD LIMITADA','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20602945589','AGRINOVA DEL PERU S.R.L','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cliente VALUES('20568242271','AGROSORIA E.I.R.L','Arequipa', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
/*INSERTANDO A LA TABLA ARTICULO*/
INSERT INTO articulo VALUES('01CaV65FVU','Camiseta básica','Unidad',30, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('02ReV65FVU','Reloj analógico','Unidad',200, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('03AuV65FVU','Auriculares Bluetooth','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('04LaV65FVU','Laptop HP','Unidad',2500, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('05BoV65FVU','Botines de moda','Unidad',120, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('06SiV65FVU','Silla ergonómica','Unidad',400, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('07LaV65FVU','Lampara de escritorio','Unidad',50, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('08MoV65FVU','Mochila para portátil','Unidad',80, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('09CiV65FVU','Cien años de soledad','Unidad',40, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('10CaV65FVU','Camara Canon EOS','Unidad',1200, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('11JeV65FVU','Jeans de diseñador','Unidad',100, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('12NiV65FVU','Nike Air Max','Unidad',200, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('13iPV65FVU','iPhone 12','Unidad',4000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('14BoV65FVU','Bolígrafo Pilot G2','Unidad',10, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('15MaV65FVU','Maleta Samsonite','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('16RaV65FVU','Ray-Ban Aviator','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('17PeV65FVU','Pend;ientes de plata','Unidad',60, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('18GaV65FVU','Garmin Forerunner','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('19TeV65FVU','Teclado mecánico RGB','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('20ImV65FVU','Impresora HP OfficeJet','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('21ChV65FVU','Chanel N°5','Unidad',250, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('22GuV65FVU','Guitarra Martin D-28','Unidad',1500, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('23JuV65FVU','Juego de sartenes antiadherentes','Unidad',100, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('24AlV65FVU','Altavoz JBL Charge 4','Unidad',200, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('25BuV65FVU','Bufanda de alpaca','Unidad',70, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('26OrV65FVU','Oral-B Pro 1000','Unidad',60, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('27CaV65FVU','Cabernet Sauvignon 2015','Unidad',50, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('28CaV65FVU','Catan: El juego de mesa','Unidad',80, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('29RoV65FVU','Roomba i7+','Unidad',1000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('30MaV65FVU','Maletín de maquillaje','Unidad',200, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('31TrV65FVU','Trípode Manfrotto','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('32CaV65FVU','Camisón de seda negra','Unidad',120, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('33EsV65FVU','Escultura de arte moderno','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('34EsV65FVU','Estante de madera maciza','Unidad',70, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('35CiV65FVU','Cinturón de diseñador','Unidad',80, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('36MoV65FVU','Monitor Dell UltraSharp','Unidad',400, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('37FrV65FVU','Frasco de perfume vintage','Unidad',40, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('38JuV65FVU','Juego de destornilladores y llaves','Unidad',50, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('39SpV65FVU','Specialized Rockhopper','Unidad',800, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('40MaV65FVU','Manta tejida a mano','Unidad',90, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('41ViV65FVU','Vitamix 5200','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('42CoV65FVU','Collar y pend;ientes de oro','Unidad',1000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('43PoV65FVU','Polaroid Now','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('44TeV65FVU','Termo Yeti de 32 oz','Unidad',60, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('45SiV65FVU','Silla Eames de diseño','Unidad',150, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('46CaV65FVU','Camara Nest Cam','Unidad',250, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('47BoV65FVU','Bolso de cuero genuino','Unidad',120, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('48CrV65FVU','Creality End;er 3','Unidad',300, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('49TaV65FVU','Tabla de cortar grande','Unidad',30, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('50VeV65FVU','Vestido de diseñador','Unidad',400, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('51CoV65FVU','Combo Logitech MK270','Unidad',50, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO articulo VALUES('52TeV65FVU','Tetera de estilo japonés','Unidad',40, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
/*INSERTANDO A LA TABLA cabecera_orden_compra*/
INSERT INTO cabecera_orden_compra VALUES('3699','Juan','Jose','2021-04-12','ninguna','CERRITO AHUAYPARA','1966','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20550775761','20568242271',2,'ninguno','Gerente','contado',1260,226.8,1486.8,0,0,0,1486.8, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3700','Maria','Jose','2021-02-21','ninguna','PUENTE UCHUMAYO','1977','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20604069352','20603049684',3,'ninguno','Gerente','contado',1400,252,1652,0,0,0,1652, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3701','Pedro','Jose','2020-11-13','ninguna','PUENTE AÑASHUAYCO','1988','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20529418737','20547825781',1,'ninguno','Gerente','contado',1500,270,1770,0,0,0,1770, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3702','Jose','Gabriel','2020-08-05','ninguna','CARRETERA PANAMERICANA','1999','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20601551030','20604915351',4,'ninguno','Gerente','contado',1000,180,1180,0,0,0,1180, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3703','Pedro','Fausto','2020-04-27','ninguna','CENTRO CIVICO CAYMA','2010','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20546656447','20538995364',2,'ninguno','Gerente','contado',5000,900,5900,0,0,0,5900, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3704','Renzo','Diego','2020-01-18','ninguna','CERRITO AHUAYPARA','2021','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20601551030','20542245671',3,'ninguno','Gerente','contado',2000,360,2360,0,0,0,2360, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3705','Diego','Renzo','2019-10-10','ninguna','PUENTE UCHUMAYO','2032','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20547208073','20603049684',1,'ninguno','Gerente','contado',100000,18000,118000,0,0,0,118000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3706','Renzo','Jose','2019-07-02','ninguna','PUENTE AÑASHUAYCO','2043','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20486682249','20494100186',4,'ninguno','Gerente','contado',20000,3600,23600,0,0,0,23600, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3707','Juan','Renzo','2019-03-24','ninguna','CARRETERA PANAMERICANA','2054','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20547208073','20525926665',4,'ninguno','Gerente','contado',200,36,236,0,0,0,236, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3708','Fabrizio','Jose','2019-08-21','ninguna','CENTRO CIVICO CAYMA','2065','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20605128557','20542245671',2,'ninguno','Gerente','contado',5000,900,5900,0,0,0,5900, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3709','Gabriel','Jose','2020-01-18','ninguna','CERRITO AHUAYPARA','2076','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20547208073','20480674414',2,'ninguno','Gerente','contado',1000,180,1180,0,0,0,1180, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3710','Maria','Jose','2020-06-16','ninguna','PUENTE UCHUMAYO','2087','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20529418737','20568242271',3,'ninguno','Gerente','contado',6000,1080,7080,0,0,0,7080, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3711','Juan','Gabriel','2020-11-13','ninguna','PUENTE AÑASHUAYCO','2098','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20602491863','20494074169',1,'ninguno','Gerente','contado',2000,360,2360,0,0,0,2360, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3712','Fabrizio','Fausto','2021-04-12','ninguna','CARRETERA PANAMERICANA','2109','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20535720739','20542259117',5,'ninguno','Gerente','contado',3000,540,3540,0,0,0,3540, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3713','Gabriel','Diego','2021-09-09','ninguna','CENTRO CIVICO CAYMA','2120','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20546656447','20602945589',3,'ninguno','Gerente','contado',1000,180,1180,0,0,0,1180, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3714','Maria','Renzo','2020-04-27','ninguna','CERRITO AHUAYPARA','2131','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20604069352','20602945589',1,'ninguno','Gerente','contado',2000,360,2360,0,0,0,2360, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3715','Gabriel','Jose','2018-12-14','ninguna','PUENTE UCHUMAYO','2142','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20552596405','20568242271',1,'ninguno','Gerente','contado',1000,180,1180,0,0,0,1180, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3716','Fausto','Renzo','2017-08-01','ninguna','PUENTE AÑASHUAYCO','2153','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20514058203','20525926665',2,'ninguno','Gerente','contado',5000,900,5900,0,0,0,5900, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3717','Diego','Juan','2016-03-19','ninguna','CARRETERA PANAMERICANA','2164','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20552596405','20480674414',2,'ninguno','Gerente','contado',2000,360,2360,0,0,0,2360, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3718','Renzo','Fabrizio','2014-11-05','ninguna','CENTRO CIVICO CAYMA','2175','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20547208073','20480674414',5,'ninguno','Gerente','contado',3000,540,3540,0,0,0,3540, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3719','Jose','Gabriel','2013-06-23','ninguna','CERRITO AHUAYPARA','2186','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20603544855','20604895988',1,'ninguno','Gerente','contado',2000,360,2360,0,0,0,2360, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3720','Adriana','Maria','2012-02-09','ninguna','PUENTE UCHUMAYO','2197','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20534637030','20602945589',1,'ninguno','Gerente','contado',4000,720,4720,0,0,0,4720, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3721','Gabriela','Diego','2010-09-27','ninguna','PUENTE AÑASHUAYCO','2208','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20602491863','20602945589',4,'ninguno','Gerente','contado',5000,900,5900,0,0,0,5900, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cabecera_orden_compra VALUES('3722','Pedro','Francois','2009-05-15','ninguna','CARRETERA PANAMERICANA','2219','zaranda mecanica metso MC - zm - 001 OBRA - SALAMANCA','20602491863','20568242271',1,'ninguno','Gerente','contado',400000,72000,472000,0,0,0,472000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
/*INSERTANDO A LA TABLA cuerpo_orden_compra*/
INSERT INTO cuerpo_orden_compra VALUES('3699','12NiV65FVU',4,800.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3700','51CoV65FVU',5,250.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3699','20ImV65FVU',2,600.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3701','20ImV65FVU',3,900.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3702','51CoV65FVU',6,300.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3703','20ImV65FVU',7,2100.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3705','44TeV65FVU',5,300.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3706','09CiV65FVU',2,80.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3707','20ImV65FVU',10,3000.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3708','20ImV65FVU',5,1500.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3709','20ImV65FVU',4,1200.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3710','20ImV65FVU',8,2400.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3711','20ImV65FVU',5,1500.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3712','20ImV65FVU',6,1800.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3713','20ImV65FVU',9,2700.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3714','44TeV65FVU',4,240.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3715','44TeV65FVU',2,120.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3716','51CoV65FVU',5,250.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3717','44TeV65FVU',3,180.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3718','51CoV65FVU',4,200.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3719','20ImV65FVU',5,1500.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3720','12NiV65FVU',3,600.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3721','20ImV65FVU',6,1800.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO cuerpo_orden_compra VALUES('3722','12NiV65FVU',4,800.00, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


CREATE PROCEDURE sp_actualizar_moneda(
    in_cod INT,
    in_nom VARCHAR(40),
    in_tipo VARCHAR(30)
)
BEGIN
    UPDATE moneda
    SET nom = in_nom, tipo = in_tipo, updated_at = CURRENT_TIMESTAMP
    WHERE cod = in_cod;
END;




CREATE PROCEDURE sp_actualizar_cliente(
    in_ruc CHAR(11),
    in_nom VARCHAR(150),
    in_dir VARCHAR(200)
)
BEGIN
    UPDATE cliente
    SET nom = in_nom, dir = in_dir, updated_at = CURRENT_TIMESTAMP
    WHERE ruc = in_ruc;
END; 




CREATE PROCEDURE sp_actualizar_articulo(
    in_cod CHAR(20),
    in_nom VARCHAR(80),
    in_und VARCHAR(40),
    in_prec_uni FLOAT
)
BEGIN
    UPDATE articulo
    SET nom = in_nom, und = in_und, prec_uni = in_prec_uni, updated_at = CURRENT_TIMESTAMP
    WHERE cod = in_cod;
END; 




CREATE PROCEDURE sp_actualizar_cabecera_orden_compra(
    in_nro_oc CHAR(8),
    in_solic_por VARCHAR(40),
    in_autor_por VARCHAR(40),
    in_fec_emi DATE,
    in_nota VARCHAR(500),
    in_obra VARCHAR(40),
    in_nro_req_ori VARCHAR(20),
    in_obs VARCHAR(500),
    in_ruc_prov CHAR(11),
    in_ruc_cli CHAR(11),
    in_cod_mon INT,
    in_padrones VARCHAR(40),
    in_representante VARCHAR(30),
    in_form_pago VARCHAR(40),
    in_subtotal FLOAT,
    in_igv FLOAT,
    in_total FLOAT,
    in_ret_tot FLOAT,
    in_det_tot FLOAT,
    in_per_tot FLOAT,
    in_tot_giro FLOAT
)
BEGIN
    UPDATE cabecera_orden_compra
    SET 
        solic_por = in_solic_por, autor_por = in_autor_por, fec_emi = in_fec_emi,
        nota = in_nota, obra = in_obra, nro_req_ori = in_nro_req_ori,
        obs = in_obs, ruc_prov = in_ruc_prov, ruc_cli = in_ruc_cli,
        cod_mon = in_cod_mon, padrones = in_padrones, representante = in_representante,
        form_pago = in_form_pago, subtotal = in_subtotal, igv = in_igv,
        total = in_total, ret_tot = in_ret_tot, det_tot = in_det_tot,
        per_tot = in_per_tot, tot_giro = in_tot_giro, updated_at = CURRENT_TIMESTAMP
    WHERE nro_oc = in_nro_oc;
END; 




CREATE PROCEDURE sp_actualizar_cuerpo_orden_compra(
    in_nro_oc CHAR(8),
    in_cod_art CHAR(20),
    in_cantidad INT,
    in_subtotal_uni FLOAT
)
BEGIN
    UPDATE cuerpo_orden_compra
    SET 
        cantidad = in_cantidad, subtotal_uni = in_subtotal_uni, 
        updated_at = CURRENT_TIMESTAMP
    WHERE nro_oc = in_nro_oc AND cod_art = in_cod_art;
END; 




CREATE PROCEDURE sp_leer_proveedores()
BEGIN
    SELECT * FROM proveedor;
END; 




CREATE PROCEDURE sp_leer_monedas()
BEGIN
    SELECT * FROM moneda;
END; 




CREATE PROCEDURE sp_leer_clientes()
BEGIN
    SELECT * FROM cliente;
END; 




CREATE PROCEDURE sp_leer_articulos()
BEGIN
    SELECT * FROM articulo;
END; 




CREATE PROCEDURE sp_leer_cabeceras_orden_compra()
BEGIN
    SELECT * FROM cabecera_orden_compra;
END; 




CREATE PROCEDURE sp_leer_cuerpos_orden_compra()
BEGIN
    SELECT * FROM cuerpo_orden_compra;
END; 




CREATE PROCEDURE sp_eliminar_proveedor(IN ruc_param CHAR(11))
BEGIN
    DELETE FROM proveedor WHERE ruc = ruc_param;
END; 




CREATE PROCEDURE sp_eliminar_moneda(IN cod_param INT)
BEGIN
    DELETE FROM moneda WHERE cod = cod_param;
END; 




CREATE PROCEDURE sp_eliminar_cliente(IN ruc_param CHAR(11))
BEGIN
    DELETE FROM cliente WHERE ruc = ruc_param;
END; 




CREATE PROCEDURE sp_eliminar_articulo(IN cod_param CHAR(20))
BEGIN
    DELETE FROM articulo WHERE cod = cod_param;
END; 




CREATE PROCEDURE sp_eliminar_cabecera_orden_compra(IN nro_oc_param CHAR(8))
BEGIN
    DELETE FROM cabecera_orden_compra WHERE nro_oc = nro_oc_param;
END; 




CREATE PROCEDURE sp_eliminar_cuerpo_orden_compra(IN nro_oc_param CHAR(8), IN cod_art_param CHAR(20))
BEGIN
    DELETE FROM cuerpo_orden_compra WHERE nro_oc = nro_oc_param AND cod_art = cod_art_param;
END; 




CREATE PROCEDURE sp_insertar_proveedor(
    in_ruc CHAR(11),
    in_nom VARCHAR(150),
    in_dir VARCHAR(200)
)
BEGIN
    INSERT INTO proveedor (ruc, nom, dir) VALUES (in_ruc, in_nom, in_dir);
END; 




CREATE PROCEDURE sp_insertar_moneda(
    in_nom VARCHAR(40),
    in_tipo VARCHAR(30)
)
BEGIN
    INSERT INTO moneda (nom, tipo) VALUES (in_nom, in_tipo);
END; 




CREATE PROCEDURE sp_insertar_cliente(
    in_ruc CHAR(11),
    in_nom VARCHAR(150),
    in_dir VARCHAR(200)
)
BEGIN
    INSERT INTO cliente (ruc, nom, dir) VALUES (in_ruc, in_nom, in_dir);
END; 




CREATE PROCEDURE sp_insertar_articulo(
    in_cod CHAR(20),
    in_nom VARCHAR(80),
    in_und VARCHAR(40),
    in_prec_uni FLOAT
)
BEGIN
    INSERT INTO articulo (cod, nom, und, prec_uni) VALUES (in_cod, in_nom, in_und, in_prec_uni);
END; 




CREATE PROCEDURE sp_insertar_cuerpo_orden_compra(
    in_nro_oc CHAR(8),
    in_cod_art CHAR(20),
    in_cantidad INT,
    in_subtotal_uni FLOAT
)
BEGIN
    INSERT INTO cuerpo_orden_compra (nro_oc, cod_art, cantidad, subtotal_uni) 
    VALUES (in_nro_oc, in_cod_art, in_cantidad, in_subtotal_uni);
END; 




CREATE PROCEDURE sp_insertar_cabecera_orden_compra(
    in_nro_oc CHAR(8),
    in_solic_por VARCHAR(40),
    in_autor_por VARCHAR(40),
    in_fec_emi DATE,
    in_nota VARCHAR(500),
    in_obra VARCHAR(40),
    in_nro_req_ori VARCHAR(20),
    in_obs VARCHAR(500),
    in_ruc_prov CHAR(11),
    in_ruc_cli CHAR(11),
    in_cod_mon INT,
    in_padrones VARCHAR(40),
    in_representante VARCHAR(30),
    in_form_pago VARCHAR(40),
    in_subtotal FLOAT,
    in_igv FLOAT,
    in_total FLOAT,
    in_ret_tot FLOAT,
    in_det_tot FLOAT,
    in_per_tot FLOAT,
    in_tot_giro FLOAT
)
BEGIN
    INSERT INTO cabecera_orden_compra (
        nro_oc, solic_por, autor_por, fec_emi, nota, obra,
        nro_req_ori, obs, ruc_prov, ruc_cli, cod_mon, padrones,
        representante, form_pago, subtotal, igv, total,
        ret_tot, det_tot, per_tot, tot_giro
    ) VALUES (
        in_nro_oc, in_solic_por, in_autor_por, in_fec_emi, in_nota, in_obra,
        in_nro_req_ori, in_obs, in_ruc_prov, in_ruc_cli, in_cod_mon, in_padrones,
        in_representante, in_form_pago, in_subtotal, in_igv, in_total,
        in_ret_tot, in_det_tot, in_per_tot, in_tot_giro
    );
END;





CREATE TRIGGER after_insert_cuerpo_orden_compra
AFTER INSERT ON cuerpo_orden_compra
FOR EACH ROW
BEGIN
    DECLARE total_subtotal FLOAT;
    DECLARE total_igv FLOAT;
    DECLARE total_total FLOAT;

    -- Calcular los totales
    SELECT SUM(subtotal_uni) INTO total_subtotal
    FROM cuerpo_orden_compra
    WHERE nro_oc = NEW.nro_oc;

    SET total_igv = total_subtotal * 0.18; -- Suponiend;o que el IGV es el 18%
    SET total_total = total_subtotal + total_igv;

    -- Actualizar la cabecera_orden_compra con los nuevos totales
    UPDATE cabecera_orden_compra
    SET subtotal = total_subtotal,
        igv = total_igv,
        total = total_total
    WHERE nro_oc = NEW.nro_oc;
END;












CREATE TRIGGER before_delete_proveedor
BEFORE DELETE ON proveedor
FOR EACH ROW
BEGIN
    DECLARE count_oc INT;

    -- Verificar si hay órdenes de compra que hacen referencia al proveedor
    SELECT COUNT(*) INTO count_oc
    FROM cabecera_orden_compra
    WHERE ruc_prov = OLD.ruc;

    -- Si hay órdenes de compra, evitar la eliminación del proveedor
    IF count_oc > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el proveedor porque hay órdenes de compra asociadas.';
    END IF;
END;

CREATE TRIGGER before_delete_cliente
BEFORE DELETE ON cliente
FOR EACH ROW
BEGIN
    DECLARE count_oc INT;

    -- Verificar si hay órdenes de compra que hacen referencia al proveedor
    SELECT COUNT(*) INTO count_oc
    FROM cabecera_orden_compra
    WHERE ruc_cli = OLD.ruc;

    -- Si hay órdenes de compra, evitar la eliminación del proveedor
    IF count_oc > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el proveedor porque hay órdenes de compra asociadas.';
    END IF;
END;

CREATE TRIGGER before_delete_articulo
BEFORE DELETE ON articulo
FOR EACH ROW
BEGIN
    DECLARE count_oc INT;

    -- Verificar si hay órdenes de compra que hacen referencia al proveedor
    SELECT COUNT(*) INTO count_oc
    FROM cuerpo_orden_compra
    WHERE cod_art = OLD.cod;

    -- Si hay órdenes de compra, evitar la eliminación del proveedor
    IF count_oc > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el proveedor porque hay órdenes de compra asociadas.';
    END IF;
END;

CREATE TRIGGER before_delete_moneda
BEFORE DELETE ON moneda
FOR EACH ROW
BEGIN
    DECLARE count_oc INT;

    -- Verificar si hay órdenes de compra que hacen referencia al proveedor
    SELECT COUNT(*) INTO count_oc
    FROM cabecera_orden_compra
    WHERE cod_mon = OLD.cod;

    -- Si hay órdenes de compra, evitar la eliminación del proveedor
    IF count_oc > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el proveedor porque hay órdenes de compra asociadas.';
    END IF;
END;


