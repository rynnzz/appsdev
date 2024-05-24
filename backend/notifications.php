<?php
include('dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $content = $_POST['content'];

    // Insert the post into the database
    $sql = "INSERT INTO posts (content) VALUES ('$content')";
    if ($conn->query($sql) === TRUE) {
        // Post inserted successfully, now insert a notification
        $notification_message = "New post: $content";
        $sql = "INSERT INTO notifications (message) VALUES ('$notification_message')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error creating notification: " . $conn->error;
        }
    } else {
        echo "Error creating post: " . $conn->error;
    }
}

// Fetch notifications from the database
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = $conn->query($sql);

$notifications = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = array(
            'id' => $row['id'],
            'message' => $row['message'],
            'created_at' => $row['created_at']
        );
    }
}

// Close database connection
$conn->close();

// Return notifications as JSON
header('Content-Type: application/json');
echo json_encode($notifications);