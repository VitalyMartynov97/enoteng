<?php 
	session_start();
	require("php/db.php");
	$id     = $_SESSION['user_id'];
   	$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
   	$result = mysqli_query($db,$sql);
   	$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
   	if ($row['is_admin'] == 1) {
   		
   		$idToDelete = $_GET['id'];
   		$sql = "DELETE FROM items_tb WHERE id='$idToDelete'";

		if ($db->query($sql) === TRUE) {
    		echo "Record deleted successfully";
		}else{
    		echo "Error deleting record: " . $db->error;
        }

		$db->close();
		echo '<meta http-equiv="refresh" content="2; url=catalog.php" />';
		exit;
  	}
?>