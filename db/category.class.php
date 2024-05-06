<?php
    declare(strict_types=1);

    class Category {
        public int $id;
        public string $name;

        public function __construct(int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }


        static function getCategoryItems(PDO $db, int $id) : array {
            $stmt = $db->prepare('
                SELECT *
                FROM Item
                WHERE Item.category = ?
            ');
        
            $stmt->execute(array($id));
        
            $items = $stmt->fetchAll();
        
            return $items; 
        }

        static function getCategory(PDO $db, int $id) : Category {
            $stmt = $db->prepare('
                SELECT categoryId, name
                FROM Category
                WHERE categoryId = ?
            ');
      
            $stmt->execute(array($id));
            $cat = $stmt->fetch();
            

            return new Category(
                $cat['categoryId'],
                $cat['name']
            );
            
        }

        static function getCategories(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT *
                FROM Category
            ');
        
            $stmt->execute(array());
        
            $categories = $stmt->fetchAll();
        
            return $categories; 
        }

        
    }