<?php
include 'db_connect.php';  //to link with php file
$add_msg = "";
$delete_msg = "";
$edit_msg = "";

// Add Member
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $check = "SELECT * FROM members WHERE name='$name' AND phone_number='$phone'";
    $result = $conn->query($check);

    if($result->num_rows > 0){
        $add_msg = "Member already exists!";
    } else {
        $sql = "INSERT INTO members (name, phone_number, address) VALUES ('$name', '$phone', '$address')";
        if($conn->query($sql) === TRUE){
            $add_msg = "Member added successfully!";
        } else {
            $add_msg = "Error: " . $conn->error;
        }
    }
}

// Delete Member
if(isset($_POST['delete'])){
    $member_id = $_POST['member_id'];
    $check = "SELECT * FROM members WHERE member_id='$member_id'";
    $result = $conn->query($check);

    if($result->num_rows == 0){
        $delete_msg = "Member not found!";
    } else {
        $sql = "DELETE FROM members WHERE member_id='$member_id'";
        if($conn->query($sql) === TRUE){
            $delete_msg = "Member deleted successfully!";
        } else {
            $delete_msg = "Error: " . $conn->error;
        }
    }
}

// Edit Member
if(isset($_POST['edit'])){
    $member_id = $_POST['member_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $check = "SELECT * FROM members WHERE member_id='$member_id'";
    $result = $conn->query($check);

    if($result->num_rows == 0){
        $edit_msg = "Member not found!";
    } else {
        $sql = "UPDATE members SET name='$name', phone_number='$phone', address='$address' WHERE member_id='$member_id'";
        if($conn->query($sql) === TRUE){
            $edit_msg = "Member updated successfully!";
        } else {
            $edit_msg = "Error: " . $conn->error;
        }
    }
}
//search meember 
$message = "";
$message_class = "";
$search_results = [];
$search_term = "";

// Check if the search button was pressed
if(isset($_GET['search'])){
    $search_term = trim($_GET['search_term']); // trim used to delete any space before or after 

    if(!empty($search_term)){
        $sql = "SELECT member_id, name, phone_number, address FROM members WHERE name = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
             $message = "Error preparing statement: " . $conn->error;
             $message_class = "error";
        } else {
             $param_search = $search_term; 
             $stmt->bind_param("s", $param_search);
             $stmt->execute();
             $result = $stmt->get_result();
     
             if($result && $result->num_rows > 0){
                 while($row = $result->fetch_assoc()){
                     $search_results[] = $row; 
                 }
                 $message = "Found " . count($search_results) . " exact matching result(s) for '{$search_term}'.";
                 $message_class = "success";
             } else {
                 $message = "No exact match found for '" . htmlspecialchars($search_term) . "'.";
                 $message_class = "error";
             }
             $stmt->close();
        }
    } else {
        $message = "Please enter a term to search for.";
        $message_class = "error";
    }
}

// Fetch all members for view
$members = $conn->query("SELECT * FROM members");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Members</title>
<style>
body { font-family: Arial; padding: 20px; background: #f8f9fa; }
.container { max-width: 900px; margin: auto; }
h2 { color: #333; }
form { background: #fff; padding: 20px; margin-bottom: 25px; border-radius: 8px; border: 1px solid #ddd; }
input { padding: 8px; margin-bottom: 10px; width: 100%; border-radius: 4px; border: 1px solid #ddd; }
.btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; color: white; background: #a36b7d; }
.btn:hover { opacity: 0.9; }
.message { padding: 10px; font-weight: bold; margin-bottom: 10px; }
.success { color: green; }
.error { color: red; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
</style>
</head>
<body>
    <!-- Home Button -->
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
    <h1 style="background: #8b4a5c; color: #f8f9fa; width: 100%;height: 50px; margin:0 0 5px 0;padding:25px 0;    text-align: center;
            margin-bottom: 30px;
            background: #8b4a5c;
            color: white;
            border-radius: 8px; ">Manage Members</h1>
    <!--search form-->
        </style>
</head>
<body>

<div class="container">
    <?php if(!empty($message)): ?>
        <div class="message <?php echo $message_class; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        
        <form action="manage_members.php" method="GET">
            <div class="form-group mb-3"><h2>Search Member</h2>
                <label for="search_term">Member Name:</label>
                <input type="text" class="form-control" name="search_term" placeholder="Enter the exact member name" value="<?php echo htmlspecialchars($search_term); ?>" required>
            </div>
            <button type="submit" name="search" class="btn">Search</button>
        </form>
    </div>

    <?php if(!empty($search_results)): ?>
        <div class="form-card">
            <h4 class="mb-3">Search Results</h4>
            <table class="results-table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($member['address']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

    <!-- Add Member -->
    <form method="POST">
        <h2>Add Member</h2>
        <?php if($add_msg != ""): ?>
            <div class="message <?= strpos($add_msg,'successfully') !== false ? 'success':'error' ?>"><?= $add_msg ?></div>
        <?php endif; ?>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="add" class="btn">Add Member</button>
    </form>

    <!-- Delete Member -->
    <form method="POST">
        <h2>Delete Member</h2>
        <?php if($delete_msg != ""): ?>
            <div class="message <?= strpos($delete_msg,'successfully') !== false ? 'success':'error' ?>"><?= $delete_msg ?></div>
        <?php endif; ?>
        <input type="number" name="member_id" placeholder="Member ID" required>
        <button type="submit" name="delete" class="btn">Delete Member</button>
    </form>

    <!-- Edit Member -->
    <form method="POST">
        <h2>Edit Member</h2>
        <?php if($edit_msg != ""): ?>
            <div class="message <?= strpos($edit_msg,'successfully') !== false ? 'success':'error' ?>"><?= $edit_msg ?></div>
        <?php endif; ?>
        <input type="number" name="member_id" placeholder="Member ID" required>
        <input type="text" name="name" placeholder="New Name" required>
        <input type="text" name="phone" placeholder="New Phone Number" required>
        <input type="text" name="address" placeholder="New Address" required>
        <button type="submit" name="edit" class="btn">Edit Member</button>
    </form>

    <!-- View Members -->
    <h2>All Members</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        <?php while($row = $members->fetch_assoc()): ?>
        <tr>
            <td><?= $row['member_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['phone_number'] ?></td>
            <td><?= $row['address'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>
