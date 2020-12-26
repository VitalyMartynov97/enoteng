<?php
	session_start();
	require("php/mains.php");
	require("php/db.php");
	$status = "-";
	
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
  	<script type="text/javascript" src="js/mains.js" defer>
  		
  	</script>
</head>
<body>
	<?php 
		require_once("modalBasket.php");
		require_once("header.php");
	?>
	<main>
		<?php 
      		require("modalBasket.php");
    	?>
		<div id="wrapper">
			<h3>Отслеживание заказа</h3>
			<span>Заказ № <b id="numOr">-</b></span><br>
			<span>Стутус заказа: <b id="resF">-</b></span>
			<div class="form-group ">
				<input 
					id="id" 
					class="form-control mt-2" 
					type="number" 
					placeholder="Номер..." >
				<small id="emailHelp" class="form-text text-muted">Нажмите Enter для поиска</small>
				
			</div>
		</div>
	</main>
	<?php 
		
		require_once("footer.php");
	?>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
        	document.getElementById('id').focus()
    	})
	</script>
</body>
</html>
