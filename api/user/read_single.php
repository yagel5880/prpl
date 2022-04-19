<?php 
    // http://localhost/prpl/api/user/read_single.php?id=1234

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';
    include_once '../../models/Items.php';

    // DB & connect
    $db = new Database();
    
    // User object
    $user = new User($db);
    
    // Items object
    $items = new Items($db);

    // Get Items List
    $itemsList = array();
    $itemsList = json_decode(json_encode($items->getItemsList()),1);
  
    // Get ID
    $user->id = isset($_GET['id']) ? $_GET['id'] : die();
    $status = isset($_GET['tag']) ? $_GET['tag'] : 'my';
    // User read query
    $result = $user->read_single();
 
    // Check if any users
    if($result->num_rows > 0) {
        
        // Array
        $userArr = array();

        while($row = $result->fetch_object()) {            
            $userArr[$row->id] = (array)$row;

            $resultItems = $items->getUserItemsList($row->id,$status);
 
            if($resultItems->num_rows > 0) { 
                $count = 0;
                while($itemRow = $resultItems->fetch_object()) { 

                    $userArr[$row->id][$status][$count]['value'] =  $itemsList[$itemRow->item_id]['value'];
                    $userArr[$row->id][$status][$count]['name'] =  $itemsList[$itemRow->item_id]['name'];
                     
                   
                    $count++;
                }
            }
            
        }

        // User JSON output
        echo json_encode($userArr);

    } else {

        // No User
        echo json_encode(
            array('message' => 'No User Found')
        );
        exit;
    }

?>    