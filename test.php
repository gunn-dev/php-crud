<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=php_crud', 'root', 'root');
    foreach ($pdo->query('SELECT * FROM employees') as $row) {
        echo $row['id'] .'.' .$row['name'].'<br>';
    }
    $pdo= null;
} catch(PDOException $e) {
    print 'Error: '.$e->getMessage().'<br>';
    die();
}