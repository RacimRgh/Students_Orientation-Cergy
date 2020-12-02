--SELECT * FROM Borne;
--SELECT * FROM Administrateur;
--SELECT * FROM Message;
--SELECT DISTINCT typeFAQ FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');
--SELECT * FROM Connexion;
--SELECT * FROM FAQ WHERE typeFAQ='Astuces' AND idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');


SELECT * FROM Etudiant;
--SELECT * FROM Assistant;
--SELECT * FROM Demandeur;

SELECT * from Message;
--SELECT * from Question;
--SELECT * from Reponse;
