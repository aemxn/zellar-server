<?php
/*
* Section 1: Connect db
* Section 2: retrieve image
* Section 3: get image filename
* Section 4: store/update in db
* Section 5: retrieve in android via img lazyload
*/
	
	/* 
	* Section 1:
	* Connect db */
	include_once "../include/db_connect.php";
	$db = new DB_Connect();
	$db->connect();

	/* 	
	* Section 2:
	* Retrieve image from device via HTTP Request */
	if ($_POST) {
	    $img = $_POST['image'];
		$txtItemName = mysql_real_escape_string($_POST['item_name']);
		$txtItemDescription = mysql_real_escape_string($_POST['item_desc']);
		$txtItemPrice = mysql_real_escape_string($_POST['item_price']);

		// search category id
		$txtCatName = mysql_real_escape_string($_POST['category_name']);
        $sql = mysql_query("SELECT * FROM categories");
        while($row = mysql_fetch_array($sql)){
        	//var_dump($row['category_name']);
        	if($row['category_name'] == $txtCatName)
        		$catId = $row['id'];
        }

		// search user id
		$txtUserName = mysql_real_escape_string($_POST['user_name']);
        $sql = mysql_query("SELECT uid, name FROM users");
        while($row = mysql_fetch_array($sql)){
        	//var_dump($row['name']);
        	if($row['name'] == $txtUserName)
        		$userId = $row['uid'];
        }

		//echo $txtItemName." ".$txtItemDescription." ".$txtCatName." ".$txtUserName." ".$txtItemPrice." ";


	    $img = str_replace('data:image/jpeg;base64,', '', $img);
	    $img = str_replace(' ', '+', $img);
	    $data = base64_decode($img);

		/*
		* Section 3:
		* Get image filename */
		//$username='testuser';
		define('UPLOAD_DIR', 'users/'.$txtUserName.'/items//');
	    $file = UPLOAD_DIR . $txtUserName . "_" . uniqid() . '.jpg';
	    $success = file_put_contents($file, $data);
	    print $success ? $file : 'Unable to save the file.';

		/*
		* Section 4
		* Store or update directory and filename in db
		*/
		//mysql_query("UPDATE users SET profile_photo_uri = '".$file."' WHERE name = '".$txtUserName."'");

        // Insert new record to database
        mysql_query("INSERT INTO items (item_photo, item_description, item_price, item_name, category_id, user_id)
        			VALUES ( '".$file."',
        				'".$txtItemDescription."',
        				'".$txtItemPrice."',
        				'".$txtItemName."',
        				'".$catId."',
        				'".$userId."'
        				)")
                    or die (mysql_error());

		$db->close();

	}


?>

