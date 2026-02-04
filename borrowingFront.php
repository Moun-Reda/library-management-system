<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Borrow & Return</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 900px;
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
        .form-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-section h2 {
            margin-top: 0;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            background: #a36b7d;
            font-size: 16px;
        }
        .btn:hover { opacity: 0.9; }
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
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .book-title { font-weight: bold; margin-bottom: 5px; color: #333; }
        .book-author { font-style: italic; color: #666; }
        .book-info { margin-bottom: 5px; }
        .fine { color: red; font-weight: bold; }
    </style>
</head>
<body>
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
    <div class="container">
        <div class="header">
            <h1>Library Borrow & Return System</h1>
        </div>

        <!-- Borrow Form -->
        <div class="form-section">
            <h2>Borrow a Book</h2>
            <form action="borrow.php" method="POST">
                <div class="form-group">
                    <label>Book Title</label>
                    <input type="text" name="book_title" required placeholder="Enter Book Title">
                </div>
                <div class="form-group">
                    <label>Borrower Name</label>
                    <input type="text" name="borrower_name" required placeholder="Enter Borrower Name">
                </div>

                <!-- زرار بيسند POST name الصح -->
                <button type="submit" name="borrow_submit" class="btn">Borrow Book</button>
            </form>
        </div>

        <!-- Return Form -->
        <div class="form-section">
            <h2>Return a Book</h2>
            <form action="return.php" method="POST">
                <div class="form-group">
                    <label>Book Title</label>
                    <input type="text" name="book_title" required placeholder="Enter Book Title">
                </div>
                <div class="form-group">
                    <label>Borrower Name</label>
                    <input type="text" name="borrower_name" required placeholder="Enter Borrower Name">
                </div>

                <!-- زرار بيسند POST name الصح -->
                <button type="submit" name="return_submit" class="btn">Return Book</button>
            </form>
        </div>

        <!-- View Borrowed Books -->
        <div class="form-section">
            <h2>Borrowed Books</h2>
            <div class="books-grid">
                <?php
                include 'view_borrowed.php'; 
                foreach($borrowed_books as $book):
                ?>
                    <div class="book-card">
                        <div class="book-title"><?= htmlspecialchars($book['title']); ?></div>
                        <div class="book-info">Borrower: <?= htmlspecialchars($book['name']); ?></div>
                        <div class="book-info">Borrowed on: <?= htmlspecialchars($book['borrow_date']); ?></div>
                        <div class="book-info">Expected Return: <?= htmlspecialchars($book['expected_return_date']); ?></div>
                        <div class="book-info">Returned on: <?= htmlspecialchars($book['return_date'] ?? 'Not returned yet'); ?></div>
                        <div class="fine">Fine: $<?= htmlspecialchars($book['fine']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</body>
</html>