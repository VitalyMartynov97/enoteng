<?php
	session_start();
	
	if (isset($_POST['final'])) {
		require("db.php");
		$userId = 0;
		if (isset($_SESSION['user_id'])) {
			$id = $_SESSION['user_id'];
			$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
    		$result = mysqli_query($db,$sql);
   			$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$userId = $row['id'];
		}
		$fullPrice = 0;
      	for ($i=0; $i < (sizeof($_SESSION['goodsArr'])); $i++) { 
        	$viewI = $i + 1;
     		$article = $_SESSION['goodsArr'][$i];
        	$result = mysqli_query($db, "SELECT * FROM items_tb WHERE id='$article'");
   			$row = mysqli_fetch_array($result);
   			$fullPrice += $row['price'];
   		};
   		$price   = $fullPrice;
		$name    = $_POST['name'];
		$surname = $_POST['surname'];
		$phone   = $_POST['phone'];
		$email   = $_POST['email'];
		$address = $_POST['address'];
		$date    = date('d.m.yy');
		$sql = "INSERT INTO 
				order_tb (client_id, status_id, date, name, surname, address, phone, email, travel_id, price)
				VALUES 
						 ('$userId', '1', '$date', '$name', '$surname', '$address', '$phone', '$email', '0', '$price')";

		if (mysqli_query($db, $sql)) {
  			echo "<h1>Спасибо за ваш заказ :)</h1>";
  			$kipa = mysqli_insert_id($db);
  			echo '<br><h3>Номер вашего заказа: <b>'.$kipa.'</b></h3>';
  			echo '<br><a href="../personal.php">Мои заказы</a>';
  			for ($i=0; $i < (sizeof($_SESSION['goodsArr'])); $i++) { 
     			$article = $_SESSION['goodsArr'][$i];
     			$sql = "INSERT INTO 
				order_item_id (item_id, order_id) VALUES ('$article', '$kipa')";
        		$result = mysqli_query($db, $sql);
   			};
		} else {
    		echo "Error: " . $sql . "<br>" . mysqli_error($db);
		}
		mysqli_close($db);
	}
	

?>