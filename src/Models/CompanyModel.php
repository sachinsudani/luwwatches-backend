<?php

    namespace src\Models;

    class CompanyModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        public function add_company(array $input) {

            $query = "INSERT INTO `COMPANY` (`NAME`) 
                                VALUES (:name)";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function get_company($id) {
            
            $query = "SELECT `ID`, `NAME`, `LOGO`, `ISDELETED`, `MODIFIEDAT`,`CREATEDAT` FROM `COMPANY` WHERE ID = :id";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function update_company(array $input, $id) {

            $query = "UPDATE `COMPANY` SET 
            `NAME` = :name WHERE `ID` = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                        'id' => $id
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function delete_company($id) {

            $query = "UPDATE `COMPANY` SET `ISDELETED` = 1 WHERE ID = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

    }

?>