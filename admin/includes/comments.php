<?php

    class Comment {

        // DB Stuff
        private $conn;
        private $table = 'blog_comment';

        // Subscriber Properties
        public $n_blog_comment_id;

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

        // Read multi records have n_blog_post_id
        public function read_single_blog_post() {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_post_id = :get_id AND n_blog_comment_parent_id = 0";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id',$this->n_blog_post_id);
            $stmt->execute();
    
            return $stmt;
        }

        //Read multi records have n_blog_post_id
        public function read_single_blog_post_reply() {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_comment_parent_id = :get_blog_comment_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_blog_comment_id',$this->n_blog_comment_id);
            $stmt->execute();

            return $stmt;
        }

        //Read all comments and replies
        public function read_comment_reply_by_blog_id($blog_id) {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_post_id = $blog_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        //Create Comment
        public function create() {
            //Create query
            $query = "INSERT INTO $this->table
                    SET n_blog_comment_parent_id = :blog_comment_parent_id,
                        n_blog_post_id = :blog_post_id,
                        v_comment_author = :comment_author,
                        v_comment_author_email = :comment_author_email,
                        v_comment = :comment,
                        d_date_created = :date_create,
                        d_time_created = :time_create";
                        
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->v_comment_author = htmlspecialchars(strip_tags($this->v_comment_author));
            $this->v_comment_author_email = htmlspecialchars(strip_tags($this->v_comment_author_email));
            $this->v_comment = htmlspecialchars(strip_tags($this->v_comment));
            
            //Bind data
            $stmt->bindParam(':blog_comment_parent_id',$this->n_blog_comment_parent_id);
            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->bindParam(':comment_author',$this->v_comment_author);
            $stmt->bindParam(':comment_author_email',$this->v_comment_author_email);
            $stmt->bindParam(':comment',$this->v_comment);
            $stmt->bindParam(':date_create',$this->d_date_created);
            $stmt->bindParam(':time_create',$this->d_time_created);
            
            //Execute query
            if ($stmt->execute()) {
                return true;
            }
            //Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        // Delete category
        public function delete_comment() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_comment_id = :get_id OR n_blog_comment_parent_id = :blog_comment_parent_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_comment_id);
            $stmt->bindParam(':blog_comment_parent_id', $this->n_blog_comment_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

        // Delete category
        public function delete_reply() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_comment_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_comment_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

        // Delete category
        public function delete_all_comments() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_post_id = :blog_post_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':blog_post_id', $this->n_blog_post_id);

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