DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Subcategory;

CREATE TABLE User (
  userId INTEGER NOT NULL,
  firstName NVARCHAR NOT NULL,
  lastName NVARCHAR NOT NULL,
  username VARCHAR NOT NULL,
  address NVARCHAR,
  city NVARCHAR,
  country NVARCHAR,
  postalCode NVARCHAR,
  phone NVARCHAR,
  email NVARCHAR NOT NULL,
  password NVARCHAR NOT NULL,                               -- password stored in sha-1
  image_url VARCHAR,                                        -- user image
  userRating FLOAT default 0.0 CHECK (userRating >= 0.0 AND userRating <= 5.0), -- stars/rating
  salesNumber INTEGER NOT NULL,
  isAdmin BOOLEAN NOT NULL,
  CONSTRAINT PK_User PRIMARY KEY (userId)
);

CREATE TABLE Category (
  categoryId INTEGER NOT NULL,            -- category id
  name VARCHAR NOT NULL,                      --  name of the category 
  CONSTRAINT PK_Category PRIMARY KEY (categoryId)
);

CREATE TABLE Item (
  itemId INTEGER NOT NULL,                                 -- item id
  seller INTEGER NOT NULL,                                 -- user that possess the item
  category INTEGER NOT NULL,
  subcategory INTEGER NOT NULL,
  title VARCHAR NOT NULL,                                  --  name of the item
  price float NOT NULL,                                    -- price of the item
  negotiable BOOLEAN NOT NULL,
  published INTEGER NOT NULL,                              -- date when the article was published in epoch format
  tags VARCHAR,                                            -- comma separated tags                
  state VARCHAR NOT NULL,                                  -- state of the item
  description VARCHAR NOT NULL,                            -- report /  aditional description of the state of the item
  shippingSize VARCHAR NOT NULL,
  shippingCost INTEGER NOT NULL,
  image_url VARCHAR NOT NULL,                              -- user image 
  CONSTRAINT PK_Item PRIMARY KEY (itemId),
  FOREIGN KEY (category) REFERENCES Category (categoryId)
  ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY (seller) REFERENCES User (userId)
  ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE Subcategory (
  subcategoryId INTEGER NOT NULL,                         -- subcategory id
  name VARCHAR NOT NULL,                                  -- name of the subcategory
  category INTEGER NOT NULL,                              -- foreign key referencing the parent category
  CONSTRAINT PK_Subcategory PRIMARY KEY (subcategoryId),
  FOREIGN KEY (category) REFERENCES Category(categoryid)
  ON DELETE NO ACTION ON UPDATE NO ACTION
);


INSERT INTO User(userId, firstName, lastName, username, address, city, country, postalCode, phone, email, password, image_url, userRating,salesNumber, isAdmin) VALUES
(0, 'João', 'Mendes', 'joaovicente', 'Avenida das Rochas 21', 'Porto', 'Portugal', '4400-123', '+351 931 234 568', 'vicente@gmail.com', 'vicente123', '/../images/users/vicente.jpeg', 4.5, 14, true),
(1, 'Rodrigo', 'Sousa', 'rodrigodesousa', 'Rua das Avenidas 23', 'Porto', 'Portugal', '4430-123', '+351 931 254 598', 'rodrigo@gmail.com', 'rodrigo123', '/../images/users/rodrigo.jpeg', 4.2, 39, false),
(2, 'Miguel', 'Moita', 'miguelmoita', 'Tv. dos Lírios 20', 'Póvoa de Varzim', 'Portugal', '4200-123', '+351 911 234 558', 'miguel@gmail.com', 'miguel123', '/../images/users/Miguel.jpg', 3.5, 61, true),
(3, 'Clara', 'Sousa', 'clarasousa', 'Av. Estados Unidos 120', 'Esposende', 'Portugal', '3400-123', '+351 921 234 568', 'clara@gmail.com', 'clara123', '/../images/users/clara_sousa.jpeg', 4.8, 28, true),
(4, 'Pedro', 'Santos', 'pedrosantos', 'Avenida de Ramalde 398', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'pedro@gmail.com', 'pedro123', '/../images/users/pedro.jpeg', 4.5, 46, false);




-- Inserções adicionais para a tabela de itens (items)
INSERT INTO Item (itemId, seller, category, subcategory, title, price, negotiable, published, tags, state, description, shippingSize, shippingCost, image_url) VALUES
(0, 1, 0, 0, 'Gaming Keyboard', 39.99, true, 12042024, 'gaming,keyboard,peripherals', 'Very Good', 'Mechanical gaming keyboard with RGB lighting', 'Small', 19.99,'/images/products/tecladogamer.jpg'),
(1, 4, 0, 5, 'ZX Spectrum', 19.99, true, 12042024, 'gaming,console,retro', 'Decent', 'Old Console a bit dusty but functional to fun nights','Medium',29.99, '/images/products/ZXSpectrum48k.jpg'),
(2, 3, 1, 6, 'Macintosh Plus', 79.99, true, 14042024, 'desktop,retro', 'Decent', 'The white components are a little yellowed due to the passing of the years', 'Large',49.99, '/images/products/macintoshplus.jpg'),
(3, 2, 4, 13, 'Record Deck', 279.99, true, 14042024, 'sound,retro,music', 'Very Good', 'a milestone in music, nothing better to listen to music than a record player', 'Large',49.99,'/images/products/GiraDiscosThorensTD125MKII.jpg'),
(4, 0, 0, 5, 'Commodore 64', 399.99, true, 15042024, 'gaming,retro,console', 'Very Good', 'Classic console to play with a bit of nostalgia, very clean', 'Medium',29.99, '/images/products/commodore64.jpg'),
(5, 2, 1, 12, 'Motorline MC1', 119.99, true, 18042024, 'processor,desktop,pc,retro', 'Good', 'Functional processor that belonged to a MC1','Small', 19.99,'/images/products/motorlineMC1.jpg'),
(6, 3, 5, 11, 'Canon Camera', 139.99, true, 18042024, 'audio,camera,canon,photo,video', 'Good', 'A canon camera that takes beautiful photos','Medium',29.99, '/images/products/Maquinacanoneos.jpg');

-- Inserções adicionais para a tabela de categorias (categories)
INSERT INTO Category (categoryId, name) VALUES
(0,'Gaming'),
(1,'PCs'),
(2,'Mobiles'),
(3,'TVs'),
(4,'Music'),
(5,'Photo&Video');

-- Inserções adicionais para a tabela de subcategorias (subcategories)
INSERT INTO Subcategory (subcategoryId, name, category) VALUES
(0,'Keyboards', 1),
(1,'Mice', 1),
(2,'Headsets', 0),
(3,'Graphics Cards', 1),
(4,'Solid State Drives', 1),
(5,'Retro Consoles', 0),
(6,'Desktops', 1),
(7,'Laptops',1),
(8,'Gaming Desktops', 1),
(9,'Gaming Laptops', 1),
(10,'Games',0),
(11,'Cameras',5),
(12,'Processor',1),
(13,'Record Deck',4),
(14,'Retro Desktop',1);
