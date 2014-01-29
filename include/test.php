<?php
	$name = "Jijiecomel";
    DEFINE("dirpath", "../controller/users/".$name."/items\/");

    $result = mkdir(dirpath, 0, true);
    
    if ($result == 1) {
        echo dirpath . " has been created";
    } else {
        echo dirpath . " has NOT been created";
    }
?>