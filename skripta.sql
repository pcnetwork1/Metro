drop database if exists edunovapp20;
create database edunovapp20 default character set utf8;
# ovu sljedeću liniju copy/psate u command prompt
# PRIPAZITI SAMO NA PUTANJU DATOTEKE
# c:\xampp\mysql\bin\mysql.exe -uedunova -pedunova --default_character_set=utf8 < F:\PP20\predavac01.edunova.hr\skripta.sql



# BACKUP
# c:\xampp\mysql\bin\mysqldump.exe -uedunova -pedunova edunovapp20 > f:\backupskriptapp20.sql


use edunovapp20;

create table operater(
sifra       int not null primary key auto_increment,
email       varchar(50) not null,
lozinka     char(60) not null,
ime         varchar(50) not null,
prezime     varchar(50) not null,
uloga       varchar(20) not null
);
insert into operater values 
(null,'edunova@edunova.hr',
'$2y$10$AzFzPK10Gi3nYBfpVKGYPeiyeQ8JOQOkfGJJ1jKJnQ.2hacJ2iwBi',
'Edunova','Operater','oper');
insert into operater values 
(null,'admin@edunova.hr',
'$2y$10$AzFzPK10Gi3nYBfpVKGYPeiyeQ8JOQOkfGJJ1jKJnQ.2hacJ2iwBi',
'Edunova','Administrator','admin');



create table smjer(
sifra       int not null primary key auto_increment,
naziv       varchar(50) not null,
trajanje    int,
cijena      decimal(18,2) not null,
upisnina    decimal(18,2) not null,
verificiran boolean default true
);


create table grupa(
sifra int not null primary key auto_increment,
naziv varchar(20) not null,
smjer int not null,
predavac int ,
brojpolaznika int not null,
datumpocetka datetime 
);

create table predavac(
    sifra int not null primary key auto_increment,
    osoba int not null,
    iban varchar(50)
);

create table osoba(
    sifra int not null primary key auto_increment,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    oib char(11),
    email varchar(100) not null
);


create table polaznik(
    sifra int not null primary key auto_increment,
    osoba int not null,
    brojugovora varchar(50)
);

create table clan(
    grupa int not null,
    polaznik int not null
);


alter table grupa add foreign key (smjer) references smjer(sifra);
alter table grupa add foreign key (predavac) references predavac(sifra);

alter table predavac add foreign key (osoba) references osoba(sifra);

alter table polaznik add foreign key (osoba) references osoba(sifra);

alter table clan add foreign key (grupa) references grupa(sifra);
alter table clan add foreign key (polaznik) references polaznik(sifra);


#select * from smjer;

# ne tako dobar način
#1
insert into smjer values 
(null,'PHP programiranje',130,4999.99,500,false);

# malo bolji način 1
# 2
insert into smjer (naziv,cijena,upisnina) values 
('Java programiranje',7825,500);

# malo bolji način 2
#3
insert into smjer (cijena,naziv,upisnina) values
(2000,'Računalni operator',500);

# najbolji način korištenja insert naredbe
#4
insert into smjer (sifra,naziv,trajanje,cijena,upisnina,verificiran)
values (null,'Knjigovodstveni operater',180,8000,500,true);

#select * from grupa;

#1
insert into grupa (sifra,naziv,smjer,predavac,brojpolaznika,datumpocetka)
values (null,'PP20',1,null,18,'2019-10-28 17:00:00');

#2
insert into grupa (sifra,naziv,smjer,predavac,brojpolaznika,datumpocetka)
values (null,'JP21',2,null,18,'2019-10-28 19:00:00');

#select * from osoba;

#1
insert into osoba (sifra,ime,prezime,oib,email)
values (null,'Tomislav','Jakopec',null,'tjakopec@gmail.com');

#2-22
insert into osoba (sifra,ime,prezime,oib,email) values
(null,'Damir','Škrebljin',null,'skrebljin@hotmail.com'),
(null,'Mirza','Deagić',null,'mirza.delagic@gmail.com'),
(null,'Marko','Biskupić',null,'biskupicmarko4@gmail.com'),
(null,'Filip','Poslek',null,'fposlek@gmail.com'),
(null,'Kristijan','Vidaković',null,'kristijan.vidakovic111@gmail.com'),
(null,'Matej','Malčić',null,'matej.malcic3@gmail.com'),
(null,'Antonio','Grbeša',null,'agrbesa995@gmail.com'),
(null,'Ivan','Jozing',null,'ivan.jozing1@gmail.com'),
(null,'Ivan','Damjanović',null,'damjanovic.ivan87@gmail.com'),
(null,'Stjepan','Perišin',null,'stjepan@xenios.hr'),
(null,'Luka','Vuk',null,'luka.vuk456@gmail.com'),
(null,'Vedran','Stojnović',null,'phidrho@gmail.com'),
(null,'Ivor','Ćelić',null,'ivorcelic@gmail.com'),
(null,'Matija','Špoljar',null,'spoljo1122@gmail.com'),
(null,'Anita','Račman',null,'racmananita@gmail.com'),
(null,'Tomislav','Zidar',null,'zidarto@hotmail.com'),
(null,'Renato','Topić',null,'renato.topic@gmail.com'),
(null,'Tomislav','Grebenar',null,'tomislav.grebenarlb@gmail.com'),
(null,'Vladimir','Grebenar',null,'vladimir.grebenar@gmail.com'),
(null,'David','Čiček',null,'official.davidcicek@gmail.com'),
(null,'Dijana','Pandurević',null,'dijana.pandurevic@gmail.com');

#23-44
insert into osoba (sifra,ime,prezime,email) values
(null,'Mirko','Rešetar','reso28@gmail.com'),
(null,'Filip','Gelenčir','stoka199@gmail.com'),
(null,'Bruno','Gelenčir','gelencirbruno@gmail.com'),
(null,'Filip','Volarević','voki095@gmail.com'),
(null,'Marko','Milić','marko.milic224@gmail.com'),
(null,'Azinić','Andrija','azinic1999@gmail.com'),
(null,'Zvonimir','Mesinger','zvonimir.mesinger@gmail.com'),
(null,'Boris','Lasović','lasovic@gmail.com'),
(null,'Maksima','Mijatović','maxima.mijatovic@gmail.com'),
(null,'Nikola','Juzbašić','nikolajuzbasic70@gmail.com'),
(null,'Sven','Čevapović','svencevapovic77@gmail.com'),
(null,'Luka','Poznić','lpoznic@net.hr'),
(null,'Dario','Perišić','perisicdario2702@gmail.com'),
(null,'Dario','Trtanj','trtanjd@gmail.com'),
(null,'Božena','Palić Cerić','bozena.palic@gmail.com'),
(null,'Nikola','Milić','nikk.mil@gmail.com'),
(null,'David','Petrić','petricdavid@protonmail.ch'),
(null,'Goran','Maras','goran.maras77@gmail.com'),
(null,'Marko','Grbeš','marko.grbes1@gmail.com'),
(null,'Matej','Šapina','sapina.matej@yahoo.com'),
(null,'Josip','Dasović','josip.dasovic22@gmail.com'),
(null,'Goran','Kovač','gokovac@gmail.com');

# 45
insert into osoba (sifra,ime,prezime,oib,email)
values (null,'Shaquille','O''Neal',null,'shaki@gmail.com');

#select * from osoba;

#1,2
insert into predavac (osoba) values
(1),(45);

# 1-43
insert into polaznik (osoba) 
select sifra from osoba where sifra not in (1,45);

#select * from grupa;


insert into clan (grupa,polaznik)
select 1, sifra from polaznik where sifra<=21;

insert into clan (grupa,polaznik)
select 2, sifra from polaznik where sifra>21;
#describe predavac;