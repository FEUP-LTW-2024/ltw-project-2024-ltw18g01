CREATE TABLE users (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR PRIMARY KEY NOT NULL,      -- unique username
  password VARCHAR NOT NULL,                  -- password stored in sha-1
  name VARCHAR NOT NULL,                       -- real name
  image_url VARCHAR NOT NULL                -- user image
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
  image_url VAR CHAR                              -- user image 
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
  image_url VAR CHAR                -- user image
  category_id INTEGER,               -- foreign key referencing the parent category
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Inserções adicionais para a tabela de usuários (users)
INSERT INTO users (username, password, name, image_url) VALUES
('bdmendes','aclaratemmedodemim','Bruno Mendes',)
('joao.vicente.36', 'abc123', 'João Vicente','/images/users/vicente.jpeg'), 
('rodrigodesousa.pt', '20comer', 'Rodrigo de Sousa','/images/users/rodrigo.jpeg'), 
('miguelmoita_', '123456', 'Miguel Moita','/images/users/Miguel.jpg'), 
('_clarasousa', 'password', 'Clara Sousa','/images/users/clara_sousa.jpeg'),  
('pukaruca', 'reidistotudo', 'Pedro Santos','/images/users/pedro.jpeg'); 

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
INSERT INTO categories (name,category_id) VALUES
('Gaming',1),
('Pcs',2),
('Mobiles',3),
('TVs',4),
('Music',5),
('Photo&Video',6);

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
