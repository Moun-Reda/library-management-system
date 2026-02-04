<?php
include 'db_connect.php';

$borrowed_books = [];

// Fetch borrowed books with member names, borrow dates, expected return dates, return dates, and fine
$stmt = $conn->prepare("
    SELECT b.title, m.name, br.borrow_date, br.expected_return_date, br.return_date, br.fine
    FROM borrowings br
    JOIN books b ON br.book_id = b.id
    JOIN members m ON br.member_id = m.member_id
    ORDER BY br.borrow_date DESC
");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $borrowed_books[] = $row;
}
$stmt->close();
?>
