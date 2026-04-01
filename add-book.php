<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $condition = $_POST['condition'] ?? 'good';

    if (empty($title)) {
        $error = "Название книги обязательно";
    } elseif (empty($author)) {
        $error = "Автор обязателен";
    } else {
        $books = loadJSON(BOOKS_FILE);

        $newBook = [
            'id' => time(),
            'user_id' => $_SESSION['user_id'],
            'title' => e($title),
            'author' => e($author),
            'description' => e($description),
            'category' => e($category),
            'year' => $year,
            'condition' => e($condition),
            'image' => '',
            'status' => 'available',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $books[] = $newBook;
        saveJSON(BOOKS_FILE, $books);

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo"><?= SITE_NAME ?></a>
                <ul class="nav-links">
                    <li><a href="index.php">Каталог</a></li>
                    <li><a href="profile.php">Кабинет</a></li>
                    <li><a href="logout.php">Выход</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Добавить книгу</h1>

            <?php if ($error): ?>
                <div class="message message-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="add-book.php">
                <div class="form-group">
                    <label>Название *</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Автор *</label>
                    <input type="text" name="author" required>
                </div>

                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label>Категория</label>
                    <select name="category">
                        <option value="">Выберите категорию</option>
                        <option value="Художественная">Художественная</option>
                        <option value="Научная">Научная</option>
                        <option value="Программирование">Программирование</option>
                        <option value="Учебная">Учебная</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Год издания</label>
                    <input type="number" name="year" min="1900" max="2026">
                </div>

                <div class="form-group">
                    <label>Состояние</label>
                    <select name="condition">
                        <option value="Новая">Новая</option>
                        <option value="Хорошее">Хорошее</option>
                        <option value="Удовлетворительное">Удовлетворительное</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Добавить</button>
                <a href="index.php" class="btn">Отмена</a>
            </form>
        </div>
    </main>
</body>
</html>