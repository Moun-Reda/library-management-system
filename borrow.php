<?php
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow_submit'])) {
    $book_title = $_POST['book_title'] ?? '';
    $borrower_name = $_POST['borrower_name'] ?? '';

    // get book_id and status
    $stmt = $conn->prepare("SELECT id, book_status FROM books WHERE title = ?");
    $stmt->bind_param("s", $book_title);
    $stmt->execute();
    $stmt->bind_result($book_id, $book_status);
    if (!$stmt->fetch()) {
        echo "Book not found!";
        $stmt->close();
        return;
    }
    $stmt->close();
    // check if book is available
    if ($book_status !== 'available') {
        echo "Book is currently unavailable!";
        return;
    }

    // get member_id
    $stmt = $conn->prepare("SELECT member_id FROM members WHERE name = ?");
    $stmt->bind_param("s", $borrower_name);
    $stmt->execute();
    $stmt->bind_result($member_id);
    if (!$stmt->fetch()) {
        echo "Member not found!";
        $stmt->close();
        return;
    }
    $stmt->close();

    //calculate expected return date (1 week from now)
    $expected_return_date = date('Y-m-d', strtotime('+1 week'));

    //add borrowing record
    $stmt = $conn->prepare("INSERT INTO borrowings (member_id, book_id, expected_return_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $member_id, $book_id, $expected_return_date);
    if ($stmt->execute()) {
        //update book status to unavailable
        $update_stmt = $conn->prepare("UPDATE books SET book_status = 'unavailable' WHERE id = ?");
        $update_stmt->bind_param("i", $book_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "Book borrowed successfully! Expected return date: " . $expected_return_date;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
