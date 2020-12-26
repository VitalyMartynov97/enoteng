<?php
	require("db.php");
	require("mains.php");
	$status = "Заказ не найден";
	$id     = $_POST['id'];
	$result = mysqli_query($db, "SELECT * FROM order_tb WHERE id='$id'");
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows ($result) < 1) {
		echo '<span style="color: darkred;">Заказ не найден :(</span>';			
    }else{
    	$status = getStatusById($row['status_id']);
    	echo $status;
    }
?>