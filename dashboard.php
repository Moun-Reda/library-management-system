
  <?php
include 'db_connect.php'; 

$books_result = mysqli_query($conn, "SELECT COUNT(*) AS total_books FROM books");
$total_books = mysqli_fetch_assoc($books_result)['total_books'];

 $members_result = mysqli_query($conn, "SELECT COUNT(*) AS total_members FROM members");
  $total_members = mysqli_fetch_assoc($members_result)['total_members'];

$borrowed_result = mysqli_query($conn, "SELECT COUNT(*) AS total_borrowed FROM borrowings");
$total_borrowed = mysqli_fetch_assoc($borrowed_result)['total_borrowed'];



?>
  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LibraryManagementSystem</title>
       <style>
      button:hover {
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
     <!-- Admin Dashboard -->

      <div
        class="menu"
        style="     height: 100vh;
      margin: 30px;
      text-align: center;
      justify-content: center;
      align-items: center;
      margin: 0 auto"
    

      >           <h1 style="    text-shadow: 10px 5px 5px rgba(0, 0, 0, 0.3);
      background: #8b4a5c;
      color: #f8f9fa;
    
      height: 120px;
      margin: 0 0 5px 0;
      padding: 10px;
      text-align: center;
      border-radius: 8px;
      line-height: 100px;
">
          Welcome To Library Management System
        </h1>
   
        <table
          
          cellpadding="10"
          style="
            width: 90%;
            text-align: center;
            border-collapse: collapse;
            box-shadow: 2px 2px 10px black;
            margin: 40px;
             background: #8b4a5c;
              color: #f8f9fa;
              border: 2px solid black;
              height:100px
              
          
          "
        >
          <tr style="border: 2px solid black;">
            <th style="border: 2px solid black;">Total Books</th>
            <th style="border: 2px solid black;">Members</th>
            <th style="border: 2px solid black;">Borrowed</th>
          </tr>
          <tr>
            <td style="border: 2px solid black; background: #f8f9fa; color: #000000ff;"><?php echo $total_books?></td>
            <td style="border: 2px solid black; background: #f8f9fa; color: #000000ff;"><?php echo $total_members?></td>
            <td style="border: 2px solid black; background: #f8f9fa; color: #000000ff;"><?php echo $total_borrowed?></td>
          </tr>
        </table>
        <!-- Management Buttons -->

         <!--  Manage Books Button -->
         <a href="books.php" style="text-decoration: none;">
        <button
          class="manage_books"
          style="
            background: local;
            margin: 20px;
            box-shadow: 2px 2px 10px black;
            border: 2px solid black;
            border-radius: 10px;
            width: 200px;
            padding: 10px;
            cursor: pointer;
              background: #a36b7d;
              color: #f8f9fa;
          "
        >
          Manage Books</button
        > </a>
        <!--  Manage Members Button -->
        <a href="manage_members.php" style="text-decoration: none;"><button
          class="manage_members"
          style="
            background: local;
            margin: 20px;
            box-shadow: 2px 2px 10px black;
            border: 2px solid black;
            border-radius: 10px;
            width: 200px;
            padding: 10px;
            cursor: pointer;
              background: #a36b7d;
              color: #f8f9fa;
          "
        >
          Manage Members</button

        > </a><!--  Manage Borrowed Books Button -->
        <a href="borrowingFront.php" style="text-decoration: none;"><button
          class="manage_borrowedBooks"
          style="
            background: local;
            margin: 20px;
            box-shadow: 2px 2px 10px black;
            border: 2px solid black;
            border-radius: 10px;
            width: 200px;
            padding: 10px;
            cursor: pointer;
              background: #a36b7d;
              color: #f8f9fa;
          "
        >
          Manage Borrowed Books</button
        ></a>
        <!--  Manage User Account Button -->
<label>
  <select onchange="location = this.value;" 
          style="background:#a36b7d; color:#f8f9fa; box-shadow: 2px 2px 10px black;
                 padding:10px; border:2px solid black; 
                 border-radius:10px; width:200px; cursor:pointer;">
    <option selected disabled>Manage User Account</option>
    <option value="edit_username.php">Edit Username</option>
    <option value="edit_password.php">Edit Password</option>
    <option value="delete_account.php">Delete Account</option>
  </select>
</label>

      </div>
    </center>
  </body>
</html>
