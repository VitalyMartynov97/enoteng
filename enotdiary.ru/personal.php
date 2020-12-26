<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		echo '<meta http-equiv="refresh" content="0; url=info.php" />';
		exit;
	}
	require("php/mains.php");
	require("php/db.php");
	if (isset($_POST['personal-sub'])) {
		$myid = $_SESSION['user_id'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$sql = "UPDATE users_tb 
				SET name = '$name', last_name = '$surname', phone = '$phone', email = '$email', address = '$address' WHERE id='$myid'";
		if (mysqli_query($db, $sql)) {
  			echo '<script type="text/javascript">alert("Информация обновлена")</script>';

		} else {
 			echo "Error updating record: " . mysqli_error($db);
		}
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Информация - Дневник Енота</title>
	<script
  		src="https://code.jquery.com/jquery-3.5.1.js"
  		integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  		crossorigin="anonymous">
  	</script>
  	<script type="text/javascript" defer>
  		function toglePersonalData(){
			console.log($('#personal-data').css('display'))
			if($('#personal-data').css('display') === 'none')
			{
    			$('#personal-data').slideDown();
			}
			else
			{
 		    	$('#personal-data').slideUp();
			}			
		}
  	</script>
</head>
<body>
	<?php 
		require_once("header.php");
	?>
	<main>
		<?php 
      require("modalBasket.php");
    ?>
		<div id="wrapper">
			
			<?php 
				require('php/db.php');
    			$id     = $_SESSION['user_id'];
    			$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
    			$result = mysqli_query($db,$sql);
    			$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
    			$count  = mysqli_num_rows($result);
    			if($count == 1) {
        			echo '
						<h3>Личный кабинет</h3>
						<ul>
							<li>Здравствуйте, <b>'.$row['name'].' '.$row['last_name'].'!</b></li>';
							if ($row['is_admin'] == 1) {
								echo '<li><a href="admin.php">Панель администратора</a></li>';
							}
							if ($row['is_travel'] == 1) {
								echo '<li><a href="travel.php">Панель курьера</a></li>';
							}
							echo '<li><a href="status.php">Очень точно уточнить статус заказа</a></li>';
							echo '
							<li><a href="php/exit.php" style="color: red;">Выход</a></li>
						</ul>
						';
						echo '<a style="text-decoration: underline; cursor: pointer; color: darkgreen;" onclick="toglePersonalData()">Личные данные</a>
			<div id="personal-data" style="display: none;">
				<form action="" method="POST">
					<h4 class="mt-3">Личная информация</h4>
					<label class="mt-2" for="uname">Имя</label>
					<input 
						id="uname"
						type="text"
						class="form-control" 
						name="name" 
						value="'.$row['name'].'" 
						placeholder="Имя...">
					<label class="mt-2" for="usurname">Фамилия</label>
					<input 
						id="usurname"
						type="text" 
						name="surname" 
						class="form-control" 
						placeholder="Фамилия..." 
						value="'.$row['last_name'].'">
					<label class="mt-2" for="uemail">Email</label>
					<input 
						id="uemail"
						type="text"
						placeholder="Email..."
						class="form-control"
						value="'.$row['email'].'" 
						name="email">
					<label class="mt-2" for="uphone">Телефон</label>
					<input 
						id="uphone"
						type="text"
						placeholder="Телефон..."
						class="form-control"
						value="'.$row['phone'].'" 
						name="phone">
					<label class="mt-2" for="uaddress">Адресс</label>
					<input 
						id="uaddress"
						type="text"
						placeholder="Адресс..."
						class="form-control"
						value="'.$row['address'].'" 
						name="address">
					<input 
						type="submit" 
						class="btn btn-success mt-2 mb-4"
						value="Применить" 
						name="personal-sub">
				</form>
			</div>';
						echo '
						<h4>Мои заказы</h4>
						
   							';
   							$myid = $_SESSION['user_id'];
   							$query = "SELECT * FROM order_tb where client_id = '$myid'";
							if ($result = mysqli_query($db, $query)) {
								if (mysqli_num_rows ($result) < 1) {
									echo "<h3>У вас еще нет заказов :(</h3>";
								}else{
									echo '<table id="items_table" border="1" class="table table-hover table-sm table-bordered table-striped">
   							<tr>
   							 <th>Номер заказа</th>
   							 <th>Содержимое</th>
   							 <th>Дата</th>
   							 <th>Цена</th>
   							 <th>Статус</th>
   							</tr>';
   								while ($row = mysqli_fetch_assoc($result)) {
        							echo '
										<tr>
											<td>'.$row['id'].'</td>
											<td>'.getItemsTitlesByOrderId($row['id']).'</td>
											<td>'.$row['date'].'</td>
											<td>'.$row['price'].' руб</td>
											<td>'.getStatusById($row['status_id']).'</td>
										</tr>
       								';
    							}
    							mysqli_free_result($result);
								}
    							
							}
							mysqli_close($db);
   							echo '
   							</table>
        			';
    			}else{
    				echo '<h3>Пользователь не найден</h3>';
    			}
			?>
		</div>
	</main>
	<?php 
		require_once("modalBasket.php");
		require_once("footer.php");
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
