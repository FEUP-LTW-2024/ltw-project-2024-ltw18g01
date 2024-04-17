CREATE TABLE users (
  username VARCHAR PRIMARY KEY,      -- unique username
  password VARCHAR,                  -- password stored in sha-1
  name VARCHAR                       -- real name
);

CREATE TABLE items (
  id INTEGER PRIMARY KEY,            -- item id
  name VARCHAR,                      --  name of the item
  price float,                       -- price of the item
  published INTEGER,                 -- date when the article was published in epoch format
  tags VARCHAR,                      -- comma separated tags
  username VARCHAR REFERENCES users, -- user that possess the item
  state VARCHAR,                     -- state of the item
  description VARCHAR,               -- report /  aditional description of the state of the item
);

CREATE TABLE categories (
  id INTEGER PRIMARY KEY,            -- category id
  name VARCHAR,                      --  name of the category 
);

CREATE TABLE subcategories (
  id INTEGER PRIMARY KEY,            -- subcategory id
  name VARCHAR,                      -- name of the subcategory 
  category_id INTEGER,               -- foreign key referencing the parent category
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Inserções adicionais para a tabela de usuários (users)
INSERT INTO users (username, password, name) VALUES
('joao.vicente.36', 'abc123', 'João Vicente'), 
('rodrigodesousa.pt', '20comer', 'Rodrigo de Sousa'), 
('miguelmoita_', '123456', 'Miguel Moita'), 
('_clarasousa', 'password', 'Clara Sousa'),  
('pukaruca', 'reidistotudo', 'Pedro Santos'); 

-- Inserções adicionais para a tabela de itens (items)
INSERT INTO items (name, price, published, tags, username, state, description) VALUES
('Gaming Keyboard', 100.00, 1649520000, 'gaming,keyboard,accessory', 'joao.vicente.36', 'new', 'Mechanical gaming keyboard with RGB lighting'),
('Gaming Mouse', 50.00, 1649606400, 'gaming,mouse,accessory', 'rodrigodesousa.pt', 'new', 'High-precision gaming mouse with customizable buttons'),
('Gaming Headset', 80.00, 1649692800, 'gaming,headset,audio', 'miguelmoita_', 'new', 'Immersive gaming headset with surround sound'),
('Graphics Card', 400.00, 1649779200, 'graphics,card,component', '_clarasousa', 'used', 'Powerful graphics card for gaming and rendering tasks'),
('SSD Drive', 120.00, 1649865600, 'ssd,drive,storage', 'pukaruca', 'new', 'High-speed solid state drive for fast storage performance');

-- Inserções adicionais para a tabela de categorias (categories)
INSERT INTO categories (name,category_id) VALUES
('Accessories',1),
('Components',2),
('Peripherals',3),
('Storage',4),
('Audio',5);

-- Inserções adicionais para a tabela de subcategorias (subcategories)
INSERT INTO subcategories (name, category_id) VALUES
('Keyboards', 1),
('Mice', 1),
('Headsets', 5),
('Graphics Cards', 2),
('Solid State Drives', 4);


