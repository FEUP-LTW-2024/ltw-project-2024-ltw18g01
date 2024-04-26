<?php
    declare(strict_types = 1);

    class User {
        public int $id;
        public string $username;
        public string $name;
        public string $image_url;

        public function __construct(int $id, string $username, string $name, string $image_url) {
            $this->id = $id;
            $this->username = $username;
            $this->name = $name;
            $this->image_url = $image_url;
        }

    }

?>