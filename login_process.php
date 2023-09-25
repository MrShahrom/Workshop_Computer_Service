<?php
session_start(); 
include_once 'logs/log.php';
include_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $role = $user["role"];

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === "admin") {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: index.php");
                
            }
        } else {
            echo "Ошибка входа. Пожалуйста, проверьте имя пользователя и пароль.";
            writeToLog('Ошибка входа: Неверное имя пользователя или пароль для пользователя ' . $username);
        }
    } catch (PDOException $e) {
        writeToLog('Ошибка базы данных: ' . $e->getMessage());
        die("Ошибка: " . $e->getMessage());
    }
}
?>
