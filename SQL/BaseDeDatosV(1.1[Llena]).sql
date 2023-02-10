DROP DATABASE IF EXISTS projecte;
CREATE DATABASE projecte;
use projecte;

create table idiomas(
                        ID integer primary key auto_increment,
                        idioma varchar(10)
);

create table tiposAlojameintos(
                                  ID integer auto_increment primary key,
                                  nombreTipo varchar(30),
                                  idiomaId integer,
                                  foreign key (idiomaId) references idiomas(ID)
);

create table traduccionTiposalojamientos(
                                            tiposAlojameintosId integer,
                                            idiomaId integer,
                                            traduccion varchar(30),
                                            primary key (tiposAlojameintosId, idiomaId),
                                            foreign key (idiomaId) references idiomas(ID),
                                            foreign key (tiposAlojameintosId) references tiposAlojameintos(ID)
);

create table tiposVacacional(
                                ID integer auto_increment primary key,
                                nombreTipo varchar(30),
                                idiomaId integer,
                                foreign key (idiomaId) references idiomas(ID)
);

create table traduccionVacacional(
                                     tiposVacacionalId integer,
                                     idiomaId integer,
                                     Traduccion varchar(30),
                                     primary key (tiposVacacionalId, idiomaId),
                                     foreign key (idiomaId) references idiomas(ID),
                                     foreign key (tiposVacacionalId) references tiposVacacional(ID)
);

create table servicios(
                          ID integer primary key auto_increment,
                          NombreServicio varchar(20)
);

create table traduccionServicios(
                                    servicioId integer,
                                    idiomaId integer,
                                    traduccion varchar(20),
                                    primary key (servicioId, idiomaId),
                                    foreign key (idiomaId) references idiomas(ID),
                                    foreign key (servicioId) references servicios(ID)
);

create table categorias(
                           ID integer auto_increment primary key,
                           nombreCategoria varchar(30),
                           tarifaBaja integer,
                           tarifaAlta integer
);

create table municipios(
                           ID integer primary key auto_increment,
                           nombre varchar(60),
                           isla enum('MALLORCA','MENORCA','EIVISSA','FORMENTERA')
);

create table usuarios(
                         ID integer primary key auto_increment,
                         DNI varchar(20),
                         nombreCompleto varchar(150),
                         direccion varchar(100),
                         correo  varchar(50),
                         telefono integer,
                         contrasena varchar(100),
                         apiTocken varchar(250),/*Recoger mas tarde para el logue in*/
                         administrador boolean
);

create table alojamientos(
                             ID integer auto_increment,
                             nombre varchar(100),
                             direccion varchar(300),
                             numeroPersonas integer,
                             numeroHabitaciones integer,
                             numeroCamas integer,
                             numeroBanos integer,
                             tipoAlojamiento integer,
                             tipoVacacional integer,
                             categoria integer,
                             municipio integer,
                             usuario integer,
                             primary key (ID),
                             foreign key (tipoAlojamiento) references tiposAlojameintos(ID),
                             foreign key (tipoVacacional) references tiposVacacional(ID),
                             foreign key (categoria) references categorias(ID),
                             foreign key (municipio) references municipios(ID),
                             foreign key (usuario) references usuarios(ID)
);

create table descripciones(
                              ID integer primary key auto_increment,
                              alojamientoId integer,
                              descripcion varchar(600),
                              idiomaId integer,
                              foreign key (idiomaId) references idiomas(ID),
                              foreign key (alojamientoId) references alojamientos(ID)
);

create table traduccionDescripsciones(
                                         descripcioneId integer,
                                         idiomaId integer,
                                         traduccion varchar(600),
                                         primary key (descripcioneId, idiomaId),
                                         foreign key (idiomaId) references idiomas(ID),
                                         foreign key (descripcioneId) references descripciones(ID)
);

create table reservas(
                         ID integer auto_increment,
                         usuarioId integer,
                         AlojamientoId integer,
                         FechaInicio DATE,
                         FechaFin DATE,
                         primary key (ID),
                         foreign key (AlojamientoId) references alojamientos(ID),
                         foreign key (usuarioId) references usuarios(ID)
);

create table valoraciones(
                             usuarioId integer,
                             AlojamientoId integer,
                             texto varchar(255),
                             puntuacion integer,
                             primary key (usuarioId, AlojamientoId),
                             foreign key (AlojamientoId) references alojamientos(ID),
                             foreign key (usuarioId) references usuarios(ID)
);

create table fotografias(
                            ID integer primary key auto_increment,
                            ruta varchar(500),
                            alojamientoId integer,
                            foreign key (alojamientoId) references alojamientos(ID)
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

INSERT INTO tiposAlojameintos (nombreTipo, idiomaId)
VALUES
  ('Mooney',2),
  ('Laceyn',1),
  ('Marsden',3),
  ('Neil',1),
  ('Mckay',1);

INSERT INTO traduccionTiposalojamientos (tiposAlojameintosId,traduccion, idiomaId)
VALUES
  (1,'Darius',2),
  (2,'Dora',1),
  (3,'Cote',1),
  (4,'Beard',2),
  (5,'Spencer',1),
  (1,'Cantrell',3);

INSERT INTO tiposVacacional (nombreTipo, idiomaId)
VALUES
  ('Zeph Eder',1),
  ('Talon Lechner',2),
  ('Illiana Fischer',3),
  ('Pamela Schwarz',1),
  ('Todd Winkler',1);

INSERT INTO traduccionVacacional (tiposVacacionalId, idiomaId,traduccion)
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

  
INSERT INTO traduccionServicios (servicioId, idiomaId,traduccion)
VALUES
  (1,1,'Emerson Maier'),
  (2,3,'Tatyana Pfarrer'),
  (3,3,'Raphael Pohl'),
  (4,2,'Reece Bruckmann'),
  (5,1,'Kim Weber');
  
INSERT INTO categorias (nombreCategoria, tarifaBaja, tarifaAlta)
VALUES
  ('Emerson Maier',234,915),
  ('Tatyana Pfarrer',323,944),
  ('Raphael Pohl',232,817),
  ('Reece Bruckmann',472,965),
  ('Kim Weber',496,616);
INSERT INTO municipios (nombre,isla)
VALUES
  ('Vernon','FORMENTERA'),
  ('Brody','MALLORCA'),
  ('Chiquita','MALLORCA'),
  ('Valentine','MENORCA'),
  ('Vivien','EIVISSA');
  
  insert into usuarios (DNI, nombreCompleto, direccion, correo, telefono, contrasena, administrador)
  VALUES
  ('746392565[A-Z]', 'Monro', 'Ivamy', 'mivamy0@mediafire.com', '641-651-8441', 'c6cxWuMsjW4', true),
  ('406628649[A-Z]', 'Blisse', 'Broadley', 'bbroadley1@whitehouse.gov', '442-704-4713', 'KlOr9KbxB', true),
  ('988578803[A-Z]', 'Neda', 'Ivie', 'nivie2@virginia.edu', '136-723-8851', 'kZjrj0Pn', false),
  ('775013151[A-Z]', 'Worden', 'Otley', 'wotley3@chron.com', '924-341-9513', 'sQzgISp2WM', true),
  ('719845069[A-Z]', 'Harley', 'Bonifant', 'hbonifant4@patch.com', '284-434-9198', '2bt3tr', false),
  ('268882389[A-Z]', 'Maxine', 'Markl', 'mmarkl5@gov.uk', '533-146-2112', 'JDCLcF', true);

insert into alojamientos(nombre, direccion, numeroPersonas, numeroHabitaciones, numeroCamas, numeroBanos, tipoAlojamiento, tipoVacacional, categoria, municipio, usuario)
values
    ('Casa rural el Bosque', 'Calle del Bosque, 123', 6, 3, 6, 2, 1, 1, 2, 1, 1),
    ('Hotel Mar de la Playa', 'Avenida de la Playa, 456', 10, 5, 10, 5, 2, 2, 3, 2, 2),
    ('Apartamentos Sol y Mar', 'Calle del Sol, 789', 4, 2, 4, 2, 3, 3, 1, 3, 3),
    ('Chalet Montañas del Norte',' "Calle de las Montañas, 101112"', 8, 4, 8, 4, 1, 4, 2, 4, 4),
    ('Villa Luz del Mar"', 'Calle de la Luz, 131415', 10, 5, 10, 5, 2, 5, 3, 5, 5);

INSERT INTO descripciones (descripcion, idiomaId, alojamientoId)
VALUES
    ('eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit',3, 1),
    ('aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui',3, 2),
    ('Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit',2, 4),
    ('risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus',3, 3),
    ('Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus.',1, 2);
INSERT INTO traduccionDescripsciones (descripcioneId, idiomaId,traduccion)
VALUES
    (1,2,'ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus'),
    (3,3,'euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis'),
    (4,2,'Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,'),
    (1,3,'est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut'),
    (1,1,'dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit');

insert into valoraciones (usuarioId, AlojamientoId, texto, puntuacion) values
(2, 4, 'Morbi a ipsum. Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet.', 5),
(3, 5, 'Sed ante. Vivamus tortor. Duis mattis egestas metus. Aenean fermentum. Donec ut mauris eget massa tempor convallis.', '02-378-4633'),
(1, 2, 'Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus. Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero. Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Intege.', 4),
(2, 3, 'In congue. Etiam justo. Etiam pretium iaculis justo. In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus. Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi. Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque. Quisque porta volutpat erat.', 4),
(4, 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', 3),
(5, 3, 'Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede. Morbi porttitor lorem id ligula. Nulla justo. Aliquam quis turpis eget elit sodales scelerisque.', 5);

INSERT INTO fotografias (ID,ruta, alojamientoId)
values (1,'http://google.co.jp/a.png', 1),
(2,'http://uol.com.br/orci/vehicula/condimentum/curabitur/in/libero/ut.aspx', 2),
(3,'http://techcrunch.com/nulla/pede/ullamcorper.js', 3),
(4,'https://digg.com/augue/luctus/tincidunt/nulla/mollis.json', 4),
(5,'https://bloglovin.com/lacinia/erat/vestibulum/sed/magna/at.xml', 5);
