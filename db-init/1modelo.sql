USE ejerciciosphp;
CREATE TABLE users (id int primary key auto_increment, username varchar(60), password varchar(50));
CREATE TABLE libros (id int primary key auto_increment, titulo varchar(60), n_pag int, autor varchar(60), editorial varchar(30));
