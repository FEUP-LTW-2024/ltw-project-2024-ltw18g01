<?php
    declare(strict_types=1);

    class Item {
        public int $id;
        public string $name;
        public float $price;
        public bool $negotiable; // novo
        public string $state; // novo
        public string $shippingSize; // novo
        public int $seller;
        public string $description;
        public string $image_url;
        public int $subcategory;




        public function __construct(int $id, string $name, float $price, bool $negotiable, string $state, string $shippingSize, int $seller, string $description, string $image_url, int $subcategory) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->negotiable = $negotiable;
            $this->state = $state;
            $this->shippingSize = $shippingSize;
            $this->seller = $seller;
            $this->description = $description;
            $this->image_url = $image_url;
            $this->subcategory = $subcategory;
        }


        static function getItem(PDO $db, int $id) : Item {
            $stmt = $db->prepare('
                SELECT id, name, price, negotiable, state, shippingSize, seller, description, image_url, subcategory_id
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
                $item['negotiable'],
                $item['state'],
                $item['shippingSize'],
                $item['seller'],
                $item['description'],
                $item['image_url'],
                $item['subcategory_id']
            );
        }
        
    }