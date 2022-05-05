-- Table: doc
------------------------------------------------------------
CREATE TABLE public.doc(
	id_doc          SERIAL NOT NULL ,
	mail            VARCHAR (50) NOT NULL ,
	mdp             VARCHAR (50) NOT NULL ,
	nom             CHAR (50)  NOT NULL ,
	prenom          CHAR (50)  NOT NULL ,
	specialite      CHAR (50)  NOT NULL ,
	etablissement   VARCHAR (50) NOT NULL  ,
	CONSTRAINT doc_PK PRIMARY KEY (id_doc) ,
	CONSTRAINT doc_AK UNIQUE (etablissement)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: user
------------------------------------------------------------
CREATE TABLE public.user(
	id_user   SERIAL NOT NULL ,
	nom       CHAR (50)  NOT NULL ,
	prenom    CHAR (50)  NOT NULL ,
	mail      VARCHAR (50) NOT NULL ,
	mdp       VARCHAR (50) NOT NULL  ,
	CONSTRAINT user_PK PRIMARY KEY (id_user)
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
	id_doc          INT  NOT NULL  ,
	CONSTRAINT appartenir_PK PRIMARY KEY (etablissement,id_doc)

	,CONSTRAINT appartenir_etablissement_FK FOREIGN KEY (etablissement) REFERENCES public.etablissement(etablissement)
	,CONSTRAINT appartenir_doc0_FK FOREIGN KEY (id_doc) REFERENCES public.doc(id_doc)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: prendre
------------------------------------------------------------
CREATE TABLE public.prendre(
	id_doc    INT  NOT NULL ,
	id_user   INT  NOT NULL ,
	heure     TIMESTAMP  NOT NULL  ,
	CONSTRAINT prendre_PK PRIMARY KEY (id_doc,id_user)

	,CONSTRAINT prendre_doc_FK FOREIGN KEY (id_doc) REFERENCES public.doc(id_doc)
	,CONSTRAINT prendre_user0_FK FOREIGN KEY (id_user) REFERENCES public.user(id_user)
)WITHOUT OIDS;