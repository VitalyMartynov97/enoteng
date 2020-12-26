<?php 
	require("php/db.php");
	echo '<div id="basket" onclick="toOrder()">';
	$fullPrice = '0';				
	for ($i=0; $i < (sizeof($_SESSION['goodsArr'])); $i++) { 
		$article = $_SESSION['goodsArr'][$i];
		$result = mysqli_query($db, "SELECT * FROM items_tb WHERE id='$article'");
		$row = mysqli_fetch_array($result);
		$fullPrice += $row['price'];
	}		
	echo 'В корзине: <i id="order-count">'.sizeof($_SESSION['goodsArr']).'</i> / '.$fullPrice.' руб';

	if (isset($_SESSION['user_id'])) {
		echo '<br><a href="personal.php">Личный кабинет</a>';
	}else{
		echo '<br><a href="info.php?log=1">Вход</a> | <a href="info.php?reg=1">Регистрация</a>';
	}
	echo '</div>';
?>
