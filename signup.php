<?php
session_start();          
include 'db_connect.php'; 

// get form data:
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$hash = password_hash($password, PASSWORD_DEFAULT);

//validate input data:
if (empty($name)) {
    echo "<h1 style='color:red; font-weight:bold; text-align:center;'>Name is required!</h1>";
} elseif (empty($email)) {
    echo "<h1 style='color:red; font-weight:bold; text-align:center;'>Email is required!</h1>";
} elseif (empty($password)) {
    echo "<h1 style='color:red; font-weight:bold; text-align:center;'>Password is required!</h1>";
} else {

    // check if email already exists
    $email_column = mysqli_query($conn, "SELECT Email FROM admins");
    $exist = false;

    if (mysqli_num_rows($email_column) > 0) {
        while ($row = $email_column->fetch_assoc()) {
            if ($row['Email'] === $email) {
                $exist = true;
                break;
            }
        }
    }

    if ($exist) {
        echo "<div style='width: 250px;;
         
          border: 3px solid black; 
          box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.3);
          border-radius: 5px;
          border-radius: 5px;
          text-align: center;
          padding: 10px;
  background: white;     
  position: fixed;         
  top: 10px;              
  left: 50%;    
  transform: translateX(-50%);          
  z-index: 9999;'>This email is already registered!</div>";
    } else {
        // insert to database
        $sql = "INSERT INTO admins(NAME, Email, PASSWORD) VALUES('$name', '$email', '$hash')";
        if (mysqli_query($conn, $sql)) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div style='width: 250px;;
         
          border: 3px solid black; 
          box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.3);
          border-radius: 5px;
          border-radius: 5px;
          text-align: center;
          padding: 10px;
  background: white;     
  position: fixed;         
  top: 10px;              
  left: 50%;    
  transform: translateX(-50%);          
  z-index: 9999;'>Couldn't register the user!</div>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryManagementSystem</title>
</head>
<body style="
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
    font-weight: bold;
    background: #f8f9fa;
">
</body>
</html>
