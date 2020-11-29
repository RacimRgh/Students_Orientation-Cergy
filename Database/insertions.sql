INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B1', 49.04288, 2.08431, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B2', 48.93906, 2.3546, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B3', 48.84703, 2.34388, 'Fonctionnelle');

INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A1', 'Moderateur', 'Richard', 'STALLMAN', '+3368453687');
INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A2', 'Moderateur', 'John', 'DOE', '+337036984532');

INSERT INTO Etudiant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu) VALUES ('2211', 'Righi', 'Racim', 'racim@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique');

INSERT INTO Etudiant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu) VALUES ('2671', 'Trabelsi', 'Lydia', 'lydia@gmail.com', '+3375681236', 'CY Cergy Paris', 'Informatique');

INSERT INTO Etudiant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu) VALUES ('2843', 'Mapaga', 'Marlyse', 'marlyse@gmail.com', '+3365123647', 'CY Cergy Paris', 'Informatique');

INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('2843', 'Mapaga', 'Marlyse', 'marlyse@gmail.com', '+3365123647', 'CY Cergy Paris', 'Informatique', '2843', 'Hors ligne', '2020-10-30');

--INSERT INTO Assistant (id_ast, statut_ast, date_inscription) VALUES ('2843', 'Hors ligne', '2020-10-30');

INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem, type_dem) VALUES ('2211', 'Righi', 'Racim', 'racim@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique', '2211', 'Personnalisée');
-- INSERT INTO Demandeur (id_dem, type_de) VALUES ('2211', 'Personnalisée');

INSERT INTO Connexion (id_dem, id_borne, date_connexion, heure_connexion) VALUES ('D2211', 'B1', '2020-11-29', '11:26');





