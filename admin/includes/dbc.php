<?php

    class Database {

        private $dsn = "bipu0jgy8k8ksufom6mv-mysql.services.clever-cloud.com";
        private $dbname = "bipu0jgy8k8ksufom6mv";
        private $username = "uewqhocfweczx3zk";
        private $password = "xaw0CPlTr6qgCZeUTdz5";
        private $conn = null;

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