<?php
include('dbconfig.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['action'])) {
        $action = $data['action'];
        switch ($action) {
            case 'deleteAnnouncement':
                handleDeleteAnnouncement($data, $conn);
                break;
            case 'updateAnnouncement':
                handleUpdateAnnouncement($data, $conn);
                break;
             case 'deleteContact':
                handleDeleteContact($data, $conn);
                break;
            case 'updateContact':
                handleUpdateContact($data, $conn);
                break;
            case 'deleteEvent':
                handleDeleteEvent($data, $conn);
                break;
            case 'updateEvent':
                handleUpdateEvent($data, $conn);
                break;
            case 'deleteSchedule':
                handleDeleteSchedule($data, $conn);
            case 'updateSchedule':
                handleUpdateSchedule($data, $conn);
            
            //comment
            case 'addComment':
                if(isset($data['post_id'], $data['category'], $data['user'], $data['content'])) {
                    $post_id = $data['post_id'];
                    $category = $data['category'];
                    $user = $data['user'];
                    $content = $data['content'];
                    addComment($conn, $post_id, $category, $user, $content);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Incomplete data for adding comment"]);
                }
                break;
            case 'getComments':
                if(isset($data['post_id'], $data['category'])) {
                    $post_id = $data['post_id'];
                    $category = $data['category'];
                    getComments($conn, $post_id, $category);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Incomplete data for fetching comments"]);
                }
                break;
            default:
                http_response_code(400);
                echo json_encode(["error" => "Invalid action"]);
                break;
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid request"]);
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action'])) {
    if ($_GET['action'] === "getAnnouncements") {
        getAnnouncements($conn);
    } else if ($_GET['action'] === "getContacts") {
        getContacts($conn); 
    } else if ($_GET['action'] === "getEvents") {
        getEvents($conn);
    } else if ($_GET['action'] === "getSchedules") {
        getSchedules($conn); 
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid action"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request method or action not set"]);
}


function addComment($conn, $post_id, $category, $user, $content) {
    $sql = "INSERT INTO comments (post_id, category, user, content) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $post_id, $category, $user, $content);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        http_response_code(201);
        echo json_encode(["message" => "Comment added successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to add comment"]);
    }
}

function getComments($conn, $postId, $category) {
    $query = "SELECT * FROM comments WHERE post_id = $postId AND category = '$category'";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {

        $comments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
        echo json_encode($comments);
    } else {
        echo json_encode([]);
    }
}

function getAnnouncements($conn) {
    $sql = "SELECT * FROM posts WHERE category = 'Announcement' ORDER BY id DESC";
    $result = $conn->query($sql);

    $announcements = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }
    }

    echo json_encode($announcements);
}

function handleDeleteAnnouncement($data, $conn) {
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $sql = "DELETE FROM posts WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Announcement deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error deleting announcement: " . $conn->error]);
    }
}

function handleUpdateAnnouncement($data, $conn) {
    if (!isset($data['id']) || !isset($data['content']) || !isset($data['date']) || !isset($data['category'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $content = $conn->real_escape_string($data['content']);
    $date = $conn->real_escape_string($data['date']);
    $category = $conn->real_escape_string($data['category']);

    $sql = "UPDATE posts SET content = '$content', date = '$date' WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        $updatedData = ["id" => $id, "content" => $content, "date" => $date];
        echo json_encode(["message" => "Announcement updated successfully", "data" => $updatedData]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error updating announcement"]);
    }
}





//contacts

function getContacts($conn) {
    $sql = "SELECT * FROM posts WHERE category = 'Contacts' ORDER BY id DESC";

    $result = $conn->query($sql);

    if ($result) {
        $contacts = [];
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
        echo json_encode($contacts);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error fetching contacts: " . $conn->error]);
    }
}

function handleDeleteContact($data, $conn) {
    error_log(json_encode($data));
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $sql = "DELETE FROM posts WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Contact deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error deleting contact: " . $conn->error]);
    }
}


function handleUpdateContact($data, $conn) {
    if (!isset($data['id']) || !isset($data['content']) || !isset($data['date']) || !isset($data['category'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $content = $conn->real_escape_string($data['content']);
    $date = $conn->real_escape_string($data['date']);
    $category = $conn->real_escape_string($data['category']);

    $sql = "UPDATE posts SET content = '$content', date = '$date' WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        $updatedData = ["id" => $id, "content" => $content, "date" => $date];
        echo json_encode(["message" => "Contact updated successfully", "data" => $updatedData]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error updating contact"]);
    }
}


//events

function getEvents($conn) {
    $sql = "SELECT * FROM posts WHERE category = 'Event' ORDER BY id DESC";

    $result = $conn->query($sql);

    if ($result) {
        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        echo json_encode($events);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error fetching events: " . $conn->error]);
    }
}

function handleDeleteEvent($data, $conn) {
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $category = $conn->real_escape_string($data['category']);
    $sql = "DELETE FROM posts WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Event deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error deleting event: " . $conn->error]);
    }
}

function handleUpdateEvent($data, $conn) {
    if (!isset($data['id']) || !isset($data['content']) || !isset($data['date']) || !isset($data['category'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $content = $conn->real_escape_string($data['content']);
    $date = $conn->real_escape_string($data['date']);
    $category = $conn->real_escape_string($data['category']);

    $sql = "UPDATE posts SET content = '$content', date = '$date' WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        $updatedData = ["id" => $id, "content" => $content, "date" => $date];
        echo json_encode(["message" => "Event updated successfully", "data" => $updatedData]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error updating event"]);
    }
}


//schedules

function getSchedules($conn) {
    $sql = "SELECT * FROM posts WHERE category = 'Schedule' ORDER BY id DESC";

    $result = $conn->query($sql);

    if ($result) {
        $schedules = [];
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
        echo json_encode($schedules);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error fetching Schedules: " . $conn->error]);
    }
}


function handleDeleteSchedule($data, $conn) {
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $category = $conn->real_escape_string($data['category']);
    $sql = "DELETE FROM posts WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Schedule deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error deleting Schedule: " . $conn->error]);
    }
}

function handleUpdateSchedule($data, $conn) {
    if (!isset($data['id']) || !isset($data['content']) || !isset($data['date']) || !isset($data['category'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $content = $conn->real_escape_string($data['content']);
    $date = $conn->real_escape_string($data['date']);
    $category = $conn->real_escape_string($data['category']);

    $sql = "UPDATE posts SET content = '$content', date = '$date' WHERE id = '$id' AND category = '$category'";

    if ($conn->query($sql) === TRUE) {
        $updatedData = ["id" => $id, "content" => $content, "date" => $date];
        echo json_encode(["message" => "Schedule updated successfully", "data" => $updatedData]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error updating Schedule"]);
    }
}