<?php 
    // http://localhost/prpl/api/user/update.php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // DB & connect
    $db = new Database();
    
    // User object
    $user = new User($db);
    
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));
   
    $fileName  =  $_FILES['image']['name'];
    $tempPath  =  $_FILES['image']['tmp_name'];
    $fileSize  =  $_FILES['image']['size'];

    if(!$_POST['id']) {

        echo json_encode(
            array('message' => 'Please Insert Id')
        );
        exit;
    }
    
    if(!empty($fileName)) {

        $uploadPath = '../../upload/';
	
        $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
        $validExtensions = array('jpeg', 'jpg', 'png', 'gif'); 

        if(in_array($fileExt, $validExtensions)) {				
            
            if($fileSize < 5000000){

                move_uploaded_file($tempPath, $uploadPath.$fileName);
            } else {		
                
                echo json_encode(
                    array('message' => 'Sorry, your file is too large, please upload 5 MB size')
                );
            } 
        
        } else {
            
            echo json_encode(
                array('message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed')
            );			
        }
		
        $user->image = $uploadPath.$fileName;
    }
    
    $data = json_decode(json_encode($_POST));
    
    foreach ($data as $k=>$v) {
        $user->$k = $v;
    }

    // Update User
    if($user->update()) {

        echo json_encode(
            array('message' => 'User Updated')
        );
    } else {

        echo json_encode(
            array('message' => 'User Not Updated')
        );
    }

  ?>