<?php
session_start();
include './db.php';
$db = new Db;
$polls = $db->getPolls();
$modPoll=[];
  foreach ($polls as  $poll) {
    if ($_SESSION) {
  
        $result =  $db->checkVoted($poll['id'],$_SESSION['id'])['Voted'];
        if($result == 1){
            $poll['voted'] = true;
        }else{
            $poll['voted'] = false;
            
        }
        array_push($modPoll,$poll);
    } else {
        $poll['voted'] = false;
        array_push($modPoll,$poll);


    }
}
 
echo json_encode($modPoll);

?>