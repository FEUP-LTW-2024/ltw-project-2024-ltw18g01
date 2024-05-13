DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Subcategory;

CREATE TABLE User (
  userId INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
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
(4, 0, 0, 5, 'Commodore 64', 99.99, true, 15042024, 'gaming,retro,console', 'Very Good', 'Classic console to play with a bit of nostalgia, very clean', 'Medium',29.99, '/images/products/commodore64.jpg'),
(5, 0, 1, 12, 'Motorline MC1', 119.99, true, 18042024, 'processor,desktop,pc,retro', 'Good', 'Functional processor that belonged to a MC1','Small', 19.99,'/images/products/motorlineMC1.jpg'),
(6, 3, 5, 11, 'Canon Camera', 139.99, true, 18042024, 'audio,camera,canon,photo,video', 'Good', 'A canon camera that takes beautiful photos','Medium',29.99, '/images/products/Maquinacanoneos.jpg'),
(7, 1, 0, 10, 'The Legend of Zelda: Ocarina of Time', 14.99, false, 01052024, 'gaming,retro,game', 'Very Good', 'Timeless masterpiece that has captivated gamers for decades. This Nintendo 64 classic is an epic journey that masterfully combines elements of action, adventure, and puzzles. With groundbreaking graphics for its time and a compelling narrative, this game transports players to a vast and magical world filled with memorable characters and thrilling challenges.', Small,19.99,'/images/product/zelda.jpg'),
(8, 2, 0, 10, 'Resident Evil 2', 14.99, false, 01052024,'gaming,retro,game','Decent', 'Whether you re a fan of classic survival horror or a newcomer looking to experience one of the genres defining titles, "Resident Evil 2" offers an unforgettable journey into the heart of darkness. Prepare yourself for a relentless battle for survival against the forces of evil in one of the most iconic games of all time.',Small,19.99,'/images/product/residentevil2ps1.jpg'),
(9, 1, 4, 15, 'Radiohead - OK Computer', 7.99, true, 02052024, 'music,retro,album', 'Decent', 'Seminal album in alternative rock, renowned for its innovative sound and introspective lyrics. With tracks like "Paranoid Android" and "Exit Music (For a Film)," it explores themes of technology and existentialism. Praised for its sonic experimentation, it remains a timeless masterpiece in music history.',Small,19.99,'/images/product/radioheadcd.jpg'),
(10, 3, 4, 15, 'Nirvana . Nevermind', 8.99,true,02052024, 'music,retro,album', 'Decent', 'Landmark album in the grunge movement that shook the music world in the early 1990s. Featuring iconic tracks like "Smells Like Teen Spirit" and "Come as You Are," the album is a raw and powerful expression of angst and disillusionment. Its blend of punk rock energy and catchy melodies propelled Nirvana to superstardom and forever changed the landscape of popular music. "Nevermind" remains a cultural touchstone, beloved by fans and critics alike for its raw emotion and timeless relevance.',Small,19.99,'/images/product/nirvanacd.jpg'),
(11, 4, 0, 5, 'Nintendo 64', 69.99, false, 02052024,'gaming,retro,console', 'Very Good','Legendary gaming console released by Nintendo in 1996. Love this console to the ground, you will be very happy playing it! ','Medium',29.99, '/images/products/nintendo64.jpg'),
(12, 2, 0, 5, 'Mega Drive', 39.99, true, 0305024,'gaming,retro,console', 'Very Good','Legendary 16-bit gaming console released by Sega in 1988. It quickly became a cultural phenomenon, competing fiercely with Nintendo during the 1990s console wars. The impact on gaming culture is undeniable, leaving behind a legacy of timeless classics and fond memories for gamers around the world.',Small,19.99,'/images/product/megadrive.jpg'),
(13, 4, 4, 13, 'CD Player', 19.99, false,03052024, 'music,retro,album', 'Decent', 'Experience the timeless joy of music with this sleek and reliable CD player, perfect for enjoying your favorite albums with pristine sound quality. Its compact design and easy-to-use controls make it a versatile addition to any audio setup.',Small,19.99,'/images/product/megadrive.jpg'),
(14, 1, 4, 15, 'Deftones - Around the flur', 11.99, true, 04052024, 'music,retro,album', 'Very Good', 'Powerful and visceral album that showcases their signature blend of heavy riffs, ethereal melodies, and emotional intensity. With tracks like "My Own Summer (Shove It)" and "Be Quiet and Drive (Far Away)," it captures the raw energy and complexity that define the Deftones sound, making it a must-have for fans of alternative metal.',Small,19.99,'/images/product/deftonesvinyl.jpg');

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
(14,'Retro Desktop',1),
(15,'Albuns & singles',4);
