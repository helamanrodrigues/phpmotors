insert into clients(clientFirstName,clientLastName, clientEmail,clientPassword,comment)
values ("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman");

update clients 
set clientLevel = 3 
where clientEmail = 'tony@starkent.com';

update inventory 
set invDescription = replace(invDescription, "small interior","spacious interior")
where invMake = "GM" and invModel="Hummer";

select invModel, classificationName
from    inventory i inner join  carclassification c
on i.classificationId = c.classificationId
where c.classificationName = 'SUV';

delete from inventory 
WHERE invMake = 'Jeep'
and invModel = 'Wrangler';

update inventory 
set invImage = concat('/phpmotors',invImage), 
invThumbnail = concat('/phpmotors',invThumbnail);


