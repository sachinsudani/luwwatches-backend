<?php

    namespace src\Models;

    class CategoryModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        //INSERT CATEGORY
        public function add_category(array $input) {

            $query = "INSERT INTO `CATEGORY` (`NAME`, `DESCRIPTION`) 
                                VALUES (:name, :description)";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                        'description' => $input["description"]
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        //GET CATEGORY
        public function get_category($id) {
            
            $query = "SELECT `ID`, `NAME`, `IMAGEPATH`,`DESCRIPTION`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `CATEGORY` WHERE ID = :id";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        // GET All CATEGORY
        public function get_all_category() {
            
            $query = "SELECT `ID`, `NAME`, `IMAGEPATH`,`DESCRIPTION`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `CATEGORY`";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        //UPDATE CATEGORY
        public function update_category(array $input, $id) {

            $query = "UPDATE `CATEGORY` SET 
            `NAME` = :name, `DESCRIPTION` = :description WHERE `ID` = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                        'description' => $input["description"],
                        'id' => $id
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        //DELETE CATEGORY
        public function delete_category($id) {

            $query = "UPDATE `CATEGORY` SET `ISDELETED` = 1 WHERE ID = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

    }

?>