<?php
declare(strict_types = 1);

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
        $this->password = $password;
        $this->image_url = $image_url ?? null;
        $this->userRating = $userRating ?? 0.0;
        $this->salesNumber = $salesNumber;
        $this->isAdmin = $isAdmin;
    }

    function name() {
        return $this->firstName . ' ' . $this->lastName;
    }

    function save(PDO $db) {
        $stmt = $db->prepare('
            INSERT INTO User (firstName, lastName, username, address, city, country, postalCode, phone, email, password, image_url, userRating, salesNumber, isAdmin)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute(array(
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
        ));
    }  

    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
        $stmt = $db->prepare('
            SELECT *
            FROM User 
            WHERE lower(email) = ? AND password = ?
        ');

        $stmt->execute(array(strtolower($email), $password));

        if ($user = $stmt->fetch()) {
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
        } else return null;
    }

    static function getUser(PDO $db, int $id) : ?User {
      $stmt = $db->prepare('
          SELECT *
          FROM User
          WHERE userId = ?
      ');
  
      $stmt->execute(array($id));
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
}
?>
