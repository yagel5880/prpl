<?php 
    class Trade {
        // DB stuff
        private $sql;
        private $table = 'trade';

        // Items Properties

        public $user_id;
        public $items;
        public $myItems;

        // Constructor
        public function __construct($db,$user_id,$myItems=null) {

            $this->sql = $db;
            $this->user_id = $user_id;
            $this->myItems = $myItems;
        }

        // Create Bids | Trades
        public function tradeCenter($tag ='bid',$temp_user_id ='' ) {
           
            if(empty($this->items) || empty($this->myItems)) return false;
            
            $items = array();
           
            foreach ($this->items as $item) {

                foreach ($this->myItems as $k=>$myItem) {
                    if ($item == $myItem && empty($items[$k])){
                        $items[$k] = $item;
                        break;
                    }
                }
            }
            
            if($items) {
             
                foreach ($items as $id=>$item_id) {
                    
                    $this->sql->query('
                        INSERT INTO `trade` SET 
                        `tag` = "'.$tag.'",
                        `user_id` = "'.$this->user_id.'" , 
                        `item_id` = "'.$id.'",
                        `temp_user_id` = "'.$temp_user_id.'" 
                    ');

                    $qr = $this->sql->query('
                        UPDATE `items` SET 
                        `tag` = "'.$tag.'"
                        WHERE `user_id` = "'.$this->user_id.'" 
                        AND `id` = "'.$id.'" 
                    ');
                }

                if($qr) return true; 

            }

            return false;
        }

        // Create Auto Trades
        public function autoTrade() { 
            if(empty($this->user_id)) return false;

            // Select all users that trade with me 
            $qr = $this->sql->query('
                SELECT `trade`.`user_id`, SUM(`ItemsList`.`value`) as `sum` FROM `trade` 
                INNER JOIN `items` ON `trade`.`item_id` = `items`.id
                INNER JOIN `ItemsList` ON `items`.`item_id` = `ItemsList`.id
                WHERE `trade`.`temp_user_id` = "'.$this->user_id.'" 
                AND `trade`.`tag` = "trade"
                GROUP BY `trade`.`user_id`
            ');

            $trade = array();
            $myItems = array();
            $tradeItems = array();
            $temp = 0;
            
            // Get the best offer for me
            if($qr->num_rows > 0 ) {

                while ($row = $qr->fetch_object()) {
                   
                    if($temp < $row->sum) {
                        $trade = $row;
                        $temp = $row->sum;
                    }
                        
                }

                // Get All my bid 
                $qr = $this->sql->query('
                    SELECT `trade`.`item_id`,`trade`.`user_id`, `ItemsList`.`value` FROM `trade` 
                    INNER JOIN `items` ON `trade`.`item_id` = `items`.id
                    INNER JOIN `ItemsList` ON `items`.`item_id` = `ItemsList`.id
                    WHERE `trade`.`user_id` = "'.$this->user_id.'" 
                    AND `trade`.`tag` = "bid"
                    ORDER BY `ItemsList`.`value` ASC
                ');

                $sum = 0;
                

                if($qr->num_rows > 0 ) { 

                    while ($row = $qr->fetch_object()) {
                        
                        $sum = $sum + $row->value;

                        if($trade->sum > $sum) {
                            $myItems[] = $row->item_id;
                        }
                            
                    }

                    // Make the transfer 
                    if(!empty($myItems)) {    
                        
                        $qr = $this->sql->query('
                            SELECT * FROM `trade`
                            WHERE `user_id`="'.$trade->user_id.'"
                            AND `temp_user_id` = "'.$this->user_id.'"
                            AND `tag` = "trade" 
                        ');

                        if ($qr->num_rows > 0) {

                            while ($row = $qr->fetch_object()) {
                        
                                $tradeItems[] = $row->item_id;   
                            }
                        }


                        // Update my items
                        $this->sql->query('
                            UPDATE `trade` SET `tag` = "traded", `temp_user_id` = "'. $this->user_id .'"
                            WHERE `item_id` IN ("'.implode('","',$tradeItems).'")
                        '); 

                        $this->sql->query('
                            UPDATE `items` SET `tag` = "", `user_id` = "'. $this->user_id .'"
                            WHERE `id` IN ("'.implode('","',$tradeItems).'")
                        ');

                        // Update trade user items    
                        $this->sql->query('
                            UPDATE `trade` SET `tag` = "bided", `temp_user_id` = "'. $trade->user_id .'"
                            WHERE `item_id` IN ("'.implode('","',$myItems).'")
                        ');

                        $this->sql->query('
                            UPDATE `items` SET `tag` = "", `user_id` = "'. $trade->user_id .'"
                            WHERE `id` IN ("'.implode('","',$myItems).'")
                        ');

                        // Trade release
                        $this->sql->query('
                            UPDATE `trade` SET `tag` = "bid_release"
                            WHERE `temp_user_id` ="'. $this->user_id .'"
                            AND `tag` ="bid"
                        ');

                        $this->sql->query('
                            UPDATE `trade` SET `tag` = "trade_release"
                            WHERE `user_id` ="'. $this->user_id .'"
                            AND `tag` ="trade"
                        ');

                        return true;
                    }
                }
            }
           
            


            return false;
        }

    }

?>