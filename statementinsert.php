<?php
include_once "dbconnect.php";
include_once "logs/log.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $message = $_POST['message'];

    $sql = "INSERT INTO statement (firstname, lastname, email, phone_number, message) VALUES (:firstname, :lastname, :email, :phone_number, :message)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':message', $message);
    
    if ($stmt->execute()) {
        echo "Данные успешно отправлены!";
        
        writeToLog('Успешно добавлена новая запись в таблицу statement.');
    } else {
        echo "Ошибка при выполнении запроса: " . implode(" ", $stmt->errorInfo());
        
        writeToLog('Ошибка при выполнении запроса: ' . implode(" ", $stmt->errorInfo()));
    }
} catch(PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
    
    writeToLog('Ошибка: ' . $e->getMessage());
} finally {
    $conn = null;
}
?>
