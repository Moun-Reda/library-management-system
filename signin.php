<?php

//database connection:
session_start();
include 'db_connect.php';
  // get form data:
if ($_SERVER["REQUEST_METHOD"] == "POST") {   

$email = $_POST['email2'] ?? '';
$password = $_POST['password2'] ?? '';


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
if($exist){
$result = mysqli_query($conn, "SELECT NAME, PASSWORD FROM admins WHERE Email='$email'");
        if ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['PASSWORD'];

            if (password_verify($password, $hashedPassword)) {
                // Save session info
                $_SESSION['admin_name'] = $row['NAME'];
                $_SESSION['admin_email'] = $email;

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            }else{
 echo" <div style=' width: 250px;;
         
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
  z-index: 9999;
          '>Incorrect Password!</div>";
}}

}else{
 echo" <div style=' width: 250px;;
         
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
  z-index: 9999;
          '>Email not found!</div>";
}
}

?>
<!-- Sign In page HTML -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LibraryManagementSystem</title>
  
         <style>
      .btn:hover {
        opacity: 0.9;
      }
    </style>
     
      
  </head>

  <body
     style="
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
      font-weight: bold;
      background: #f8f9fa;
    "
  >
    <center>
<!-- Sign In Form -->
      <div
        id="signin"
        class="signin"
        style="
          width: 500px;
          height: fit-content;
          border: 3px solid black;
          box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.3);
          border-radius: 10px;
          margin-top: 90px;
          display: block;
        "
      >
        <h1 style=" background: #8b4a5c; color: #f8f9fa; width: 100%;height: 50px; margin:0 0 5px 0;padding:10px 0 ">Sign In</h1>
        <form action="signin.php" method="post">
          <!--link to the backend admin table -->
          <label for="email">E-mail: </label><br /><input
            type="email"
            required
            name="email2"
            placeholder="Enter Your E-mail"
            style="background: local"
          />
          <br /><br />
          <label for="password">Password: </label><br /><input
            type="password"
            required
            name="password2"
            style="background: local"
          /><br /><br />
          <input
          class="btn"
            type="submit"
            name="btn"
            value="Sign In"
           style="
              margin: 20px;
              box-shadow: 2px 2px 10px black;
              border: 2px solid black;
              border-radius: 10px;
              cursor: pointer;
              width: 200px;
              padding: 10px;
              background:  #a36b7d;
              color: #f8f9fa;
             
            "
          />
        </form>
      </div>
    </center>
    </body>
</html>

