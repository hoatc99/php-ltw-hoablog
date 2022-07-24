<?php

    class Like {

        private $conn;
        private $table = 'blog_like';

        public $n_like_id;
        public $n_blog_post_id;
        public $v_session_id;
        public $d_date_created;
        public $d_time_created;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :blog_post_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $sql = "INSERT INTO $this->table
                    SET n_blog_post_id = :blog_post_id,
                        v_session_id = :session_id,
                        d_date_created = :date_created,
                        d_time_created = :time_created";
                        
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->bindParam(':session_id',$this->v_session_id);
            $stmt->bindParam(':date_created',$this->d_date_created);
            $stmt->bindParam(':time_created',$this->d_time_created);

            if($stmt->execute()){
                return true;
            }

            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function check() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :blog_post_id AND v_session_id = :session_id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->bindParam(':session_id',$this->v_session_id);

            $stmt->execute();

            return $stmt;
        }

    }

?>