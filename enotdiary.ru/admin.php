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
        	if ($row['is_admin'] != 1) {
        		echo '<meta http-equiv="refresh" content="0; url=info.php" />';
        		exit;

        	}
   		}
    	mysqli_free_result($result);
	}
	//next handlers for forms
	if (isset($_POST['change-status-sub'])) {
		$orderid = $_POST['order-id'];
		$newStatusId = $_POST['cstat'];
		$sql = "UPDATE order_tb SET status_id = '$newStatusId' WHERE id='$orderid'";
		if (mysqli_query($db, $sql)) {
  			echo "Статтус сменен";
		} else {
 			echo "Error updating record: " . mysqli_error($db);
		}
	}
	//and change travel (curier :z)
	if (isset($_POST['change-travel-sub'])) {
		$orderid = $_POST['order-id'];
		$newTravelId = $_POST['ctravel'];
		$sql = "UPDATE order_tb SET travel_id = '$newTravelId' WHERE id='$orderid'";
		if (mysqli_query($db, $sql)) {
  			echo "Курьер сменен";
		} else {
 			echo "Error updating record: " . mysqli_error($db);
		}
	}

$target_dir = "img/upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["item-sub"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    echo "<br>".$_FILES["fileToUpload"]["name"];
    $imgName  = $_FILES["fileToUpload"]["name"];
    $title    = $_POST['title'];
    $price    = $_POST['price'];
    $author   = $_POST['author'];
    $category = $_POST['category'];
    $sql = "INSERT INTO items_tb (title, price, img, category, author)
			VALUES ('$title', '$price', '$imgName', '$category', '$author')";

if (mysqli_query($db, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($db);
}
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
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
			<h3>Панель администратора</h3>
			<hr>
			<div id="admin-wrap">
				<div id="admin-nav">
					<ul>
						<li><a href="#" id="orders" style="color: orange" onclick="showOrdersTogle()">Заказусы</a></li>
						<li><a href="#" id="addNew"  onclick="addNewTogle()">Добавить товар</a></li>
						
					</ul>
				</div>
				<div id="admin-workplace">
					<div id="add-new" class="d-none">
						<h5>Добавить новый товар</h5>
						<form class="pl-4 mt-3" action="" method="POST"  enctype="multipart/form-data">
							<label for="a_pic">Изображение</label>
							<input type="file" name="fileToUpload" id="a_pic" class="form-control">
							
							<label for="a_title" class="mt-2">Наименование</label>
							<input name="title" type="text" id="a_title" class="form-control" placeholder="Наименование...">
							
							<label for="a_price" class="mt-2">Цена</label>
							<input type="number" name="price" id="a_price" class="form-control" placeholder="Цена...">
			
							<label for="a_category" class="mt-2">Автор</label>
							<select name="author" id="a_category" class="form-control ">
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

							<label for="a_author" class="mt-2">Категория</label>
							<select name="category" id="a_author" class="form-control">
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
							<input 
								type="submit" 
								class="btn btn-primary form-control mt-3" 
								name="item-sub" 
								value="Добавить">
						</form>
					</div>
					<div id="ad-orders" class="">
						<h5>Заказы</h5>
						<table class="table table-hover table-sm table-bordered table-striped">
							<tr>
								<th>Номер</th>
								<th>Содержимое</th>
								<th>Данные клиента</th>
								<th>Цена</th>
								<th>Дата заказа</th>
								<th>Статус заказа</th>
								<th>Назначить курьера</th>
							</tr>
							<?php
							$query = "SELECT * FROM order_tb ORDER BY status_id";
								if ($result = mysqli_query($db, $query)) {
					if (mysqli_num_rows ($result) < 1) {
						echo "<h3>Заказов нет :(</h3>";
					}
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
								<td>Текущий статус: <b>'.getStatusById($row['status_id']).'</b>
								<form method="post" action="">
									<label for="cstat">Изменить на</label>
									<select id="cstat" name="cstat">';

   				$querys = "SELECT * FROM status_tb";
				if ($results = mysqli_query($db, $querys)) {
    				while ($rows = mysqli_fetch_assoc($results)) {
        				echo '
							<option value="'.$rows['id'].'">'.$rows['title'].'</option> 
       					';
    				}
    				mysqli_free_result($results);
				}
				// hard to understand what hapening here	
									echo '
									</select><br>
									<input type="hidden" value="'.$row['id'].'" name="order-id">
									<input type="submit" class="btn btn-sm btn-primary" value="Применить" name="change-status-sub">
								</form>
								</td>
								<td>';
								if ($row['status_id'] != 4) {
									
									if ($row['travel_id'] != 0) {
										echo 'Курьер: <b>'.getTravelNameById($row['travel_id']).'</b>';
									}else{
										echo "Курьер: <b>не назначен</b>";
									}
									echo '<form action="" method="POST">
									<label for="cс">Назначить</label>
									<select id="cс" name="ctravel">';
									$travelid = $row['travel_id'];
										$queryt = "SELECT * FROM users_tb where is_travel = '1'";
				if ($resultt = mysqli_query($db, $queryt)) {
    				while ($rowt = mysqli_fetch_assoc($resultt)) {
        				echo '
							<option value="'.$rowt['id'].'">'.getTravelNameById($rowt['id']).'</option> 
       					';
    				}
    				mysqli_free_result($resultt);
				}
									
									echo '
									</select><br>
									<input type="hidden" value="'.$row['id'].'" name="order-id">
									<input type="submit" class="btn btn-sm btn-success" value="Применить" name="change-travel-sub">
								</form>';
							}else
							{
								echo "Заказ <b>завершен</b>";
							}	
								echo '</td>
							
							<tr>
       					';
    				}
    				mysqli_free_result($result);
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
	<script type="text/javascript">
		function addNewTogle(){
			var target = document.getElementById('add-new')
			var target2 = document.getElementById('ad-orders')
			console.log(target.classList)
			if(target.className == 'd-none'){
				addNew.style.color = 'orange'
				orders.style.color = ''
				target2.classList.add('d-none')
				target.classList.remove('d-none')
			}else{
				target.classList.add('d-none')
				addNew.style.color = ''
			}
		}
		function showOrdersTogle(){
			var target = document.getElementById('add-new')
			var target2 = document.getElementById('ad-orders')
			console.log(target.classList)
			if(target2.className == 'd-none'){
				orders.style.color = 'orange'
				addNew.style.color = ''
				target2.classList.remove('d-none')
				target.classList.add('d-none')
			}else{
				orders.style.color = ''
				target2.classList.add('d-none')
			}
		}
	</script>
</body>
</html>