<?php
    declare(strict_types=1);

    class Item {
        public int $id;
        public string $name;
        public float $price;
        public int $seller;
        public string $description;
        public string $image_url;
        public int $subcategory;




        public function __construct(int $id, string $name, float $price, int $seller, string $description, string $image_url, int $subcategory) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->seller = $seller;
            $this->description = $description;
            $this->image_url = $image_url;
            $this->subcategory = $subcategory;
        }


        static function getItem(PDO $db, int $id) : Item {
            $stmt = $db->prepare('
                SELECT id, name, price, seller, description, image_url, subcategory_id
                FROM items
                WHERE id = ?
                GROUP BY id
            ');
        
            $stmt->execute(array($id));
        
            $item = $stmt->fetch();
        
            return new Item(
                $item['id'],
                $item['name'],
                $item['price'],
                $item['seller'],
                $item['description'],
                $item['image_url'],
                $item['subcategory_id']
            );
        }
        
    }