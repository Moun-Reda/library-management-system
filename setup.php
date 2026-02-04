<?php
include "library_db.php";

$sql = "CREATE TABLE IF NOT EXISTS admins (
    Email VARCHAR(50) NOT NULL PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Password VARCHAR(250) NOT NULL
)";
$conn->query($sql);

echo "Setup done!";
$conn->close();

?>
