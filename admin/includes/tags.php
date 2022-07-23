<?php

    class Tag {

        // DB Stuff
        private $conn;
        private $table = 'blog_tag';

        // Blog Categories Properties
        public $n_tag_id;
        public $n_blog_post_id;
        public $v_tag;

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

        // Read one record
        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set Properties
            $this->n_tag_id = $row['n_tag_id'];
            $this->n_blog_post_id = $row['n_blog_post_id'];
            $this->v_tag = $row['v_tag'];
        }

        // Create category
        public function create() {
            // Create query
            $query = "INSERT INTO $this->table
                      SET n_blog_post_id = :blog_post_id,
                          v_tag = :tag";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            // Bind data
            $stmt->bindParam(':blog_post_id', $this->n_blog_post_id);
            $stmt->bindParam(':tag', $this->v_tag);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Update category
        public function update() {
            // Create query
            $query = "UPDATE $this->table
                      SET v_tag = :tag
                      WHERE
                          n_tag_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_tag_id);
            $stmt->bindParam(':tag', $this->v_tag);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Delete category
        public function delete() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_tag_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->n_tag_id = htmlspecialchars(strip_tags($this->n_tag_id));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_tag_id);

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