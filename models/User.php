<?php 
    class User {
        // DB stuff
        private $sql;
        private $table = 'user';

        // User Properties
        public $id;
        public $name;
        public $image;
        
        // Constructor
        public function __construct($db) {

            $this->sql = $db;
        }

        // Get Users
        public function read() { 

            $qr = $this->sql->query('SELECT * FROM `'.$this->table.'`');
            
            return $qr;            
        }

        // Get Single User
        public function read_single() {

            $qr = $this->sql->query('SELECT * FROM `'.$this->table.'` WHERE `id` = "'.$this->id.'"');
           
            return $qr;
        }

        // Create User
        public function create() {
            
            if($this->id ){
                $qr = $this->sql->query('INSERT INTO ' . $this->table . ' SET `id`="'.$this->id.'", `name` = "'.$this->name.'", `image` = "'.$this->image.'"');            
                if($qr) return true;
            }

            return false;
        }

        // Update User
        public function update() {
            $set = array();
            $query = '';

            if($this->id && $this->read_single()->num_rows > 0) {
                if (isset($this->name)) $set[] = '`name` = "'.$this->name.'"';
                if (isset($this->image)) $set[] = '`image` = "'.$this->image.'"';
                $query = rtrim(implode(',',$set),',');
                 
                $qr = $this->sql->query('UPDATE ' . $this->table . ' SET '.$query.' WHERE `id`="'.$this->id.'"');
               
                if($qr) return true;
            }

            return false;
        }
        
    }

?>