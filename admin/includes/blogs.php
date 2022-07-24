<?php

    class Blog {

        private $conn;
        private $table = 'blog_post';

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
        public $f_post_admin_deleted;
        public $d_date_created;	
        public $d_time_created;	
        public $d_date_updated;	
        public $d_time_updated;

        public $last_insert_id;

        public function __construct($db) {
            $this->conn = $db;
        }

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
                $sql = "SELECT * FROM $this->table WHERE f_post_status = 2 AND n_user_id = :user_id AND f_post_admin_deleted = 0";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $this->n_user_id);
            }
            
            $stmt->execute();

            return $stmt;
        }

        public function admin_read_blog_by_category() {
            $sql = "SELECT * FROM $this->table WHERE n_category_id = :category_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':category_id', $this->n_category_id);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_active_blog() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_id DESC LIMIT 12";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_active_blog_by_page($blog_from, $offset) {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_id DESC LIMIT $blog_from, $offset";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_active_blog_by_category() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 AND n_category_id = $this->n_category_id ORDER BY n_blog_post_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_popular_blog() {
            $sql = "SELECT * FROM $this->table WHERE f_post_status = 1 ORDER BY n_blog_post_views DESC LIMIT 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_home_page_placement() {
            $sql = "SELECT * FROM $this->table WHERE n_home_page_placement > 0 AND f_post_status = 1 ORDER BY n_home_page_placement ASC LIMIT 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function client_read_active_blog_by_query($query) {
            $sql = "SELECT * FROM $this->table JOIN blog_tag ON $this->table.n_blog_post_id = blog_tag.n_blog_post_id
                    WHERE f_post_status = 1 AND (
                        v_post_title LIKE '%$query%' OR v_post_summary LIKE '%$query%' 
                        OR v_post_content LIKE '%$query%' OR v_tag LIKE '%$query%'
                    ) ORDER BY $this->table.n_blog_post_id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

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

        public function check_blog_exists() {
            $sql = "SELECT * FROM $this->table
                    WHERE n_blog_post_id = :blog_post_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":blog_post_id", $this->n_blog_post_id);
            $stmt->execute();

            return $stmt;
        }

        public function admin_read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id AND f_post_status != 2";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
            $this->f_post_admin_deleted = $row['f_post_admin_deleted'];
            $this->d_date_created = $row['d_date_created'];	
            $this->d_time_created = $row['d_time_created'];	
            $this->d_date_updated = $row['d_date_updated'];	
            $this->d_time_updated = $row['d_time_updated'];
        }

        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
            $this->f_post_admin_deleted = $row['f_post_admin_deleted'];
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

        public function create() {
            $query = "UPDATE $this->table
                      SET n_home_page_placement = 0
                      WHERE n_home_page_placement = :home_page_placement";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);

            $stmt->execute();

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
                          f_post_admin_deleted = 0,
                          d_date_created = :date_created,
                          d_time_created = :time_created";

            $stmt = $this->conn->prepare($query);

            $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
            $this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
            $this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
            $this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
            $this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
            $this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));

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

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function update() {
            $query = "UPDATE $this->table
                      SET n_home_page_placement = 0
                      WHERE n_home_page_placement = :home_page_placement";
                      
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':home_page_placement', $this->n_home_page_placement);

            $stmt->execute();

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
                          
            $stmt = $this->conn->prepare($query);

            $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
            $this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
            $this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
            $this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
            $this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
            $this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));

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

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function delete() {
            $query = "UPDATE $this->table
                      SET f_post_admin_deleted = :post_admin_deleted,
                          f_post_status = 2,
                          d_date_updated = :date_updated,
                          d_time_updated = :time_updated
                      WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->bindParam(':post_admin_deleted', $this->f_post_admin_deleted);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function inactive() {
            $query = "UPDATE $this->table
                      SET f_post_status = 0,
                          d_date_updated = :date_updated,
                          d_time_updated = :time_updated
                      WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n$stmt->error");
            return false;
        }

        public function active() {
            $query = "UPDATE $this->table
                      SET f_post_status = 1,
                          d_date_updated = :date_updated,
                          d_time_updated = :time_updated
                      WHERE n_blog_post_id = :get_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':get_id', $this->n_blog_post_id);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

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

    }

?>