<?php
// db.php
$host = 'localhost';
$db   = 'marine_platform';
$user = 'root';
$pass = ''; // XAMPP 預設密碼為空，若您有設定請修改

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定編碼，避免中文字亂碼
$conn->set_charset("utf8mb4");

// 開啟 Session (所有頁面都需要)
session_start();
?>