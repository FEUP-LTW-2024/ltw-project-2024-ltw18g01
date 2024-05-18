<?php
function hash_password($password) {
    // Gera um salt aleatório de 16 bytes
    $salt = random_bytes(16);
    // Converte o salt para um formato hexadecimal para armazenamento
    $salt_hex = bin2hex($salt);

    // Concatena a senha com o salt
    $salted_password = $password . $salt_hex;

    // Aplica o algoritmo de hash SHA-256
    $hash = hash('sha256', $salted_password);

    // Retorna o salt e o hash concatenados, separados por um caractere delimitador (por exemplo, ':')
    return $salt_hex . ':' . $hash;
}

function verify_password($password, $hashed_password) {
    // Separa o hash e o salt armazenados
    list($salt_hex, $hash) = explode(':', $hashed_password);

    // Concatena a senha com o salt
    $salted_password = $password . $salt_hex;

    // Aplica o algoritmo de hash SHA-256
    $hash_check = hash('sha256', $salted_password);

    // Compara o hash gerado com o hash armazenado
    return hash_equals($hash, $hash_check);
}