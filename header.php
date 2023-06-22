<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Community Board</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>
<body>

<?php
  // 세션 시작
  session_start();

  // 로그인 여부 확인
  $is_logged_in = false;
  if (isset($_SESSION['user_id'])) {
    $is_logged_in = true;
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
  }
?>

<header>
  <h1>Community Board</h1>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <?php if ($is_logged_in): ?>
        <li><a href="create_post.php">Create Post</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main>
