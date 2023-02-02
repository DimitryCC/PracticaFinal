DROP DATABASE IF EXISTS projecte;
CREATE DATABASE projecte;
use projecte;

create table idiomas(
	ID integer primary key auto_increment,
	idioma varchar(10)
);/*No se genera automaticamente*/

create table descripciones(
	ID integer primary key auto_increment,
    descripcion varchar(600),
    idioma_id integer,
    foreign key (idioma_id) references idiomas(ID)
);

create table traduccionDescripsciones(
    descripcione_ID integer,
    idioma_id integer,
    traduccion varchar(600),
    primary key (descripcione_ID, idioma_id),
    foreign key (idioma_id) references idiomas(ID),
    foreign key (descripcione_ID) references descripciones(ID)
);

create table tiposAlojameintos(
	ID integer auto_increment primary key,
    nombre_tipo varchar(30),
    idioma_id integer,
    foreign key (idioma_id) references idiomas(ID)
);

create table traduccionTiposalojamientos(
    tiposAlojameintos_ID integer,
    idioma_id integer,
    traduccion varchar(30),
    primary key (tiposAlojameintos_ID, idioma_id),
    foreign key (idioma_id) references idiomas(ID),
    foreign key (tiposAlojameintos_ID) references tiposAlojameintos(ID)
);

create table tiposVacacional(
	ID integer auto_increment primary key,
    nombre_tipo varchar(30),
    idioma_id integer,
    foreign key (idioma_id) references idiomas(ID)
);

create table traduccionVacacional(
    tiposVacacional_ID integer,
    idioma_id integer,
    Traduccion varchar(30),
    primary key (tiposVacacional_ID, idioma_id),
    foreign key (idioma_id) references idiomas(ID),
    foreign key (tiposVacacional_ID) references tiposVacacional(ID)
);

create table servicios(
	  ID integer primary key auto_increment,
    NombreServicio varchar(20)
);

create table traduccionservicios(
    servicios_ID integer,
    idioma_id integer,
    traduccion varchar(20),
    primary key (servicios_ID, idioma_id),
    foreign key (idioma_id) references idiomas(ID),
    foreign key (servicios_ID) references servicios(ID)
);

create table categorias(
	ID integer auto_increment primary key,
    nombre_categoria varchar(30),
    tarifa_baixa integer,
    tarifa_alta integer
);

create table municipios(
	  ID integer primary key auto_increment,
    nombre varchar(60),
    islas enum('MALLORCA','MENORCA','EIVISSA','FORMENTERA')
);

create table usuarios(
	ID integer primary key auto_increment,
    DNI varchar(20),
    nom_complet varchar(150),
    direccio varchar(100),
    correu  varchar(50),
    telefon integer,
    contrasenya varchar(100),
    api_tocken varchar(250),
    administrador boolean
    );
    


create table alojamientos(
	ID integer auto_increment,
    nombre varchar(100),
    adresa varchar(300),
    numpero_personas integer,
    numero_habitaciones integer,
    numero_camas integer,
    numero_banos integer,
    descripcio integer,
    tipo_alojamiento integer,
    tipo_vacacional integer,
    categoria integer,
    municipio integer,
    usuari integer,
    primary key (ID),
    foreign key (tipo_alojamiento) references tiposAlojameintos(ID),
    foreign key (tipo_vacacional) references tiposVacacional(ID),
    foreign key (categoria) references categorias(ID),
    foreign key (municipio) references municipios(ID),
    foreign key (usuari) references usuarios(ID),
    foreign key (descripcio) references descripciones(ID)

);

create table valoraciones(
	usuari_id integer,
    Alojamiento_id integer,
    texto varchar(255),
    puntuacion integer,
    primary key (usuari_id, Alojamiento_id),
    foreign key (Alojamiento_id) references alojamientos(ID),
    foreign key (usuari_id) references usuarios(ID)
    
);

create table fotografias(
	ID integer primary key auto_increment,
    ruta varchar(500),
    alojamiento_id integer,
    foreign key (alojamiento_id) references alojamientos(ID)
);


/*
create table calcValoracion(
	ID integer primary key auto_increment,
    valoracion integer
);*/

/*Inserts automaticos*/
INSERT INTO idiomas (idioma)
VALUES
  ('Español'),
  ('Catalan'),
  ('Ingles');
INSERT INTO descripciones (descripcion,idioma_id)
VALUES
  ('eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit',3),
  ('aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui',3),
  ('Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit',2),
  ('risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus',3),
  ('Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus.',1);
INSERT INTO traduccionDescripsciones (descripcione_ID,idioma_id,traduccion)
VALUES
  (1,2,'ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus'),
  (3,3,'euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis'),
  (4,2,'Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,'),
  (1,3,'est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut'),
  (1,1,'dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit');
INSERT INTO tiposAlojameintos (nombre_tipo,idioma_id)
VALUES
  ('Mooney',2),
  ('Laceyn',1),
  ('Marsden',3),
  ('Neil',1),
  ('Mckay',1);

INSERT INTO traduccionTiposalojamientos (tiposAlojameintos_ID,traduccion,idioma_id)
VALUES
  (1,'Darius',2),
  (2,'Dora',1),
  (3,'Cote',1),
  (4,'Beard',2),
  (5,'Spencer',1),
  (1,'Cantrell',3);

INSERT INTO tiposVacacional (nombre_tipo,idioma_id)
VALUES
  ('Zeph Eder',1),
  ('Talon Lechner',2),
  ('Illiana Fischer',3),
  ('Pamela Schwarz',1),
  ('Todd Winkler',1);

INSERT INTO traduccionVacacional (tiposVacacional_ID,idioma_id,traduccion)
VALUES
  (1,3,'Phelan Mullins'),
  (4,1,'Mariko Newman'),
  (4,3,'Judith Vaughn'),
  (2,3,'Amy Burch');
/**/
INSERT INTO servicios (NombreServicio)
VALUES
  ('Charissa'),
  ('Jeanette'),
  ('Moser'),
  ('Lehner'),
  ('Müller');

  
INSERT INTO traduccionservicios (servicios_ID,idioma_id,traduccion)
VALUES
  (1,1,'Emerson Maier'),
  (2,3,'Tatyana Pfarrer'),
  (3,3,'Raphael Pohl'),
  (4,2,'Reece Bruckmann'),
  (5,1,'Kim Weber');
  
INSERT INTO categorias (nombre_categoria,tarifa_baixa,tarifa_alta)
VALUES
  ('Emerson Maier',234,915),
  ('Tatyana Pfarrer',323,944),
  ('Raphael Pohl',232,817),
  ('Reece Bruckmann',472,965),
  ('Kim Weber',496,616);
INSERT INTO municipios (nombre,islas)
VALUES
  ('Vernon','FORMENTERA'),
  ('Brody','MALLORCA'),
  ('Chiquita','MALLORCA'),
  ('Valentine','MENORCA'),
  ('Vivien','EIVISSA');
  
  insert into usuarios (DNI, nom_complet, direccio, correu, telefon, contrasenya, administrador) 
  VALUES
  ('746392565[A-Z]', 'Monro', 'Ivamy', 'mivamy0@mediafire.com', '641-651-8441', 'c6cxWuMsjW4', true),
  ('406628649[A-Z]', 'Blisse', 'Broadley', 'bbroadley1@whitehouse.gov', '442-704-4713', 'KlOr9KbxB', true),
  ('988578803[A-Z]', 'Neda', 'Ivie', 'nivie2@virginia.edu', '136-723-8851', 'kZjrj0Pn', false),
  ('775013151[A-Z]', 'Worden', 'Otley', 'wotley3@chron.com', '924-341-9513', 'sQzgISp2WM', true),
  ('719845069[A-Z]', 'Harley', 'Bonifant', 'hbonifant4@patch.com', '284-434-9198', '2bt3tr', false),
  ('268882389[A-Z]', 'Maxine', 'Markl', 'mmarkl5@gov.uk', '533-146-2112', 'JDCLcF', true);

  insert into alojamientos (nombre, adresa, numpero_personas, numero_habitaciones, numero_camas, numero_banos, descripcio, tipo_alojamiento, tipo_vacacional, categoria, municipio, usuari) values ('Sloan', '447 Del Mar Parkway', '59-212-9725', '15-586-4039', '69-313-8608', '12-056-5449', 1, 1, 1, 1, 1, 1),
('Edi', '51 Veith Place', '75-510-8155', '07-561-6112', '69-580-1262', '23-518-7537', 1, 1, 1, 1, 1, 1),
('Ode', '4891 Annamark Pass', '41-690-0108', '84-643-4268', '62-823-2663', '04-768-2142', 1, 2, 3, 3, 2, 1),
('Federico', '7 Mallory Plaza', '82-132-2986', '34-977-6242', '09-617-6815', '35-749-7397', 1, 2, 4, 2, 4, 2),
('Cherri', '6 Grayhawk Road', '28-375-0691', '08-811-2789', '89-979-8864', '13-377-3345', 5, 1, 3, 1, 2, 5),
('Caryl', '465 Bartillon Road', '51-921-4969', '83-000-6751', '98-870-8293', '38-502-2576', 5, 5, 5, 5, 5, 5);
insert into valoraciones (usuari_id, Alojamiento_id, texto, puntuacion) values 
(2, 4, 'Morbi a ipsum. Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet.', 5),
(3, 5, 'Sed ante. Vivamus tortor. Duis mattis egestas metus. Aenean fermentum. Donec ut mauris eget massa tempor convallis.', '02-378-4633'),
(1, 2, 'Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus. Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero. Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Intege.', 4),
(2, 3, 'In congue. Etiam justo. Etiam pretium iaculis justo. In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus. Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi. Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque. Quisque porta volutpat erat.', 4),
(4, 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', 3),
(5, 3, 'Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede. Morbi porttitor lorem id ligula. Nulla justo. Aliquam quis turpis eget elit sodales scelerisque.', 5);

INSERT INTO fotografias (ID,ruta, alojamiento_id)
values (1,'http://google.co.jp/a.png', 1),
(2,'http://uol.com.br/orci/vehicula/condimentum/curabitur/in/libero/ut.aspx', 2),
(3,'http://techcrunch.com/nulla/pede/ullamcorper.js', 3),
(4,'https://digg.com/augue/luctus/tincidunt/nulla/mollis.json', 4),
(5,'https://bloglovin.com/lacinia/erat/vestibulum/sed/magna/at.xml', 5);
