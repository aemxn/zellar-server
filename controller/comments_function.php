<?php

class CMT_Functions {
    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once '../include/db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
    
    // destructor
    function __destruct() {
        
    }

    // Get comment by item_id
    public function viewComment($itemId) {
        $result = mysql_query("SELECT
                                    comments.`comment` AS `comments`,
                                    comments.to_item_id AS item_id,
                                    users.`name`
                                FROM
                                    comments
                                INNER JOIN items ON comments.to_item_id = items.id
                                INNER JOIN users ON comments.from_user_id = users.unique_id
                                WHERE
                                    comments.to_item_id = '$itemId'")
                            or die(mysql_error());
        
        $response_arr["comments"] = array();
        $comments_arr             = array();
        
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            while ($row = mysql_fetch_assoc($result)){
                // comments array
                $comments_arr = array();
                $comments_arr["user_name"] = $row["name"];
                $comments_arr["comment"] = $row["comments"];

                // item id block (outer)
                $response_arr["item_id"] = $row["item_id"];

                // push comments array into item_id block
                array_push($response_arr["comments"], $comments_arr);
            }
            return $response_arr;
        } else { return false; }
    }

    public function submitComment($item_id, $user_id, $comment) {

        $result = mysql_query("INSERT INTO comments(`comment`, from_user_id, to_item_id, created_at) VALUES ('$comment','$user_id','$item_id', NOW())")
                    or die (mysql_error());

        return $result;
    }
}

?>
