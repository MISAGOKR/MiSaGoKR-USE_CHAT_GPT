<?php include 'header.php'; ?>

<?php
  // 데이터베이스 연결 설정
  include 'includes/db_connect.php';

  // 게시물 목록 가져오기
  $query = "SELECT * FROM posts ORDER BY created_at DESC";
  $result = mysqli_query($connection, $query);

  // 게시물 목록을 반복하여 출력
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $post_id = $row['id'];
      $post_title = $row['title'];
      $post_content = $row['content'];
      $post_date = $row['created_at'];
      $post_author = $row['author'];
      
      // 게시물 출력
      echo "<div class='post'>";
      echo "<h2><a href='view_post.php?id=$post_id'>$post_title</a></h2>";
      echo "<p>$post_content</p>";
      echo "<p class='meta'>Posted by $post_author on $post_date</p>";
      echo "</div>";
    }
  } else {
    echo "<p>No posts found.</p>";
  }

  // 데이터베이스 연결 해제
  mysqli_close($connection);
?>

<?php include 'footer.php'; ?>
