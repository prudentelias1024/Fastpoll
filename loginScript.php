<?php 
include './db.php';
$db = new Db; 
if (isset($_POST['password'])) {
    $usernameoremail = $_POST['usernameoremail'];
    $password = $_POST['password'];
    
    $result = explode('@',$usernameoremail);
    if (count($result) > 1) {
        #verify hash password
        $title = 'email';
        $result = $db->getUserPassword($title,$usernameoremail);
        if ($result['password'] == 404){
            echo json_encode(array(
                'message' => 'User Not Found',
                'success' => false
            ));
            exit;
                       
        }else{
         $h_password = $result['password'];

         if(password_verify($password,$h_password)){
            $user_profile = $db->getUserByEmail($usernameoremail);

            session_start();

            $_SESSION['id'] = $user_profile[0];
            $_SESSION['fullname'] = $user_profile[1];
            $_SESSION['email'] = $user_profile[2];
            $_SESSION['username'] = $user_profile[3];
            $_SESSION['profile_img'] = $user_profile[4];
            echo json_encode(array(
                'message' => 'Login Successfully',
                'success' => true
            ));
            exit;
        
        } else {
            echo json_encode(array(
                'message' => 'Password not correct',
                'success' => false
            ));
            exit;
              
        }
        }

    } else {
        $title = 'username';
        $result = $db->getUserPassword($title,$usernameoremail);
        if ($result['password'] == 404){
            echo json_encode(array(
                'message' => 'User Not Found',
                'success' => false
            ));
            exit;
        } else {
         $h_password = $result['password'];
   
        if(password_verify($password,$h_password)){
            $user_profile = $db->getUserByUsername($usernameoremail);
            if(!key_exists('status',$user_profile)){
            session_start();

            $_SESSION['id'] = $user_profile[0];
            $_SESSION['fullname'] = $user_profile[1];
            $_SESSION['email'] = $user_profile[2];
            $_SESSION['username'] = $user_profile[3];
            $_SESSION['profile_img'] = $user_profile[4];
            echo json_encode(array(
                'message' => 'Login Successfully',
                'success' => true
            ));
            exit;
  
        } else {
    
                echo json_encode(array(
                    'message' => 'User Not Found',
                    'success' => false
                ));
                exit;
            }
        } else {
            echo json_encode(array(
                'message' => 'Password not correct',
                'success' => false
            ));
            exit;
        }

    }
    }
   
}



?>