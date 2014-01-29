<?php
    /*
     * Simple JSON generation from static array
     * Author: Ravi Tamada
     * web: www.androidhive.info
     *
     * This is not a RAW json format
     * A JSON encoder will parse these arrays into a JSON format
    */

    /* 
    * Section 1:
    * Connect db */
    include_once "../include/db_connect.php";
    $db = new DB_Connect();
    $db->connect();

    $result = mysql_query("
                SELECT
                    categories.id,
                    categories.category_name AS category,
                    items.item_name AS `name`,
                    users.`name` AS user_name,
                    users.full_name,
                    items.id AS item_id,
                    items.item_description,
                    items.item_price AS price,
                    items.item_photo
                FROM
                    items
                INNER JOIN categories ON items.category_id = categories.id
                INNER JOIN users ON items.user_id = users.uid;"
            );

    $results = array();
    $i = 0;
    $oldCat = "";

    while ($row = mysql_fetch_assoc($result)) {
        // If the current category is different than the previous, reset $i
        if ($row['category'] != $oldCat)
            $i = 0;

        // Set $oldCat to the current categery (used for next loop's comparison)
        $oldCat = $row['category'];

        $i++;

        // $var1 > $var2 ? true : false);
        //$i = ($row['category'] != $oldCat ? 0 : $i++);

        $results[] = array(
                    $row['id'] => array(
                        'category' => $row['category'],
                        'items' => array(
                            array(
                                // 'id'                => $i,
                                'id'                => $row['item_id'],
                                'name'              => $row['name'],
                                'user_name'         => $row['user_name'],
                                'full_name'         => $row['full_name'],
                                'price'             => $row['price'],
                                'item_photo'        => $row['item_photo'],
                                'item_description'  => $row['item_description']
                            )
                        )
                    )
        );

    }

    //var_dump($results);
    //echo $results[5][3]['category'];
    //echo count($results);

    // Begin rebuilding trees

    $output = array();

    //$results is array from mysql
    foreach ($results as $data) {
        //var_dump($data);
        //dumping each block of array
        foreach ($data as $categoryId => $item) {
            //check if NOT yet set
            if (!isset($output[$categoryId])) {
                //insert values in the first Array()
                $output[$categoryId] = array(
                    'id'       => $categoryId,
                    'category' => $item['category'],
                    'items'    => array()
                );
            }

            //populate 'items' array with stuff
            $output[$categoryId]['items'] = 
                array_merge(
                    $output[$categoryId]['items'],
                    $item['items']
            );
        }
    }

    $categories_list = $output;
    //var_dump($categories_list);

    //Debugging section
/*    echo "<h1>!DEBUG!</h1>Flat array: <br/>";
    //print_r($output);

    echo "<br/><br/>JSON encode: <br/>";
    echo json_encode($output);

    echo '<hr/>';*/


    $db->close();
?>