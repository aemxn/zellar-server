<?php
/*
 * Second level ListView
 * Echoes list of songs under album id passed from AlbumsActivity
 * Passing parameter id as GET
 *
 * example of output (id=4):
 * 		http://api.androidhive.info/songs/album_tracks.php?id=4
 *
 * Thanks to Ravi
 */

include_once './data.php';

// Check if album id is posted as GET parameter
// &&: evaluate first expression, if it is true then evaluate the second one. Then do the &&
//		to ensure it won't throw any exception
if (isset($_GET["id"]) && $_GET["id"] != "") {

    // Check if the album id exists in album_tracks array
    if (array_key_exists($_GET["id"], $categories_list)) {
        // print album tracks json
        echo json_encode($categories_list[$_GET["id"]]);
    } else {
        // no album found
        echo "{}";
    }
}


?>