<?php
$host = 'localhost';
$dbname = 'librarydatabase';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    $tableExists = $pdo->query("SHOW TABLES LIKE 'books'")->rowCount() > 0;
    
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function bookExists($title, $author) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM books WHERE title = ? AND author = ?");
    $stmt->execute([$title, $author]);
    return $stmt->fetch() ? true : false;
}

function addBook($title, $author, $publish_house = '', $publishing_date = '', $category = '') {
    global $pdo;
    
    // نcheck إذا كل الحقول المطلوبة مملوءة
    if (empty($title) || empty($author) || empty($publish_house) || empty($category)) {
        return "Please fill in all required fields!";
    }
    
    if (bookExists($title, $author)) {
        return "Book already exists in the library!";
    }
    
    // بس الـ date هو اللي نخليه null لو فاضي
    if (empty($publishing_date)) {
        $publishing_date = null;
    }
    
    $stmt = $pdo->prepare("INSERT INTO books (title, author, publish_house, publishing_date, category) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$title, $author, $publish_house, $publishing_date, $category])) {
        return "Book added successfully!";
    }
    return "Error adding book!";
}
function deleteBook($title, $author) {
    global $pdo;
    
    if (!bookExists($title, $author)) {
        return "Book not found in the library!";
    }
    
    $stmt = $pdo->prepare("DELETE FROM books WHERE title = ? AND author = ?");
    if ($stmt->execute([$title, $author])) {
        return "Book deleted successfully!";
    }
    return "Error deleting book!";
}

function viewBooks() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchBooks($searchTerm) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ? OR publish_house LIKE ? ORDER BY id DESC");
    $searchPattern = "%$searchTerm%";
    $stmt->execute([$searchPattern, $searchPattern, $searchPattern, $searchPattern]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// معالجة الفورمات
$message = '';
$books = [];
$show_add_form = false;
$show_delete_form = false;
$show_edite_form = false;


try {
    $books = viewBooks();
    
    // استخدام GET parameters علشان نظهر الفورمات
    if (isset($_GET['show_form'])) {
        if ($_GET['show_form'] === 'add') {
            $show_add_form = true;
        } elseif ($_GET['show_form'] === 'delete') {
            $show_delete_form = true;
        }
        elseif ($_GET['show_form'] === 'edite') {
            $show_edite_form = true;
        }
    }

    // معالجة البحث
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'] ?? '';
        $books = searchBooks($searchTerm);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_book'])) {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $publish_house = $_POST['publish_house'] ?? '';
            $publishing_date = $_POST['publishing_date'] ?? '';
            $category = $_POST['category'] ?? '';
            
            if (!empty($title) && !empty($author)) {
                $message = addBook($title, $author, $publish_house, $publishing_date, $category);
                $books = viewBooks(); // تحديث البيانات
            } else {
                $message = "Please fill in all required fields!";
                $show_add_form = true;
            }
        }
        
        if (isset($_POST['delete_book'])) {
            $title = $_POST['delete_title'] ?? '';
            $author = $_POST['delete_author'] ?? '';
            
            if (!empty($title) && !empty($author)) {
                $message = deleteBook($title, $author);
                $books = viewBooks(); // تحديث البيانات
            } else {
                $message = "Please fill in all required fields!";
                $show_delete_form = true;
            }
        }
        //edite section
        if (isset($_POST['edite_book'])) {
            $title = $_POST['edite_title'] ?? '';
            $author = $_POST['edite_author'] ?? '';
            $new_title = $_POST['edite_title'] ?? '';
            $new_author = $_POST['new_author'] ?? '';
            $new_publish_house = $_POST['new_publish_house'] ?? '';
            $new_publishing_date = $_POST['new_publishing_date'] ?? '';
            $new_category = $_POST['new_category'] ?? '';

            if (!empty($title) && !empty($author)) {
                //to set the update fields
                $fields = [];
                $params = [];

                if (!empty($new_title)) {
                    $fields[] = "title = ?";
                    $params[] = $new_title;
                }
                if (!empty($new_author)) {
                    $fields[] = "author = ?";
                    $params[] = $new_author;
                }
                if (!empty($new_publish_house)) {
                    $fields[] = "publish_house = ?";
                    $params[] = $new_publish_house;
                }
                if (!empty($new_publishing_date)) {
                    $fields[] = "publishing_date = ?";
                    $params[] = $new_publishing_date;
                }
                if (!empty($new_category)) {
                    $fields[] = "category = ?";
                    $params[] = $new_category;
                }

                if (count($fields) > 0) {
                    $params[] = $title;
                    $params[] = $author;
                    $sql = "UPDATE books SET " . implode(", ", $fields) . " WHERE title = ? AND author = ?";
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute($params)) {
                        $message = "Book updated successfully!";
                    } else {
                        $message = "Error updating book!";
                    }
                } else {
                    $message = "No new data provided for update!";
                }
                $books = viewBooks(); 
            } else {
                $message = "Please provide the title and author of the book to edit!";
            }
        }
   $books = viewBooks();
        }  

} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
}
?>

<!--html part-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background: #8b4a5c;
            color: white;
            border-radius: 8px;
        }
        .message {
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .search-box {
            display: flex;
            gap: 10px;
        }
        .search-box input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover { opacity: 0.9; }
        .add-btn { background: #a36b7d; }
        .delete-btn { background: #a36b7d; }
        .search-btn { background: #a36b7d; }
        .close-btn { background: #6c757d; }
        
        
        .add-form, .delete-form, .edite-form {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .show-form {
            display: block !important;
        }
        
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .book-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .book-title {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .book-author {
            color: #666;
            font-style: italic;
        }
        .search-results {
            margin: 15px 0;
            padding: 10px;
            background: #e9ecef;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MY LIBRARY</h1>
            <p>Manage your book collection easily</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>


        <div class="actions-bar">
            <div class="search-box">
                <form method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="search" placeholder="Search books..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="btn search-btn">Search</button>
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                        <a href="books.php" class="btn close-btn">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="action-buttons">
                <a href="?show_form=add" class="btn add-btn">Add Book</a>
                <a href="?show_form=delete" class="btn delete-btn">Delete Book</a>
                <a href="?show_form=edite" class="btn delete-btn">Edite Book</a>
            </div>
        </div>

        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
            <div class="search-results">
                <strong>Search results for: "<?php echo htmlspecialchars($_GET['search']); ?>"</strong>
                <br>
                <span>Found <?php echo count($books); ?> book(s)</span>
            </div>
        <?php endif; ?>

       <!-- فورم الإضافة -->
<div id="add-form" class="add-form <?php echo $show_add_form ? 'show-form' : ''; ?>">
    <h3>Add New Book</h3>
    <form method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label>Book Title *</label>
                <input type="text" name="title" required placeholder="Enter book's name">
            </div>
            <div class="form-group">
                <label>Author Name *</label>
                <input type="text" name="author" required placeholder="Enter author's name">
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
            <div class="form-group">
                <label>Publish House *</label>
                <input type="text" name="publish_house" required placeholder="Enter the publish house">
            </div>
            <div class="form-group">
                <label>Publishing Date</label>
                <input type="date" name="publishing_date">
            </div>
        </div>
        <div style="margin-top: 15px;">
            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="Novel">Novel</option>
                    <option value="Science">Science</option>
                    <option value="History">History</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
        </div>
        <div class="form-buttons">
            <button type="submit" name="add_book" class="btn add-btn">Add Book</button>
            <button type="reset" class="btn close-btn">Reset</button>
            <a href="books.php" class="btn close-btn">Close</a>
        </div>
    </form>
</div>
        <div id="delete-form" class="delete-form <?php echo $show_delete_form ? 'show-form' : ''; ?>">
            <h3>Delete Book</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Book Title *</label>
                    <input type="text" name="delete_title" required placeholder="Enter book title">
                </div>
                <div class="form-group">
                    <label>Author Name *</label>
                    <input type="text" name="delete_author" required placeholder="Enter author name">
                </div>
                <div class="form-buttons">
                    <button type="submit" name="delete_book" class="btn delete-btn">Delete Book</button>
                    <button type="reset" class="btn close-btn">Reset</button>
                    <a href="books.php" class="btn close-btn">Close</a>
                </div>
            </form>
        </div>
        <!--edite section-->
        <div id="edite-form" class="edite-form <?php echo $show_edite_form ? 'show-form' : ''; ?>">
            <h3>Edite Book</h3>
            <form action="books.php" method="post">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group" >
                    <label>Book Title *</label>
                    <input type="text" name="edite_title" required placeholder="Enter book title">
                </div>
                <div class="form-group">
                    <label>Author Name *</label>
                    <input type="text" name="edite_author" required placeholder="Enter author name">
                </div></div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                        <label>New Book Title</label>
                        <input type="text" name="edite_title"  placeholder="Enter book title">
                    </div>
                <div class="form-group">
                    <label >New Author Name</label>
                    <input type="text" name="new_author" placeholder="Enter new author name">
                </div></div>
                <div class="form-group">
                    <label>New Publish House</label>
                    <input type="text" name="new_publish_house" placeholder="Enter new publish house">
                </div>
                <div class="form-group">
                    <label>New Publishing Date</label>
                    <input type="date" name="new_publishing_date">
                </div>
                <div class="form-group">
                    <label>New Category</label>
                    <select name="new_category">
                        <option value="">Select New Category</option>
                        <option value="Novel">Novel</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Romance">Romance</option>
                    </select>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="edite_book" class="btn add-btn">Edite Book</button>
                    <button type="reset" class="btn close-btn">Reset</button>
                    <a href="books.php" class="btn close-btn">Close</a>
                </div>
            </form>
        </div>
        </div>

        <div class="books-grid">
            <?php if (empty($books)): ?>
                <div style="text-align: center; padding: 40px; color: #666; grid-column: 1 / -1;">
                    <h3>No books found</h3>
                    <p><?php echo isset($_GET['search']) ? 'Try a different search term' : 'Start by adding your first book!'; ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="book-author">by <?php echo htmlspecialchars($book['author']); ?></div>
                        <?php if (!empty($book['category'])): ?>
                            <div style="margin-top: 8px; color: #888; font-size: 0.9em;">
                                Category: <?php echo htmlspecialchars($book['category']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($book['publish_house'])): ?>
                            <div style="margin-top: 5px; color: #888; font-size: 0.9em;">
                                Publisher: <?php echo htmlspecialchars($book['publish_house']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
    <a href="dashboard.php"
    
    style=" position: fixed;
  bottom: 20px;
  right: 20px;
  width: 60px;
  height: 60px;
  background-color: #8b4a5c;
  color: #f8f9fa;
  font-size: 24px;
  text-align: center;
  line-height: 60px;
  border-radius: 50%;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  text-decoration: none;
  z-index: 9999;
  cursor: pointer;


">H</a>
</body>
</html>
