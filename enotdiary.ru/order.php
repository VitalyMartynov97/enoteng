<?php 
  session_start();
  require("php/db.php");
  if (isset($_GET['clear'])) {
    $_SESSION['goodsArr'] = [];
  }
  if (isset($_GET['del'])) {
    array_splice($_SESSION['goodsArr'], array_search($_GET['del'], $_SESSION['goodsArr'] ), 1);
    header('Location: order.php');
  }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/order.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Информация - Дневник Енота</title>
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
			<h1>Корзина</h1>
			<br>
      <?php
        $isEmpty = false;
        if (sizeof($_SESSION['goodsArr']) < 1) {
          $isEmpty = true;
          echo "<h4>Корзина пуста :(</h4>";
        }
      if (!$isEmpty) {
        echo '
          <table class="table table-hover table-sm table-bordered">
            <thead>
              <tr>
                <th scope="row">#</th>
                <th scope="row">Изображение</th>
                <th scope="row">Наименование</th>
                <th scope="row">Цена</th>
                <th scope="row">Удалить</th>
              </tr>
            </thead>
          <tbody>
        ';
      
			
      $fullPrice = 0;
      for ($i=0; $i < (sizeof($_SESSION['goodsArr'])); $i++) { 
        $viewI = $i + 1;
        $article = $_SESSION['goodsArr'][$i];
        $result = mysqli_query($db, "SELECT * FROM items_tb WHERE id='$article'");
        $row = mysqli_fetch_array($result);
        $fullPrice += $row['price'];
        echo '
          <tr>
            <td>'.$viewI.'</td>
            <td><img src="img/upload/'.$row['img'].'" class="order-img"></td>
            <td>'.$row['title'].'</td>
            <td>'.$row['price'].' руб</td>
            <td><a href="?del='.$row['id'].'"><i class="far fa-trash-alt"></i></a></td>
          </tr>
        ';
      } 
    echo '
    
  </tbody>
</table>
      <hr>
      <div id="order-navigate">
        
        <div id="order-navigate-price">
          К оплате: <b>'.$fullPrice.' руб</b>
          <br>
          <a href="confirm.php" class="btn btn-success mt-3">Оформить заказ</a>
          <br>
          <a href="order.php?clear=1">Очистить корзину</a>
        </div>
      </div>
      '; } ?>
		</div>
	</main>
	<?php 
		require_once("footer.php");
    
	?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>