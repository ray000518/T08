<?php
require 'db.php';

// 如果已經登入，直接導向儀表板 (稍後製作 dashboard.php)
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 簡單的驗證 (為了教學簡化，這裡使用明碼比對)
    // 實務上請使用 password_verify()
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // 登入成功跳轉
        exit;
    } else {
        $error = "帳號或密碼錯誤";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>登入 - 海洋智慧監控平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { width: 100%; max-width: 400px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background: white; }
        .brand-title { color: #0d6efd; font-weight: bold; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="brand-title">海洋智慧監控平台</h3>
    <p class="text-center text-muted">Marine Intelligence Platform</p>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">管理員帳號</label>
            <input type="text" name="username" class="form-control" required placeholder="admin">
        </div>
        <div class="mb-3">
            <label class="form-label">密碼</label>
            <input type="password" name="password" class="form-control" required placeholder="1234">
        </div>
        <button type="submit" class="btn btn-primary w-100">登入系統</button>
    </form>
</div>

</body>
</html>