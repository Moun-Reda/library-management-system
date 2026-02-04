<h2>Delete Member</h2>        
<form method="POST" action="">
    Member ID: <input type="number" name="member_id" required><br>
    <input type="submit" name="delete" value="Delete Member">
</form>


<?php       //to link with php file
include 'db_connect.php';

// if user press on button "delete"
if(isset($_POST['delete'])){
$member_id=$_POST['member_id'];

//check if member exists to delete him 
$check="SELECT*FROM members WHERE member_id='$member_id'";
$result=$conn->query($check);
if($result->num_rows>0){
    $delete_member="DELETE FROM members WHERE member_id='$member_id'";
    if($conn->query($delete_member)===TRUE){
        //when member deleted from database
        echo "Member deleted successfully!";
    }else {
        //if there is an error in deleting
        echo "There is an ERROR: ".$conn->error;
    }
}else{
    //if member not found
    echo "Member already not found!";
}

}
?>




