<?php
include 'db.php';

$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';

// Quick exit if empty inputs
if (empty($title) || empty($author)) {
    http_response_code(400);
    exit('Missing title or author');
}

$stmt = $conn->prepare("INSERT INTO books (title, author) VALUES (?, ?)");
if (!$stmt) {
    http_response_code(500);
    exit('DB error');
}

$stmt->bind_param("ss", $title, $author);

if (!$stmt->execute()) {
    http_response_code(500);
    exit('DB error');
}

// Just return 200 status with no message to reduce payload
http_response_code(200);
echo "Saved to Databased.";
$stmt->close();
$conn->close();
?>
