-- CRÉATION DES TABLES 

CREATE TABLE Carte(
	idCarte int PRIMARY KEY,
	nom varchar(20),
	description varchar(200),
	dateCrea date,
	idObj
);

CREATE TABLE Parametre(
	idParam int PRIMARY KEY,
	nom varchar(20),
	valeur int, 
	idCarte int REFERENCES Carte(idCarte)
);

CREATE TABLE Contributeur(
	idUser int PRIMARY KEY,
	nom varchar(20),
	prenom varchar(20),
	idCarte int REFERENCES Carte(idCarte)
);

CREATE TABLE logCarte(
    idCarte int REFERENCES Carte(idCarte),
    idUser int REFERENCES contributeur(idUser),
    dateModif date,
    type varchar(20),
    param varchar(250)
);

CREATE TABLE Zone(
    idZone int PRIMARY KEY,
    description varchar(250),
    dim_x int,
    dim_y int,
    nbCases int,
    idCarte int REFERENCES Carte(idCarte),
    idEnv int REFERENCES Environnement(idEnv)
);

CREATE TABLE Relier(
    idZone1 int,
    idZone2 int,
    direction varchar(10),
    CONSTRAINT pk_Relier PRIMARY KEY (idZone1, idZone2),
    CONSTRAINT fk_Relier1 FOREIGN KEY (idZone1) REFERENCES Zone(idZone),
    CONSTRAINT fk_Relier2 FOREIGN KEY (idZone2) REFERENCES Zone(idZone)
);

CREATE TABLE PassageSecret(
    idZone1 int,
    idZone2 int,
    idElem int REFERENCES Mobilier(idMobilier),
    détection varchar(20),
    CONSTRAINT pk_ps PRIMARY KEY (idZone1, idZone2),
    CONSTRAINT fk_ps1 FOREIGN KEY (idZone1) REFERENCES Zone(idZone),
    CONSTRAINT fk_ps2 FOREIGN KEY (idZone2) REFERENCES Zone(idZone)
);

CREATE TABLE Contient(
    idContient int PRIMARY KEY,
    idZone int REFERENCES Zone(idZone),
    idPiege int REFERENCES Piege(idPiege),
    idMobilier int REFERENCES Mobilier(idMobilier),
    idEquipement int REFERENCES Equipement(idEquipement),
    pos_x int, 
    pos_y int
);

CREATE TABLE Piege(
    idPiege int PRIMARY KEY,
    zone_x int,
    zone_y int,
    nom varchar(20),
    image varchar(250),
    catégorie varchar(20),
    detecter varchar(20),
    desamorcer varchar(20),
    esquiver varchar(20)
);

CREATE TABLE Mobilier(
    idMobilier int PRIMARY KEY,
    nom varchar(20),
    image varchar(250),
    deplacable varchar(3),
    dim_x int,
    dim_y int,
    nbCases int,
    environnement varchar(20)
);

CREATE TABLE Equipement(
    idEquipement int PRIMARY KEY,
    nom varchar(20),
    image varchar(250),
    prix int
);

CREATE TABLE Objectif(
    idObj int PRIMARY KEY,
    idZone int REFERENCES Zone(idZone),
    idEquipement int REFERENCES Equipement(idEquipement)
);

CREATE TABLE Rencontre(
    idRencontre int PRIMARY KEY,
    idZone int REFERENCES Zone(idZone),
    idPNJ int REFERENCES PNJ(idPNJ),
    idCreature int REFERENCES Creature(idCreature),
    pos_x int, 
    pos_y int
);

CREATE TABLE PNJ(
    idPNJ int PRIMARY KEY,
    nom varchar(20),
    catégorie varchar(20),
    nbOr int,
    pa int,
    pv int,
    métier varchar(20),
    caractère varchar(20),
    phrase varchar(250),
    image varchar(20)
);

CREATE TABLE Creature(
    idCreature int PRIMARY KEY,
    nom varchar(20),
    catégorie varchar(20),
    nbOr int,
    pa int,
    pv int,
    climat varchar(20),
    difficulté int, 
    environnement varchar(20),
    image varchar(20)
);

CREATE TABLE Habitat(
    idCreature int REFERENCES Creature(idCreature),
    idEnvironnement int REFERENCES Environnement(idEnvironnement),
    degré int,
    CONSTRAINT pk_Habitat PRIMARY KEY (idCreature, idEnvironnement)
);

CREATE TABLE Environnement(
    idEnvironnement int PRIMARY KEY,
    nom varchar(20),
    description varchar(250),
    image varchar(20)
);

-- REMPLISSAGE DES TABLES

-- ajout de mobiliers
INSERT INTO Mobilier(idMobilier, nom, image, deplacable, environnement) VALUES(0, 'arbre', 'arbre.png', 'non', 'exterieur');
INSERT INTO Mobilier(idMobilier, nom, image, deplacable, environnement) VALUES(1, 'algue', 'algue.png', 'non', 'aquatic');

-- remplissage des équipements

INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(0, 'épée en fer', 'epee_fer.png', 50); 
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(1, 'épée', 'epee.png', 20);
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(2, 'arc', 'arc.webp', 17);
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(3, 'couteau', 'couteau.png', 5); 
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(4, 'baton', 'baton.png', 2); 
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(5, 'arbalète', 'arbalète.png', 34); 
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(6, 'clé', 'cle.png', 12); 
INSERT INTO Equipement(idEquipement, nom, image, prix) VALUES(7, 'hache en fer', 'hache_fer.png', 18); 

-- remplissage des pnj

INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(0, 'Gabrielle', 'Humain', 12, 10, 10, 'dresseuse', 'passionnée', 'Comment tu vas chaton ? ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(1, 'Patrick', 'Humain', 12, 10, 10, 'chomeur', 'gentil', 'bonjour ! ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(2, 'JP', 'Humain', 55, 7, 10, 'boulanger', 'rigoureux', 'pas trop cuite la baguette ? ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(3, 'Claude', 'Humain', 26, 15, 18, 'jardinier', 'froid', 'marche pas sur la pelouse. ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(4, 'Richard', 'Humain', 25, 14, 15, 'Forgeron', 'concentré', ' Qu\'est ce que tu viens faire là gamin ? ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(5, 'Diane', 'Humain', 22, 8, 12, 'couturière', 'gronchon', 'De toutes façons, on f\'ra pas de vieux os.. ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(6, 'Tatiana', 'Humain', 26, 15, 18, 'guerrière', 'courageuse', '... Et là, je lui ai tranché la gorge ! ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(7, 'Nicolas', 'Humain', 12, 10, 10, 'enfant', 'innocent', 'Tu veux un bonbon ? ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(8, 'Greg', 'Humain', 55, 7, 10, 'épicier', 'fatigué', 'ça vous fera 10 pièces d\'or. ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(9, 'Marc', 'Humain', 26, 15, 18, 'dealer', 'forceur', 'eh j\' en ai de la bonne frère');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(10, 'Emma', 'Humain', 12, 10, 10, 'mère au foyer', 'généreuse', 'Victor ! Arrête de courir ! ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(11, 'Capucine', 'Humain', 55, 7, 10, 'Pompier', 'dévouée', 'Y a pas le feu ! ');
INSERT INTO PNJ(idPNJ, nom, catégorie, nbOr, pa, pv, métier, caractère, phrase) VALUES(12, 'Géraldine', 'Humain', 26, 15, 18, 'Professeure', 'maternelle', 'Fais-moi voir ton joli dessin. ');

-- remplissage des environnements

INSERT INTO Environnement VALUES(0, 'RuinsDungeons', 'Donjon en ruine', 'tuile_carrelage.png');
INSERT INTO Environnement VALUES(1, 'Hills', 'en haut de la coline ', 'hills1.jpg');
INSERT INTO Environnement VALUES(2, 'Plains', 'Plaine', 'plains.jpg');
INSERT INTO Environnement VALUES(3, 'Aquatic', 'Ocean', 'aquatic');
INSERT INTO Environnement VALUES(4, 'Moutains', 'Montagne', 'moutain.jpg');
INSERT INTO Environnement VALUES(5, 'Urban', 'dans la rue', 'urban.png');
INSERT INTO Environnement VALUES(6, 'Underground', 'sous-terrain', 'underground.jpg');
INSERT INTO Environnement VALUES(7, 'Swamp', 'Marais', 'marais.png');
INSERT INTO Environnement (`idEnvironnement`,`nom`, `description`) VALUES(8, 'Sky', 'Le ciel');
INSERT INTO Environnement (`idEnvironnement`,`nom`, `description`) VALUES(9, 'ForestJungle', 'Jungle');
INSERT INTO Environnement (`idEnvironnement`,`nom`, `description`) VALUES(10, 'Unknow', 'Inconnu');

-- remplissage des contributeurs

INSERT INTO Contributeur VALUES('0', 'Kremer-Cochet', 'Eglantine', '2020-4-6');
INSERT INTO Contributeur VALUES('1', 'Angelov', 'Kevin', '2020-4-2');
INSERT INTO Contributeur VALUES('2', 'Dupont', 'Henri', '2020-6-12');
INSERT INTO Contributeur VALUES('3', 'Martin', 'Harry', '2020-8-24');
INSERT INTO Contributeur VALUES('4', 'Gonzales', 'Lea', '2020-9-5');
