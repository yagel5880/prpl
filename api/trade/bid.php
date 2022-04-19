<?php 
    // http://localhost/prpl/api/trade/bid.php
    // http://localhost/prpl/api/trade/bid.php?tag=trade

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

    if(empty($_POST['items'])) {

        echo json_encode(
            array('message' => 'Please Insert At list One Item To Bid')
        );
        exit;
    }
    
    // DB & connect
    $db = new Database();
    
    // Trade object
    $trade = new Trade($db,$_POST['id']);
    
    // Items object
    $items = new Items($db);

    $resultItems = $items->getUserItemsList($_POST['id']);
    
    
    if($resultItems->num_rows > 0) { 
        
        while($itemRow = $resultItems->fetch_object()) { 
            if(!empty($itemRow->tag)) continue;
            $_POST['myItems'][$itemRow->id] = $itemRow->item_id;
        }
    }

    $data = json_decode(json_encode($_POST));
    
    foreach ($data as $k=>$v) {
        $trade->$k = $v;
    }
    $tags = ['bid', 'trade'];
    $tag = 'bid';
    $temp_user_id = '';


    if(isset($_GET['tag']) && in_array($_GET['tag'],$tags)) {
        $tag = $_GET['tag'];
    }else{

        echo json_encode(
            array('message' => 'Tag Is not Valid')
        );
        exit;        
    }

    if(isset($_POST['temp_user'])) $temp_user_id = $_POST['temp_user'];

    if($tag == 'trade' && empty($temp_user_id)) {
        
        echo json_encode(
            array('message' => 'Must Have User Temp Id')
        );
        exit;
    }

    // Create Trade
    if($trade->tradeCenter($tag, $temp_user_id)) {

        echo json_encode(
            array('message' => 'Trade Bid')
        );
         
    } else {

        echo json_encode(
            array('message' => 'Trade Not Bid')
        );

    }

  ?>