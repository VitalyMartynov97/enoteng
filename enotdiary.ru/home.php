<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Главная страница</title>
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
			<h1>Енот приветствует друзей!</h1>
			<p>На нашем сайте вы можете найти работы следующих авторов:</p>
			
				<?php
   				require('php/db.php');
   				$query = "SELECT * FROM author_tb";
				if ($result = mysqli_query($db, $query)) {
					echo "<ul class='anc'>";
    				while ($row = mysqli_fetch_assoc($result)) {
   						/*if ($row['img_path'] == "") {
   							$row['img_path'] = 'itemhold.jpg';
    					}*/
        				echo '
							<li>
								<a href="catalog.php?author='.$row['id'].'">
									'.$row['title'].'
								</a>
							</li>
       					';
    				}
    				echo "</ul>";
    				mysqli_free_result($result);
				}
				?>
				<p>Работы представлены в следующих категориях:</p>
				<?php
				$query = "SELECT * FROM category_tb";
				if ($result = mysqli_query($db, $query)) {
					echo "<ul class='anc'>";
    				while ($row = mysqli_fetch_assoc($result)) {
   						/*if ($row['img_path'] == "") {
   							$row['img_path'] = 'itemhold.jpg';
    					}*/
        				echo '
							<li>
								<a href="catalog.php?category='.$row['id'].'">
									'.$row['title'].'
								</a>
							</li>
       					';
    				}
    				echo "</ul>";
    				mysqli_free_result($result);
				}
				mysqli_close($db);
			?>
				
			<p>Более тщательно подобрать вы можете на странице <a href="catalog.php">каталога</a></p>
			<p>Также, <a href="status.php">здесь</a> вы можете узнать статус своего заказа</p>
			<h3>Оформление заказа и доставка</h3>
			<p>После оформления заказа наш менеджер свяжется с вами для уточнения деталей заказа</p>
			<p>Оплата заказа осуществляется по факту получения заказа</p>
			<p>Стоимость и время доставки обсуждается с нашим менеджером после совершения заказа</p>
		</div>
	</main>
	<?php 
		require_once("footer.php");
		
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>