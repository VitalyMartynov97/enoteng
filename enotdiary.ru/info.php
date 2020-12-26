<?php 
	session_start();
	if (isset($_GET['log'])) {
		echo '
			<script type="text/javascript">
				window.onload = function() {
  					togleSliderLog()
				};
			</script>
		';
		
	}
	if (isset($_GET['reg'])) {
		echo '
			<script type="text/javascript">
				window.onload = function() {
  					togleSliderReg()
				};
			</script>
		';
		
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
</head>
<body>
	<?php 
		require_once("header.php");
	?>
	<main>
		<div id="wrapper">
			<h1>Покупателям</h1>
			<br>
			<?php 
				if (isset($_SESSION['user_id'])) {
					echo '<a href="personal.php" class="mt-2">Личный кабинет</a>';
		
				}else{
					echo '
						<p class="bp">Личный кабинет</p>

			<a class="togle-link" class="mt-2" onclick="togleSliderLog()">Вход в личный кабинет</a>
			<div id="slid">
				<form method="POST" action="php/login.php" class="container">
					<input class="form-control" type="text" name="login" placeholder="Логин..." required>
					<input class="form-control mt-2" type="password" name="password" placeholder="Пароль..." required>
					<input class="form-control mt-2 btn btn-primary" type="submit" name="submit">
				</form>
			</div>
			<br>
			<a class="togle-link" class="mt-2" onclick="togleSliderReg()">Регистрация</a>
			<div id="slidreg">
				<form class="container" method="POST" action="php/reg.php">
					<input class="form-control " type="text" name="name" placeholder="Имя..." required>
					<input class="form-control mt-2" type="text" name="last_name" placeholder="Фамилия..." required>
					<input class="form-control mt-2" type="text" name="login" placeholder="Логин..." required>
					<input class="form-control mt-2" type="password" name="password" placeholder="Пароль..." required>
					<input class="form-control mt-2" type="text" name="email" placeholder="Email..." required>
					<input class="form-control mt-2" type="text" name="phone" placeholder="Телефон...">
					<input class="form-control mt-2" type="text" name="address" placeholder="Адресс..." required>
					<input class="form-control mt-2 btn btn-success" type="submit" name="submit">
				</form>
			</div>
					';
				}
			?>
			
			<p><a class="mt-2" href="status.php">Узнать статус заказа</a></p>
		</div>
	</main>
	<?php 
		require_once("modalBasket.php");
		require_once("footer.php");
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>