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

        static function getWishlistUser(PDO $db, int $id) : array {
            $stmt = $db->prepare('
                SELECT item
                FROM Wishlist
                WHERE Wishlist.user = ?
            ');

            $stmt->execute(array($id));

            $items = $stmt->fetchAll();

            return $items;
        }
    }