DROP DATABASE IF EXISTS projecte
CREATE DATABASE projecte;
use projecte;

create table idiomas(
	ID integer primary key auto_increment,
	idioma varchar(6)
);

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

create table Valoraciones(
	usuari_id integer,
    Alojamiento_id integer,
    texto varchar(255),
    puntuacion integer,
    primary key (usuari_id, Alojamiento_id),
    foreign key (Alojamiento_id) references alojamientos(ID),
    foreign key (usuari_id) references usuarios(ID)
    
);

create table Fotografias(
	ID integer primary key,
    ruta varchar(500),
    alojamiento_id integer,
    foreign key (alojamiento_id) references alojamientos(ID)
);


create table serviciosAlojameintos(
	servivio_id integer,
    alojamiento_id integer,
    primary key (servivio_id, alojamiento_id),
    foreign key (alojamiento_id) references municipios(ID),
    foreign key (servivio_id) references servicios(ID)
);


/*
create table calcValoracion(
	ID integer primary key auto_increment,
    valoracion integer
);*/