<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">🌊 海洋智慧平台</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">儀表板 (生態監測)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="report_list.php">污染通報管理</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="report_create.php">新增通報 (AI 模擬)</a>
        </li>
      </ul>
      <span class="navbar-text text-white me-3">
        你好, <?php echo $_SESSION['username'] ?? 'User'; ?>
      </span>
      <a href="logout.php" class="btn btn-light btn-sm">登出</a>
    </div>
  </div>
</nav>