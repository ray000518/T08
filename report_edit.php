<?php
// report_edit.php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$msg = "";

// 處理更新
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $location = $_POST['location'];
    
    $sql = "UPDATE pollution_reports SET status = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $location, $id);
    
    if ($stmt->execute()) {
        header("Location: report_list.php");
        exit;
    } else {
        $msg = "更新失敗";
    }
}

// 讀取舊資料
$sql = "SELECT * FROM pollution_reports WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("查無此資料");
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>處理通報 - 海洋智慧平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">⚙️ 通報處理與調度 (ID: <?php echo $row['id']; ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if($row['image_path']): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo $row['image_path']; ?>" class="img-fluid rounded border" style="max-height: 200px;">
                            <p class="text-muted mt-1">AI 辨識結果：<?php echo $row['pollutant_type']; ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">地點修正</label>
                            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($row['location']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">清理進度狀態 (題目3)</label>
                            <select name="status" class="form-select">
                                <option value="待處理" <?php echo ($row['status'] == '待處理') ? 'selected' : ''; ?>>待處理 (Pending)</option>
                                <option value="清潔船派遣中" <?php echo ($row['status'] == '清潔船派遣中') ? 'selected' : ''; ?>>清潔船派遣中 (Dispatching)</option>
                                <option value="已結案" <?php echo ($row['status'] == '已結案') ? 'selected' : ''; ?>>已結案 (Completed)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">更新狀態</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>