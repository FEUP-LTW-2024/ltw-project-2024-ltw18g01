<?php
    declare(strict_types=1);

    class Subcategory {
        public int $id;
        public string $name;
        public int $category;

        public function __construct(int $id, string $name, int $category) {
            $this->id = $id;
            $this->name = $name;
            $this->category = $category;
        }


        static function getSubcategoryItems(PDO $db, int $id) : array {
            $stmt = $db->prepare('
                SELECT *
                FROM Item
                WHERE Item.subcategory = ?
            ');
        
            $stmt->execute(array($id));
        
            $items = $stmt->fetchAll();
        
            return $items; 
        }

        static function getCategoryFromSubcategory(PDO $db, int $id) : Category {
            $stmt = $db->prepare('
                SELECT categoryId, name
                FROM Category
                WHERE subcategoryId = ?
            ');
      
            $stmt->execute(array($id));
            $cat = $stmt->fetch();
            

            return new Category(
                $cat['categoryId'],
                $cat['name']
            );
            
        }

        static function getSubcategory(PDO $db, int $id) : Subcategory {
            $stmt = $db->prepare('
                SELECT subcategoryId, name, category
                FROM Subcategory
                WHERE subcategoryId = ?
            ');
      
            $stmt->execute(array($id));
            $cat = $stmt->fetch();
            

            return new Subcategory(
                $cat['subcategoryId'],
                $cat['name'],
                $cat['category']
            );
            
        }

        static function getSubcategoriesFromCategory(PDO $db, int $id) : array {
            $stmt = $db->prepare('
            SELECT *
            FROM Subcategory
            WHERE category = ?
            ');

            $stmt->execute(array($id));
            $cat = $stmt->fetchAll();

            return $cat;
        }
        
    }