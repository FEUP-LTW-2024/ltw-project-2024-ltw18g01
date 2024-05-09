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
    public int $shippingCost;
    public string $image_url;

    public function __construct(int $id, int $seller, int $category, int $subcategory, string $title, float $price, bool $negotiable, int $published, string $tags, string $state, string $description, string $shippingSize, int $shippingCost, string $image_url) {
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

    $shippingCost = isset($item['shippingCost']) ? (int)$item['shippingCost'] : 0;

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
    $shippingCost,
    $item['image_url']
);
}
}


