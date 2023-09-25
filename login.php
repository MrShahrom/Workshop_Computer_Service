<!DOCTYPE html>
<html>
<head>
    <title>Аутентификация</title>
</head>
<body>
    <h2>Аутентификация</h2>
    <form method="post" action="login_process.php">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Войти">
    </form>
</body>
</html>
