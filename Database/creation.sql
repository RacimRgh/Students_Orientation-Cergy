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
DROP TABLE IF EXISTS FAQ CASCADE;
DROP TABLE IF EXISTS faq_borne CASCADE;

-- La table borne gère la connexion entre le client et le réseau
CREATE TABLE Borne
(
	id_borne VARCHAR(50),
	longitude FLOAT,
	latitude FLOAT,
	etatB VARCHAR(50),
	CONSTRAINT Borne_pk PRIMARY KEY (id_borne)
);

-- L'administrateur gère les messages
CREATE TABLE Administrateur
(
	idAdm VARCHAR(50),
	roleAdm VARCHAR(50),
	nomAdm VARCHAR(50),
	prenomAdm VARCHAR(50),
	telAdm VARCHAR(50),
	CONSTRAINT Administrateur_pk PRIMARY KEY (idAdm)
);

-- L'etudiant peut-être demandeur ou assistant
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

-- Un demandeur est un etudiant qui publie une demande
CREATE TABLE Demandeur
(
	id_dem VARCHAR(50),	-- identifiant de la demande faite par le demandeur
	type_dem VARCHAR(50),	-- type de la demande faite par un demandeur
	etat_dem VARCHAR(50),	-- Etat de la demande faite par un demandeur 
	CONSTRAINT Demandeur_pk PRIMARY KEY (id_dem)
) INHERITS (Etudiant); 

-- Un assistant est un etudiant qui repond aux demandes 
CREATE TABLE Assistant
(
	id_ast VARCHAR(50),		-- identifiant de l'aide porposée
	statut_ast VARCHAR(10),	-- statut de l'aide proposée
	date_inscription DATE,		-- date de l'inscription de l'assistant
	nb_reponses INT,		-- nombre de réponses emises par l'assistant 
	CONSTRAINT Assistant_pk PRIMARY KEY (id_ast)
) INHERITS (Etudiant);

-- Message est la table parente des tables question et reponse
CREATE TABLE Message 
(
	idMessage VARCHAR(50),
	dateMess DATE,
	heureMess time,
	admAjout VARCHAR(50), 		-- Administrateur qui a approuvé le message
	CONSTRAINT Message_pk PRIMARY KEY (idMessage),
	CONSTRAINT Message_fk FOREIGN KEY (admAjout) REFERENCES Administrateur (idAdm)
);

-- Une question est un message publié par un demandeur
CREATE TABLE Question
(
	idQ VARCHAR(50),
	titreQ VARCHAR(50),
	categorie VARCHAR(50),
	contenuQ VARCHAR(1000),
	id_borne VARCHAR(50),		 -- identifiant de la borne par ou est passée la question
	idDem VARCHAR(50),
	CONSTRAINT Question_pk PRIMARY KEY (idQ),
	CONSTRAINT Question_fk1 FOREIGN KEY (id_borne) REFERENCES Borne (id_borne),
	CONSTRAINT Question_fk2 FOREIGN KEY (idDem) REFERENCES Demandeur (id_dem)
) INHERITS (Message);

-- Une reponse est un message publié par un assistant
CREATE TABLE Reponse
(
	idR VARCHAR(50),
	contenuRep VARCHAR(1000),
	idq VARCHAR(50),
	idAst VARCHAR(50),
	CONSTRAINT Reponse_pk PRIMARY KEY (idR),
	CONSTRAINT Reponse_fk1 FOREIGN KEY (idAst) REFERENCES Assistant (id_ast),
	CONSTRAINT Reponse_fk2 FOREIGN KEY (idq) REFERENCES Question (idQ)
) INHERITS (Message);

-- Quand un utilisateur se connecte à une borne la connexion est enregistrée
CREATE TABLE Connexion
(

	id_dem VARCHAR(50),
	id_borne VARCHAR(50),
	identC VARCHAR(50),
	date_connexion DATE,
	heure_connexion time,
	CONSTRAINT Connexion_pk PRIMARY KEY (id_dem, id_borne)
);

-- Cette table represente la maintenance de la borne qu'effectue l'administrateur
CREATE TABLE Maintenance
(
	
	idC VARCHAR(50),
	idAdm VARCHAR(50),
	idMain VARCHAR(50),
	id_borne VARCHAR(50),
	date_maintenance DATE,
	heure_maintenance time,
	CONSTRAINT Maintenance_pk PRIMARY KEY (idAdm, id_borne)
);

-- La foire aux questions qui englobe les questions fréquemment posées 
CREATE TABLE FAQ
(
	
	typeFAQ VARCHAR(50),
	titreFAQ VARCHAR(200),
	idFAQ VARCHAR(50),
	contenuFAQ VARCHAR(1000),
	reponseFAQ VARCHAR(1000),
	CONSTRAINT QuestionPR_pk PRIMARY KEY (idFAQ)
);

-- La liaison d'une borne et d'une FAQ
CREATE TABLE faq_borne
(
	idFAQ_B VARCHAR(50),
	id_borne VARCHAR(50),
	idFAQ VARCHAR(50),
	CONSTRAINT contenu_pk PRIMARY KEY (id_borne, idFAQ)
);



