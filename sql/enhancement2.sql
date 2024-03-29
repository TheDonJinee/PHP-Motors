INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 'I am the real Ironman');

UPDATE clients
SET clientLevel = 3
WHERE
clientFirstName = 'Tony' and clientLastName = 'Stark';

UPDATE inventory
SET invDescription = replace(invDescription, 'small interior', 'spacious interior')
WHERE invMake = 'GM' and invModel = 'Hummer';

SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification
ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationName = 'SUV';

DELETE FROM inventory WHERE invId = 1;

UPDATE inventory 
SET invImage = concat('/phpmotors', invImage), invThumbnail = concat('/phpmotors', invThumbnail);
