<?php
session_start();
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Заполните все обязательные поля";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный email";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов";
    } else {
        $users = loadJSON(USERS_FILE);

        foreach ($users as $user) {
            if ($user['email'] == $email) {
                $error = "Пользователь с таким email уже существует!";
                break;
            }
        }

        if (empty($error)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $newUser = [
                'id' => time(),
                'name' => e($name),
                'email' => e($email),
                'password' => $passwordHash,
                'phone' => e($phone),
                'city' => e($city),
                'registered_at' => date('Y-m-d H:i:s')
            ];

            $users[] = $newUser;
            saveJSON(USERS_FILE, $users);

            $success = "Регистрация успешна! Теперь вы можете войти.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head> 
    <meta charset="UTF-8">
    <title>Регистрация - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body> 
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo"> <?= SITE_NAME ?></a>
                <ul class="nav-links">
                    <li><a href="index.php">Каталог</a></li>
                    <li><a href="login.php">Вход</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Регистрация</h1>

            <?php if ($error): ?>
                <div class="message message-error"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="message message-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="form-group">
                    <label>Имя *</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required> 
                </div>

                <div class="form-group">
                    <label>Пароль *</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone">
                </div>

                <div class="form-group">
                    <label>Город</label>
                    <input type="text" name="city">
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="login.php" class="btn">Уже есть аккаунт?</a>
            </form>
        </div>
    </main>
</body>
</html>
