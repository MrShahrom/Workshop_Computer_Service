<?php
include_once "dbconnect.php";
include_once "logs/log.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mark = $_POST['mark'];
    $text = $_POST['text'];

    $sql = "INSERT INTO reviews (firstname, lastname, mark, text) VALUES (:firstname, :lastname, :mark, :text)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':mark', $mark);
    $stmt->bindParam(':text', $text);
    if ($stmt->execute()) {
        echo "Данные успешно отправлены!";
        writeToLog("Запись отзыва успешно добавлена в базу данных.");
    } else {
        $errorMessage = "Ошибка при выполнении запроса: " . implode(" ", $stmt->errorInfo());
        echo $errorMessage;
        writeToLog($errorMessage);
    }
} catch(PDOException $e) {
    $errorMessage = "Ошибка: " . $e->getMessage();
    echo $errorMessage;
    writeToLog($errorMessage);
} finally {
    $conn = null;
}

?>
