DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Subcategory;
DROP TABLE IF EXISTS Wishlist;
DROP TABLE IF EXISTS Message;

CREATE TABLE User (
  userId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  firstName NVARCHAR NOT NULL,
  lastName NVARCHAR NOT NULL,
  username VARCHAR NOT NULL,
  address NVARCHAR,
  city NVARCHAR,
  country NVARCHAR,
  postalCode NVARCHAR,
  phone NVARCHAR,
  email NVARCHAR NOT NULL,
  password NVARCHAR NOT NULL,                               -- password stored in bcrypt
  image_url VARCHAR,                                        -- user image
  userRating FLOAT default 0.0 CHECK (userRating >= 0.0 AND userRating <= 5.0), -- stars/rating
  salesNumber INTEGER NOT NULL,
  isAdmin BOOLEAN NOT NULL
);

CREATE TABLE Category (
  categoryId INTEGER NOT NULL,                             -- category id
  name VARCHAR NOT NULL,                                   --  name of the category 
  CONSTRAINT PK_Category PRIMARY KEY (categoryId)
);

CREATE TABLE Item (
  itemId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,       -- item id
  seller INTEGER NOT NULL,                                 -- user that possess the item
  category INTEGER NOT NULL,
  subcategory INTEGER NOT NULL,
  title VARCHAR NOT NULL,                                  --  name of the item
  price FLOAT NOT NULL,                                    -- price of the item
  negotiable BOOLEAN NOT NULL,
  published INTEGER NOT NULL,                              -- date when the article was published in epoch format
  tags VARCHAR,                                            -- comma separated tags                
  state VARCHAR NOT NULL,                                  -- state of the item
  description VARCHAR NOT NULL,                            -- report / additional description of the state of the item
  shippingSize VARCHAR NOT NULL,
  likes INTEGER,
  shippingCost INTEGER NOT NULL,
  sold BOOLEAN DEFAULT FALSE,
  image_url VARCHAR NOT NULL,                              -- user image 
  FOREIGN KEY (category) REFERENCES Category (categoryId)
  ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY (seller) REFERENCES User (userId)
  ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE Subcategory (
  subcategoryId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,                         -- subcategory id
  name VARCHAR NOT NULL,                                  -- name of the subcategory
  category INTEGER NOT NULL,                              -- foreign key referencing the parent category
  FOREIGN KEY (category) REFERENCES Category(categoryId)
  ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE Wishlist (
  wishlistId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  user INTEGER NOT NULL,
  item INTEGER NOT NULL,
  FOREIGN KEY (user) REFERENCES User(userId)
  ON DELETE CASCADE ON UPDATE NO ACTION,
  FOREIGN KEY (item) REFERENCES Item(itemId)
  ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE Message (
  messageId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  senderId INTEGER NOT NULL,
  receiverId INTEGER NOT NULL,
  itemId INTEGER NOT NULL,
  message TEXT NOT NULL,
  sentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (senderId) REFERENCES User(userId)
  ON DELETE CASCADE ON UPDATE NO ACTION,
  FOREIGN KEY (receiverId) REFERENCES User(userId)
  ON DELETE CASCADE ON UPDATE NO ACTION,
  FOREIGN KEY (itemId) REFERENCES Item(itemId)
  ON DELETE CASCADE ON UPDATE NO ACTION
);
INSERT INTO User(userId, firstName, lastName, username, address, city, country, postalCode, phone, email, password, image_url, userRating, salesNumber, isAdmin) VALUES
(0, 'João', 'Mendes', 'joaovicente', 'Avenida das Rochas 21', 'Porto', 'Portugal', '4400-123', '+351 931 234 568', 'vicente@gmail.com', 'fce95b0e642bdb3aa90e9a80ab0d2c21:9f0abed8140a497a16bb1ae82043c1fcbcecb4f78b262a57f34a4f7a4d258960', '/../images/users/vicente.jpeg', 4.5, 14, true),
(1, 'Rodrigo', 'Sousa', 'rodrigodesousa', 'Rua das Avenidas 23', 'Porto', 'Portugal', '4430-123', '+351 931 254 598', 'rodrigo@gmail.com', '61408077430d0305d443bb829499f4dc:e249da3ad5f4242a9a1620952f5ea0363bc7c09e519e20e8ad82c4dedd10a6f1', '/../images/users/rodrigo.jpeg', 4.2, 39, false),
(2, 'Miguel', 'Moita', 'miguelmoita', 'Tv. dos Lírios 20', 'Póvoa de Varzim', 'Portugal', '4200-123', '+351 911 234 558', 'miguel@gmail.com', 'f19ec2139fdf38b3295ce98060bebcff:487c150f550277fe8e272779324c51b607f296b1fc0215543fa3954f66daa844', '/../images/users/Miguel.jpg', 3.5, 61, true),
(3, 'Clara', 'Sousa', 'clarasousa', 'Av. Estados Unidos 120', 'Esposende', 'Portugal', '3400-123', '+351 921 234 568', 'clara@gmail.com', '58734c246dc16ed0761df8393cda66b3:b317934ffb5c5666751d3afb8a4867438f9ed51b30171059c7100c8f655515e4', '/../images/users/clara_sousa.jpeg', 4.8, 28, true),
(4, 'Pedro', 'Santos', 'pedrosantos', 'Avenida de Ramalde 398', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'pedro@gmail.com', 'bdb4f6b1cd6ed228bc92097e7af21f3d:dcfa3719bbc79c3a2d4930fd9793099cbe25ab7258bf5a9d569a5a8ac586b320', '/../images/users/pedro.jpeg', 4.5, 46, false),
(5, 'Afonso', 'Castro', 'afonsocastro', 'Senhora da Hora 28', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'afonso@gmail.com', 'a54a3dbbf24dcce54bf632c1a31b18cb:c28035dd145d2d9cad73e59ced8f444ce50f9de7ccc9793b9d649e2fa801088c','/../images/users/afonso.jpg', 2.5, 102, false);

INSERT INTO Category (categoryId, name) VALUES
(0, 'Gaming'),
(1, 'PCs'),
(2, 'Mobiles'),
(3, 'TVs'),
(4, 'Music'),
(5, 'Photo&Video');

INSERT INTO Subcategory (subcategoryId, name, category) VALUES
(0, 'Peripherals', 0),
(1, 'PC components', 1),
(3, 'Retro Consoles', 0),
(4, 'Desktops', 1),
(5, 'Laptops', 1),
(6, 'Gaming Desktops', 1),
(7, 'Gaming Laptops', 1),
(8, 'Games', 0),
(9, 'Cameras', 5),
(10, 'Record Deck', 4),
(11, 'Retro Desktop', 1),
(12, 'Albums & singles', 4),
(13, 'Consoles', 0),
(14, 'Films', 3);

INSERT INTO Item (itemId, seller, category, subcategory, title, price, negotiable, published, tags, state, description, shippingSize, shippingCost, likes, sold, image_url) VALUES
(0, 1, 0, 0, 'Gaming Keyboard', 39.99, true, 12042024, 'gaming,keyboard,peripherals', 'Very Good', 'Mechanical gaming keyboard with RGB lighting', 'Small', 19.99, 10, false, '/../images/products/tecladogamer.jpg'),
(1, 4, 0, 11, 'ZX Spectrum', 19.99, true, 12042024, 'gaming,console,retro', 'Decent', 'Old Console a bit dusty but functional to fun nights', 'Medium', 29.99, 2, false, '/../images/products/ZXSpectrum48k.jpg'),
(2, 1, 1, 11, 'Macintosh Plus', 79.99, true, 14042024, 'desktop,retro', 'Decent', 'The white components are a little yellowed due to the passing of the years', 'Large', 49.99, 3, false, '/../images/products/macintoshplus.jpg'),
(3, 3, 4, 10, 'Record Deck', 279.99, true, 14042024, 'sound,retro,music', 'Very Good', 'A milestone in music, nothing better to listen to music than a record player', 'Large', 49.99, 27, false, '/../images/products/GiraDiscosThorensTD125MKII.jpg'),
(4, 0, 0, 3, 'Commodore 64', 99.99, true, 15042024, 'gaming,retro,console', 'Very Good', 'Classic console to play with a bit of nostalgia, very clean', 'Medium', 29.99, 31, false, '/../images/products/commodore64.jpg'),
(5, 0, 1, 1, 'Motorline MC1', 119.99, true, 18042024, 'processor,desktop,pc,retro', 'Good', 'Functional processor that belonged to a MC1', 'Small', 19.99, 1, true, '/../images/products/motorlineMC1.jpg'),
(6, 3, 5, 9, 'Canon Camera', 139.99, true, 18042024, 'audio,camera,photo,video', 'Good', 'A canon camera that takes beautiful photos', 'Medium', 29.99, 0, false, '/../images/products/Maquinacanoneos.jpg'),
(7, 1, 0, 8, 'The Legend of Zelda: Ocarina of Time', 39.99, true, 18042024, 'gaming,retro,console', 'Very Good', 'Game released for Nintendo 64', 'Small', 9.99, 4, false, '/../images/products/thelegendofzeldaocarinaoftime.jpg');

INSERT INTO Wishlist (wishlistId, user, item) VALUES
(0, 1, 1),
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 2, 1),
(5, 3, 2),
(6, 3, 3),
(7, 3, 4),
(8, 3, 5),
(9, 3, 6);

INSERT INTO Message (messageId, senderId, receiverId, itemId, message, sentAt) VALUES
(0, 1, 2, 0, 'Olá, estou interessado em comprar este teclado.', '2023-05-12 08:00:00'),
(1, 2, 1, 0, 'Ótimo! O teclado ainda está disponível.', '2023-05-12 08:05:00'),
(2, 3, 1, 1, 'O ZX Spectrum ainda está à venda?', '2023-05-12 08:10:00');

