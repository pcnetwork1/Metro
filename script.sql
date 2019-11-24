drop database if exists metro;
create database metro;
use metro;

create table kupac(
    id int primary key auto_increment,
    ime varchar(20) not null,
    prezime varchar(20) not null,
    metrokartica int not null,
    brojmobitela char(15)
);

create table racun(
    id int primary key auto_increment,
    stavka int not null,
    kupac int not null,
    vrijemekupnje datetime,
    nacinplacanja int not null,
    djelatnik int not null
);

create table stavka(
    proizvod int not null,
    racun int not null
);

create table proizvod(
    id int primary key auto_increment,
    naziv varchar(50),
    barcode char(20),
    kategorija int not null,
    racun int not null
);

create table kategorija(
    id int primary key auto_increment,
    naziv varchar(20),
    lokacija varchar(20)
);

create table djelatnik(
    id int primary key auto_increment,
    ime varchar(20) not null,
    prezime varchar(20) not null,
    iban varchar(15),
    brojmobitela char(15),
    menadzer int not null

);

create table menadzer(
    id int primary key auto_increment,
    ime varchar(20),
    prezime varchar(20),
    brojmobitela char(20)
);

create table nacinplacanja(
    id int primary key auto_increment,
    naziv varchar(20)
);


alter table racun add foreign key (kupac) references kupac(id);
alter table racun add foreign key (djelatnik) references djelatnik(id);
alter table racun add foreign key (nacinplacanja) references nacinplacanja(id);
alter table stavka add foreign key (racun) references racun(id);
alter table stavka add foreign key (proizvod) references proizvod(id);
alter table proizvod add foreign key (kategorija) references kategorija(id);
alter table djelatnik add foreign key (menadzer) references menadzer(id);
