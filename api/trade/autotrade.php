<?php 
    // http://localhost/prpl/api/trade/autotrade.php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Items.php';
    include_once '../../models/trade.php';
   
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));
 
    if(empty($_POST['id'])) {

        echo json_encode(
            array('message' => 'Please Insert Id')
        );
        exit;
    }
    
    // DB & connect
    $db = new Database();
    
    // Trade object
    $trade = new Trade($db,$_POST['id']);
    
    // Items object
    $items = new Items($db);

    $data = json_decode(json_encode($_POST));
    
    foreach ($data as $k=>$v) {
        $trade->$k = $v;
    }


    // Create Trade
    if($trade->autoTrade()) {

        echo json_encode(
            array('message' => 'AuotoTrade success')
        );
         
    } else {

        echo json_encode(
            array('message' => 'AuotoTrade Error')
        );

    }

  ?>