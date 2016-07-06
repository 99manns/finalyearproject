insert into location(AddressLine,TownCity,Country)values ('UOR','Reading','UK');
insert into location(AddressLine,TownCity,Country)values ('The Place','Reading','UK');

insert into permission(Name,`admin`)values ('Employee',1);
insert into permission(Name,`admin`)values ('Customer',0);
insert into permission(Name,`admin`)values ('Admin',1);

insert into company(apikey,locationid,Name,telephone) 
 select 'dd6852db-3697-4b74-95f2-7e49f40018bf', locationid,'Uni Vending co','01234' from location where AddressLine ='UOR';
insert into company(apikey,locationid,Name,telephone) 
 select '59f3b9ec-f0bf-4763-a6f9-9ee00791d690', locationid,'Palace Vending co','012345' from location where AddressLine ='The Place';

insert into `user` (firstName,lastName,email,permissionid) 
 select 'king','bob','king.bob@hrh.un', permissionid from permission where Name = 'Customer';
insert into `user` (firstName,lastName,email,permissionid) 
 select 'hand','bob','hand@uor.un', permissionid from permission where Name = 'Employee';
insert into `user` (firstName,lastName,email,permissionid) 
 select 'admin','admin','admin@api.co.uk', permissionid from permission where Name = 'ADMIN';
 