-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Users-taulun testidataa
INSERT INTO Users (username, password) VALUES ('kymco', 'hunter2');
INSERT INTO Users (username, password) VALUES ('toka', 'pwd');
-- Note-taulun testidataa
INSERT INTO Note (user_id, header, text) VALUES (1, 'muistutus', 'muista ostaa maitoo');
INSERT INTO Note (user_id, header, text) VALUES (2, 'tärkee', 'fi785544074148980');
-- List-taulun testidataa
INSERT INTO List (user_id, header) VALUES (1, 'ostoslista');
--Listitem-taulun testidataa
INSERT INTO Listitem (list_id, text) VALUES (1, 'maito');
INSERT INTO Listitem (list_id, text) VALUES (1, 'makkara');
INSERT INTO Listitem (list_id, text) VALUES (1, 'leipä');