<?php
session_start();
include './db.php';
$db = new Db;
$polls = $db->getMyPolls($_SESSION['id']);
$modPoll=[];
  foreach ($polls as  $poll) {
        $result =  $db->checkVoted($poll['id'],$_SESSION['id'])['Voted'];
        if($result == 1){
            $poll['voted'] = true;
        }else{
            $poll['voted'] = false;
            
        }
        array_push($modPoll,$poll);
    }
 
echo json_encode($modPoll);

?>