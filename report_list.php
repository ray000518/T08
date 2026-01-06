<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: index.php");

// 撈取所有資料
$sql = "SELECT * FROM pollution_reports ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>通報管理 - 海洋智慧平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 海洋污染通報清單</h2>
        <a href="report_create.php" class="btn btn-primary">+ 新增通報 (模擬 AI 辨識)</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>影像預覽</th>
                        <th>地點</th>
                        <th>AI 辨識狀態 (題目1)</th>
                        <th>清理進度 (題目3)</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td>
                            <?php if($row['image_path']): ?>
                                <img src="<?php echo $row['image_path']; ?>" style="height: 50px; border-radius: 5px;">
                            <?php else: ?>
                                <span class="text-muted">無影像</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                            <span class="badge bg-info text-dark"><?php echo $row['ai_status']; ?></span><br>
                            <small class="text-muted"><?php echo $row['pollutant_type']; ?></small>
                        </td>
                        <td>
                            <?php 
                                $status = $row['status'];
                                $badgeClass = match($status) {
                                    '已結案' => 'bg-success',
                                    '清潔船派遣中' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                        </td>
                        <td>
                            <a href="report_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">處理/調度</a>
                            <a href="report_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('確定刪除？');">刪除</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>