DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS subcategories;

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
  password NVARCHAR NOT NULL,                  -- password stored in sha-1
  image_url VARCHAR,                           -- user image
  userRating FLOAT default 0.0 CHECK (userRating >= 0.0 AND userRating <= 5.0), -- stars/rating
  CONSTRAINT PK_User PRIMARY KEY (userId)
);

CREATE TABLE items (
  id INTEGER PRIMARY KEY,                         -- item id
  name VARCHAR,                                   --  name of the item
  price float,                                    -- price of the item
  published INTEGER,                              -- date when the article was published in epoch format
  tags VARCHAR,                                   -- comma separated tags
  seller VARCHAR REFERENCES users,                -- user that possess the item
  buyer VARCHAR REFERENCES users DEFAULT NULL ,    -- user that wants to buy the item
  state VARCHAR,                                  -- state of the item
  description VARCHAR,                            -- report /  aditional description of the state of the item
  image_url VARCHAR,                              -- user image 
  subcategory_id INTEGER REFERENCES subcategories -- subcategorie wich will display the item                          --
);

CREATE TABLE categories (
  id INTEGER PRIMARY KEY,            -- category id
  name VARCHAR,                      --  name of the category 
  image_url VAR CHAR                -- user image
);

CREATE TABLE subcategories (
  id INTEGER PRIMARY KEY,            -- subcategory id
  name VARCHAR,                      -- name of the subcategory 
  image_url VARCHAR,                -- user image
  category_id INTEGER,               -- foreign key referencing the parent category
  FOREIGN KEY (category_id) REFERENCES categories(id)
);


INSERT INTO User(userId, firstName, lastName, username, address, city, country, postalCode, phone, email, password, image_url, userRating) VALUES
(0, 'João', 'Mendes', 'joaovicente', 'Avenida das Rochas 21', 'Porto', 'Portugal', '4400-123', '+351 931 234 568', 'vicente@gmail.com', 'vicente123', '/images/users/vicente.jpeg', 4.5),
(1, 'Rodrigo', 'Sousa', 'rodrigodesousa', 'Rua das Avenidas 23', 'Porto', 'Portugal', '4430-123', '+351 931 254 598', 'rodrigo@gmail.com', 'rodrigo123', '/images/users/rodrigo.jpeg', 4.2),
(2, 'Miguel', 'Moita', 'miguelmoita', 'Tv. dos Lírios 20', 'Póvoa de Varzim', 'Portugal', '4200-123', '+351 911 234 558', 'miguel@gmail.com', 'miguel123', '/images/users/Miguel.jpg', 3.5),
(3, 'Clara', 'Sousa', 'clarasousa', 'Av. Estados Unidos 120', 'Esposende', 'Portugal', '3400-123', '+351 921 234 568', 'clara@gmail.com', 'clara123', '/images/users/clara_sousa.jpeg', 4.8),
(4, 'Pedro', 'Santos', 'pedrosantos', 'Avenida de Ramalde 398', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'pedro@gmail.com', 'pedro123', '/images/users/pedro.jpeg', 4.5);




-- Inserções adicionais para a tabela de itens (items)
INSERT INTO items (name, price, published, tags, seller, state, description,image_url) VALUES
('Gaming Keyboard', 39.99, 12042024, 'gaming,keyboard,peripherals', 'joao.vicente.36', 'Very Good', 'Mechanical gaming keyboard with RGB lighting','/images/products/tecladogamer.jpg'),
('ZXSpectrum', 19.99, 12042024, 'gaming,console,retro', 'rodrigodesousa.pt', 'Decent', 'Old Console a bit dusty but functional to fun nights','/images/products/ZXSpectrum48k.jpg'),
('Macintos Plus', 79.99, 14042024, 'desktop,retro', 'miguelmoita_', 'Decent', 'The white components are a little yellowed due to the passing of the years','/images/products/macintoshplus.jpg'),
('Record Desck', 279.99, 14042024, 'sound,retro,music', 'miguelmoita_', 'Very Good', 'a milestone in music, nothing better to listen to music than a record player','/images/products/GiraDiscosThorensTD125MKII.jpg'),
('Commodore 64', 399.99, 15042024, 'gaming,retro,console', '_clarasousa', 'Very Good', 'Classic console to play with a bit of nostalgia, very clean', '/images/products/commodore64.jpg'),
('Motorline MC1', 119.99, 18042024, 'processor,desktop,pc,retro', 'pukaruca', 'Good', 'Functional processor that belonged to a MC1','/images/products/motorlineMC1.jpg'),
('Canon Camera', 139.99, 18042024, 'audio,camera,canon,photo,video', 'pukaruca', 'Good', 'A canon camera that takes beautiful photos','/images/products/Maquinacanoneos.jpg');

-- Inserções adicionais para a tabela de categorias (categories)
INSERT INTO categories (id,name) VALUES
(0,'Gaming'),
(1,'Pcs'),
(2,'Mobiles'),
(3,'TVs'),
(4,'Music'),
(5,'Photo&Video');

-- Inserções adicionais para a tabela de subcategorias (subcategories)
INSERT INTO subcategories (name, category_id) VALUES
('Keyboards', 2),
('Mice', 2),
('Headsets', 5),
('Graphics Cards', 2),
('Solid State Drives', 2),
('Retro Consoles',1),
('Desktops', 2),
('Laptops',2),
('Gaming Desktops', 1),
('Gaming Laptops', 1),
('Games',1),
('Cameras',6),
('Processor',2),
('Record Deck',5),
('Retro Desktop',2);
