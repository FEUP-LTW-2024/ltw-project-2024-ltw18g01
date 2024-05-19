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
(14, 'Movies', 5),
-- 19/05 02h update
(15, 'Retro', 2),
(16, 'Xiaomi', 2),
(17, 'Samsung', 2),
(18, 'Apple', 2),
(19, 'CRT', 3),
(20, 'Smart TV', 3),
(21, 'LCD', 3),
(22, 'Home Audio', 4),
(23, 'Portable Audio', 4),
(24, 'Filming Tools', 5);



INSERT INTO Item (itemId, seller, category, subcategory, title, price, negotiable, published, tags, state, description, shippingSize, shippingCost, likes, sold, image_url) VALUES
(0, 1, 0, 0, 'Gaming Keyboard', 39.99, true, 12042024, 'gaming,keyboard,peripherals', 'Very Good', 'Mechanical gaming keyboard with RGB lighting', 'Small', 19.99,10,false,'/../images/products/tecladogamer.jpg'),
(1, 4, 0, 3, 'ZX Spectrum', 19.99, true, 12042024, 'gaming,console,retro', 'Decent', 'Old Console a bit dusty but functional to fun nights','Medium',29.99, 2, false, '/../images/products/ZXSpectrum48k.jpg'),
(2, 1, 1, 11, 'Macintosh Plus', 79.99, true, 14042024, 'desktop,retro', 'Decent', 'The white components are a little yellowed due to the passing of the years', 'Large',49.99, 3, false, '/../images/products/macintoshplus.jpg'),
(3, 3, 4, 10, 'Record Deck', 279.99, true, 14042024, 'sound,retro,music', 'Very Good', 'a milestone in music, nothing better to listen to music than a record player', 'Large',49.99,27, false,  '/../images/products/GiraDiscosThorensTD125MKII.jpg'),
(4, 0, 0, 3, 'Commodore 64', 99.99, true, 15042024, 'gaming,retro,console', 'Very Good', 'Classic console to play with a bit of nostalgia, very clean', 'Medium',29.99, 31, false, '/../images/products/commodore64.jpg'),
(5, 0, 1, 1, 'Motorline MC1', 119.99, true, 18042024, 'processor,desktop,pc,retro', 'Good', 'Functional processor that belonged to a MC1','Small', 19.99,1, true, '/../images/products/motorlineMC1.jpg'),
(6, 3, 5, 9, 'Canon Camera', 139.99, true, 18042024, 'audio,camera,photo,video', 'Good', 'A canon camera that takes beautiful photos','Medium',29.99, 0, false, '/../images/products/Maquinacanoneos.jpg'),
(7, 1, 0, 8, 'The Legend of Zelda: Ocarina of Time', 14.99, false, 01052024, 'gaming,retro,game', 'Very Good', 'Timeless masterpiece that has captivated gamers for decades. This Nintendo 64 classic is an epic journey that masterfully combines elements of action, adventure, and puzzles. With groundbreaking graphics for its time and a compelling narrative, this game transports players to a vast and magical world filled with memorable characters and thrilling challenges.', 'Small',19.99, 4, false, '/../images/products/zelda.jpg'),
(8, 2, 0, 8, 'Resident Evil 2', 14.99, false, 01052024,'gaming,retro,game','Decent', 'Whether you re a fan of classic survival horror or a newcomer looking to experience one of the genres defining titles, "Resident Evil 2" offers an unforgettable journey into the heart of darkness. Prepare yourself for a relentless battle for survival against the forces of evil in one of the most iconic games of all time.','Small',19.99, 2, false, '/../images/products/residentevil2ps1.jpg'),
(9, 1, 4, 12, 'Radiohead - OK Computer', 7.99, true, 02052024, 'music,retro,album', 'Decent', 'Seminal album in alternative rock, renowned for its innovative sound and introspective lyrics. With tracks like "Paranoid Android" and "Exit Music (For a Film)," it explores themes of technology and existentialism. Praised for its sonic experimentation, it remains a timeless masterpiece in music history.','Small',19.99,19, false, '/../images/products/radioheadcd.jpg'),
(10, 3, 4, 12, 'Nirvana . Nevermind', 8.99,true,02052024, 'music,retro,album', 'Decent', 'Landmark album in the grunge movement that shook the music world in the early 1990s. Featuring iconic tracks like "Smells Like Teen Spirit" and "Come as You Are," the album is a raw and powerful expression of angst and disillusionment. Its blend of punk rock energy and catchy melodies propelled Nirvana to superstardom and forever changed the landscape of popular music. "Nevermind" remains a cultural touchstone, beloved by fans and critics alike for its raw emotion and timeless relevance.','Small',19.99, 1, false, '/../images/products/nirvanacd.jpg'),
(11, 4, 0, 3, 'Nintendo 64', 69.99, false, 02052024,'gaming,retro,console', 'Very Good','Legendary gaming console released by Nintendo in 1996. Love this console to the ground, you will be very happy playing it! ','Medium',29.99, 58, true, '/../images/products/nintendo64.jpg'),
(12, 0, 0, 3, 'Mega Drive', 39.99, true, 0305024,'gaming,retro,console', 'Very Good','Legendary 16-bit gaming console released by Sega in 1988. It quickly became a cultural phenomenon, competing fiercely with Nintendo during the 1990s console wars. The impact on gaming culture is undeniable, leaving behind a legacy of timeless classics and fond memories for gamers around the world.','Small',19.99, 23, false, '/../images/products/megadrive.jpg'),
(13, 4, 4, 10, 'CD Player', 19.99, false, 03052024, 'music,retro,album', 'Decent', 'Experience the timeless joy of music with this sleek and reliable CD player, perfect for enjoying your favorite albums with pristine sound quality. Its compact design and easy-to-use controls make it a versatile addition to any audio setup.','Small',19.99, 0, false, '/../images/products/cdplayer.jpg'),
(14, 1, 4, 12, 'Deftones - Around the fur', 11.99, true, 04052024, 'music,retro,album', 'Very Good', 'Powerful and visceral album that showcases their signature blend of heavy riffs, ethereal melodies, and emotional intensity. With tracks like "My Own Summer (Shove It)" and "Be Quiet and Drive (Far Away)," it captures the raw energy and complexity that define the Deftones sound, making it a must-have for fans of alternative metal.','Small',19.99, 8, false, '/../images/products/deftonesvinyl.jpg'),
(15, 2, 0, 8, 'Shadow The Hedgehog', 9.99, false, 04052024,'gaming,retro,game', 'Very Good', ',Step into the shoes of the enigmatic Shadow the Hedgehog in this thrilling action-adventure game! Uncover the mysteries of his past as you embark on a quest for redemption. With fast-paced gameplay, intense combat, and multiple endings to discover, Shadow the Hedgehog offers an exhilarating experience for Sonic fans and newcomers alike. Get ready for an epic adventure filled with speed, chaos, and unforgettable moments!','Small',19.99, 10, false, '/../images/products/shadow.jpg'),
(16, 2, 0, 8, "Uncharted 3: Drake's Deception",14.99,false, 04052024,'gaming,retro,game','Very Good',"Get ready for an adrenaline-fueled thrill ride like no other in Uncharted 3: Drake's Deception! Join Nathan Drake on his most daring adventure yet as he races against time and enemies to uncover the secrets of a lost city. With jaw-dropping visuals, pulse-pounding action, and a storyline packed with twists and turns, this game will keep you on the edge of your seat from start to finish. ",'Small',19.99, 9, false, '/../images/products/uncharted3.jpg'),
(17, 2, 0, 3, 'Playstation 2', 29.99, false, 05052024,'gaming,retro,console', 'Decent', 'Immerse yourself in the excitement of the PlayStation 2, the console that revolutionized gaming for millions! With its sleek design and cutting-edge technology, the PS2 delivers unforgettable experiences that transport you to new worlds. Whether you are exploring vast landscapes, engaging in epic battles, or embarking on thrilling adventures, the PlayStation 2 offers endless entertainment for players of all ages. Join the gaming community and experience the magic of the PS2 for yourself!', 'Medium',29.99, 18, false, '/../images/products/ps2.jpg'),
(18, 2, 0, 0, 'Ps3 Controller', 89.99, false, 05052024, 'gaming,controller', 'Very Good', 'Get your hands on the original PlayStation 3 controller and elevate your gaming experience to new heights! Designed for precision and comfort, this controller offers responsive buttons, ergonomic grips, and intuitive controls that allow you to immerse yourself fully in your favorite games. With its sleek and iconic design, the original PS3 controller is a must-have accessory for any PlayStation enthusiast.', 'Small',19.99, 98, false, '/../images/products/ps3controller.jpeg'),
(19, 1, 1, 6, 'PC Gamer', 599.99, true, 05052024,'gaming,pc,desktop','Very Good', 'Step into the world of high-performance gaming with my PC Gamer, the ultimate platform for immersive gaming experiences! Powered by cutting-edge hardware and state-of-the-art components, this PC is engineered to deliver blistering speeds, stunning graphics, and seamless gameplay. From fast-paced shooters to expansive open worlds, conquer every virtual challenge with ease.Whether you are a casual gamer, a competitive esports enthusiast, or a seasoned pro, our PC Gamer is your ticket to victory. Dominate the digital battlefield, explore fantastical realms, and experience gaming like never before with my top-tier PC Gamer!','Large', 49.99, 63, false, '/../images/products/pcgamer.jpg'),
(20, 3, 5, 14, 'Lemonade Mouth', 19.99, true, 05052024,'tv,film, blu-ray', 'Decent', 'Join the musical journey of a lifetime with "Lemonade Mouth," the electrifying movie that will inspire you to find your voice and chase your dreams! Follow the story of five high school students who form an unlikely band and embark on a musical adventure that will change their lives forever. Get ready to sing along, dance to the beat, and feel the rhythm of "Lemonade Mouth" as it captures the essence of youth, empowerment, and the joy of making music. Let this feel-good film inspire you to follow your passions and embrace the magic of chasing your dreams!', 'Small',19.99, 11, false, '/../images/products/lemonademouth.jpg'),
(21, 4, 1, 0, 'Monitor Curvo ', 159.99, true, 05052024,'monitor,peripherals,gaming','Decent', 'Immerse yourself in the ultimate viewing experience with our curved monitor, designed to bring your entertainment and productivity to life like never before! With its sleek and stylish design, this monitor enhances any workspace or gaming setup with its modern aesthetic.The curved screen wraps around your field of vision, creating a more immersive viewing experience that draws you into the action and makes every moment feel larger than life. Whether you are watching movies, playing games, or working on projects, the curved design reduces eye strain and provides a more comfortable viewing experience for extended periods.', 'Large', 49.99, 2, true, '/../images/products/monitorcurvo.jpeg'),
(22, 3, 3, 19, 'TV antiga', 29.99, false, 06052024,'tv,retro,video', 'Decent', 'Step back in time and rediscover the charm of classic television with our vintage TV! Embrace nostalgia as you experience the iconic design and retro vibes of a bygone era.With its vintage aesthetic and authentic wood-panel finish, this TV adds a touch of old-world elegance to any living space or collection. Relive the magic of vintage programming or showcase it as a unique decor piece in your home.', 'Large',49.99, 2, false, '/../images/products/tvantiga.jpg'),
(23, 1, 5, 24, 'Tripé', 39.99, true, 06052024,'video,peripherals,photo', 'Decent', 'Elevate your photography and videography to new heights with our professional-grade tripod! Designed for stability, versatility, and durability, this tripod is the perfect companion for capturing stunning images and smooth footage in any environment.From amateur enthusiasts to professional photographers and filmmakers, our tripod is a must-have tool for anyone serious about capturing stunning visual content. Take your photography and videography to the next level with our premium tripod and unleash your creative potential!', 'Large', 49.99, 1, false, '/../images/products/tripé.jpg'),
(24, 3, 2, 15, 'Nokia', 0.99, true, 06052024, 'mobile,peripherals,phone','Very Good','Introducing the Nokia 3310, the legendary mobile phone that defined a generation! Known for its iconic design, indestructible build, and long-lasting battery life, the Nokia 3310 is a timeless classic that continues to capture the hearts of mobile enthusiasts around the world.With its sturdy construction and reliable performance, the Nokia 3310 is more than just a phone its a symbol of durability and simplicity in a world of ever-evolving technology. From making calls and sending texts to playing Snake and composing ringtones, the Nokia 3310 offers everything you need in a mobile device, without the distractions of modern smartphones.Whether you are nostalgic for the days of T9 texting and monochrome screens or simply appreciate the elegance of a well-crafted device, the Nokia 3310 is the perfect choice for anyone looking to experience the magic of classic mobile technology. Grab a piece of mobile history and relive the glory days with the Nokia 3310!','Small', 19.99, 5, false, '/../images/products/nokia.jpg'),
(25, 4, 5, 9, 'Fuji Film Camera', 79.99, false, 06052024, 'audio,camera,photo,video', 'Very Good','Introducing the Fujifilm X100V, a masterpiece of modern photography that combines classic design with cutting-edge technology. With its retro-inspired aesthetics and advanced features, the X100V is the perfect companion for capturing stunning images in any situation.Featuring a high-performance 26.1MP X-Trans CMOS 4 sensor and X-Processor 4, the X100V delivers exceptional image quality with sharp detail, vibrant colors, and rich dynamic range. Its versatile 23mm F2 lens provides a wide field of view, perfect for everything from landscapes to street photography.', 'Medium',29.99, 10, false, '/../images/products/fujifilm.jpg'),
(26, 2, 0, 8, 'Call of Duty Modern Warfare 3', 29.99,true, 07052024, 'gaming,retro,game', 'Very Good','Get ready to experience the adrenaline-pumping action of modern warfare like never before with "Call of Duty: Modern Warfare 3"! As the thrilling conclusion to the epic Modern Warfare trilogy, this game thrusts players into the heart of a global conflict where every decision could mean the difference between victory and defeat.With its intense single-player campaign, gripping multiplayer modes, and addictive cooperative missions, "Modern Warfare 3" offers something for every type of player. Join iconic characters like Soap, Price, and Frost as they battle against the forces of chaos and terror in a desperate fight for survival.' , 'Small',19.99, 15, false, '/../images/products/mw3.jpg'),
-- 19/05 02h update

(27, 1, 1, 7, 'Acer GL553VD gaming laptop', 300.00, true, 19052024, 'laptop,gaming,pc', 'Good', 'Includes charger. In great shape, bought in 2021, runs most modern games.', 'Large', 49.99, 4, false, '/../images/products/acergaming.jpg'),
(28, 3, 1, 5, 'Macbook Pro 2016', 150.00, false, 19052024, 'laptop, apple', 'Very Good', '2016 model, some scratches in the bottom case but overall very good state. Non-negotiable price.', 'Medium', 29.99, 15, false, '/../images/products/macbook2016.jpg'),
(29, 4, 1, 6, 'Gaming station - GTX1060 3GB', 219.99, true, 19052024, 'desktop, gaming', 'Very Good', 'Ryzen R5, 1TB (HDD), 16GB RAM, GTX1060 3GB. Runs some modern games but, of course, all parts are upgradeable.', 'Large', 49.99, 27, false, '/../images/products/gamingstation.jpg'),
(30, 2, 1, 5, 'iBook G3', 139.99, false, 19052024, 'frutiger, aero', 'Good', 'Some yellowing. Everything works fine.', 'Medium', 29.99, 120, false, '/../images/products/ibook.jpg'),
(31, 0, 1, 4, 'Asus full setup', 99.99, true, 19052024, 'pc, full, setup', 'Good', 'Full PC setup from circa 2009. Good for accessing internet and other light tasks. Windows 7 activated.', 'Large', 49.99, 5, false, '/../images/products/asussetup.jpg'),
(32, 4, 1, 4, 'Lenovo Thinkcentre', 119.99, true, 19052024, 'pc, lenovo', 'Very Good', 'Old thinkcentre laptop, professional line. 2016 model, intel core i3. Great for small businesses.', 'Large', 49.99, 88, false, '/../images/products/thinkcentre.jpg'),
(33, 1, 1, 1, 'Intel Core i7-9700T NEW', 40.00, false, 19052024, 'processor', 'Very Good', 'i7-9700T, new. 2.0GHz - Eight-Core Eight-Thread CPU Processor 12M 35W PC Desktop LGA 1151', 'Small', 19.99, 12, false, '/../images/products/i7.jpg'),
(34, 0, 1, 11, 'IBM 5150, untested', 200.00, false, 19052024, 'retro, desktop', 'Very Good', 'IBM 5150 from the 80s, floppy hard drive. Untested but with all cables', 'Large', 49.99, 34, false, '/../images/products/amiga.jpg'),


(35, 4, 2, 18, 'iPhone 11 A2221 128gb', 99.99, false, 19052024, 'iphone, phone', 'Decent', 'iPhone 11, very scratched at the back, hence the low price (non negotiable). 128gb, fully working, 89% capacity.', 'Small', '19.99', 21, false, '/../images/products/iphone11.jpg'),
(36, 0, 2, 16, 'Xiaomi Redmi Note 12', 115.00, true, 19052024, 'xiaomi', 'Very Good', 'Redmi Note 12. Few scratches but very good state. 2021 model, my daily driver until I bought a newer model.', 'Small', 19.99, 28, false, '/../images/products/redmi12.jpg'),
(37, 3, 2, 17, 'Note 20 5G Snapdragon 865+', 299.99, false, 19052024, 'samsung', 'Very Good', 'Samsung Galaxy Note 20 5G - NEW SEALED - Snapdragon 865+, great specs and amazing phone.', 'Small', 19.99, 13, false, '/../images/products/note20.jpg'),
(38, 2, 2, 15, 'Nokia N95 symbian', 25.00, false, 19052024, 'nokia, n95, retro', 'Good', 'Retro Nokia N95 8GB. Symbian operating system. Might not work with all carriers as it only supports 3G.', 'Small', 19.99, 2, false, '/../images/products/n95.jpg'),
(39, 0, 2, 15, 'Microsoft Lumia 950', 69.00, false, 19052024, 'lumia, microsoft', 'Good', 'Microsoft Lumia 950 32GB, good state. Windows 10 Mobile included. Charger not included (regular micro USB)', 'Small', 19.99, 7, false, '/../images/products/lumia950.jpg');



INSERT INTO Wishlist (wishlistId, user, item) VALUES
(0, 0, 14),
(1, 0, 15),
(2, 1, 1),
(3, 1, 20),
(4, 2, 21),
(5, 2, 10),
(6, 3, 14),
(7, 3, 3),
(8, 4, 5),
(9, 4, 16),
(10, 0, 1),
(11, 0, 2),
(12, 0, 3),
(13, 0, 4),
(14, 0, 5),
(15, 0, 6),
(16, 0, 7),
(17, 0, 8),
(18, 0, 9),
(19, 0, 10),
(20, 0, 11),
(21, 0, 12),
(22, 0, 13),
(23, 0, 21);

INSERT INTO Message (messageId, senderId, receiverId, itemId, message, sentAt) VALUES
(0, 2, 1, 0, 'Olá, estou interessado em comprar este teclado.', '2023-05-12 08:00:00'),
(1, 2, 1, 0, 'Ótimo! O teclado ainda está disponível.', '2023-05-12 08:05:00'),
(2, 3, 1, 1, 'O ZX Spectrum ainda está à venda?', '2023-05-12 08:10:00');

