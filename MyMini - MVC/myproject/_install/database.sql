/* Borramos la base de datos si existe */
drop database if exists myMini;
/* Creacion de la base de datos */
create database myMini character set utf8 collate utf8_general_ci;
/* Uso de la base de datos */
use myMini;

/* Tabla listado de usuarios */
create table categoria(
    nombre varchar(20) not null comment 'nombre de la categoria del usuario',
    primary key(nombre)
);

INSERT INTO categoria (nombre) VALUES ('subscriptor'), ('administrador');

/* Tabla listado de usuarios */
create table usuario (
    nick      varchar(20) not null comment 'nombre de usuario elegido por la persona',
    password  varchar(35) not null comment 'contraseña elegida por el usuario',
    email     varchar(50) not null comment 'email del usuario',
    categoria varchar(20) not null default 'usuario' comment 'categoría del usuario',
    foreign key(categoria) references categoria(nombre),
    unique(email),
    primary key(nick)
);

/* La contraseña es en todos Admin123 */
INSERT INTO usuario (nick, password, email, categoria) VALUES 
('admin', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'root@gmail.com', 'administrador'),
('luilli', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'luilli@gmail.com', 'subscriptor');

/* Tabla para las noticias */
create table noticia(
	slug varchar(200) not null,
    titulo varchar(100) not null,
    cuerpo text not null,
    fecha_publicacion datetime not null,
    publicada boolean not null default 1,
    primary key(slug)
);

INSERT INTO noticia (slug, titulo, cuerpo, fecha_publicacion, publicada) VALUES
('el-programa-de-recuperaci-n-del-lince-ib-rico-liberar-a-10-en-2016', 
'El programa de recuperación del lince ibérico liberará a 10 en 2016',
'Fue un visto y no visto. Mirabel, una hembra de lince ibérico, salió 
de la jaula con hambre de libertad y corrió a gran velocidad para perderse 
por el campo de la finca ‘El Castañar’ de Mazarambroz. El ejemplar estrenó 
las cuentas de las sueltas de este año en Castilla-La Mancha, que totalizarán 
19 al cierre del ejercicio.<br/><br/>El animal, como parte del programa de repoblamiento 
de esta especie autóctona ‘Proyecto Life+Iberlince’, se crió en cautividad, pero desde 
ayer está en plena libertad, con los movimientos controlados por los agentes medioambientales.',
'2016-02-08 02:07:12',1);

/* Tabla para las revistas */
create table revista(
    titulo varchar(100) not null,
    img text not null,
    file varchar(200) not null,
    publicada boolean not null default 1,
    unique(file),
    primary key(titulo)
);

INSERT INTO revista (titulo, img, file, publicada) VALUES
('GBQ69', 'gbq69.jpg', 'gbq69.pdf', 1),
('GBQ70', 'gbq70.jpg', 'gbq70.pdf', 1),
('GBQ71', 'gbq71.jpg', 'gbq71.pdf', 0);