<?php
session_start();
require_once 'includes/config.php';

$books = loadJSON(BOOKS_FILE);

$availableBooks = array_filter($books, function($book) {
    return $book['status'] === 'available';
});
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Разработка сайта по обмену книгами</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>    
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo">Разработка сайта по обмену книгами</a>
                <ul class="nav-links">
                    <li><a href="index.php">Каталог</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">Кабинет</a></li>
                        <li><a href="add-book.php">Добавить</a></li>
                        <li><a href="logout.php">Выход</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Вход</a></li>
                        <li><a href="register.php">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Каталог книг для обмена</h1>

            <div class="books-grid">
                <?php foreach ($availableBooks as $book): ?>
                <div class="book-card">
                    <h3><?=  e($book['title']) ?></h3>
                    <p class="author"><?=  e($book['author']) ?></p>
                    <p class="description"><?=  e($book['description']) ?></p>
                    <p class="condition">Состояние: 
                        <?php
                        $condition = $book['condition'];
                        if ($condition === 'new' || $condition === "Новая") echo 'Новая';
                        elseif ($condition === 'good' || $condition === 'Хорошее') echo 'хорошее';
                        elseif ($condition === 'satisfactory' || $condition === 'Удовлетворительное') echo 'Удовлетворительное';
                        else echo e($condition);
                        ?>
                    </p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="mailto:user@example.com" class="btn btn-primary">Связаться</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Войти для связи</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($availableBooks)): ?>
                <p class="no-books">Пока нет книг для обмена. Будьте первыми</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>