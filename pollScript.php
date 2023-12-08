<?php
include  './db.php';
$db = new Db;
session_start();
if(isset($_POST['title'])){
    $error_messages = [];
    if ($_POST['title'] == '') {
       array_push($error_messages, 'Question cannot be empty');
   
    }
    if ($_POST['option_1'] == '') {
       array_push($error_messages, 'Option One cannot be empty');
   
    }
    if ($_POST['option_2'] == '') {
       array_push($error_messages, 'Option two cannot be empty');
   
    }
    if($_POST['title'] != '' && $_POST['option_1'] != '' && $_POST['option_2'] != '') {
    $title = $_POST['title'];
    $option_1 = $_POST['option_1'];
    $option_2 = $_POST['option_2'];
    $option_3 = $_POST['option_3'];
    $option_4 = $_POST['option_4'];
    $user = $_SESSION['id'];
    $done =  $db->createPoll($user,$title,$option_1,$option_2,$option_3,$option_4);
    if($done){
        echo json_encode(array(
            'message' => 'Poll created successfully',
            'success' => true
        ));
        exit;
    
    }
} 
echo json_encode(array(
    'message' => $error_messages,
    'success' => false
));

}




?>