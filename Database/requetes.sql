--SELECT * FROM Borne;
--SELECT * FROM Administrateur;
--SELECT * FROM Message;
--SELECT * FROM Etudiant;
--SELECT * FROM Assistant;
--SELECT * FROM Demandeur;
SELECT * FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');
--SELECT * FROM Connexion;
