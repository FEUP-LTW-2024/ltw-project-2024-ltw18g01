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
        public string $image_url;
        public float $userRating;
        public int $salesNumber;
        public int $isAdmin;

        public function __construct(int $userId, string $firstName, string $lastName, string $username, string $address, string $city, string $country, string $postalCode, string $phone, string $email, string $image_url, float $userRating, int $salesNumber,int $isAdmin) {
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
            $this->image_url = $image_url;
            $this->userRating = $userRating;
            $this ->salesNumber = $salesNumber;
            $this->isAdmin = $isAdmin;
        }

        function name() {
            return $this->firstName . ' ' . $this->lastName;
          }
      
          function save($db) {
            $stmt = $db->prepare('
              UPDATE User SET firstName = ?, lastName = ?, username = ?, address = ?, city = ?, country = ?, postalCode = ?, phone = ?
              WHERE userId = ?
            ');
      
            $stmt->execute(array($this->firstName, $this->lastName, $this->username, $this->address, $this->city, $this->country, $this->postalCode, $this->phone, $this->userId));
          }

          static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
            $stmt = $db->prepare('
              SELECT *
              FROM User 
              WHERE lower(email) = ? AND password = ?
            ');
      
            // $stmt->execute(array(strtolower($email), sha1($password)));
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
                $user['image_url'],
                $user['userRating'],
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

              $salesNumber = isset($user['salesNumber']) ? (int)$user['salesNumber'] : 0;

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
                $user['image_url'],
                $user['userRating'],
                  $salesNumber,
                $user['isAdmin']
              );
            } else {
              return null;
            }
            

            
          }

    }

?>