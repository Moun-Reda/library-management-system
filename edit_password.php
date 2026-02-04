



<?php
include "db_connect.php";

$message = "";
$message_class = "";


if(isset($_POST['update'])){
    $email = trim($_POST['email']);
    $old_password = trim($_POST['old_password']); 
    $new_password = trim($_POST['new_password']);

    if(!empty($email) && !empty($old_password) && !empty($new_password)){

        $sql = "SELECT * FROM admins WHERE Email='$email'";
        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){
        if ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['PASSWORD'];

            if (password_verify($old_password, $hashedPassword)) {
                $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE admins SET Password='$hashedNewPassword' WHERE Email='$email'";
                if($conn->query($sql_update) === TRUE){
                    $message = "Password updated successfully!";
                    $message_class = "success";
                } else {
                    $message = "Error updating password: " . $conn->error;
                    $message_class = "error";
                }
            } else {
                $message = "Old password is incorrect!";
                $message_class = "error";
            }
        } else {
            $message = "Email not found!";
            $message_class = "error";
        }
    } else {
        $message = "Please fill all fields.";
        $message_class = "error";
    }}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 500px;
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
        .form-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .btn {
            background: #a36b7d;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            width: 100%;
            font-size: 16px;
        }
        .btn:hover { opacity: 0.9; }
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
        Admin Dashboard
    </div>

    <div class="form-card">
        <h3 class="text-center mb-3">Edit Password</h3>

        <form action="edit_password.php" method="POST">
            <div class="form-group mb-3">
                <label for="email">Admin Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your admin email" required>
            </div>

            <div class="form-group mb-3">
                <label for="old_password">Old Password</label>
                <input type="password" class="form-control" name="old_password" placeholder="Enter old password" required>
            </div>

            <div class="form-group mb-3">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required>
            </div>

            <button type="submit" name="update" class="btn">Update Password</button>
        </form>

        <?php if(!empty($message)): ?>
            <div class="message <?php echo $message_class; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
