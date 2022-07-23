<?php

    class Contact {

        // DB Stuff
        private $conn;
        private $table = 'blog_contact';

        // Subscriber Properties
        public $n_contact_id;
        public $v_fullname;
        public $v_email;
        public $v_phone;
        public $v_message;
        public $d_date_created;
        public $d_time_created;
        public $f_contact_status;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Read multi records
        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Read multi records
        public function client_read() {
            $sql = "SELECT * FROM $this->table ORDER BY n_contact_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        //Create Comment
        public function create() {
            //Create query
            $sql = "INSERT INTO $this->table
                    SET v_fullname = :fullname,
                        v_email = :email,
                        v_phone = :phone,
                        v_message = :message,
                        d_date_created = :date_created,
                        d_time_created = :time_created,
                        f_contact_status = :contact_status";
                        
            //Prepare statement
            $stmt = $this->conn->prepare($sql);

            //Clean data
            $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
            $this->v_email = htmlspecialchars(strip_tags($this->v_email));
            $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
            $this->v_message = htmlspecialchars(strip_tags($this->v_message));
            
            //Bind data
            $stmt->bindParam(':fullname',$this->v_fullname);
            $stmt->bindParam(':email',$this->v_email);
            $stmt->bindParam(':phone',$this->v_phone);
            $stmt->bindParam(':message',$this->v_message);
            $stmt->bindParam(':date_created',$this->d_date_created);
            $stmt->bindParam(':time_created',$this->d_time_created);
            $stmt->bindParam(':contact_status',$this->f_contact_status);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        // Delete category
        public function delete() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_contact_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_contact_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

    }

?>