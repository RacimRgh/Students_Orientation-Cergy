INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B1', 49.04288, 2.08431, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B2', 48.93906, 2.3546, 'Fonctionnelle');
INSERT INTO Borne (id_borne, longitude, latitude, etatB) VALUES ('B3', 48.84703, 2.34388, 'Fonctionnelle');

INSERT INTO Etudiant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu) VALUES ('E1', 'Mamfoumbi', 'ben', 'ben@gmail.com', '+3365123647', 'CY Cergy Paris', 'Informatique');

INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A1', 'Moderateur', 'Richard', 'STALLMAN', '+3368453687');
INSERT INTO Administrateur (idAdm, roleAdm, nomAdm, prenomAdm, telAdm) VALUES ('A2', 'Moderateur', 'John', 'DOE', '+337036984532');

INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('A2843', 'Mapaga', 'Marlyse', 'marlyse@gmail.com', '+3365123647', 'CY Cergy Paris', 'Informatique', 'A2843', 'Hors ligne', '2020-10-30');

INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('A6531', 'Trabelsi','Lydia', 'lydia@gmail.com', '+336465132', 'CY Cergy Paris', 'Informatique', 'A6531', 'Hors ligne', '2020-10-30');

INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('D2211', 'Righi', 'Racim', 'racim@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique', 'D2211');

INSERT INTO Connexion (id_borne, id_dem, date_connexion, heure_connexion) VALUES ('B1', 'D2211', '2020-11-29', '11:26');

INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('1', 'Astuces', 'Comment trouver le chemin le plus vers la fac?', 'Vous êtes nouveaux et vous cherchez un moyen de trouver les trajets les plus rapides et éviter les turbulences pour ne pas rater vos cours et examens?', 'Il existe plusieurs applications pour celà, par exemple CityMapper');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('2', 'Astuces', 'Où trouver les meilleures promotions pour les étudiants?', 'Etre étudiant en France ou en Europe vous donne plein d"avatages dont il faut absolumer profiter ! mais où les trouver?', 'Plusieurs sites offrents des rabais pour les étudiants en donnant un ID valable, vous pouvez en trouver certains à Unidays et StudentBeans');
--INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('3', 'Astuces', '', '', '');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('4', 'Spécialité', 'Comment choisir sa spécialité?', 'Dans toutes les filiaires, à un moment donnée il faut choisir une spécialité, comment faire le bon choix?', 'Avant tout, il faut toujours regarder les sites officiels des universités, vous pouvez aussi voir www.meilleurs-masters.com pour voir le classement officiel, si celà n"est pas suffisant, vous pouvez faire une demande personnalisée qui sera traité par un de nos membres ;)');
INSERT INTO FAQ (idFAQ, typeFAQ, titreFAQ, contenuFAQ, reponseFAQ) VALUES ('5', 'Crous', 'C"est quoi le CROUS?', 'Le Centre régional des œuvres universitaires et scolaires de Paris (Crous) est le service public de la vie étudiante, qu"offre t"til?', 'Le CROUS offre aux étudiants des bourses, des logements étudiants, la restauration dans les universités et écoles ainsi que plein d"activités sociales, culturelles et sportives');

INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '1');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '2');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '3');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '4');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B1', '5');

INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B2', '4');
INSERT INTO faq_borne (id_borne, idFAQ) VALUES ('B2', '5');


INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M10', '2020-12-01', '12:48', 'A1','Q10','Enseignement', 'Test question', 'long description', 'B1', 'D2211');

INSERT INTO Reponse (idMessage, dateMess, heureMess, admAjout,idR, contenuRep, idq, idAst) VALUES ('M11', '2020-12-02', '14:18', 'A1','R1' ,'This is the way','Q10','A6531');



INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2212', 'Bahar', 'Samir', 'bahar@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique', 'D2212');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2213', 'Namir', 'Yasmine', 'namir@gmail.com', '+3368931247', 'CY Cergy Paris', 'Mathematiques', 'D2213');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2214', 'Sarraf', 'Lina', 'sarraf@gmail.com', '+3368931247', 'CY Cergy Paris', 'Informatique', 'D2214');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2215', 'onio', 'Maria', 'onio@gmail.com', '+3368931247', 'CY Cergy Paris', 'Droit', 'D2215');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('D2216', 'Lucchesi', 'Rosa', 'lucchesi@gmail.com', '+3368931247', 'CY Cergy Paris', 'Economie', 'D2216');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2217', 'Aliyeva', 'Anouchka', 'aliyeva@gmail.com', '+3368931247', 'CY Cergy Paris', 'Economie', 'D2217');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2218', 'Yin', 'Li Hua', 'yin@gmail.com', '+3368931247', 'CY Cergy Paris', 'Mathematiques', 'D2218');
INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ('E2219', 'Boston', 'Barbara', 'boston@gmail.com', '+3368931247', 'CY Cergy Paris', 'Droit', 'D2219');

INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M7', '2020-10-02', '12:48', 'A1','Q6','Visite de l"ecole', 'Visite des salles de cours', 'Bonjour, je viens d"arriver et je n"arrive pas à trouver mes salles de cours, j"aurai besoin d"une personne pour me faire visiter le campus ', 'B1', 'D2212');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M8', '2020-12-01', '12:48', 'A1','Q7','Enseignement', 'Test question', 'Bonjour, il y aurait une personne en L2 Mathematique qui pourrait me passer les cours que j"ai raté depuis la rentrée à maintenant svp ? Je viens d"arriver et je suis très en retard. Merci !', 'B3', 'D2213');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M9', '2020-12-01', '12:48', 'A1','Q8','Projet', 'Comment inserer un groupe de projet', 'Bonjour, je ne sais pas comment se passent les projets de ce semestre je viens d"arriver et je ne sais pas comment faire, j"aimerai aussi trouver un groupe pour le projet de developpement web. Bonne journée ! ', 'B2', 'D2214');

INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M1', '2020-12-01', '12:48', 'A1','Q1','Enseignement', 'Test question', 'long description', 'B1', 'D2215');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M2', '2020-12-01', '12:48', 'A1','Q2','Enseignement', 'Test question', 'long description', 'B1', 'D2216');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M3', '2020-12-01', '12:48', 'A1','Q3','Enseignement', 'Test question', 'long description', 'B1', 'D2217');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M4', '2020-12-01', '12:48', 'A1','Q4','Enseignement', 'Test question', 'long description', 'B1', 'D2218');
INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('M5', '2020-12-01', '12:48', 'A1','Q5','Enseignement', 'Test question', 'long description', 'B1', 'D2219');









