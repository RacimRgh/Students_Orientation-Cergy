DROP TABLE IF EXISTS Assistant CASCADE;
DROP TABLE IF EXISTS Connexion CASCADE;
DROP TABLE IF EXISTS Demandeur CASCADE;
DROP TABLE IF EXISTS Maintenance CASCADE;
DROP TABLE IF EXISTS Reponse CASCADE;
DROP TABLE IF EXISTS Question CASCADE;
DROP TABLE IF EXISTS Message CASCADE;
DROP TABLE IF EXISTS Etudiant CASCADE;
DROP TABLE IF EXISTS Borne CASCADE;
DROP TABLE IF EXISTS Administrateur CASCADE;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS faq_borne;


CREATE TABLE Borne
(
	id_borne VARCHAR(50),
	longitude FLOAT,
	latitude FLOAT,
	etatB VARCHAR(50),
	nb_requetes SERIAL,
	CONSTRAINT Borne_pk PRIMARY KEY (id_borne)
);

CREATE TABLE Administrateur
(
	idAdm VARCHAR(50),
	roleAdm VARCHAR(50),
	nomAdm VARCHAR(50),
	prenomAdm VARCHAR(50),
	telAdm VARCHAR(50),
	CONSTRAINT Administrateur_pk PRIMARY KEY (idAdm)
);

CREATE TABLE Etudiant
(
	matricule_etu VARCHAR(50),
	nom_etu VARCHAR(50),
	prenom_etu VARCHAR(50),
	email_etu VARCHAR(50),
	numtel_etu VARCHAR(20),
	univ_etu VARCHAR(50),
	specialite_etu VARCHAR(50),
	CONSTRAINT Etudiant_pk PRIMARY KEY (matricule_etu)
);

--	id_dem VARCHAR(50),
--	CONSTRAINT Demandeur_pk PRIMARY KEY (id_dem)
--	CONSTRAINT Demandeur_fk FOREIGN KEY (id_dem) REFERENCES Etudiant (matricule_etu),
CREATE TABLE Demandeur 
(
	matricule_etu VARCHAR(50),
	type_dem VARCHAR(50),
	etat_dem VARCHAR(50),
	CONSTRAINT Demandeur_pk PRIMARY KEY (matricule_etu)
) INHERITS (Etudiant); 

--	CONSTRAINT Assistant_fk FOREIGN KEY (id_ast) REFERENCES Etudiant (matricule_etu),
--	CONSTRAINT Assistant_pk PRIMARY KEY (id_ast)
CREATE TABLE Assistant
(
	matricule_etu VARCHAR(50),
	statut_ast VARCHAR(10),
	date_inscription DATE,
	nb_reponses INT,
	CONSTRAINT Assistant_pk PRIMARY KEY (matricule_etu)
) INHERITS (Etudiant);

CREATE TABLE Message
(
	idMessage VARCHAR(50),
	dateMess DATE,
	heureMess time,
	admAjout VARCHAR(50),
	CONSTRAINT Message_pk PRIMARY KEY (idMessage),
	CONSTRAINT Message_fk FOREIGN KEY (admAjout) REFERENCES Administrateur (idAdm)
);

CREATE TABLE Question
(
	idQ VARCHAR(50),
	titreQ VARCHAR(50),
	contenuQ VARCHAR(50),
	id_borne VARCHAR(50),
	matriculeDem VARCHAR(50),
	CONSTRAINT Question_pk PRIMARY KEY (idQ),
	CONSTRAINT Question_fk1 FOREIGN KEY (idQ) REFERENCES Message (idMessage),
	CONSTRAINT Question_fk2 FOREIGN KEY (id_borne) REFERENCES Borne (id_borne),
	CONSTRAINT Question_fk3 FOREIGN KEY (matriculeDem) REFERENCES Demandeur (matricule_etu)
) INHERITS (Message);

CREATE TABLE Reponse
(
	idR VARCHAR(50),
	contenuRep VARCHAR(50),
	matriculeRep VARCHAR(50),
	idQ VARCHAR(50),
	CONSTRAINT Reponse_pk PRIMARY KEY (idR),
	CONSTRAINT Reponse_fk1 FOREIGN KEY (idR) REFERENCES Message (idMessage),
	CONSTRAINT Reponse_fk2 FOREIGN KEY (matriculeRep) REFERENCES Assistant (matricule_etu),
	CONSTRAINT Reponse_fk3 FOREIGN KEY (idQ) REFERENCES Question (idQ)
) INHERITS (Message);

CREATE TABLE Connexion
(
	matricule_etu VARCHAR(50),
	id_borne VARCHAR(50),
	date_connexion DATE,
	heure_connexion time,
	CONSTRAINT Connexion_pk PRIMARY KEY (matricule_etu, id_borne)
);

CREATE TABLE Maintenance
(
	idAdm VARCHAR(50),
	id_borne VARCHAR(50),
	date_maintenance DATE,
	heure_maintenance time,
	CONSTRAINT Maintenance_pk PRIMARY KEY (idAdm, id_borne)
);

CREATE TABLE FAQ
(
	idFAQ VARCHAR(50),
	typeFAQ VARCHAR(50),
	titreFAQ VARCHAR(50),
	contenuFAQ VARCHAR(200),
	reponseFAQ VARCHAR(200),
	CONSTRAINT QuestionPR_pk PRIMARY KEY (idFAQ)
);

CREATE TABLE faq_borne
(
	id_borne VARCHAR(50),
	idFAQ VARCHAR(50),
	CONSTRAINT contenu_pk PRIMARY KEY (id_borne, idFAQ)
);



