<?php 
	function getStatusById($id){
		require("db.php");
		$sql    = "SELECT * FROM status_tb WHERE id = '$id'";
    	$result = mysqli_query($db,$sql);
   		$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
   		switch ($row['id']) {
   			case 1:
   				return '<span class="text-muted">'.$row['title'].'</span>';
   				break;
   			case 2:
   				return '<span class="text-warning">'.$row['title'].'</span>';
   				break;
   			case 3:
   				return '<span class="text-primary">'.$row['title'].'</span>';
   				break;
   			case 4:
   				return '<span class="text-success">'.$row['title'].'</span>';
   				break;

   			default:
   				return '<span>'.$row['title'].'</span>';
   				break;
   		}
	}
	function getItemTitleById($id){
		require("db.php");
		$sql    = "SELECT * FROM items_tb WHERE id = '$id'";
    	$result = mysqli_query($db,$sql);
   		$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
   		return $row['title'];
	}
	function getItemsTitlesByOrderId($order_id){
		require("php/db.php");
			$query = "SELECT * FROM order_item_id WHERE order_id = '$order_id'";
			$resString = "";
			if ($result = mysqli_query($db, $query)) {
    			while ($row = mysqli_fetch_assoc($result)) {
    				$resString = $resString . getItemTitleById($row['item_id']).'; ';
    			}
    			mysqli_free_result($result);
    		}else{
    			echo "Что то не так с запросом";
    		}
    		return $resString;
    		mysqli_close($db);
	}

	function getTravelNameById($id){
		require("db.php");
		$fullName = "";
		$sql    = "SELECT * FROM users_tb WHERE id = '$id'";
    	$result = mysqli_query($db,$sql);
   		$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
   		$fullName = $row['name']." ".$row['last_name'];
   		return $fullName;
	}


?>