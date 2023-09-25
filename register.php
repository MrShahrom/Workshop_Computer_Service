<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form method="post" action="register_process.php">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Почта:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Зарегистрироваться"> 
    </form>
    
    <form action="login.php" method="post">
        <p>Уже зарегистрировались:</p>
        <button type="submit">Войти</button>
    </form>
    
    
</body>
</html>
