<?php

    class Subscriber {

        private $conn;
        private $table = 'blog_subscriber';

        public $n_sub_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = "INSERT INTO $this->table
                    SET v_sub_email = :email,
                        d_date_created = :date_create,
                        d_time_created = :time_create,
                        f_sub_status = :sub_status";

            $stmt = $this->conn->prepare($query);

            $this->v_sub_email = htmlspecialchars(strip_tags($this->v_sub_email));
            
            $stmt->bindParam(':email',$this->v_sub_email);
            $stmt->bindParam(':date_create',$this->d_date_created);
            $stmt->bindParam(':time_create',$this->d_time_created);
            $stmt->bindParam(':sub_status',$this->f_sub_status);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function delete() {
            $query = "DELETE FROM $this->table 
                      WHERE n_sub_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_sub_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

    }

?>