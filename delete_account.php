<!-- backend-->
<?php
include "db_connect.php"; 

$message = "";
$message_class = "";

// if user press on delete button
if(isset($_POST['delete'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); 

    if(!empty($email) && !empty($password)){
        
$result = mysqli_query($conn, "SELECT NAME, PASSWORD FROM admins WHERE Email='$email'");
        if ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['PASSWORD'];

            if (password_verify($password, $hashedPassword)) {
                $sql_delete = "DELETE FROM admins WHERE Email='$email'";
                if($conn->query($sql_delete) === TRUE){
                    $message = "Account deleted successfully!";
                    $message_class = "success";
                } else {
                    $message = "Error deleting account: " . $conn->error;
                    $message_class = "error";
                }
            } else {
                $message = "Incorrect password!";
                $message_class = "error";
            }

        } else {
            $message = "Email not found!";
            $message_class = "error";
        }

    } else {
        $message = "Please fill all fields.";
        $message_class = "error";
    }
}
?>
<!-- frontend -->
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
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
       <a href="index.html"
    
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
        <h3 class="text-center mb-3">Delete Account</h3>

        <form action="delete_account.php" method="POST">
            <div class="form-group mb-3">
                <label for="email">Admin Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your admin email" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="delete" class="btn">Delete Account</button>
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
