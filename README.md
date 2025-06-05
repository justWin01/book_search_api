

📚 BookAPI Web Application
A web application that allows users to search for books using the Open Library API and manage a list of favorite books. The app includes search, display, and favorites management features with a backend powered by PHP and MySQL.

🚀 Features
🔍 Book Search: Search for books by title, author, or subject.

📄 Book Details: View key information including title, author, publish year, and cover.

❤️ Favorites: Add and remove books from your personal favorites list.

🗃️ Database Integration: Store and retrieve favorites using a MySQL database.

🌐 Open Library API: Utilizes the Open Library public API for fetching book data.

🛠️ Tech Stack
Frontend: HTML, CSS, JavaScript
Backend: PHP
Database: MySQL
API: Open Library API

📂 Project Structure
bash
Copy
Edit
/bookapi
│
|-/css
  |style.css
|-/js
  |script.js
| 
├── about.html       #About this web
├── db.php           # Database connection settings.
├── delete_book.php  # Delete saved book.
├── index.html    # # Home interface
├── save_book.php   # Adds book to favorites
├── search.html         # Search book
|──view_saved.        # Displays favorite books
└── README.md              # Project documentation
⚙️ Setup Instructions
Clone the Repository

bash
Copy
Edit
git clone https://github.com/your-username/bookapi.git
cd bookapi
Set Up MySQL Database

Create a database (e.g., bookdb)

Create a favorites table:

sql
Copy
Edit
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  cover_url VARCHAR(255)
);
Configure Database
Update db.php with your MySQL credentials.

Run the App

Place the folder in your local server directory (e.g., htdocs for XAMPP)

Access it at [http://localhost/bookapi/index.html](http://localhost/Final-Project---Integrative-Programming_booksearch/book_search_api/index.html)

📡 API Reference
Base URL: https://openlibrary.org/search.json

Example Usage:

pgsql
Copy
Edit
https://openlibrary.org/search.json?q=harry+potter
