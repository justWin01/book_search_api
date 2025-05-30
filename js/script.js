function searchBooks() {
  const query = document.getElementById("searchQuery").value.trim();
  const results = document.getElementById("results");
  results.innerHTML = ""; // Clear previous results

  if (!query) {
    results.innerHTML = "<p class='text-danger'>Please enter a search term.</p>";
    return;
  }

  fetch(`https://openlibrary.org/search.json?q=${encodeURIComponent(query)}`)
    .then(res => {
      if (!res.ok) {
        throw new Error(`Server error: ${res.status}`);
      }
      return res.json();
    })
    .then(data => {
      if (!data.docs || data.docs.length === 0) {
        results.innerHTML = "<p class='text-danger'>No books found. Try a different keyword.</p>";
        return;
      }

      data.docs.slice(0, 10).forEach(book => {
        const title = book.title || "No title";
        const author = (book.author_name && book.author_name[0]) || "Unknown";
        const coverId = book.cover_i;
        const coverImg = coverId
          ? `https://covers.openlibrary.org/b/id/${coverId}-M.jpg`
          : "https://via.placeholder.com/128x180?text=No+Cover";

        const html = `
          <div class="col-md-4">
            <div class="card p-3 h-100">
              <img src="${coverImg}" alt="Cover of ${title}" class="card-img-top mb-3" style="height: 250px; object-fit: contain;" />
              <h5>${title}</h5>
              <p><strong>Author:</strong> ${author}</p>
              <button class="btn btn-outline-primary" onclick="saveBook('${title.replace(/'/g, "\\'")}', '${author.replace(/'/g, "\\'")}')">Save</button>
            </div>
          </div>`;
        results.innerHTML += html;
      });
    })
    .catch(error => {
      console.error("Search failed:", error);
      results.innerHTML = `<p class='text-danger'>An error occurred while searching. Please try again later.</p>`;
    });
}


document.getElementById('searchQuery').addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();
    searchBooks();
  }
});

function saveBook(title, author) {
  const formData = new FormData();
  formData.append("title", title);
  formData.append("author", author);

  fetch("save_book.php", {
    method: "POST",
    body: formData
  })
  .then(response => {
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    return response.text();
  })
  .then(msg => alert(msg))
  .catch(error => alert("Save failed: " + error.message));
}

function deleteBook(id) {
  if (!confirm("Are you sure you want to delete this book?")) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('delete_book.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => {
    alert(result);
    location.reload();
  })
  .catch(error => {
    console.error('Error:', error);
    alert("An error occurred while deleting the book.");
  });
}
