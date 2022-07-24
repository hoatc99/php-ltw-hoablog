<?php

    class Comment {

        private $conn;
        private $table = 'blog_comment';

        public $n_blog_comment_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function read_single_blog_post() {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_post_id = :get_id AND n_blog_comment_parent_id = 0";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id',$this->n_blog_post_id);
            $stmt->execute();
    
            return $stmt;
        }

        public function read_single_blog_post_reply() {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_comment_parent_id = :get_blog_comment_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_blog_comment_id',$this->n_blog_comment_id);
            $stmt->execute();

            return $stmt;
        }

        public function read_comment_reply_by_blog_id() {
            $sql = "SELECT * FROM $this->table 
                    WHERE n_blog_post_id = :blog_post_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = "INSERT INTO $this->table
                    SET n_blog_comment_parent_id = :blog_comment_parent_id,
                        n_blog_post_id = :blog_post_id,
                        v_comment_author = :comment_author,
                        v_comment_author_email = :comment_author_email,
                        v_comment = :comment,
                        d_date_created = :date_create,
                        d_time_created = :time_create";
                        
            $stmt = $this->conn->prepare($query);

            $this->v_comment_author = htmlspecialchars(strip_tags($this->v_comment_author));
            $this->v_comment_author_email = htmlspecialchars(strip_tags($this->v_comment_author_email));
            $this->v_comment = htmlspecialchars(strip_tags($this->v_comment));
            
            $stmt->bindParam(':blog_comment_parent_id',$this->n_blog_comment_parent_id);
            $stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
            $stmt->bindParam(':comment_author',$this->v_comment_author);
            $stmt->bindParam(':comment_author_email',$this->v_comment_author_email);
            $stmt->bindParam(':comment',$this->v_comment);
            $stmt->bindParam(':date_create',$this->d_date_created);
            $stmt->bindParam(':time_create',$this->d_time_created);
            
            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

        public function delete_comment() {
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_comment_id = :get_id OR n_blog_comment_parent_id = :blog_comment_parent_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_blog_comment_id);
            $stmt->bindParam(':blog_comment_parent_id', $this->n_blog_comment_id);

            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function delete_reply() {
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_comment_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_blog_comment_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function delete_all_comments() {
            $query = "DELETE FROM $this->table 
                      WHERE n_blog_post_id = :blog_post_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':blog_post_id', $this->n_blog_post_id);

            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s. \n$stmt->error");
            return false;
        }

    }

?>