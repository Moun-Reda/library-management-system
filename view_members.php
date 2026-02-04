<?php
include 'db_connect.php';

$view="SELECT*FROM members";
$result=$conn->query($view);

echo"<h2>All Members</h2>";
if($result->num_rows>0){
echo "<table border='1' cellpadding='10' cellspacing='0'>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Address</th>
</tr> ";

while($row=$result->fetch_assoc()){
echo "<tr>
<td>".$row['member_id']."</td>
<td>".$row['name']."</td>
<td>".$row['phone_number']."</td>
<td>".$row['address']."</td>
</tr> ";
}

echo "</table>";

}else{echo "No members found!";}

$conn->close();

?>
