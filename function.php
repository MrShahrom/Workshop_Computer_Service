<?php
include_once('dbconnect.php');
include_once('logs/log.php');

function fetchDataFromDatabase($dbConnection, $tableName) {
    try {
        $query = "SELECT * FROM $tableName";
        $statement = $dbConnection->prepare($query);
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        writeToLog('Успешно извлечены данные из таблицы ' . $tableName);
        
        return $data;
    } catch (PDOException $e) {
        
        writeToLog('Ошибка базы данных: ' . $e->getMessage());
        
        die("Ошибка базы данных: " . $e->getMessage());
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tableName = "reviews";
    
    $data = fetchDataFromDatabase($conn, $tableName);
    
    foreach ($data as $row) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Имя: " . $row['firstname']." ";
        echo "Имя: " . $row['lastname'] . "<br>";
        echo "Имя: " . $row['mark'] . "<br>";
        echo "Email: " . $row['text'] . "<br><br>";
    }
    
    $conn = null;
} catch (PDOException $e) {
    
    writeToLog('Ошибка подключения к базе данных: ' . $e->getMessage());
    
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
