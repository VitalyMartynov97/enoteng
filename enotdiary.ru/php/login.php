<?php session_start();
	//echo '<meta charset="utf-8">';
	if (isset($_POST['submit'])) {
   		if($_SERVER["REQUEST_METHOD"] == "POST") {
   			require('db.php');
            //echo "go";
      // username and password sent from form 
      
      $myuserlogin = mysqli_real_escape_string($db,$_POST['login']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT id FROM users_tb WHERE login = '$myuserlogin' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $userid = $row['id'];
      $count  = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         //echo "finded";
         //session_register("myuserlogin");
         $_SESSION['user_id'] = $userid;
         $_SESSION['is_admin'] = $row['is_admin'];
         $_SESSION['is_travel'] = $row['is_travel'];
         setcookie("user_id", $userid, time()+3600);
         //echo "session: ".$_SESSION['user_id']."<br>";
         //echo "cookisy: ".$_COOKIE['user_id'];
         echo '<meta http-equiv="refresh" content="0; url=../personal.php?id='.$userid.'" />';
         //header("location: search.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
      //echo "unfinded";
   	}
    }
