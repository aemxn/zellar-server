<?php

/*
 * Third level View after album_tracks.php
 * Echoes the song information from album_id and item_id
 * Passed from TrackListActivity.java
 *
 * example of output (category=3, item=1):
 *      http://api.androidhive.info/songs/track.php?category=3&item=1
 *      http://localhost/webshopper/controller/item_details.php?category=3&item=6
 *
 * Thanks to Ravi
 */

include_once './data.php';

// check if song id is posted as GET param
// &&: evaluate first expression, if it is true then evaluate the second one
//      to ensure it won't throw any exception
if (isset($_GET["category"]) && $_GET["category"] != "" && isset($_GET["item"]) && $_GET["item"] != "") {
    $category_id = $_GET["category"];
    $item_id = $_GET["item"];

    // get the category
    $category = array_key_exists($category_id, $categories_list) ? $categories_list[$category_id] : NULL;
    if ($category != NULL) {
        // category found 
        // get item array by item_id
        foreach($category["items"] as $data => $key){
            if ($key["id"] == $item_id)
                $item = $key;
            else NULL;
        }

        $item["category_id"] = $category_id;
        $item["category"] = $category["category"];
        echo json_encode($item);
    } else {
        // no category found
        echo "no category";
    }
}
?>