--SELECT * FROM Borne;
--SELECT * FROM Administrateur;
--SELECT * FROM Message;
--SELECT * FROM Etudiant;
--SELECT * FROM Assistant;
--SELECT * FROM Demandeur;
--SELECT DISTINCT typeFAQ FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');
--SELECT * FROM Connexion;
--SELECT * FROM FAQ WHERE typeFAQ='Astuces' AND idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');
--UPDATE Demandeur SET type_dem='Personnalisée', etat_dem='En cours' WHERE matricule_etu='2211';

SELECT * from Message;
SELECT * from Question;
