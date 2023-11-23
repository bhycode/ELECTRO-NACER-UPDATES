drop database electro_nacer;
create database electro_nacer;
use electro_nacer;


create table User(
    userID varchar(50) PRIMARY KEY,
    userPassword varchar(28) not null
);
describe User;

insert into User(userID, userPassword) values('master', '123456789');
select * from User;





create table ProductCategory(
    categoryID varchar(50) PRIMARY KEY,
    categoryName varchar(100) not null
);
describe ProductCategory;

insert into ProductCategory(categoryID, categoryName) values('#1', 'Ungrouped');
insert into ProductCategory(categoryID, categoryName) values('#2', 'Motor');
insert into ProductCategory(categoryID, categoryName) values('#3', 'Cable');
insert into ProductCategory(categoryID, categoryName) values('#4', 'Sensor');
insert into ProductCategory(categoryID, categoryName) values('#5', 'Arduino');
select * from ProductCategory;



create table Product (
    productID varchar(50) PRIMARY KEY,
    imagePath varchar(100),
    label varchar(100),
    unitPrice float,
    minQuantity float,
    stockQuantity int,
    category varchar(50),
    categoryID_fk varchar(50),
    foreign key (categoryID_fk) references ProductCategory(categoryID)
);

describe Product;


insert into Product (productID, imagePath, label, unitPrice, minQuantity, stockQuantity, categoryID_fk)
values ('#1', 'arduino-cable.jpg', 'Arduino Cable', 15.99, 100, 215, '#3'),
       ('#2', 'arduino-mega.jpg', 'Arduino Mega', 450.99, 200, 145, '#5'),
       ('#3', 'arduino-uno.jpg', 'Arduino Uno', 300.99, 100, 50, '#5'),
       ('#4', 'arduino-shield.jpg', 'Arduino Shield', 40.99, 100, 47, '#5'),
       ('#5', 'distance-sensor.png', 'Distance Sensor', 65.99, 50, 45, '#4'),
       ('#6', 'gas-sensor.jpg', 'Gas Sensor', 45.99, 95, 175, '#4'),
       ('#7', 'jumpers.jpg', 'Jumpers', 1.99, 10, 100, '#3'),
       ('#8', 'lcd-screen.jpg', 'LCD Screen', 55.99, 15, 165, '#1'),
       ('#9', 'leds.jpg', 'LEDs', 1.99, 10, 100, '#1'),
       ('#10', 'light-sensor.jpg', 'Light Sensor', 25.99, 200, 254, '#4'),
       ('#11', 'motor-drive-controller.jpg', 'Motor Drive Controller', 40.99, 100, 145, '#2'),
       ('#12', 'movement-sensor.jpg', 'Movement Sensor', 55.99, 10, 98, '#4'),
       ('#13', 'servo-motor.jpg', 'Servo Motor', 45.99, 10, 100, '#2'),
       ('#14', 'smart-car-motor.jpg', 'Smart Car Motor', 20.99, 50, 45, '#2'),
       ('#15', 'sound-sensor.jpg', 'Sound Sensor', 40.99, 70, 15, '#4');


select * from Product;



SELECT Product.productID, Product.imagePath, Product.label, Product.unitPrice, Product.minQuantity, Product.stockQuantity, Product.category, ProductCategory.categoryName FROM Product JOIN ProductCategory ON Product.categoryID_fk = ProductCategory.categoryID and ProductCategory.categoryName = 'Arduino';

SELECT * from Product where stockQuantity < minQuantity;