<h2>Edit Member</h2>
<form method="POST" action="">
    Member ID: <input type="number" name="member_id" required><br>
    Name: <input type="text" name="name" required><br>
    Phone: <input type="text" name="phone" required><br>
    Address: <input type="text" name="address" required><br>
    <input type="submit" name="edit" value="Edit Member">
</form>


<?php                  //to link with php file
include 'db_connect.php';

if(isset($_POST['edit'])){
$member_id=$_POST['member_id'];
$name=$_POST['name'];
$phone=$_POST['phone'];
$address=$_POST['address'];

//check if member not found
$check="SELECT*FROM members WHERE member_id='$member_id'";
$result=$conn->query($check);
if($result->num_rows==0){
    echo "Member not found!";
}else{
    //if member exists then update member data
 $update="UPDATE members SET name='$name', phone_number='$phone',address='$address' WHERE member_id='$member_id'";
 if($conn->query($update)===TRUE){
    //if updated successfully
    echo "Member data updated successfully!";
}
 else{
    //when finding an error during editing 
   echo "There is an ERROR: ".$conn->error;
}
}
}
?>