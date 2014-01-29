<?php

		include_once "../include/db_connect.php";
	    $db = new DB_Connect();
	    $db->connect();

	    $result = mysql_query("
					SELECT
					version_update.message,
					version_update.current_ver
					FROM
					version_update");

	    while ($row = mysql_fetch_array($result)) {
	    	$response = array('message' => $row['message'], 'current_version' => $row['current_ver']);
	    }
	    echo json_encode($response);

?>