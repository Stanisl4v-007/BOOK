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

$id = $_GET['id'] ?? 0;
$books = loadJSON(BOOKS_FILE);

foreach ($books as $key => $book) {
    if ($book['id'] == $id) {
        if ($book['user_id'] === $_SESSION['user_id']) {
            unset($books[$key]);

            if (!empty($book['image']) && file_exists($book['image'])) {
                unlink($book['image']);
            }
        }
        break;
    }
}

$books = array_values($books);
saveJSON(BOOKS_FILE, $books);

header("Location: profile.php");
exit;
?>