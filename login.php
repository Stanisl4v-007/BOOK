<?php 
session_start();
require_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Введите email и пароль";
    } else {
        $users = loadJSON(USERS_FILE);
        $found = false;

        foreach ($users as $user) {
            if ($user['email'] === $email) {

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    header("Location: index.php");
                    exit;
                 } else {
                    $error = "Неверный пароль";
                 }
                 $found = true;
                 break;
             }
        }

        if (!$found) {
            $error = "Пользователь не найден";
        }
    }    

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - <?=  SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo"> <?=  SITE_NAME ?></a> 
                <ul class="nav-links">
                    <li><a href="index.php">Каталог</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Вход в систему</h1>

            <?php if ($error): ?>
                <div class="message message-error"><?=  $error ?></div> 
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Войти</button>
                <a href="register.php" class="btn">Нет аккаунта?</a>
            </form>
        </div>
    </main>
</body>
</html>