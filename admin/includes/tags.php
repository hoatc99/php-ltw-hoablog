<?php

    class Tag {

        private $conn;
        private $table = 'blog_tag';

        public $n_tag_id;
        public $n_blog_post_id;
        public $v_tag;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->n_tag_id = $row['n_tag_id'];
            $this->n_blog_post_id = $row['n_blog_post_id'];
            $this->v_tag = $row['v_tag'];
        }

        public function create() {
            $query = "INSERT INTO $this->table
                      SET n_blog_post_id = :blog_post_id,
                          v_tag = :tag";

            $stmt = $this->conn->prepare($query);

            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            $stmt->bindParam(':blog_post_id', $this->n_blog_post_id);
            $stmt->bindParam(':tag', $this->v_tag);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function update() {
            $query = "UPDATE $this->table
                      SET v_tag = :tag
                      WHERE
                          n_tag_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            $stmt->bindParam(':get_id', $this->n_tag_id);
            $stmt->bindParam(':tag', $this->v_tag);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function delete() {
            $query = "DELETE FROM $this->table 
                      WHERE n_tag_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $this->n_tag_id = htmlspecialchars(strip_tags($this->n_tag_id));

            $stmt->bindParam(':get_id', $this->n_tag_id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

    }

?>