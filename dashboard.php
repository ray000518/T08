<?php
// dashboard.php
require 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: index.php");

// 統計數據查詢
$total_reports = $conn->query("SELECT COUNT(*) FROM pollution_reports")->fetch_row()[0];
$pending = $conn->query("SELECT COUNT(*) FROM pollution_reports WHERE status='待處理'")->fetch_row()[0];
$ongoing = $conn->query("SELECT COUNT(*) FROM pollution_reports WHERE status='清潔船派遣中'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>儀表板 - 海洋智慧平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container">
    <h2 class="mb-4">📊 生態監測儀表板 (Dashboard)</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">總通報數</h5>
                    <h1 class="display-4"><?php echo $total_reports; ?></h1>
                    <p class="card-text">累計接收到的海洋污染通報。</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h5 class="card-title">待處理案件</h5>
                    <h1 class="display-4"><?php echo $pending; ?></h1>
                    <p class="card-text">急需指派清潔船的案件。</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">作業中</h5>
                    <h1 class="display-4"><?php echo $ongoing; ?></h1>
                    <p class="card-text">清潔船正在執行清理任務。</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4>快速操作</h4>
        <hr>
        <a href="report_create.php" class="btn btn-outline-primary btn-lg">📸 新增 AI 辨識通報</a>
        <a href="report_list.php" class="btn btn-outline-secondary btn-lg">📋 管理所有通報</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>