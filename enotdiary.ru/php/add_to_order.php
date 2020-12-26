<?php
	session_start();
	$product_id = $_GET['product_id'];
	$from = $_GET['from'];
	if ($_SESSION['goodsArr']=='') {
		$_SESSION['goodsArr'] = array();
	}
	array_push($_SESSION['goodsArr'], $product_id);
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="1; URL=../catalog.php">';
?>