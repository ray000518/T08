<?php
// report_create.php
require 'db.php';

// 權限檢查
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $pollutant_type = $_POST['pollutant_type'];
    
    // 圖片上傳處理
    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        // 確保 uploads 資料夾存在
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // 為了避免檔名重複，加上時間戳記
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    // --- 模擬 AI 辨識邏輯 (題目1) ---
    // 假設系統自動辨識完成，標記為 '已辨識'
    $ai_status = "AI 已辨識"; 

    // 寫入資料庫
    $sql = "INSERT INTO pollution_reports (location, pollutant_type, image_path, ai_status, status) VALUES (?, ?, ?, ?, '待處理')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $location, $pollutant_type, $image_path, $ai_status);

    if ($stmt->execute()) {
        header("Location: report_list.php"); // 成功後回列表
        exit;
    } else {
        $msg = "新增失敗: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增通報 - 海洋智慧平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📸 上傳污染影像 (模擬 AI 辨識)</h4>
                </div>
                <div class="card-body">
                    <?php if($msg): ?><div class="alert alert-danger"><?php echo $msg; ?></div><?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">發現地點 (Location)</label>
                            <input type="text" name="location" class="form-control" required placeholder="例如：高雄港第三號碼頭">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">污染物類型 (由 AI 輔助判斷)</label>
                            <select name="pollutant_type" class="form-select">
                                <option value="塑膠漂浮物">塑膠漂浮物 (Plastic)</option>
                                <option value="油汙洩漏">油汙洩漏 (Oil Spill)</option>
                                <option value="廢棄漁網">廢棄漁網 (Ghost Net)</option>
                                <option value="其他垃圾">其他垃圾 (Others)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">現場照片上傳</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <div class="form-text">上傳後系統將自動執行 AI 辨識演算法。</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">開始辨識並通報</button>
                            <a href="report_list.php" class="btn btn-secondary">返回列表</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>