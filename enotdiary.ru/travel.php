<?php
	session_start();
	require("php/mains.php");
	require("php/db.php");
	if (!isset($_SESSION['user_id'])) {
		echo '<meta http-equiv="refresh" content="0; url=info.php" />';
		exit;
	}
	//check admins rights
	$myId = $_SESSION['user_id'];
	$sql = "SELECT * FROM users_tb WHERE id = '$myId'";
    if ($result = mysqli_query($db, $sql)) {
   		while ($row = mysqli_fetch_assoc($result)) {
        	if ($row['is_travel'] != 1) {
        		echo '<meta http-equiv="refresh" content="0; url=http://enotdiary.ru/info.php" />';
        		exit;
        		
        	}
   		}
    	mysqli_free_result($result);
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/travel.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Панель администратора - Дневник Енота</title>
	<script
  		src="https://code.jquery.com/jquery-3.5.1.js"
  		integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  		crossorigin="anonymous">
  	</script>
</head>
<body>
	<?php 
		require_once("header.php");
	?>
	<main>
		<div id="wrapper">
			<h3>Панель курьера</h3>
			<hr>
			<div id="admin-wrap">
			
				<div id="admin-workplace">
					
					<div id="ad-orders" class="">
						<h5>Мои рабочие заказы</h5>
						
							<?php
							$myGId = $_SESSION['user_id'];
		$query = "SELECT * FROM order_tb where (travel_id = '$myGId' AND status_id = 3)  ORDER BY status_id";
								if ($result = mysqli_query($db, $query)) {
					if (mysqli_num_rows ($result) < 1) {
						echo "<h3>Заказов нет :(</h3>";
					}else{
						echo '<table class="table table-hover table-sm table-bordered table-striped">
							<tr>
								<th>Номер</th>
								<th>Содержимое</th>
								<th>Данные клиента</th>
								<th>Цена</th>
								<th>Дата заказа</th>
								
							</tr>';
						while ($row = mysqli_fetch_assoc($result)) {
   						
        				echo '
							<tr>
								<td>'.$row['id'].'</td>
								<td>'.getItemsTitlesByOrderId($row['id']).'</td>
								<td>'.$row['name'].' '.
									$row['surname'].', <br>'.
									$row['address'].', <br>'.
									$row['phone'].', <br>'.
									$row['email']
								.'</td>
								<td>'.$row['price'].' руб</td>
								<td>'.$row['date'].'</td>
								
							<tr>
       					';
    				}
    				mysqli_free_result($result);
				}
			}
				mysqli_close($db);
							?>
						</table>
					</div>
				</div>
			</div>
			
			<hr>
			
		</div>
	</main>
	<?php 
		require_once("modalBasket.php");
		require_once("footer.php");
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>