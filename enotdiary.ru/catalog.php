<?php 
	session_start();
	require("php/db.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/catalog.css">
	<link rel="stylesheet" type="text/css" href="css/item.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<title>Каталог - Дневник Енота</title>
	<script
  		src="https://code.jquery.com/jquery-3.5.1.js"
  		integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  		crossorigin="anonymous">
  	</script>
  	<script type="text/javascript">

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
			<h1>Каталог</h1>
			<hr>
			<form method="get" action="">
				<!--<label for="search-field">Поиск по названию</label>-->
				<input type="select" name="search" id="search-field" placeholder="Найти...">
				<input type="submit" name="title_search" value="Поиск">
			</form>
			<hr>
			<form method="GET" action="">
				<label for="author-select">Автор</label>
				<select name="author" id="author-select">
				<?php
   				require('php/db.php');
   				$query = "SELECT * FROM author_tb";
				if ($result = mysqli_query($db, $query)) {
    				while ($row = mysqli_fetch_assoc($result)) {
        				echo '
							<option value="'.$row['id'].'">'.$row['title'].'</option> 
       					';
    				}
    				mysqli_free_result($result);
				}
				?> 
				</select>
				<label for="category-select">Категория</label>
				<select name="category" id="category-select">
				<?php
   				$query = "SELECT * FROM category_tb";
				if ($result = mysqli_query($db, $query)) {
    				while ($row = mysqli_fetch_assoc($result)) {
        				echo '
							<option value="'.$row['id'].'">'.$row['title'].'</option> 
       					';
    				}
    				mysqli_free_result($result);
				}
				?> 
				</select>
				<br>
				<input type="submit" name="param_btn" value="Применить">
			</form>
			<hr>
			<div id="items-holder">
				<?php
				$isAdmin = false;
				$id     = $_SESSION['user_id'];
   				$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
    			$result = mysqli_query($db,$sql);
   				$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
   				if ($row['is_admin'] == 1) {
   					$isAdmin = true;
   				}
   				$query = "SELECT * FROM items_tb";
   				if (isset($_GET['author'])) {
   					$id = $_GET['author'];
   					$query = "SELECT * FROM items_tb WHERE author = '$id'";
   				}
   				if (isset($_GET['category'])) {
   					$id = $_GET['category'];
   					$query = "SELECT * FROM items_tb WHERE category = '$id'";
   				}
   				if (isset($_GET['title_search'])) {
   					$search = $_GET['search'];
					$query = "SELECT * FROM items_tb WHERE (title LIKE '%$search%')";
				}
				if (isset($_GET['param_btn'])) {
   					$cat = $_GET['category'];
   					$author = $_GET['author'];
					$query = "SELECT * FROM items_tb WHERE category = '$cat' AND author = '$author'";
				}
 	
				if ($result = mysqli_query($db, $query)) {
					if (mysqli_num_rows ($result) < 1) {
						echo "<h3>Ничего не найдено :(</h3>";
					}
    				while ($row = mysqli_fetch_assoc($result)) {
   						
        				echo '
							<div class="item">
								<img src="img/upload/'.$row['img'].'" id="img1" class="item-img" >
								<div class="item-desc">
									<div>
										<span class="item-title">'.$row['title'].'</span>
										<br>
										<span class="item-price">'.$row['price'].' руб</span>
										';
										if ($isAdmin) {
											echo "<a class='ml-3' style='color: red;' href='delete_item.php?id=".$row['id']."'>Удалить</a>";
										}
										echo '
									</div>
									<div>
										<a href="php/add_to_order.php?product_id='.$row['id'].'" class="item-tobasket" id="tobasket-status"">
											<i class="fas fa-shopping-cart"></i>
										</a>
									</div>
								</div>
							</div>
       					';
    				}
    				mysqli_free_result($result);
				}
				mysqli_close($db);
			?>

				


				
			</div>
		</div>
	</main>
	
	<?php 
		require_once("footer.php");
		
	?>
	<div id="itemfull" class="modal hidden">
		<div id="modal-center" onclick="event.stopPropagation()">
			<div id="modal-close" >X</div>
		</div>
	</div>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>


<!--

<div class="item">
								<img src="img/upload/`.$row['img'].`" id="img1" class="item-img" onclick="setModal('img1')">
								<div class="item-desc">
									<div>
										<span class="item-title">`.$row['title'].`</span>
										<br>
										<span class="item-price">`.$row['price'].` руб</span>
									</div>
									<div>
										<span class="item-tobasket" id="tobasket-status" onclick="addToOrder()">
											<i class="fas fa-shopping-cart"></i>
										</span>
									</div>
								</div>
							</div>
-->