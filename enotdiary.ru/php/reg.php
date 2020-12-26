<?php 
	require("db.php");
	if(isset($_POST['submit'])){
		$login    = $_POST['login'];
		$password = $_POST['password'];
		$name     = $_POST['name'];
		$last     = $_POST['last_name'];
		$email    = $_POST['email'];
		$phone    = $_POST['phone'];
		$address    = $_POST['address'];
		$regdate  = date("d.m.yy");
	}

	if ($login !== 'admin') {
		$sql = "INSERT INTO users_tb 
			(name, last_name, email, phone, address, login, password, reg_date) 
			VALUES 
			('$name','$last','$email','$phone','$address','$login', '$password', '$reg_date')";	
		if (mysqli_query($db, $sql)) {
  			echo "Успешная регистрация! Перенаправление на страницу входа";
  			mysqli_close($db);
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=../info.php?log=1">';
		} else {
		  echo "Ошибка: <br>" . mysqli_error($db);
		}	  
    }else{
    	echo 'Логин "admin" не может быть использован!! Приносим свои извинения<br>Придумайте другой логин<br>'; 
	    echo '<a href="reg.php">Регестрация</a>';
    }

?>