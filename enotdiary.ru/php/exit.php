<?php 
	session_start();
	unset($_COOKIE['user_id']); 
    setcookie('user_id', null, -1, '/'); 
   
	if(session_destroy()) {
      header("Location: ../info.php");
   }
?>