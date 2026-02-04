<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_submit'])) {
    $book_title = $_POST['book_title'] ?? '';
    $borrower_name = $_POST['borrower_name'] ?? '';

    // get book_id
    $stmt = $conn->prepare("SELECT id FROM books WHERE title = ?");
    $stmt->bind_param("s", $book_title);
    $stmt->execute();
    $stmt->bind_result($book_id);
    if (!$stmt->fetch()) {
        echo "Book not found!";
        $stmt->close();
        return;
    }
    $stmt->close();

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

    // check if book is currently borrowed by this member
    $stmt = $conn->prepare("SELECT borrow_id, expected_return_date FROM borrowings WHERE book_id = ? AND member_id = ? AND return_date IS NULL");
    $stmt->bind_param("ii", $book_id, $member_id);
    $stmt->execute();
    $stmt->bind_result($borrow_id, $expected_return_date);
    if (!$stmt->fetch()) {
        echo "Book is not currently borrowed by this member!";
        $stmt->close();
        return;
    }
    $stmt->close();

    // calculate fine if returned late
    $today = date('Y-m-d');
    $fine = 0; 
    if ($today > $expected_return_date) {
        $fine = 5; }
    
    // update return_date and fine_amount
    $stmt = $conn->prepare("UPDATE borrowings SET return_date = NOW(), fine = ? WHERE borrow_id = ?");
    $stmt->bind_param("di", $fine, $borrow_id);
    if ($stmt->execute()) {
        // update book status to available
        $stmt2 = $conn->prepare("UPDATE books SET book_status = 'available' WHERE id = ?");
        $stmt2->bind_param("i", $book_id);
        $stmt2->execute();
        $stmt2->close();

        echo "Book returned successfully!";
        if ($fine > 0) {
            echo " Fine: $$fine for late return.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
