<?php

    namespace src\utils;
    use Firebase\JWT\JWT;

    class UserAuth {
        private static $key = "thisisakey";
        private $user;
        private static $result = array(false, '');

        public function __construct($user = null) {
            $this->user = $user;
        }

        // Generate Authentication Token
        private function genJWT() {
            $payload = array(
                "id" => $this->user['ID'],
                "username" => $this->user['USERNAME'],
                "role" => $this->user['ROLES']
            );
            
            return JWT::encode($payload, UserAuth::$key);
        }

        // return token
        public function get_token() {
            $token = $this->genJWT();
            return $token;
        }

        // Validates a token
        public static function validateJWT() {
            if(isset(getallheaders()['Cookie'])) {
                $cookie = getallheaders()['Cookie'];
                $jwt = explode(";", $cookie);
                $token = explode("=", $jwt[0]);
                try {
                    $decode = JWT::decode($token[1], UserAuth::$key, array('HS256'));
                    UserAuth::$result['0'] = true;
                    UserAuth::$result['1'] = (array) $decode;
                } catch (\Exception $ex) {
                    header("HTTP/1.1 401 Unauthorised");
                    exit();
                }
            }
            else {
                header("HTTP/1.1 401 Unauthorised");
                exit();
            }

            return UserAuth::$result;
        }
    }

?>