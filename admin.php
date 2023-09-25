<?php
session_start();
include_once 'dbconnect.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    die();
}

// Создание новой записи
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

// Обновление записи
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}
$userToUpdate = []; 
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $editId);
    $stmt->execute();
    
    $userToUpdate = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Удаление записи
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Админ-панель CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Админ-панель CRUD</h1>
        
        <!-- Форма для создания и обновления записи -->
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="username" value="<?php echo isset($_GET['edit']) ? $userToUpdate['username'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_GET['edit']) ? $userToUpdate['email'] : ''; ?>" required>
            </div>
            <?php if (isset($_GET['edit'])): ?>
                <button type="submit" class="btn btn-primary" name="update">Обновить</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="create">Создать</button>
            <?php endif; ?>
        </form>

        <!-- Таблица для отображения пользователей -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-warning">Редактировать</a>
                            <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
