--SELECT * FROM Etudiant;
--SELECT * FROM Assistant;
--SELECT * FROM Demandeur;

--SELECT * from Message;
--SELECT * from Question;
--SELECT * from Reponse;

--SELECT * FROM Borne;
--SELECT * FROM Administrateur;
--SELECT * FROM Connexion;

--SELECT DISTINCT typeFAQ FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');

--SELECT * FROM FAQ WHERE typeFAQ='Astuces' AND idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne='B1');


