<?php

    namespace src\Models;
    
    class ProductModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        //INSERT PRODUCT
        public function add_product(array $input) {


            $query = "INSERT INTO `PRODUCT` (`NAME`, `DESCRIPTION`, `PRICE`, `CATEGORYID`, `COMPANYID`) 
                                VALUES (:name, :description, :price, :categoryId, :companyId)";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                        'description' => $input["description"],
                        'price' => $input["price"],
                        'categoryId' => $input["categoryId"],
                        'companyId' => $input["companyId"]
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function get_product($id) {
            
            $product = "SELECT `ID`, `NAME`, `DESCRIPTION`,`IMAGEPATH`, `PRICE`, `CATEGORYID`, `COMPANYID`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `PRODUCT` WHERE ID = :id";
            $category = "SELECT `ID`, `NAME`, `IMAGEPATH`,`DESCRIPTION`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `CATEGORY` WHERE ID = :id";
            $company = "SELECT `ID`, `NAME`, `LOGO`, `ISDELETED`, `MODIFIEDAT`,`CREATEDAT` FROM `COMPANY` WHERE ID = :id";
            $stock = "SELECT `ID`, `QUANTITY`, `PRODUCTID`, `MODIFIEDAT`,`CREATEDAT` FROM `STOCK` WHERE ID = :id";


            try {

                $statement = $this->db->prepare($product);
                $statement->execute(array('id' => $id));
                $result = $statement->fetch(\PDO::FETCH_ASSOC);

                $categoryStatement = $this->db->prepare($category);
                $categoryStatement->execute(array('id' => $result["CATEGORYID"]));
                $categoryResult = $categoryStatement->fetch(\PDO::FETCH_ASSOC);

                $companyStatement = $this->db->prepare($company);
                $companyStatement->execute(array('id' => $result["COMPANYID"]));
                $companyResult = $companyStatement->fetch(\PDO::FETCH_ASSOC);

                $stockStatement = $this->db->prepare($stock);
                $stockStatement->execute(array('id' => $result["ID"]));
                $stockResult = $stockStatement->fetch(\PDO::FETCH_ASSOC);
                
                unset($result["CATEGORYID"], $result["COMPANYID"]);

                return array_merge($result,array("CATEGORY" => $categoryResult, "COMPANY" => $companyResult, "STOCK" => $stockResult));

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function get_products_by_category($id) {
            
            $product = "SELECT `ID`, `NAME`, `DESCRIPTION`,`IMAGEPATH`, `PRICE`, `CATEGORYID`, `COMPANYID`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `PRODUCT` WHERE CATEGORYID = :id";

            try {

                $statement = $this->db->prepare($product);
                $statement->execute(array('id' => $id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function get_products_by_company($id) {
            
            $product = "SELECT `ID`, `NAME`, `DESCRIPTION`,`IMAGEPATH`, `PRICE`, `CATEGORYID`, `COMPANYID`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `PRODUCT` WHERE COMAPNYID = :id";

            try {

                $statement = $this->db->prepare($product);
                $statement->execute(array('id' => $id));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function get_all_product($page, $limit) {
            $startid = ($page * $limit - $limit) + 1;
            $endid = $page * $limit;
            
            $product = "SELECT `ID`, `NAME`, `DESCRIPTION`,`IMAGEPATH`, `PRICE`, `CATEGORYID`, `COMPANYID`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `PRODUCT` WHERE ID BETWEEN :sid AND :eid";
            $category = "SELECT `ID`, `NAME`, `IMAGEPATH`,`DESCRIPTION`, `ISDELETED`,`MODIFIEDAT`,`CREATEDAT` FROM `CATEGORY` WHERE ID = :id";
            $company = "SELECT `ID`, `NAME`, `LOGO`, `ISDELETED`, `MODIFIEDAT`,`CREATEDAT` FROM `COMPANY` WHERE ID = :id";
            $stock = "SELECT `ID`, `QUANTITY`, `MODIFIEDAT`,`CREATEDAT` FROM `STOCK` WHERE ID = :id";


            try {

                $statement = $this->db->prepare($product);
                $statement->execute(array('sid' => $startid, 'eid' => $endid));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                

                for($i = 0 ; $i < count($result) ; $i ++) {
                    $categoryStatement = $this->db->prepare($category);
                    $categoryStatement->execute(array('id' => $result[$i]["CATEGORYID"]));
                    $categoryResult = $categoryStatement->fetch(\PDO::FETCH_ASSOC);
                    $result[$i]["CATEGORY"] = $categoryResult;
                    unset($result[$i]["CATEGORYID"]);
                }
                
                for($i = 0 ; $i < count($result) ; $i ++) {
                    $companyStatement = $this->db->prepare($company);
                    $companyStatement->execute(array('id' => $result[$i]["COMPANYID"]));
                    $companyResult = $companyStatement->fetch(\PDO::FETCH_ASSOC);
                    $result[$i]["COMPANY"] = $companyResult;
                    unset($result[$i]["COMPANYID"]);
                }
                
                for($i = 0 ; $i < count($result) ; $i ++) {
                    $stockStatement = $this->db->prepare($stock);
                    $stockStatement->execute(array('id' => $result[$i]["ID"]));
                    $stockResult = $stockStatement->fetch(\PDO::FETCH_ASSOC);                    
                    $result[$i]["STOCK"] = $stockResult;
                }

                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        //UPDATE PRODUCT
        public function update_product(array $input, $id) {

            $query = "UPDATE `PRODUCT` SET 
            `NAME` = :name, `DESCRIPTION` = :description, `PRICE` = :price, `CATEGORYID` = :categoryId, `COMPANYID` = :companyId
                WHERE `ID` = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'name' => $input["name"],
                        'description' => $input["description"],
                        'price' => $input["price"],
                        'categoryId' => $input["categoryId"],
                        'companyId' => $input["companyId"],
                        'id' => $id
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        //DELETE PRODUCT
        public function delete_product($id) {

            $query = "UPDATE `PRODUCT` SET `ISDELETED` = 1 WHERE ID = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function add_photos()
        {
            
        }

    }

?>