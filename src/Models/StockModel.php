<?php

    namespace src\Models;

    class StockModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        public function add_stock(array $input) {

            $query = "INSERT INTO `STOCK` (`QUANTITY`, `PRODUCTID`) 
                                VALUES (:quantity, :productId)";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'quantity' => $input["quantity"],
                        'productId' => $input["productId"],
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function get_stock($id) {
            
            $query = "SELECT `ID`, `QUANTITY`, `PRODUCTID`, `MODIFIEDAT`,`CREATEDAT` FROM `STOCK` WHERE ID = :id";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function update_stock(array $input, $id) {

            $query = "UPDATE `STOCK` SET 
            `QUANTITY` = :quantity, `PRODUCTID` = :productId WHERE `ID` = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'quantity' => $input["quantity"],
                        'productId' => $input["productId"],
                        'id' => $id
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function delete_stock($id) {

            $query = "UPDATE `STOCK` SET `ISDELETED` = 1 WHERE ID = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

    }

?>