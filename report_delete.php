<?php
// report_delete.php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // (選擇性) 如果要順便刪除圖片檔案，可以先查詢路徑再 unlink()
    
    $stmt = $conn->prepare("DELETE FROM pollution_reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: report_list.php");
exit;
?>