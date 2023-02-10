create table idiomas(
	ID integer primary key auto_increment,
	idioma varchar(10)
);

create table descripciones(
	ID integer primary key auto_increment,
	alojamientoId integer,
    descripcion varchar(600),
    idiomaId integer,
    foreign key (idiomaId) references idiomas(ID),
    foreign key (alojamientoId) references alojamientos(ID)
);
/*
  He modificado la descripcion poruqe si enlazamos una descripcion
  al alojamiento una descripcion solo tiene una descripcion aunque
  creemos multiples descripciones, de forma que la unica forma que
  tenemos de traducir las descripciones es duplicar el alojamiento
*/

create table traduccionDescripsciones(
    descripcioneId integer,
    idiomaId integer,
    traduccion varchar(600),
    primary key (descripcioneId, idiomaId),
    foreign key (idiomaId) references idiomas(ID),
    foreign key (descripcioneId) references descripciones(ID)
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
    tarifaBaija integer,
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
/*
  He modificado la descripcion poruqe si enlazamos una descripcion
  al alojamiento una descripcion solo tiene una descripcion aunque
  creemos multiples descripciones, de forma que la unica forma que
  tenemos de traducir las descripciones es duplicar el alojamiento
*/

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