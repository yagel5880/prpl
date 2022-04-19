<?php 
    // http://localhost/prpl/api/user/create.php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';
    include_once '../../models/Items.php';
 
    // DB & connect
    $db = new Database();
    
    // User object
    $user = new User($db);
    
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));
    
    if($_FILES){

        $fileName  =  $_FILES['image']['name'];
        $tempPath  =  $_FILES['image']['tmp_name'];
        $fileSize  =  $_FILES['image']['size'];
    }

    if(empty($_POST['id'])) {

        echo json_encode(
            array('message' => 'Please Insert Id')
        );
        exit;
    }

    if(empty($_POST['name'])) {

        echo json_encode(
            array('message' => 'Please Insert Name')
        );
        exit;
    }

    if(empty($fileName)) {

        echo json_encode(
            array('message' => 'Please Select Image')
        );
        exit;
    } else { 

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
                exit;
            } 
        
        } else {
            
            echo json_encode(
                array('message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed')
            );
            exit;			
        }
		
    }

    $data = json_decode(json_encode($_POST));
    
    foreach ($data as $k=>$v) {
        $user->$k = $v;
    }

    $user->image = $uploadPath.$fileName;

    // Create User
    if($user->create()) {
        
        echo json_encode(
            array('message' => 'User Created')
        );
         
        // Generates items randomly
        $items = new Items($db);

        $itemsList = json_decode(json_encode($items->getItemsList()),1);  
        $rand = rand(3,20);
        $total = 0;
        $tempTotal = 0;
        $userItems = array();
        
        for ($i=0; $i <= $rand; $i++) { 
            
            $randItem = rand(1,6);
            $tempTotal += $itemsList[$randItem]['value'];
            
            if($tempTotal <= 20) {
                $total += $itemsList[$randItem]['value'];
                $items->setUserItemsList($user->id,$itemsList[$randItem]['id']); 
            }else{
                break;
            } 
        }    
        
        echo json_encode(
            array('message' => 'User Generates total value '.$total)
        );

    } else {

        echo json_encode(
            array('message' => 'User Not Created')
        );
        exit;
    }

  ?>