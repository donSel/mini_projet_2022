------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------



------------------------------------------------------------
-- Table: doc
------------------------------------------------------------
CREATE TABLE public.doc(
	mail            VARCHAR (50) NOT NULL ,
	mdp             VARCHAR (50) NOT NULL ,
	nom             CHAR (50)  NOT NULL ,
	prenom          CHAR (50)  NOT NULL ,
	specialite      CHAR (50)  NOT NULL ,
	telephone       INT  NOT NULL ,
	CONSTRAINT doc_PK PRIMARY KEY (mail) ,
	CONSTRAINT doc_AK UNIQUE (etablissement)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: patient
------------------------------------------------------------
CREATE TABLE public.patient(
	mail        VARCHAR (50) NOT NULL ,
	nom         CHAR (50)  NOT NULL ,
	prenom      CHAR (50)  NOT NULL ,
	mdp         VARCHAR (50) NOT NULL ,
	telephone   INT  NOT NULL  ,
	CONSTRAINT patient_PK PRIMARY KEY (mail)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: etablissement
------------------------------------------------------------
CREATE TABLE public.etablissement(
	etablissement   VARCHAR (50) NOT NULL ,
	ville           CHAR (50)  NOT NULL ,
	code_postal     INT  NOT NULL  ,
	CONSTRAINT etablissement_PK PRIMARY KEY (etablissement)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: appartenir
------------------------------------------------------------
CREATE TABLE public.appartenir(
	etablissement   VARCHAR (50) NOT NULL ,
	mail            VARCHAR (50) NOT NULL  ,
	CONSTRAINT appartenir_PK PRIMARY KEY (etablissement,mail)

	,CONSTRAINT appartenir_etablissement_FK FOREIGN KEY (etablissement) REFERENCES public.etablissement(etablissement)
	,CONSTRAINT appartenir_doc0_FK FOREIGN KEY (mail) REFERENCES public.doc(mail)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: prendre
------------------------------------------------------------
CREATE TABLE public.prendre(
	mail_doc           VARCHAR (50) NOT NULL ,
	mail_patient   VARCHAR (50) NOT NULL ,
	heure          TIMESTAMP  NOT NULL ,
	date           DATE  NOT NULL  ,
	CONSTRAINT prendre_PK PRIMARY KEY (mail_doc,mail_patient)

	,CONSTRAINT prendre_doc_FK FOREIGN KEY (mail_doc) REFERENCES public.doc(mail_doc)
	,CONSTRAINT prendre_patient0_FK FOREIGN KEY (mail_patient) REFERENCES public.patient(mail)
)WITHOUT OIDS;



