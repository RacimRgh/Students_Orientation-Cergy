INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B1', 49.04288, 2.08431, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B2', 48.93906, 2.3546, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B3', 48.84703, 2.34388, 'Fonctionnelle');

INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A1', 'Moderateur', 'Richard', 'STALLMAN', '+3368453687');
INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A2', 'Moderateur', 'John', 'DOE', '+337036984532');

INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('2843', 'Mapaga', 'Marlyse', 'marlyse@gmail.com', '+3365123647', 'CY Cergy Paris', 'Informatique', 'A2843', 'Hors ligne', '2020-10-30');

INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('6531', 'Trabelsi','Lydia', 'lydia@gmail.com', '+336465132', 'CY Cergy Paris', 'Informatique', 'A6531', 'Hors ligne', '2020-10-30');

INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('2211', 'Righi', 'Racim', 'racim@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique', 'D2211');

INSERT INTO Connexion (id_dem, id_borne, date_connexion, heure_connexion) VALUES ('2211', 'B1', '2020-11-29', '11:26');

INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('1', 'Astuces', 'Comment trouver le chemin le plus vers la fac?', 'Vous êtes nouveaux et vous cherchez un moyen de trouver les trajets les plus rapides et éviter les turbulences pour ne pas rater vos cours et examens?', 'Il existe plusieurs applications pour celà, par exemple CityMapper');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('2', 'Astuces', 'Où trouver les meilleures promotions pour les étudiants?', 'Etre étudiant en France ou en Europe vous donne plein d"avatages dont il faut absolumer profiter ! mais où les trouver?', 'Plusieurs sites offrents des rabais pour les étudiants en donnant un ID valable, vous pouvez en trouver certains à Unidays et StudentBeans');
--INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('3', 'Astuces', '', '', '');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('4', 'Spécialité', 'Comment choisir sa spécialité?', 'Dans toutes les filiaires, à un moment donnée il faut choisir une spécialité, comment faire le bon choix?', 'Avant tout, il faut toujours regarder les sites officiels des universités, vous pouvez aussi voir www.meilleurs-masters.com pour voir le classement officiel, si celà n"est pas suffisant, vous pouvez faire une demande personnalisée qui sera traité par un de nos membres ;)');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('5', 'Crous', 'C"est quoi le CROUS?', 'Le Centre régional des œuvres universitaires et scolaires de Paris (Crous) est le service public de la vie étudiante, qu"offre t"til?', 'Le CROUS offre aux étudiants des bourses, des logements étudiants, la restauration dans les universités et écoles ainsi que plein d"activités sociales, culturelles et sportives');

INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '1');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '2');
--INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '3');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '4');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '5');

INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B2', '4');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B2', '5');

INSERT INTO Question (idQ, idMessage, dateMess, heureMess, admAjout, titreQ, contenuQ, id_borne, idDem) VALUES ('AAA','Q1', '2020-12-01', '12:34', 'A1', 'Test question', 'long description', 'B1', 'D2211');

INSERT INTO Reponse (idR, idMessage, dateMess, heureMess, admAjout, contenuRep, idAst, idQ) VALUES ('BBB', 'R2', '2020-12-02', '14:18', 'A1', 'This is the way','A6531', 'AAA');


--INSERT INTO Connexion (id_dem, id_borne, date_connexion, heure_connexion) VALUES ('mD2123','B1','2020-12-03','21:23:05');









