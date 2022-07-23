<?php

    class Database {

        // DB Params
        private $dsn = "byt3adjecddqfpnhuj91-mysql.services.clever-cloud.com";
        private $dbname = "byt3adjecddqfpnhuj91";
        private $username = "ukjs091upjezxrbf";
        private $password = "cXiAVmralrRtrA6i4IdE";
        private $conn = null;

        // DB Connect
        public function connect() {
            $this->conn = null;
            try {
                $this->conn = new PDO(
                    'mysql:host=' . $this->dsn . 
                    ';dbname=' . $this->dbname, $this->username, $this->password, 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8, time_zone = "+7:00";'));
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // $this->conn->exec("SET time_zone='+07:00';");
            } catch (Exception $e) {
                echo "Connection failed: $e->getMessage()";
            }
            return $this->conn;
        }

    }

?>