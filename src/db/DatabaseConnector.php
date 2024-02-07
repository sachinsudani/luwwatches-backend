<?php

    namespace src\db;

    class DatabaseConnector {
        
        private $db_connection = null;

        private function __construct() {
            
            $dbname = getenv("DB_NAME");
            $username = getenv("DB_USERNAME");
            $password = getenv("DB_PASSWORD");
            $host = getenv("DB_HOST");
            $port = getenv("DB_PORT");

            try {
                $this->db_connection = new \PDO("mysql:host=$host;port=$port;dbname=$dbname;", $username, $password);
            } catch (\PDOException $e) {
                $this->db_connection = $e->getMessage();
            }

        }

        public static function get_connection() {
            $con = new DatabaseConnector();
            return $con->db_connection;
        }

    }

?>