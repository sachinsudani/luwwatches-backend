<?php
namespace src\Models;

    class CartModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        public function add_to_cart($user) {
            
            $productid = $_GET["id"];
            $qunatity = $_GET["quantity"];
            $message = null;
            $flag = 0;
            
            $selectProductQuery = "SELECT `price` FROM `PRODUCT` where id = :id ORDER BY `createdAt`";
            $selectquantityQuery = "SELECT `quantity` FROM `STOCK` where `productid` = :id ORDER BY `createdAt`";
            if(isset($user)) {
                $query = "SELECT `id`, `statusId` FROM `order` WHERE `userId` = :id ORDER BY `createdAt`";
                $statement = $this->db->prepare($query);
                $id = (int)$user["id"];
                
                $statement->execute(array('id'=>$id));
                $orderId = $statement->fetchAll(\PDO::FETCH_ASSOC);
                
                $selectOrderedProducts = "SELECT `id` FROM `ORDEREDPRODUCTS` where productId = :id ORDER BY `orderId`";

                if(isset($orderId[0]["id"]) && isset($orderId[0]["statusID"])) {
                    $statement = $this->db->prepare($selectOrderedProducts);                
                    $statement->execute(array('id'=>$productid));
                    $selectOrderedProduct = $statement->fetchAll(\PDO::FETCH_ASSOC);
                    $count = 0;
                    foreach($selectOrderedProduct as $product) {
                        if(isset($product["id"])) {
                            $count++;
                        }
                    }

                    if($count > 0) {
                        $statement = $this->db->prepare($selectProductQuery);                
                        $statement->execute(array('id'=>$productid));
                        $selectProduct = $statement->fetch(\PDO::FETCH_ASSOC);
                        
                        $statement = $this->db->prepare($selectquantityQuery);                
                        $statement->execute(array('id'=>$productid));
                        $selectAvailablequantity = $statement->fetch(\PDO::FETCH_ASSOC);
                        
                        $selectQuantity = "SELECT `qunatity` FROM `orderedproducts` WHERE `productId` = :id";
                        $statement = $this->db->prepare($selectQuantity);                
                        $statement->execute(array('id'=>$productid));
                        $selectquantity = $statement->fetch(\PDO::FETCH_ASSOC);

                        if($qunatity > $selectAvailablequantity["quantity"]) {
                            $message = "Not Enough Quantity";
                            $flag = 1;
                        } else {
                            $totalQunatity = (int) $selectquantity["qunatity"] + (int)$qunatity;
                            $totalprice = $totalQunatity * (int)$selectProduct["price"];
                            $query = "UPDATE `orderedproducts` SET `qunatity` = :qunatity, `totalprice` = :totalprice WHERE `productid` = :id";
                            $statement = $this->db->prepare($query);                
                            $statement->execute(array('qunatity' => $totalQunatity, 'totalprice' => $totalprice, 'id' => $productid));
                            $message = "Cart Added Successfully";
                        }
                    }
                    else {
                        $statement = $this->db->prepare($selectProductQuery);                
                        $statement->execute(array('id'=>$productid));
                        $selectProduct = $statement->fetch(\PDO::FETCH_ASSOC);
                        
                        $statement = $this->db->prepare($selectquantityQuery);                
                        $statement->execute(array('id'=>$productid));
                        $selectquantity = $statement->fetch(\PDO::FETCH_ASSOC);
                        $message = $selectquantity;

                        if($qunatity > $selectquantity["quantity"]) {
                            $message = "Not Enough Quantity";
                            $flag = 1;
                        } else {
                            $totalprice = $qunatity * (int)$selectProduct["price"];
                            $insertOrderedProducts = "INSERT INTO `orderedproducts` (`productId`, `orderId`, `qunatity`, `totalprice`) 
                                VALUES (:productId, :orderId, :quantity, :totalprice)";
                            
                            $statement = $this->db->prepare($insertOrderedProducts);                
                            $statement->execute(array('productId' => $productid, 'orderId' => (int)$orderId[0]["id"], 'quantity' => $qunatity, 'totalprice' => $totalprice));
                            $message = "Cart Added Successfully";
                        }
                    }
                }

                else {
                    $insertOrder = "INSERT INTO `order` (`userId`, `statusId`) 
                        VALUES (:userId, :statusId)";
                    $statement = $this->db->prepare($insertOrder);                
                    $statement->execute(array('userId' => $id, 'statusId' => 1));
                    $orderid = $this->db->lastInsertId();

                    $statement = $this->db->prepare($selectProductQuery);                
                    $statement->execute(array('id'=>$productid));
                    $selectProduct = $statement->fetch(\PDO::FETCH_ASSOC);
                    
                    $statement = $this->db->prepare($selectquantityQuery);                
                    $statement->execute(array('id'=>$productid));
                    $selectquantity = $statement->fetchAll(\PDO::FETCH_ASSOC)[0];
                    
                    if($qunatity > $selectquantity["quantity"]) {
                        $message = "Not Enough Quantity";
                        $flag = 1;
                    } else {
                        $totalprice = $qunatity * (int)$selectProduct["price"];
                        $insertOrderedProducts = "INSERT INTO `orderedproducts` (`productId`, `orderId`, `qunatity`, `totalprice`) 
                            VALUES (:productId, :orderId, :quantity, :totalprice)";
                        
                        $statement = $this->db->prepare($insertOrderedProducts);                
                        $statement->execute(array('productId' => $productid, 'orderId' => $orderid, 'quantity' => $qunatity, 'totalprice' => $totalprice));
                        $message = "Cart Added Successfully";
                    }
                }
                if($flag == 0) {
                    return $message;
                }
            } else {
                throw new Exception("Please Login");
            }
        }
        public function update_cart($user) {

            $productid = $_GET["id"];
            $qunatity = $_GET["quantity"];

            
            
        }

        public function get_cart($user) {
            $selectProductQuery = "SELECT `name`,`price`,`imagePath`,`id` FROM `PRODUCT` where id = :id ORDER BY `createdAt`";
            $totalprice = 0;
            if(isset($user)) {
                $result = array("ORDEREDPRODUCTS" => array(), "TOTALPRICE" => array());
                $query = "SELECT `id` FROM `order` WHERE `userId` = :id AND `statusId` = :sid ORDER BY `createdAt`";
                $statement = $this->db->prepare($query);                
                $statement->execute(array('id'=>$user["id"], 'sid'=>1));
                $selectOrder = $statement->fetch(\PDO::FETCH_ASSOC);
                
                $selectOrderedProductQuery = "SELECT `productid`,`qunatity`,`totalprice` FROM ORDEREDPRODUCTS WHERE `orderid` = :id";
                $statement = $this->db->prepare($selectOrderedProductQuery);                
                $statement->execute(array('id'=>$selectOrder["id"]));
                $selectOrderedProducts = $statement->fetchAll(\PDO::FETCH_ASSOC);   
                
                for($i = 0 ; $i < count($selectOrderedProducts) ; $i ++) {
                    $statement = $this->db->prepare($selectProductQuery);
                    $statement->execute(array('id' => $selectOrderedProducts[$i]["productid"]));
                    $orderResult = $statement->fetch(\PDO::FETCH_ASSOC);
                    $orderResult['quantity'] = $selectOrderedProducts[$i]["qunatity"];
                    $orderResult['totalprice'] =  $selectOrderedProducts[$i]["totalprice"];
                    array_push($result["ORDEREDPRODUCTS"],$orderResult);
                    $totalprice += $orderResult['totalprice'];
                }
                array_push($result["TOTALPRICE"], $totalprice);
                return $result;
            }
        }

        public function get_orders() {
            $totalprice = 0;

            $orderQuery = "SELECT `id`, `USERID`, `STATUSID`, `CREATEDAT` FROM `order` ORDER BY `createdAt`";
            $userQuery = "SELECT `NAME` FROM `userdetails` WHERE `ID` = :id";
            $statusQuery = "SELECT `NAME` FROM `orderStatus` WHERE `ID` = :id";

            $statement = $this->db->prepare($orderQuery);                
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            for($i = 0 ; $i < count($result) ; $i ++) {
                $userStatement = $this->db->prepare($userQuery);
                $userStatement->execute(array('id' => $result[$i]["USERID"]));
                $userResult = $userStatement->fetch(\PDO::FETCH_ASSOC);
                $result[$i]["CUSTOMER"] = isset($userResult["NAME"]) ? $userResult["NAME"] : "";
                unset($result[$i]["USERID"]);

                $statusStatement = $this->db->prepare($statusQuery);
                $statusStatement->execute(array('id' => $result[$i]["STATUSID"]));
                $statusResult = $statusStatement->fetch(\PDO::FETCH_ASSOC);
                $result[$i]["STATUS"] = isset($statusResult["NAME"]) ? $statusResult["NAME"] : "";
                unset($result[$i]["STATUSID"]);

                $selectOrderedProductQuery = "SELECT `qunatity`,`totalprice` FROM ORDEREDPRODUCTS WHERE `orderid` = :id";
                $statement = $this->db->prepare($selectOrderedProductQuery);                
                $statement->execute(array('id'=>$result[$i]["id"]));
                $selectOrderedProducts = $statement->fetchAll(\PDO::FETCH_ASSOC);
                
                $result[$i]["ORDEREDPRODUCTS"] = 0;
                $result[$i]["TOTALPRICE"] = 0;
                
                for($j = 0 ; $j < count($selectOrderedProducts) ; $j ++) {
                    $result[$i]["ORDEREDPRODUCTS"] += $selectOrderedProducts[$j]["qunatity"];
                    $result[$i]["TOTALPRICE"] +=  $selectOrderedProducts[$j]["totalprice"];
                }
            }
            return $result;
        }
        
        public function place_order($user) {
            try {
                $updateQuery = "UPDATE `ORDER` SET `STATUSID` = :id WHERE `userId` = :uid";
                $updateStatement = $this->db->prepare($updateQuery);
                $updateStatement->execute(array('id' => 2, 'uid' => $user["id"])); 
            } catch (\Throwable $th) {
                exit($th->getMessage());
            }   
        }
    }

?>