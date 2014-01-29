<?php
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag from client side
    $tag = $_POST['tag'];
    
    require_once 'comments_function.php';
    $cmt_func = new CMT_Functions();
    
    // view comment based on $item_id selected
    if ($tag == 'view_comment') {
        //echo 'inside if';
        $itemId = $_POST["item_id"];
        
        $comments = $cmt_func->viewComment($itemId);
        //echo 'after function';


        if($comments != false){
            $comments["status"] = 1;
            echo json_encode($comments);
        } else {
            $comments["status"] = 0;
            echo json_encode($comments);
        }
    } else if ($tag == 'submit_comment') {
        $item_id = $_POST["item_id"];
        $user_id = $_POST["user_id"];
        $comment = $_POST["comment"];

        $result = $cmt_func->submitComment($item_id, $user_id, $comment);

        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["status"] = 1;
            $response["message"] = "Product successfully created.";

            // echoing JSON response
            echo json_encode($response);
        } else {
            // failed to insert row
            $response["status"] = 0;
            $response["message"] = "Oops! An error occurred.";

            // echoing JSON response
            echo json_encode($response);
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>
