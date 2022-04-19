<?php 
    class Items {
        // DB stuff
        private $sql;
        private $table = 'items';

        // Items Properties

        public $getItemsList;
        
        // Constructor
        public function __construct($db) {

            $this->sql = $db;
        }

        // Get Items List
        public function getItemsList() { 

            $qr = $this->sql->query('SELECT * FROM `ItemsList`');
            $this->getItemsList = new stdClass();

            if($qr->num_rows > 0) {

                while ($row = $qr->fetch_object()) {
                    $this->getItemsList->{$row->id} = $row; 
                }
            }            

            return $this->getItemsList;            
        }
        
        // Get User Items
        public function getUserItemsList($user=null,$status="my"){
            if($user==null) return false;
            if(empty($status)) $status="my";
  
            switch ($status) {
                
                case 'bided':
                   
                    $qr = $this->sql->query('
                        SELECT * FROM `trade`
                        INNER JOIN `items` ON `trade`.item_id = `items`.`id`
                        WHERE `trade`.`user_id` = "'.$user.'" 
                        AND `trade`.`tag`="'.$status.'"
                    ');

                    break;

                case 'traded':
                 
                    $qr = $this->sql->query('
                        SELECT * FROM `trade`
                        INNER JOIN `items` ON `trade`.item_id = `items`.`id`
                        WHERE `trade`.`temp_user_id` = "'.$user.'" 
                        AND `trade`.`tag`="'.$status.'"
                    ');

                    break;    
                
                default:
                 
                    $qr = $this->sql->query('
                        SELECT * FROM `items`
                        WHERE `user_id` = "'.$user.'" 
                        AND `status`="'.$status.'"
                    ');

                    break;
            }  

            return $qr; 
        }
    
        // Set User Items
        public function setUserItemsList($user=null, $item=null, $status='my' ){
            
            if($user==null || $item==null) return false;
        
            $this->sql->query('
                INSERT INTO `items` SET 
                `user_id` = "'. $user .'",
                `item_id` = "'. $item . '",
                `status` = "'. $status .'"
            ');
            
            return true;
        }

        
    }

?>