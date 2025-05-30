<?php
include 'db.php';

function getCoverURL($title) {
    $query = urlencode($title);
    $url = "https://openlibrary.org/search.json?title={$query}&limit=1";

    $json = file_get_contents($url);
    if (!$json) return null;

    $data = json_decode($json, true);
    if (isset($data['docs'][0]['cover_i'])) {
        $coverId = $data['docs'][0]['cover_i'];
        return "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg";
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Saved Books / Favorites</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
				background-size: cover;
				background-position: center;
				background-repeat: no-repeat;
				min-height: 100vh;
    }
    .book-cover {
      height: 200px;
      object-fit: contain;
      width: 100%;
      background-color: #f0f0f0; 
    }
    .saved-section {
      background-color: #ffffff; 
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <!-- Begin saved-section container -->
    <div class="saved-section">

      <!-- Header and back button are now inside the container -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Saved Books / Favorites</h2>
        <a href="search.html" class="btn btn-primary">&larr; Back to Search</a>
      </div>

      <?php
      $query = "SELECT * FROM books ORDER BY id DESC";
      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) {
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        while ($row = $result->fetch_assoc()) {
          $coverURL = getCoverURL($row['title']);
          ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <?php if ($coverURL): ?>
                <img src="<?= $coverURL ?>" alt="Book Cover" class="card-img-top book-cover">
              <?php else: ?>
                <div class="card-img-top book-cover d-flex align-items-center justify-content-center text-muted">No Cover Image</div>
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                <p class="card-text"><strong>Author:</strong> <?= htmlspecialchars($row['author']) ?></p>
                <button onclick="deleteBook(<?= $row['id'] ?>)" class="btn btn-danger mt-2">Delete</button>
              </div>
            </div>
          </div>
          <?php
        }
        echo '</div>';
      } else {
        echo '<p class="text-center fs-5">No saved books found. Go back to <a href="search.html">search</a> and save some!</p>';
      }

      $conn->close();
      ?>
    </div> <!-- End saved-section -->
  </div>

  <!-- JavaScript to handle book deletion -->
  <script>
  function deleteBook(id) {
    if (!confirm("Are you sure you want to delete this book?")) return;

    fetch('delete_book.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload(); // Refresh to update the list
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Something went wrong while deleting the book.");
    });
  }
  </script>
</body>
</html>
