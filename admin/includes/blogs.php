<?php

    class Blog {

        // DB Stuff
        private $conn;
        private $table = 'blog_post';

        // Blog Categories Properties
        public $n_blog_post_id;	
        public $n_category_id;	
        public $n_user_id;	
        public $v_post_title;	
        public $v_post_meta_title;	
        public $v_post_path;	
        public $v_post_summary;	
        public $v_post_content;	
        public $v_main_image_url;
        public $v_alt_image_url;	
        public $n_blog_post_views;	
        public $n_home_page_placement;	
        public $f_post_status;
        public $d_date_created;	
        public $d_time_created;	
        public $d_date_updated;	
        public $d_time_updated;

        // Last id insert
        public $last_insert_id;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Read multi records
        public function read() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status != 2 ORDER BY f_post_status DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function admin_read_active_blog() {
            if ($this->n_user_id == $GLOBALS['admin_id']) {
                $sql = "SELECT * FROM $this->table WHERE f_post_status != 2 ORDER BY f_post_status DESC";
                $stmt = $this->conn->prepare($sql);
            } else {
                $sql = "SELECT * FROM $this->table WHERE f_post_status != 2 AND n_user_id = :user_id ORDER BY f_post_status DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $this->n_user_id);
            }

            $stmt->execute();

            return $stmt;
        }

        public function admin_read_deleted_blog() {
            if ($this->n_user_id == $GLOBALS['admin_id']) {
                $sql = "SELECT * FROM $this->table WHERE f_post_status = 2";
                $stmt = $this->conn->prepare($sql);
            } else {
                $sql = "SELECT * FROM $this->table WHERE f_post_status = 2 AND n_user_id = :user_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $this->n_user_id);
            }
            
            $stmt->execute();

            return $stmt;
        }

        // Read active blogs
        public function admin_read_blog_by_category() {
            $sql = "SELECT * FROM $this->table WHERE n_category_id = :category_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':category_id', $this->n_category_id);
            $stmt->execute();

            return $stmt;
        }

        // Read active blogs
        public function client_read_active_blog() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Read active blogs by page
        public function client_read_active_blog_by_page($blog_from, $offset) {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_id DESC LIMIT $blog_from, $offset";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Read active blogs by page
        public function client_read_active_blog_by_category() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 AND n_category_id = $this->n_category_id ORDER BY n_blog_post_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Read active blogs
        public function client_read_popular_blog() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_views DESC LIMIT 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        //Read records have n_home_page_place
        public function client_read_home_page_placement() {
            $sql = "SELECT * FROM $this->table WHERE n_home_page_placement > 0 ORDER BY n_home_page_placement ASC LIMIT 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        //Read active blogs by query
        public function client_read_active_blog_by_query($query) {
            $sql = "SELECT * FROM $this->table JOIN blog_tag ON $this->table.n_blog_post_id = blog_tag.n_blog_post_id
                    WHERE f_post_status = 1 AND (v_post_title LIKE '%$query%' OR v_tag LIKE '%$query%') 
                    ORDER BY $this->table.n_blog_post_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        //Read previous record
        public function client_read_previous_blog() {
            $sql = "SELECT * FROM $this->table
                    WHERE n_blog_post_id = (SELECT MAX(n_blog_post_id) 
                                            FROM $this->table 
                                            WHERE n_blog_post_id < :current_id AND f_post_status = 1)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":current_id", $this->n_blog_post_id);
            $stmt->execute();

            return $stmt;
        }

        //Read next record
        public function client_read_next_blog() {
            $sql = "SELECT * FROM $this->table
                    WHERE n_blog_post_id = (SELECT MIN(n_blog_post_id) 
                                            FROM $this->table 
                                            WHERE n_blog_post_id > :current_id AND f_post_status = 1)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":current_id", $this->n_blog_post_id);
            $stmt->execute();

            return $stmt;
        }

        public function admin_read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set Properties
            $this->n_blog_post_id = $row['n_blog_post_id'];	
            $this->n_category_id = $row['n_category_id'];	
            $this->n_user_id = $row['n_user_id'];	
            $this->v_post_title = $row['v_post_title'];	
            $this->v_post_meta_title = $row['v_post_meta_title'];	
            $this->v_post_path = $row['v_post_path'];	
            $this->v_post_summary = $row['v_post_summary'];	
            $this->v_post_content = $row['v_post_content'];	
            $this->v_main_image_url = $row['v_main_image_url'];
            $this->v_alt_image_url = $row['v_alt_image_url'];	
            $this->n_blog_post_views = $row['n_blog_post_views'];	
            $this->n_home_page_placement = $row['n_home_page_placement'];	
            $this->f_post_status = $row['f_post_status'];
            $this->d_date_created = $row['d_date_created'];	
            $this->d_time_created = $row['d_time_created'];	
            $this->d_date_updated = $row['d_date_updated'];	
            $this->d_time_updated = $row['d_time_updated'];
        }

        // Read one record
        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set Properties
            $this->n_blog_post_id = $row['n_blog_post_id'];	
            $this->n_category_id = $row['n_category_id'];	
            $this->n_user_id = $row['n_user_id'];	
            $this->v_post_title = $row['v_post_title'];	
            $this->v_post_meta_title = $row['v_post_meta_title'];	
            $this->v_post_path = $row['v_post_path'];	
            $this->v_post_summary = $row['v_post_summary'];	
            $this->v_post_content = $row['v_post_content'];	
            $this->v_main_image_url = $row['v_main_image_url'];
            $this->v_alt_image_url = $row['v_alt_image_url'];	
            $this->n_blog_post_views = $row['n_blog_post_views'];	
            $this->n_home_page_placement = $row['n_home_page_placement'];	
            $this->f_post_status = $row['f_post_status'];
            $this->d_date_created = $row['d_date_created'];	
            $this->d_time_created = $row['d_time_created'];	
            $this->d_date_updated = $row['d_date_updated'];	
            $this->d_time_updated = $row['d_time_updated'];

            $this->n_blog_post_views = $this->n_blog_post_views + 1;
            $sql = "UPDATE $this->table
                    SET n_blog_post_views = $this->n_blog_post_views
                    WHERE n_blog_post_id = $this->n_blog_post_id"; 

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }

        // Create category
        public function create() {
            // Create query 
            $query = "UPDATE $this->table
                      SET n_home_page_placement = 0
                      WHERE n_home_page_placement = :home_page_placement";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);

            $stmt->execute();

            // Create query
            $query = "INSERT INTO $this->table
                      SET n_category_id = :category_id,
                          n_user_id = :user_id,
                          v_post_title = :post_title,
                          v_post_meta_title = :post_meta_title,
                          v_post_path = :post_path,
                          v_post_summary = :post_summary,
                          v_post_content = :post_content,
                          v_main_image_url = :main_image_url,
                          v_alt_image_url = :alt_image_url,
                          n_blog_post_views = :blog_post_views,
                          n_home_page_placement = :home_page_placement,
                          f_post_status = :post_status,
                          d_date_created = :date_created,
                          d_time_created = :time_created";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
            $this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
            $this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
            $this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
            $this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
            $this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));

            // Bind data
            $stmt->bindParam(':category_id', $this->n_category_id);
            $stmt->bindParam(':user_id', $this->n_user_id);
            $stmt->bindParam(':post_title', $this->v_post_title);
            $stmt->bindParam(':post_meta_title', $this->v_post_meta_title);
            $stmt->bindParam(':post_path', $this->v_post_path);
            $stmt->bindParam(':post_summary', $this->v_post_summary);
            $stmt->bindParam(':post_content', $this->v_post_content);
            $stmt->bindParam(':main_image_url', $this->v_main_image_url);
            $stmt->bindParam(':alt_image_url', $this->v_alt_image_url);
            $stmt->bindParam(':blog_post_views', $this->n_blog_post_views);
            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);
            $stmt->bindParam(':post_status', $this->f_post_status);
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

        // Update category
        public function update() {
            // Create query 
            $query = "UPDATE $this->table
                      SET n_home_page_placement = 0
                      WHERE n_home_page_placement = :home_page_placement";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);

            $stmt->execute();

            // Create query
            $query = "UPDATE $this->table
                      SET n_category_id = :category_id,
                          v_post_title = :post_title,
                          v_post_meta_title = :post_meta_title,
                          v_post_path = :post_path,
                          v_post_summary = :post_summary,
                          v_post_content = :post_content,
                          v_main_image_url = :main_image_url,
                          v_alt_image_url = :alt_image_url,
                          n_blog_post_views = :blog_post_views,
                          n_home_page_placement = :home_page_placement,
                          f_post_status = :post_status,
                          d_date_updated = :date_updated,
                          d_time_updated = :time_updated
                      WHERE
                          n_blog_post_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
            $this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
            $this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
            $this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
            $this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
            $this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->bindParam(':category_id', $this->n_category_id);
            $stmt->bindParam(':post_title', $this->v_post_title);
            $stmt->bindParam(':post_meta_title', $this->v_post_meta_title);
            $stmt->bindParam(':post_path', $this->v_post_path);
            $stmt->bindParam(':post_summary', $this->v_post_summary);
            $stmt->bindParam(':post_content', $this->v_post_content);
            $stmt->bindParam(':main_image_url', $this->v_main_image_url);
            $stmt->bindParam(':alt_image_url', $this->v_alt_image_url);
            $stmt->bindParam(':blog_post_views', $this->n_blog_post_views);
            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);
            $stmt->bindParam(':post_status', $this->f_post_status);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

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
            $query = "UPDATE $this->table
                      SET f_post_status = 2 
                      WHERE n_blog_post_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_post_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

        // Delete category
        public function inactive() {

            // Create query
            $query = "UPDATE $this->table
                      SET f_post_status = 0
                      WHERE n_blog_post_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_post_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }
        // Delete category
        public function active() {

            // Create query
            $query = "UPDATE $this->table
                      SET f_post_status = 1 
                      WHERE n_blog_post_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_blog_post_id);

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

    }

?>