<?php

class DB {
public function connectToDB(){
    $conn = new mysqli('localhost','root','','fastpoll');
    if($conn->connect_error){
        die('Connection Failed: '. $conn->connect_error);
    }
    return $conn;
}


public function createUser($fullname,$username,$email,$dob,$profile_img,$password){
    $this->connectToDB();
    $sql = "INSERT INTO users(fullname,username,email,dob,profile_img,password) VALUES('$fullname','$username', '$email', '$dob', '$profile_img','$password')";
    if($this->connectToDB()->query($sql)){
        return true;
    } else {
        return false;
    }
}

public function getUserByEmail($email){
    $this->connectToDB();
    $sql = "SELECT * FROM users WHERE email ='$email'";
        $result = $this->connectToDB()->query($sql);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                return array($rows['id'],$rows['fullname'], $rows['email'], $rows['username'], $rows['profile_img']);
            }
        
       
    } else {
        return ["status" =>404];
    }
}

public function getUserPassword($title,$value){
    $this->connectToDB();
    $sql = "SELECT password, $title FROM users WHERE $title = '$value'";
    $result = $this->connectToDB()->query($sql);
    if($result->num_rows > 0){
        while($rows = $result ->fetch_assoc()){
            return ["password" => $rows['password']];
        }
    }else {
        return  ["password" => 404];
    }
}


public function getUserByUsername($username){
    $this->connectToDB();
    $sql = "SELECT * FROM users WHERE username ='$username'";
        $result = $this->connectToDB()->query($sql);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                return array($rows['id'],$rows['fullname'], $rows['email'], $rows['username'], $rows['profile_img']);
               }
        
    } else {
        return ["status" =>404];
    }
}

public function createPoll($user,$text,$option_1,$option_2,$option_3, $option_4){
    $user = intval($user);
    $text = strval($text);
    $this->connectToDB();
    $sql = "INSERT INTO polls(user,text,  option_1,option_2,option_3,option_4) VALUES($user,'$text','$option_1','$option_2','$option_3','$option_4')";
    if($this->connectToDB()->query($sql)){
            return true;
        } else {
            return false;
     
    }
  
}

public function getPolls(){
    $this->connectToDB();
    $sql = "SELECT polls.*, users.fullname, users.username, users.profile_img FROM polls INNER JOIN  users   ON polls.user =users.id ORDER BY polls.created_on DESC";
    $polls = [];
    $result = $this->connectToDB()->query($sql);
    if($result->num_rows > 0){
        while ($rows = $result->fetch_assoc()) {
            array_push($polls,$rows);

        }
        return $polls;
    }else {
        return [];
    }
}


public function getMyPolls($user){
    $this->connectToDB();
    $my_poll = [];
    $sql = "SELECT polls.*, users.fullname, users.username, users.profile_img FROM polls INNER JOIN  users   ON polls.user = users.id WHERE user=$user";
    $result = $this->connectToDB()->query($sql);
  
        if($result->num_rows > 0){
            while ($rows = $result->fetch_assoc()) {
                array_push($my_poll,$rows);
    
            }
            return $my_poll;
        }else {
            return [];
        
    }
}

// public function getVoters($poll_id){
//     $this->connectToDB();
//     $voters = [];
//     $sql = "SELECT * FROM voters WHERE poll_id=$poll_id";
//     if($this->connectToDB()->query($sql)){
//       if($result->num_rows > 0){
//         while ($rows = $result->fetch_assoc()) {
//             array_push($voters,$rows);

//         }
//         return $voters;
//     }else {
//         return [];
//     }   
//     }
// }
public function checkVoted($poll_id,$user_id){
    $this->connectToDB();
    $voters = [];
    $sql = "SELECT COUNT(*) AS Voted FROM voters WHERE poll_id=$poll_id AND user_id = $user_id";
    if($result = $this->connectToDB()->query($sql)){
        return $result->fetch_assoc();
    }else {
        return [];
    }   
    }


public function vote($poll_id, $user_id,$option_taken, $option_new_value){
    $this->connectToDB();
    $poll_to_retrieve = [];
    $sql = "UPDATE  polls SET  $option_taken= $option_new_value WHERE id=$poll_id ";
    if($this->connectToDB()->query($sql)){
        $sql = "INSERT INTO voters(poll_id,user_id) VALUES($poll_id,$user_id)";
        if($this->connectToDB()->query($sql)){
            $sql = "SELECT * FROM polls INNER JOIN  users ON polls.user = users.id WHERE polls.id= $poll_id ";
  
            $result = $this->connectToDB()->query($sql);
            if($result->num_rows > 0){
                while ($rows = $result->fetch_assoc()) {
                    array_push($poll_to_retrieve,$rows);
                }
                return $poll_to_retrieve;
            }
  
        } else {
        return false;
    }
}
}


}



?>