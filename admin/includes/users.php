<?php

    class User {

        // DB Stuff
        private $conn;
        private $table = 'blog_user';

        // Blog Categories Properties
        public $n_user_id;	
        public $v_username;	
        public $v_password;	
        public $v_fullname;	
        public $v_phone;	
        public $v_email;	
        public $v_image;	
        public $v_message;	
        public $f_user_status;	
        public $d_date_created;	
        public $d_time_created;	

        // Last id insert
        public $last_insert_id;

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

        public function read_by_username() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Read one record
        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set Properties
            $this->n_user_id = $row['n_user_id'];
            $this->v_username = $row['v_username'];
            $this->v_password = $row['v_password'];
            $this->v_fullname = $row['v_fullname'];
            $this->v_phone = $row['v_phone'];
            $this->v_email = $row['v_email'];
            $this->v_image = $row['v_image_url'];
            $this->v_message = $row['v_message'];
            $this->f_user_status = $row['f_user_status'];
            $this->d_date_created = $row['d_date_created'];
            $this->d_time_created = $row['d_time_created'];
        }

        // Create user
        public function create() {
            // Create query
            $query = "INSERT INTO $this->table
                      SET v_fullname = :fullname,
                          v_username = :username, 
                          v_password = :password,
                          f_user_status = :user_status
                          d_date_created = :date_created, 
                          d_time_created = :time_created";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_username = htmlspecialchars(strip_tags($this->v_username));

            // Bind data
            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->bindParam(':user_status', $this->f_user_status);
            $stmt->bindParam(':date_created', $this->d_date_created);
            $stmt->bindParam(':time_created', $this->d_time_created);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Update user
        public function update() {
            // Create query
            $query = "UPDATE $this->table
                      SET v_fullname = :fullname, 
                          v_phone = :phone, 
                          v_email = :email, 
                          v_image_url = :image, 
                          v_message = :message
                      WHERE
                          n_user_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
            $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
            $this->v_email = htmlspecialchars(strip_tags($this->v_email));
            $this->v_image = htmlspecialchars(strip_tags($this->v_image));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':phone', $this->v_phone);
            $stmt->bindParam(':email', $this->v_email);
            $stmt->bindParam(':image', $this->v_image);
            $stmt->bindParam(':message', $this->v_message);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Delete user
        public function delete() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_user_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_message = htmlspecialchars(strip_tags($this->v_message));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

        public function last_id() {
            $this->last_insert_id = $this->conn->lastInsertId();
            return $this->last_insert_id;
        }

        // Read login
        public function login() {
            $sql = "SELECT * FROM $this->table WHERE v_username = :username AND v_password = :password";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->execute();

            return $stmt;
        }

        // Reset password
        public function reset_password() {
            // Create query
            $query = "UPDATE $this->table
                      SET v_password = :password
                      WHERE n_user_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_password = htmlspecialchars(strip_tags($this->v_password));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->bindParam(':password', $this->v_password);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function disable() {
            // Create query
            $query = "UPDATE $this->table
                      SET f_user_status = 0
                      WHERE n_user_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function enable() {
            // Create query
            $query = "UPDATE $this->table
                      SET f_user_status = 1
                      WHERE n_user_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);

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