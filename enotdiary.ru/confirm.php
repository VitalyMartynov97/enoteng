<?php
	session_start();
	require("php/mains.php");
	require("php/db.php");
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
</head>
<body>
	<?php 
		require_once("header.php");
	?>
	<main>
		<div id="wrapper">
			<form method="POST" action="php/final.php">
				<h2>Подтверждение заказа</h2>
				
					<?php 
						if (isset($_SESSION['user_id'])) {
							$id     = $_SESSION['user_id'];
    						$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
    						$result = mysqli_query($db,$sql);
    						$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
							echo '
					<label class="mt-2" for="uname">Имя</label>
					<input 
						required
						id="uname"
						type="text"
						class="form-control" 
						name="name" 
						value="'.$row['name'].'" 
						placeholder="Имя...">
					<label class="mt-2" for="usurname">Фамилия</label>
					<input 
						required
						id="usurname"
						type="text" 
						name="surname" 
						class="form-control" 
						placeholder="Фамилия..." 
						value="'.$row['last_name'].'">
					<label class="mt-2" for="uemail">Email</label>
					<input 
						required
						id="uemail"
						type="text"
						placeholder="Email..."
						class="form-control"
						value="'.$row['email'].'" 
						name="email">
					<label class="mt-2" for="uphone">Телефон</label>
					<input 
						required
						id="uphone"
						type="text"
						placeholder="Телефон..."
						class="form-control"
						value="'.$row['phone'].'" 
						name="phone">
					<label class="mt-2" for="uaddress">Адресс</label>
					<input 
						required
						id="uaddress"
						type="text"
						placeholder="Адресс..."
						class="form-control"
						value="'.$row['address'].'" 
						name="address">
					
							';
						}else{
							echo '
					<label class="mt-2" for="uname">Имя</label>
					<input 
						required
						id="uname"
						type="text"
						class="form-control" 
						name="name" 
						
						placeholder="Имя...">
					<label class="mt-2" for="usurname">Фамилия</label>
					<input 
						required
						id="usurname"
						type="text" 
						name="surname" 
						class="form-control" 
						placeholder="Фамилия..." 
				
					<label class="mt-2" for="uemail">Email</label>
					<input 
						required
						id="uemail"
						type="text"
						placeholder="Email..."
						class="form-control"
						
						name="email">
					<label class="mt-2" for="uphone">Телефон</label>
					<input 
						required
						id="uphone"
						type="text"
						placeholder="Телефон..."
						class="form-control"
					
						name="phone">
					<label class="mt-2" for="uaddress">Адресс</label>
					<input 
						required
						id="uaddress"
						type="text"
						placeholder="Адресс..."
						class="form-control"
						
						name="address">
							';
						}
					$fullPrice = 0;
      				for ($i=0; $i < (sizeof($_SESSION['goodsArr'])); $i++) { 
        				$viewI = $i + 1;
        				$article = $_SESSION['goodsArr'][$i];
        				$result = mysqli_query($db, "SELECT * FROM items_tb WHERE id='$article'");
        				$row = mysqli_fetch_array($result);
        				$fullPrice += $row['price'];
    				};
    				echo '
						<h4 class="mt-2 mb-2">К оплате: <b>'.$fullPrice.' руб</b></h4>';
					?>
					
					<input 
						type="submit" 
						class="btn btn-success mt-2"
						value="Оформить заказ" 
						name="final"><br>
						<a href="order.php" class="">Отмена</a>
			</form>
			
		</div>
	</main>
	<?php 
		require_once("modalBasket.php");
		require_once("footer.php");
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
