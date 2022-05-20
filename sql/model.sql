 /*
 * File: /var/www/html/php/projet/code/model.sql
 * Project: /var/www/html/php/projet/code
 * Created Date: Thursday May 5th 2022
 * Author: Mickaël Neroda
 * -----
 * Last Modified: Thursday May 5th 2022 10:50:37 am
 * Modified By: the developer formerly known as Mickaël Neroda at <you@you.you>
 * -----
 * Copyright (c) 2022 Your Company
 * -----
 * HISTORY:
 */

------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------
DROP TABLE IF EXISTS doc CASCADE;
DROP TABLE IF EXISTS patient CASCADE;
DROP TABLE IF EXISTS etablissement CASCADE;
DROP TABLE IF EXISTS appartenir CASCADE;
DROP TABLE IF EXISTS prendre CASCADE;

------------------------------------------------------------
-- Table: doc
------------------------------------------------------------
CREATE TABLE doc(
	mail            VARCHAR (50) NOT NULL ,
	mdp             VARCHAR (50) NOT NULL ,
	nom             CHAR (50)  NOT NULL ,
	prenom          CHAR (50)  NOT NULL ,
	specialite      CHAR (50)  NOT NULL ,
	telephone       VARCHAR (50)  NOT NULL ,
	PRIMARY KEY (mail) 
);


------------------------------------------------------------
-- Table: patient
------------------------------------------------------------
CREATE TABLE patient(
	mail        VARCHAR (50) NOT NULL ,
	nom         CHAR (50)  NOT NULL ,
	prenom      CHAR (50)  NOT NULL ,
	mdp         VARCHAR (50) NOT NULL ,
	telephone   VARCHAR (50)  NOT NULL ,
	PRIMARY KEY (mail)
);


------------------------------------------------------------
-- Table: etablissement
------------------------------------------------------------
CREATE TABLE etablissement(
	etablissement   VARCHAR (50) NOT NULL ,
	adresse        VARCHAR (50) NOT NULL ,
	ville           CHAR (50)  NOT NULL ,
	code_postal     INTEGER  NOT NULL  ,
	PRIMARY KEY (etablissement)
);


------------------------------------------------------------
-- Table: appartenir
------------------------------------------------------------
CREATE TABLE appartenir(
	etablissement   VARCHAR (50) NOT NULL ,
	mail            VARCHAR (50) NOT NULL  ,
	code_postal     INTEGER  NOT NULL  ,
	PRIMARY KEY (etablissement,mail) ,
	FOREIGN KEY (etablissement) REFERENCES etablissement(etablissement) ,
	FOREIGN KEY (mail) REFERENCES doc(mail)
);


------------------------------------------------------------
-- Table: prendre
------------------------------------------------------------
CREATE TABLE prendre(
	mail           VARCHAR (50) NOT NULL ,
	mail_patient   VARCHAR (50) NOT NULL ,
	heure          TIMESTAMP  NOT NULL ,
	jour           DATE  NOT NULL  ,
	PRIMARY KEY (mail,mail_patient) ,
	FOREIGN KEY (mail) REFERENCES doc(mail) ,
	FOREIGN KEY (mail_patient) REFERENCES patient(mail)
);


