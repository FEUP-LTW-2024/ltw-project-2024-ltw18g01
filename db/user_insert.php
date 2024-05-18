<?php
require_once 'user_class.php';

try {
    $db = new PDO('sqlite:/../db/database.db'); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $users = [
        [0, 'João', 'Mendes', 'joaovicente', 'Avenida das Rochas 21', 'Porto', 'Portugal', '4400-123', '+351 931 234 568', 'vicente@gmail.com', 'vicente123', '/../images/users/vicente.jpeg', 4.5, 14, 1],
        [1, 'Rodrigo', 'Sousa', 'rodrigodesousa', 'Rua das Avenidas 23', 'Porto', 'Portugal', '4430-123', '+351 931 254 598', 'rodrigo@gmail.com', 'rodrigo123', '/../images/users/rodrigo.jpeg', 4.2, 39, 0],
        [2, 'Miguel', 'Moita', 'miguelmoita', 'Tv. dos Lírios 20', 'Póvoa de Varzim', 'Portugal', '4200-123', '+351 911 234 558', 'miguel@gmail.com', 'miguel123', '/../images/users/Miguel.jpg', 3.5, 61, 1],
        [3, 'Clara', 'Sousa', 'clarasousa', 'Av. Estados Unidos 120', 'Esposende', 'Portugal', '3400-123', '+351 921 234 568', 'clara@gmail.com', 'clara123', '/../images/users/clara_sousa.jpeg', 4.8, 28, 1],
        [4, 'Pedro', 'Santos', 'pedrosantos', 'Avenida de Ramalde 398', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'pedro@gmail.com', 'pedro123', '/../images/users/pedro.jpeg', 4.5, 46, 0],
        [5, 'Afonso', 'Castro', 'afonsocastro', 'Senhora da Hora 28', 'Porto', 'Portugal', '4480-123', '+351 961 234 568', 'afonso@gmail.com', 'afonso123','/../images/users/afonso.jpg', 2.5, 102, 0]
    ];

    // Inserir usuários
    User::insertUsers($db, $users);

    echo "Usuários inseridos com sucesso.";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
