<?php

/*
 *	This is first level View
 *	Echoes list of categories in JSON
 *	Data is taken from data.php
 *
 *	example of output: http://api.androidhive.info/songs/albums.php
 */
require_once '../include/db_connect.php';

// connecting to database
$db = new DB_Connect();
$db->connect();
// include_once './data.php';


$result = mysql_query(" SELECT
    categories.id,
    categories.category_name,
	categories.category_logo,
    COUNT(items.item_name) AS items
FROM
    categories LEFT JOIN items
        ON items.category_id = categories.id
GROUP BY
    categories.id")
						or die(mysql_error());

// looping throguh each categories
while($row = mysql_fetch_assoc($result)){
	$categories[] = array('id' => $row['id'],
						'category' => $row['category_name'],
						'categories_logo' => $row['category_logo'],
						'categories_count' => $row['items']);
} 

// looping through each album
/*foreach ($categories_list as $category) {
    $tmp = array();
    // returns id integer
    $tmp["id"] = $category["id"];
    // returns Album string
    $tmp["category"] = $category["category"];
    // returns no of item in Songs array
    $tmp["categories_count"] = count($category["items"]);

    // push album
    array_push($categories, $tmp);
}
*/
echo json_encode($categories);

/*{
	'categories':
		[
			{
				'id':
				'category':
				'categories_count':
			}
		]
}*/
?>
