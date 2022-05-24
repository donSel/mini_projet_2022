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
	etablissement   VARCHAR (50) NOT NULL ,
	adresse   VARCHAR (50) NOT NULL ,
	ville           CHAR (50)  NOT NULL ,
	code_postal     INT  NOT NULL  ,
	CONSTRAINT doc_PK PRIMARY KEY (mail)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: patient
------------------------------------------------------------
CREATE TABLE patient(
	mail        VARCHAR (50) NOT NULL ,
	nom         CHAR (50)  NOT NULL ,
	prenom      CHAR (50)  NOT NULL ,
	mdp         VARCHAR (50) NOT NULL ,
	telephone   VARCHAR (50)  NOT NULL  ,
	CONSTRAINT patient_PK PRIMARY KEY (mail)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: prendre
------------------------------------------------------------
CREATE TABLE prendre(
	mail           VARCHAR (50) NOT NULL ,
	mail_patient   VARCHAR (50) NOT NULL ,
	jour          DATE  NOT NULL ,
	heure          TIME  NOT NULL ,
	-- CONSTRAINT prendre_PK PRIMARY KEY (mail,mail_patient) ,
	CONSTRAINT prendre_doc_FK FOREIGN KEY (mail) REFERENCES doc(mail) ,
	CONSTRAINT prendre_patient0_FK FOREIGN KEY (mail_patient) REFERENCES patient(mail)
)WITHOUT OIDS;



