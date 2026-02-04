<?php
include "db_connect.php";

$sql = "CREATE TABLE IF NOT EXISTS members (
    member_id INT(11) AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    address VARCHAR(225) NOT NULL,
    PRIMARY KEY (member_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Members table created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
