<?php 
    class DbConnect{
        private $host = 'localhost';
        private $user = 'root';
        private $pwd  = '';
        private $db   = 'cloud';

        public function connect(){
            try{
                $conn = new PDO('mysql:host='.$this->host.'; dbname='.$this->db,$this->user,$this->pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $conn; 
            }catch(PDOException $e){
                echo 'Database Error: '.$e->getMessage();
            }
        }
    }
?>