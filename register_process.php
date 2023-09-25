<?php
include_once 'dbconnect.php';
include_once 'logs/log.php';  // Подключаем файл с функцией writeToLog

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];
        $role = "user"; 

        // Вставка данных в базу данных
        $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email); 
        $stmt->bindParam(":role", $role);
        $stmt->execute();

        echo "Регистрация успешна!";

        // Записываем информацию о регистрации в лог
        writeToLog("Пользователь зарегистрирован: Имя пользователя - $username, Email - $email");

    } catch (PDOException $e) {
        writeToLog('Ошибка при регистрации пользователя: ' . $e->getMessage());
        die("Ошибка: " . $e->getMessage());
    }
}
?>
