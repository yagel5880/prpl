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
        public function getUserItemsList($user=null,$status="my" ){
            if($user==null) return false;
            
            $qr = $this->sql->query('SELECT * FROM '. $this->table .' WHERE `user_id` = "'.$user.'" AND `status`="'.$status.'"' );
            
            return $qr; 
        }
    
        // Set User Items
        public function setUserItemsList($user=null, $item=null){
            
            if($user==null || $item==null) return false;
            
            $qr = $this->sql->query('INSERT INTO '. $this->table .' SET `user_id` = "'.$user.'", `item_id`="'.$item.'", status = "my"' );
            
            if($qr) return true;
            
            return false;
        }

        
    }

?>