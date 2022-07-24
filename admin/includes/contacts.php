<?php

    class Contact {

        private $conn;
        private $table = 'blog_contact';

        public $n_contact_id;
        public $v_fullname;
        public $v_email;
        public $v_phone;
        public $v_message;
        public $d_date_created;
        public $d_time_created;
        public $f_contact_status;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read() {
            $sql = "SELECT * FROM $this->table ORDER BY n_contact_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $sql = "INSERT INTO $this->table
                    SET v_fullname = :fullname,
                        v_email = :email,
                        v_phone = :phone,
                        v_message = :message,
                        d_date_created = :date_created,
                        d_time_created = :time_created,
                        f_contact_status = :contact_status";
                        
            $stmt = $this->conn->prepare($sql);

            $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
            $this->v_email = htmlspecialchars(strip_tags($this->v_email));
            $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
            $this->v_message = htmlspecialchars(strip_tags($this->v_message));
            
            $stmt->bindParam(':fullname',$this->v_fullname);
            $stmt->bindParam(':email',$this->v_email);
            $stmt->bindParam(':phone',$this->v_phone);
            $stmt->bindParam(':message',$this->v_message);
            $stmt->bindParam(':date_created',$this->d_date_created);
            $stmt->bindParam(':time_created',$this->d_time_created);
            $stmt->bindParam(':contact_status',$this->f_contact_status);

            if($stmt->execute()){
                return true;
            }

            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function delete() {
            $query = "DELETE FROM $this->table 
                      WHERE n_contact_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_contact_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

    }

?>