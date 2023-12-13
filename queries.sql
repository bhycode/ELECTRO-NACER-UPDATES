drop database electro_nacer_updates;
create database electro_nacer_updates;
use electro_nacer_updates;


create table User(
    userID varchar(50) PRIMARY KEY,
    email varchar(200) not null,
    userPassword varchar(28) not null,
    isAdmin boolean not null,
    isActiveAccount boolean not null
);
describe User;

insert into User(userID, email, userPassword, isAdmin, isActiveAccount) values('#1', 'master@gmail.com', '123456789', true, true);
select * from User;





create table ProductCategory(
    categoryID varchar(50) PRIMARY KEY,
    categoryName varchar(100) not null,
    categoryImage varchar(100),
    isActive boolean
);
describe ProductCategory;

insert into ProductCategory(categoryID, categoryImage, categoryName, isActive) values('id1', "", 'Ungrouped', true);
insert into ProductCategory(categoryID, categoryImage, categoryName, isActive) values('id2', "", 'Motor', true);
insert into ProductCategory(categoryID, categoryImage, categoryName, isActive) values('id3', "", 'Cable', true);
insert into ProductCategory(categoryID, categoryImage, categoryName, isActive) values('id4', "", 'Sensor', true);
insert into ProductCategory(categoryID, categoryImage, categoryName, isActive) values('id5', "", 'Arduino', true);
select * from ProductCategory;



create table Product (
    productID varchar(50) PRIMARY KEY,
    imagePath varchar(100),
    barcode varchar(100),
    label varchar(100),
    full_description varchar(100),
    minQuantity float,
    stockQuantity int,
    buyingPrice float,
    finalPrice float,
    offerPrice float,
    categoryID_fk varchar(50),
    foreign key (categoryID_fk) references ProductCategory(categoryID),
    isActive boolean
);

describe Product;

select ProductCategory.categoryName, Product.label from Product inner join ProductCategory on ProductCategory.categoryID = Product.categoryID_fk;
INSERT INTO Product (productID, imagePath, barcode, label, full_description, minQuantity, stockQuantity, buyingPrice, finalPrice, offerPrice, categoryID_fk, isActive)
VALUES
('id1', 'assets/images/arduino-cable.jpg', '4587864481', 'Arduino Cable', 'Cable for Arduino boards of 5V.', 100, 215, 150.66, 215, 199.99, 'id3', true),
('id2', 'assets/images/arduino-mega.jpg', '9876543210', 'Arduino Mega', 'Powerful Arduino Mega board.', 200, 145, 50.45, 250.78, 199.99, 'id5', true),
('id3', 'assets/images/arduino-uno.jpg', '1234567890', 'Arduino Uno', 'Basic Arduino Uno board for beginners.', 300.99, 100, 50, 50, 49.99, 'id5', true),
('id4', 'assets/images/arduino-shield.jpg', '1357924680', 'Arduino Shield', 'Shield for expanding Arduino capabilities.', 40.99, 100, 47, 47, 35.99, 'id5', true),
('id5', 'assets/images/distance-sensor.png', '2468013579', 'Distance Sensor', 'Sensor for measuring distances.', 65.99, 50, 45, 45, 55.99, 'id4', true),
('id6', 'assets/images/gas-sensor.jpg', '9876543219', 'Gas Sensor', 'Sensor for detecting gas levels.', 45.99, 95, 175, 175, 39.99, 'id4', true),
('id7', 'assets/images/jumpers.jpg', '6543210987', 'Jumpers', 'Set of jumper wires for connections.', 1.99, 10, 100, 100, 0.99, 'id3', true),
('id8', 'assets/images/lcd-screen.jpg', '4567890123', 'LCD Screen', 'Display screen for Arduino projects.', 55.99, 15, 165, 165, 49.99, 'id1', true),
('id9', 'assets/images/leds.jpg', '7890123456', 'LEDs', 'Pack of LEDs for lighting projects.', 1.99, 10, 100, 100, 1.49, 'id1', true),
('id10', 'assets/images/light-sensor.jpg', '0123456789', 'Light Sensor', 'Sensor for detecting light levels.', 25.99, 200, 254, 254, 20.99, 'id4', true),
('id11', 'assets/images/motor-drive-controller.jpg', '3456789012', 'Motor Drive Controller', 'Controller for driving motors.', 40.99, 100, 145, 145, 35.99, 'id2', true),
('id12', 'assets/images/movement-sensor.jpg', '5678901234', 'Movement Sensor', 'Sensor for detecting movement.', 55.99, 10, 98, 98, 49.99, 'id4', true),
('id13', 'assets/images/servo-motor.jpg', '6789012345', 'Servo Motor', 'Motor for precise control in projects.', 45.99, 10, 100, 100, 39.99, 'id2', true),
('id14', 'assets/images/smart-car-motor.jpg', '7890123456', 'Smart Car Motor', 'Motor for smart car projects.', 20.99, 50, 45, 45, 18.99, 'id2', true),
('id15', 'assets/images/sound-sensor.jpg', '8901234567', 'Sound Sensor', 'Sensor for detecting sound levels.', 40.99, 70, 15, 15, 35.99, 'id4', true);


select * from Product;



SELECT Product.productID, Product.imagePath, Product.label, Product.unitPrice, Product.minQuantity, Product.stockQuantity, Product.category, ProductCategory.categoryName FROM Product JOIN ProductCategory ON Product.categoryID_fk = ProductCategory.categoryID and ProductCategory.categoryName = 'Arduino';

SELECT * from Product where stockQuantity < minQuantity;