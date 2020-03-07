drop database if exists metro;
create database metro;
use metro;

create table kupac(
    id int primary key auto_increment,
    ime varchar(20) not null,
    prezime varchar(20) not null,
    lozinka varchar(60) not null,
    email varchar(50)not null,
    metrokartica char(15) not null,
    brojmobitela char(15)
);

create table racun(
    id int primary key auto_increment,
    stavka int not null,
    kupac int not null,
    vrijemekupnje datetime,
    nacinplacanja varchar(20),
    operater int not null,
    brojracuna varchar(50)
);

create table stavka(
    proizvod int not null,
    racun int not null
);

create table proizvod(
    id int primary key auto_increment,
    naziv varchar(50),
    barcode char(20),
    kategorija varchar(20),
    racun int not null
);


create table operater(
id          int primary key auto_increment,
email       varchar(50) not null,
lozinka     char(60) not null,
ime         varchar(50) not null,
prezime     varchar(50) not null,
uloga       varchar(20) not null,
aktivan     boolean not null default false,
sessionid   varchar(100)
);
	




alter table racun add foreign key (kupac) references kupac(id);
alter table racun add foreign key (operater) references operater(id);
alter table stavka add foreign key (racun) references racun(id);
alter table stavka add foreign key (proizvod) references proizvod(id);
