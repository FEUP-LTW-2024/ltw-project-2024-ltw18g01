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
    public string $image_url;

    public function __construct(int $id, int $seller, int $category, int $subcategory, string $title, float $price, bool $negotiable, int $published, string $tags, string $state, string $description, string $shippingSize, float $shippingCost, int $likes, string $image_url) {
        $this->id = $id;
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
    $item['itemId'],
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

    if ($items) {
        foreach ($items as &$item) {
            $item['user_status'] = 'SOLD'; 
        }
    }

    return $items;
}

static function likeManipulator(PDO $db, int $itemId, int $userId, bool $add) {
    if ($add) {
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
        
        $stmt->execute(array($itemId));
    } else {
        $stmt = $db->prepare('
        UPDATE Item
        SET likes = likes - 1
        WHERE itemId = ?
        ');

        $stmt->execute(array($itemId));

        $stmt = $db->prepare('
        DELETE FROM Wishlist
        WHERE item = ?
        ');

        $stmt->execute(array($itemId));
    }
}



