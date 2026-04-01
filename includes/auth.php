<?php
session_start();

function reqireAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function isOwner($userId) {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId;
}
?>