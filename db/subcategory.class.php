<?php
declare(strict_types=1);

class Subcategory {
    public ?int $id;
    public string $name;
    public int $category;

    public function __construct(string $name, int $category, int $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
    }

    public static function getSubcategoryItems(PDO $db, int $id): array {
        $stmt = $db->prepare('
            SELECT *
            FROM Item
            WHERE Item.subcategory = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoryFromSubcategory(PDO $db, int $id): Category {
        $stmt = $db->prepare('
            SELECT c.categoryId, c.name
            FROM Category c
            JOIN Subcategory s ON c.categoryId = s.category
            WHERE s.subcategoryId = ?
        ');
        $stmt->execute([$id]);
        $cat = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$cat) {
            throw new Exception("Category not found for subcategory id $id");
        }

        return new Category($cat['categoryId'], $cat['name']);
    }

    public static function getSubcategory(PDO $db, int $id): Subcategory {
        $stmt = $db->prepare('
            SELECT subcategoryId, name, category
            FROM Subcategory
            WHERE subcategoryId = ?
        ');
        $stmt->execute([$id]);
        $cat = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cat) {
            throw new Exception("Subcategory not found with id $id");
        }

        return new Subcategory($cat['name'], $cat['category'], $cat['subcategoryId']);
    }

    public static function getAllSubcategories(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM Subcategory');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSubcategoriesFromCategory(PDO $db, int $id): array {
        $stmt = $db->prepare('
            SELECT *
            FROM Subcategory
            WHERE category = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function removeSubcategory(PDO $db, int $id): void {
        $stmt = $db->prepare('DELETE FROM Subcategory WHERE subcategoryId = ?');
        $stmt->execute([$id]);
    }

    public static function checkSubcategoryExistence(PDO $db, string $title): bool {
        $stmt = $db->prepare('
            SELECT COUNT(*)
            FROM Subcategory
            WHERE name = ?
        ');
        $stmt->execute([$title]);
        return $stmt->fetchColumn() > 0;
    }

    public function save(PDO $db): void {
        if ($this->id === null) {
            $stmt = $db->prepare('
                INSERT INTO Subcategory (name, category)
                VALUES (?, ?)
            ');
            $stmt->execute([$this->name, $this->category]);
            $this->id = (int)$db->lastInsertId();
        } else {
            $stmt = $db->prepare('
                UPDATE Subcategory
                SET name = ?, category = ?
                WHERE subcategoryId = ?
            ');
            $stmt->execute([$this->name, $this->category, $this->id]);
        }
    }
}
?>
