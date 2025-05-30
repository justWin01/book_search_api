<?php
include 'db.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    http_response_code(400);
    echo "Invalid ID.";
    exit();
}

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo "Failed to prepare statement: " . $conn->error;
    exit();
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo "Execute failed: " . $stmt->error;
    exit();
}

if ($stmt->affected_rows > 0) {
    echo "Book deleted successfully!";
} else {
    echo "No book found with that ID.";
}

$stmt->close();
$conn->close();
?>
