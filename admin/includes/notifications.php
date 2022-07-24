<?php

    class Notification {

        private $conn;
        private $table = 'blog_notification';

        public $n_noti_id;
        public $n_user_id;
        public $v_message;
        public $f_noti_status;
        public $d_date_created;
        public $d_time_created;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table WHERE n_user_id = :user_id AND f_noti_status != 2 ORDER BY n_noti_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id',$this->n_user_id);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = "INSERT INTO $this->table
                      SET n_user_id = :user_id,
                          v_message = :message,
                          f_noti_status = 1,
                          d_date_created = :date_created,
                          d_time_created = :time_created";
                        
            $stmt = $this->conn->prepare($query);

            $this->v_message = htmlspecialchars(strip_tags($this->v_message));
            
            $stmt->bindParam(':user_id',$this->n_user_id);
            $stmt->bindParam(':message',$this->v_message);
            $stmt->bindParam(':date_created',$this->d_date_created);
            $stmt->bindParam(':time_created',$this->d_time_created);
            
            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function view() {
            $query = "UPDATE $this->table
                      SET f_noti_status = 0
                      WHERE n_user_id = :user_id";
                        
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':user_id',$this->n_user_id);
            
            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function delete() {
            $query = "UPDATE $this->table
                      SET f_noti_status = 2
                      WHERE n_user_id = :user_id";
                        
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':user_id',$this->n_user_id);
            
            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

    }

?>