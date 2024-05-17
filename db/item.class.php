<?php
    declare(strict_types=1);

class Item {
    public int $id;
    public int $seller;
    public int $category;
    public int $subcategory;
    public string $title;
    public float $price;
    public bool $negotiable;
    public int $published;
    public string $tags;
    public string $state;
    public string $description;
    public string $shippingSize;
    public float $shippingCost;
    public int $likes;
    public bool $sold;
    public string $image_url;

    public function __construct(int $seller, int $category, int $subcategory, string $title, float $price, bool $negotiable, int $published, string $tags, string $state, string $description, string $shippingSize, float $shippingCost, int $likes, bool $sold, string $image_url) {
        $this->seller = $seller;
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->title = $title;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->published = $published;
        $this->tags = $tags;
        $this->state = $state;
        $this->description = $description;
        $this->shippingSize = $shippingSize;
        $this->shippingCost = $shippingCost;
        $this->likes = $likes;
        $this->sold = $sold;
        $this->image_url = $image_url;
    }


    static function getItem(PDO $db, int $id) : Item {
        $stmt = $db->prepare('
        SELECT *
        FROM Item
        WHERE itemId = ?
        ');

        $stmt->execute(array($id));

        $item = $stmt->fetch();

        if (!$item) {
            return null;
        }

        

        return new Item(
            $item['seller'], 
            $item['category'],
            $item['subcategory'],
            $item['title'],
            $item['price'],
            (bool)$item['negotiable'],
            $item['published'],
            $item['tags'],
            $item['state'],
            $item['description'],
            $item['shippingSize'],
            $item['shippingCost'],
            $item['likes'],
            (bool)$item['sold'],
            $item['image_url']
        );
    }

    static function getItemsByUser(PDO $db, int $userId) {
        $stmt = $db->prepare('
            SELECT i.*, u.username AS seller_username
            FROM Item i
            JOIN User u ON i.seller = u.userId
            WHERE i.seller = ?
        ');

        $stmt->execute(array($userId));
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }

    static function removeLike(PDO $db, int $itemId, int $userId) {
        $stmt = $db->prepare('
            UPDATE Item
            SET likes = likes - 1
            WHERE itemId = ?
            ');

        $stmt->execute(array($itemId));

        $stmt = $db->prepare('
            DELETE FROM Wishlist
            WHERE item = ? AND user = ?
            ');

        $stmt->execute(array($itemId, $userId));
    }

    static function addLike(PDO $db, int $itemId, int $userId) {
            $stmt = $db->prepare('
            UPDATE Item
            SET likes = likes + 1
            WHERE itemId = ?
            ');

            $stmt->execute(array($itemId));

            $stmt = $db->prepare('
            INSERT INTO Wishlist (item, user)
            VALUES (?, ?)
            ');
            
            $stmt->execute(array($itemId, $userId));
    }

    static function updateSold(PDO $db, int $itemId) {
        $stmt = $db->prepare('
        UPDATE Item
        SET sold = true
        WHERE itemId = ?
        ');

        $stmt->execute(array($itemId));
    }

    static function searchItems(PDO $db, string $query, int $count) : array {
        $stmt = $db->prepare(
            'SELECT *
            FROM Item
            WHERE title LIKE ? AND sold = false
            LIMIT ?'
        );

        $stmt->execute(array($query . '%', $count));

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }

    public function save(PDO $db) {
        $stmt = $db->prepare('
            INSERT INTO Item (seller, category, subcategory, title, price, negotiable, published, tags, state, description, shippingSize, likes, shippingCost, sold, image_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute(array(
            $this->seller,
            $this->category,
            $this->subcategory,
            $this->title,
            $this->price,
            $this->negotiable,
            $this->published,
            $this->tags,
            $this->state,
            $this->description,
            $this->shippingSize,
            $this->likes,
            $this->shippingCost,
            $this->sold,
            $this->image_url
        ));

        $this->id= (int) $db->lastInsertId();
    }
}

