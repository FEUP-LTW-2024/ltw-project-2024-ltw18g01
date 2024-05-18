<?php
declare(strict_types=1);

require_once 'password.php';

class User {
    public int $userId;
    public string $firstName;
    public string $lastName;
    public string $username;
    public string $address;
    public string $city;
    public string $country;
    public string $postalCode;
    public string $phone;
    public string $email;
    public string $password;
    public ?string $image_url = null;
    public float $userRating;
    public int $salesNumber;
    public int $isAdmin;

    public function __construct(int $userId, string $firstName, string $lastName, string $username, string $address, string $city, string $country, string $postalCode, string $phone, string $email, string $password, ?string $image_url = null, ?float $userRating = null, int $salesNumber = 0, int $isAdmin = 0) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = hash_password($password); // Usa a função hash_password do password.php
        $this->image_url = $image_url;
        $this->userRating = $userRating ?? 0.0;
        $this->salesNumber = $salesNumber;
        $this->isAdmin = $isAdmin;
    }

    function name(): string {
        return $this->firstName . ' ' . $this->lastName;
    }

    function save(PDO $db): void {
        $stmt = $db->prepare('
            INSERT INTO User (userId, firstName, lastName, username, address, city, country, postalCode, phone, email, password, image_url, userRating, salesNumber, isAdmin)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $this->userId,
            $this->firstName,
            $this->lastName,
            $this->username,
            $this->address,
            $this->city,
            $this->country,
            $this->postalCode,
            $this->phone,
            $this->email,
            $this->password,
            $this->image_url,
            $this->userRating,
            $this->salesNumber,
            $this->isAdmin
        ]);
    }

    static function insertUsers(PDO $db, array $users): void {
        foreach ($users as $user) {
            $userObj = new User(
                $user[0], // userId
                $user[1], // firstName
                $user[2], // lastName
                $user[3], // username
                $user[4], // address
                $user[5], // city
                $user[6], // country
                $user[7], // postalCode
                $user[8], // phone
                $user[9], // email
                $user[10], // password
                $user[11], // image_url
                $user[12], // userRating
                $user[13], // salesNumber
                $user[14]  // isAdmin
            );
            $userObj->save($db);
        }
    }

    static function getUserWithPassword(PDO $db, string $email, string $password): ?User {
        $stmt = $db->prepare('
            SELECT *
            FROM User 
            WHERE lower(email) = ?
        ');

        $stmt->execute([strtolower($email)]);

        if ($user = $stmt->fetch()) {
            if (verify_password($password, $user['password'])) { // Usa a função verify_password do password.php
                return new User(
                    $user['userId'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['username'],
                    $user['address'],
                    $user['city'],
                    $user['country'],
                    $user['postalCode'],
                    $user['phone'],
                    $user['email'],
                    $user['password'],
                    $user['image_url'],
                    $user['userRating'] !== null ? (float)$user['userRating'] : null,
                    $user['salesNumber'],
                    $user['isAdmin']
                );
            }
        }

        return null;
    }

    static function getUser(PDO $db, int $id): ?User {
        $stmt = $db->prepare('
            SELECT *
            FROM User
            WHERE userId = ?
        ');

        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if ($user) {
            $image_url = is_string($user['image_url']) ? $user['image_url'] : '/images/others/guesticon.png';

            return new User(
                $user['userId'],
                $user['firstName'],
                $user['lastName'],
                $user['username'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['postalCode'],
                $user['phone'],
                $user['email'],
                $user['password'],
                $image_url,
                $user['userRating'] !== null ? (float)$user['userRating'] : null,
                $user['salesNumber'],
                $user['isAdmin']
            );
        } else {
            return null;
        }
    }

    static function getAllUsers(PDO $db): array {
        $stmt = $db->prepare('
            SELECT *
            FROM User
        ');

        $stmt->execute();
        $users = $stmt->fetchAll();

        $result = [];
        foreach ($users as $user) {
            $image_url = is_string($user['image_url']) ? $user['image_url'] : '/images/others/guesticon.png';
            $userObj = new User(
                $user['userId'],
                $user['firstName'],
                $user['lastName'],
                $user['username'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['postalCode'],
                $user['phone'],
                $user['email'],
                $user['password'],
                $image_url,
                $user['userRating'] !== null ? (float)$user['userRating'] : null,
                $user['salesNumber'],
                $user['isAdmin']
            );
            $result[] = $userObj;
        }

        return $result;
    }

    function updateUserStatus(PDO $db, int $id, int $isAdmin): void {
        $stmt = $db->prepare(
            "UPDATE User SET isAdmin = ?
             WHERE userId = ?"
        );

        $stmt->execute([$isAdmin, $id]);
    }

    function removeUser(PDO $db, int $id): void {
        $stmt = $db->prepare("DELETE FROM User WHERE userId = ?");
        $stmt->execute([$id]);
    }
}
?>
