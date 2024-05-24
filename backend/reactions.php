<?php

include ('dbconfig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'];

    if ($action == 'getReactions') {
        $postId = $data['post_id'];
        $user = $data['user'];
        getReactions($postId, $user);
    } elseif ($action == 'addReaction') {
        $postId = $data['post_id'];
        $user = $data['user'];
        $reactionType = $data['reaction'];
        addReaction($postId, $user, $reactionType);
    } elseif ($action == 'deleteReaction') {
        $postId = $data['post_id'];
        $user = $data['user'];
        deleteReaction($postId, $user);
    }
}

function getReactions($postId, $user) {
    global $conn;

    // Fetch reactions count
    $sql = "SELECT reaction_type, COUNT(*) as count FROM reactions WHERE post_id = ? GROUP BY reaction_type";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $reactions = [];
    while ($row = $result->fetch_assoc()) {
        $reactions[$row['reaction_type']] = $row['count'];
    }
    $stmt->close();

    // Fetch user's reaction
    $sql = "SELECT reaction_type FROM reactions WHERE post_id = ? AND user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $postId, $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $userReaction = $result->fetch_assoc();
    $stmt->close();

    $userReactionType = $userReaction ? $userReaction['reaction_type'] : null;

    echo json_encode(['reactions' => $reactions, 'userReaction' => $userReactionType]);
}

function addReaction($postId, $user, $reactionType) {
    global $conn;

    // Remove existing reaction
    $sql = "DELETE FROM reactions WHERE post_id = ? AND user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $postId, $user);
    $stmt->execute();
    $stmt->close();

    // Add new reaction
    $sql = "INSERT INTO reactions (post_id, user, reaction_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iss', $postId, $user, $reactionType);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error adding reaction']);
    }
    $stmt->close();
}

function deleteReaction($postId, $user) {
    global $conn;

    $sql = "DELETE FROM reactions WHERE post_id = ? AND user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $postId, $user);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Reaction not found']);
    }
    $stmt->close();
}

?>
