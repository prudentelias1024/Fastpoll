<?php
include './db.php';
$db = new Db;
session_start();
 
if (isset($_POST['option'])) {
    if ($_SESSION) {
    
    $voted = false;
    $option = $_POST['option'];
    $user_id = $_SESSION['id'];
    $option_value = $_POST['option_value'] ;
    $poll_id = $_POST['poll_id'];
    $res = $db->vote($poll_id,$user_id,$option,$option_value);
    if($res){
        echo json_encode(array(
            'message' => $res,
            'success' => true
        ));
        exit;
    
    } 
} else {
    echo json_encode(array(
        'message' => 403,
        'success' => false
    ));
    
}
}



?>