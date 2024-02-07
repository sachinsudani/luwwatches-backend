<?php

    namespace src\Models;

    class UserModel {
        private $db = null;

        public function __construct($db) {
            $this->db = $db;
        }

        public function add_user(array $input) {

            $query = "INSERT INTO `USERDETAILS` (`USERNAME`, `PASSWORD`, `NAME`, `CONTACTNO`, `EMAIL`) 
                                VALUES (:username, :password, :name, :contact, :email)";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'username' => $input["username"],
                        'password' => password_hash($input["password"], PASSWORD_BCRYPT),
                        'name' => $input["name"],
                        'contact' => $input["contact"],
                        'email' => $input["email"]
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function add_user_address(array $input) {
            $query = "INSERT INTO `USER_ADDRESS` (`ADDRESS_LINE1`, `CITY`, `PIN_CODE`, `COUNTRY`) 
                                VALUES (:addressl1, :city, :pincode, :country)";

            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'addressl1' => $input["addressl1"],
                        'city' => $input["city"],
                        'pinocde' => $input["pincode"],
                        'country' => $input["country"],
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        public function get_user($id) {
            
            $query = "SELECT USERNAME, NAME, CONTACTNO, EMAIL
             FROM USERDETAILS WHERE ID = :id";

            $addressQuery = "SELECT `ADDRESSLINE1`, `CITY`, `PINCODE`, `COUNTRY` 
                FROM `USERADDRESS` WHERE `userId` = :id";

            try {
                $result = array("profile" => array(), "address" => array());

                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
                $userResult = $statement->fetch(\PDO::FETCH_ASSOC);

                $AddressStatement = $this->db->prepare($addressQuery);
                $AddressStatement->execute(array('id' => $id));
                $addressResult = $AddressStatement->fetch(\PDO::FETCH_ASSOC);

                $result["profile"] = $userResult;
                $result["address"] = $addressResult;

                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }
        
        public function get_all_user() {
            
            $query = "SELECT ID, USERNAME, NAME, CONTACTNO, EMAIL, CREATEDAT, UPDATEDAT
             FROM USERDETAILS";

            try {
                $statement = $this->db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

                return $result;

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function get_login_with_username($username, $password) {

            $query = "SELECT ID,USERNAME,PASSWORD,EMAIL,ROLES FROM USERDETAILS
                    WHERE USERNAME = :username";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute(array(
                    "username" => $username,
                ));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                if(password_verify($password, $result[0]["PASSWORD"])) {
                    return $result[0];
                }

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        public function get_login_with_email($email, $password) {
            $query = "SELECT ID,USERNAME,PASSWORD,EMAIL,ROLES FROM USERDETAILS
                    WHERE EMAIL = :email";

            try {

                $statement = $this->db->prepare($query);
                $statement->execute(array(
                    "email" => $email,
                ));
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                if(password_verify($password, $result[0]["PASSWORD"])) {
                    return $result[0];
                }

            } catch (\PDOException $ex) {
                $ex->getMessage();
            }
        }

        //UPDATE USER
        public function update_user(array $input, $id) {

            $query = "UPDATE `USERDETAILS` SET `USERNAME` = :username, `NAME` = :name,  `CONTACTNO` = :contact, `EMAIL` = :email
                    WHERE `ID` = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(
                    array(
                        'username' => $input["username"],
                        'name' => $input["name"],
                        'contact' => $input["contactno"],
                        'email' => $input["email"],
                        'id' => $id
                    )
                );
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

        //DELETE USER
        public function delete_user($id) {

            $query = "DELETE FROM `USERDETAILS` WHERE ID = :id";
            
            try {
                $statement = $this->db->prepare($query);
                $statement->execute(array('id' => $id));
            } catch (\PDOException $ex) {
                exit($ex->getMessage());
            }
        }

    }

?>