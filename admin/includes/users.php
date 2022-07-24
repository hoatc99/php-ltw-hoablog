<?php

    class User {

        private $conn;
        private $table = 'blog_user';

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

        public $last_insert_id;

        public function __construct($db) {
            $this->conn = $db;
        }

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

        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

        public function create() {
            $query = "INSERT INTO $this->table
                      SET v_fullname = :fullname,
                          v_username = :username, 
                          v_password = :password,
                          f_user_status = :user_status
                          d_date_created = :date_created, 
                          d_time_created = :time_created";

            $stmt = $this->conn->prepare($query);

            $this->v_username = htmlspecialchars(strip_tags($this->v_username));

            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->bindParam(':user_status', $this->f_user_status);
            $stmt->bindParam(':date_created', $this->d_date_created);
            $stmt->bindParam(':time_created', $this->d_time_created);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function update() {
            $query = "UPDATE $this->table
                      SET v_fullname = :fullname, 
                          v_phone = :phone, 
                          v_email = :email, 
                          v_image_url = :image, 
                          v_message = :message
                      WHERE
                          n_user_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
            $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
            $this->v_email = htmlspecialchars(strip_tags($this->v_email));
            $this->v_image = htmlspecialchars(strip_tags($this->v_image));

            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':phone', $this->v_phone);
            $stmt->bindParam(':email', $this->v_email);
            $stmt->bindParam(':image', $this->v_image);
            $stmt->bindParam(':message', $this->v_message);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function delete() {
            $query = "DELETE FROM $this->table 
                      WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $this->v_message = htmlspecialchars(strip_tags($this->v_message));

            $stmt->bindParam(':get_id', $this->n_user_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function last_id() {
            $this->last_insert_id = $this->conn->lastInsertId();
            return $this->last_insert_id;
        }

        public function login() {
            $sql = "SELECT * FROM $this->table WHERE v_username = :username AND v_password = :password";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);

            $stmt->execute();

            return $stmt;
        }

        public function reset_password() {
            $query = "UPDATE $this->table
                      SET v_password = :password
                      WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $this->v_password = htmlspecialchars(strip_tags($this->v_password));

            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->bindParam(':password', $this->v_password);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function disable() {
            $query = "UPDATE $this->table
                      SET f_user_status = 0
                      WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_user_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function enable() {
            $query = "UPDATE $this->table
                      SET f_user_status = 1
                      WHERE n_user_id = :get_id";
                      
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_user_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

    }

?>