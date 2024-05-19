<?php
function hash_password($password) {
    $salt = random_bytes(16);
    $salt_hex = bin2hex($salt);

    $salted_password = $password . $salt_hex;

    $hash = hash('sha256', $salted_password);

    return $salt_hex . ':' . $hash;
}

function verify_password($password, $hashed_password) {
    list($salt_hex, $hash) = explode(':', $hashed_password);

    $salted_password = $password . $salt_hex;
    $hash_check = hash('sha256', $salted_password);

    return hash_equals($hash, $hash_check);
}