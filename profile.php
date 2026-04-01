<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$books = loadJSON(BOOKS_FILE);
$myBooks = array_filter($books, function($book) {
    return $book['user_id'] === $_SESSION['user_id'];
});
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo"><?= SITE_NAME ?></a>
                <ul class="nav-links">
                    <li><a href="index.php">Каталог</a></li>
                    <li><a href="add-book.php">Добавить</a></li>
                    <li><a href="logout.php">Выход</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Личный кабинет</h1>
            <p>Добро пожаловать, <?= e($_SESSION['user_name']) ?>!</p>

            <h2>Мои книги</h2>

            <div class="books-grid">
                <?php foreach ($myBooks as $book): ?>
                <div class="book-card">
                    <h3><?= e($book['title']) ?></h3>
                    <p class="author"><?= e($book['author']) ?></p>
                    <p class="status">Статус: <?= e($book['status']) ?></p>
                    <div class="actions">
                        <a href="edit-book.php?id=<?= $book['id'] ?>" class="btn btn-primary">Изменить</a>
                        <a href="delete-book.php?id=<?= $book['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Удалить книгу?')">Удалить</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($myBooks)): ?>
                <p>У вас пока нет книг. <a href="add-book.php">Добавьте первую!</a></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>