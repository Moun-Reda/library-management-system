<h2>Add Member</h2>  
<form method="POST" action="add_member.php"> 
    Name: <input type="text" name="name" required><br>
    Phone: <input type="text" name="phone" required><br>
    Address: <input type="text" name="address" required><br>
    <input type="submit" name="add" value="Add Member">
</form>


<?php                      // to link with php file
include "db_connect.php";

//if user press on button "add"
if(isset($_POST['add'])){
$name=$_POST['name'];
$phone=$_POST['phone'];
$address=$_POST['address'];

//check if member already exists
$check= "SELECT*FROM members WHERE name='$name' AND phone_number='$phone' AND address='$address'";
$result=$conn->query($check);
if($result->num_rows>0){
    echo"Member already exists!";
}else {
    //add data of member
    $insert_member="INSERT INTO members (name, phone_number, address ) VALUES ('$name','$phone','$address')";
    if($conn->query($insert_member)===TRUE){
        //after adding successully
        echo "Member added successfully!";
    }else{
            //if there is an error in adding
        echo "there is an ERROR : ".$conn->error;
    }
}
}
?>

