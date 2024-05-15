<?php

    declare(strict_types=1);

    class Wishlist {
        public int $id;
        public int $user;
        public int $item;

        public function __construct(int $id, int $user, int $item) {
            $this->id = $id;
            $this->user = $user;
            $this->item = $item;
        }

        static function getWishlistUser(PDO $db, int $userId): array {
            $stmt = $db->prepare('
                SELECT Item.*
                FROM Wishlist
                INNER JOIN Item ON Wishlist.item = Item.itemId
                WHERE Wishlist.user = ?
            ');
        
            $stmt->execute(array($userId));
        
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $items;
        }
        
    }