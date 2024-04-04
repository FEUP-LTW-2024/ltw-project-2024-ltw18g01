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
  id INTEGER PRIMARY KEY,            -- item id
  name VARCHAR,                      --  name of the category 
);

CREATE TABLE subcategories (
  id INTEGER PRIMARY KEY,            -- subcategory id
  name VARCHAR,                      -- name of the subcategory 
  category_id INTEGER,               -- foreign key referencing the parent category
  FOREIGN KEY (category_id) REFERENCES categories(id)
);


