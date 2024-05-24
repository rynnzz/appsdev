<?php

include ('dbconfig.php');

if (isset($_POST['action']) && $_POST['action'] === 'getComments') {
  // Assuming you have a function to sanitize input data to prevent SQL injection
  $postId = ($_POST['post_id']);
  $category = ($_POST['category']);
  
  // Query to fetch comments based on postId and category
  $query = "SELECT * FROM comments WHERE post_id = $postId AND category = '$category'";
  
  // Execute the query
  $result = mysqli_query($connection, $query);
  
  // Check if there are any rows returned
  if (mysqli_num_rows($result) > 0) {
      // Fetch and return comments as JSON
      $comments = [];
      while ($row = mysqli_fetch_assoc($result)) {
          $comments[] = $row;
      }
      echo json_encode($comments);
  } else {
      // No comments found
      echo json_encode([]);
  }
} else {
  // Invalid action
  echo json_encode(['error' => 'Invalid action']);
}
?>
