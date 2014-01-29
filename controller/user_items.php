<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
	$tag = $_POST['tag'];

    require_once '../include/db_connect.php';
    // connecting to database
    $db = new DB_Connect();
    $db->connect();	

	if ($tag == 'item_grid') {
		$userId = $_POST['uid'];
		$userName = $_POST['username'];
		define('USER_DIR', 'http://uw0tm8.freeiz.com/webshopper/controller/users/'.$userName.'/items/');

	    $result = mysql_query("	SELECT
								items.item_photo,
								items.item_name
								FROM
								users
								INNER JOIN items ON items.user_id = users.uid
								WHERE users.unique_id = '$userId'")
								or die(mysql_error());

		$response_arr["items"] = array();
		$items_arr = array();

		$no_of_rows = mysql_num_rows($result);

		if ($no_of_rows > 0) {
			while ($row = mysql_fetch_assoc($result)){
				$items_arr = array();
				$items_arr['item_name'] = $row['item_name'];
				$items_arr['item_photo'] = USER_DIR . $row['item_photo'];

				array_push($response_arr["items"], $items_arr);
			}
			$response_arr['status'] = 1;
			echo json_encode($response_arr);
		} else {	
			$items_arr["status"] = 0;
			echo json_encode($items_arr);
		}

	} else if ($tag == 'delete_item') {
		//TODO delete item
	}
} else {
	echo "Access Denied";
}
?>