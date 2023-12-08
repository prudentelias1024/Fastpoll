<?php
if (isset($_POST['fullname'])) {
    $error_messages = [];
    $full_name = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $password_1 = $_POST['password'];
    $password_2 = $_POST['password_conf'];
    $targetDir = 'uploads/';
    $targetFile = $targetDir. basename($_FILES['profile_img']['name']);
  
    if($full_name == ''){
        array_push($error_messages,["fullname_error"  =>'Enter a fullname']);
    }
    
    if($username == ''){
        array_push($error_messages,["username_error"=> 'Enter a username']);
    }
    if($email == ''){
        array_push($error_messages,["email_error" => 'Enter a email']);
    }
    if($dob == ''){
        array_push($error_messages, ["dob_error" => 'Please choose a Date Of Birth']);
    }
  
    if($password_1 == ''){
        array_push($error_messages,["password_error" => 'Please type in your password']);
    }
    
    
    if($password_2 == ''){
        array_push($error_messages, ["password_conf_error"  => 'Please repeat password here ']);
    }
    
    if(!empty($_FILES['profile_img'])){
        array_push($error_messages,["profile_image_error"=> 'Please upload an image ']);
    }
    
    
    if($password_1 != $password_2){
        array_push($error_messages, 'Please repeat password here ');
    }
    if (count($error_messages) == 0) {

        if(move_uploaded_file($_FILES['profile_img']['tmp_name'], $targetFile)){
        }
         else {
            echo 'Error uploading Image';
        }
    if($password_1 == $password_2 && !empty($_FILES['profile_img'])){
        $h_password = password_hash($password_1, PASSWORD_DEFAULT);
        include './db.php';
        $db = new DB;
        if ($db->getUserByEmail($email)['status'] == 404) {
        $created =  $db->createUser($full_name,$username,$email,$dob,$targetFile,$h_password);
        if ($created) {
            echo json_encode(array(
                'message' => 'User Created Succesfully',
                'success' => true
            ));
            exit;
    
        } else {
            echo json_encode(array(
                'message' => 'Couldn\'t create User',
                'success' => false
            ));
            exit;
      
    }
    } else {
        #if user  exists
        echo json_encode(array(
            'message' => 'User  already exists',
            'success' => false
        ));
        exit;
  
    }
    }
    

} else {
    echo json_encode(array(
        'message' => $error_messages,
        'success' => false
    ));

}

}



?>