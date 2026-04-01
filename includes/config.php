<?php

define('SITE_NAME', 'Сайт по обмену книгами');
define('SITE_URL', 'http://localhost:8000/');  

define('USERS_FILE', __DIR__ . '/../data/users.json');
define('BOOKS_FILE', __DIR__ . '/../data/books.json');
define('UPLOAD_DIR', __DIR__ . '/../uploads/books/');

function loadJSON($file) {
    if (file_exists($file)) {
        $data = file_get_contents($file);
        return json_decode($data, true) ?? [];
    }
    return [];
}

function saveJSON($file, $data) {
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>