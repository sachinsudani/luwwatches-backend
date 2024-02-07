<?php

    namespace src\Controller;
    use Src\Models\UserModel;
    use Src\utils\UserAuth;

    class UserController {
        private $db = null;
        private $requestMethod = null;
        private $UserModel;
        private $userId = null;
        private $user = null;

        public function __construct($db, $requestMethod, array $uri, $user) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->UserModel = new UserModel($db);
            $this->userId = $uri;
            $this->user = $user;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                    if(isset($this->userId[4])) {
                        if($this->userId[4] == "login") {
                            $response = $this->login_user_from_request();
                        }
                        if($this->userId[4] == "logout") {
                            $response = $this->logout_user_from_request();
                        }
                    }
                    else {
                        $response = $this->create_user_from_request();
                    }
                break;
                case 'GET':
                    if(isset($this->userId[4])) {
                        if($this->userId[4] == "all") {
                            $response = $this->get_all_user();
                        }
                    }
                    else {
                        $response = $this->get_user($this->user["id"]);
                    }
                break;

                case 'UPDATE':
                    $response = $this->update_user_from_request($this->user["id"]);
                break;

                case 'DELETE':
                    $response = $this->delete_user_from_request();
                break;

            }
            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function create_user_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->UserModel->add_user($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }

        public function get_user($id) {
            $result = $this->UserModel->get_user($id);
            $response['status_code_header'] = 'HTTP/1.1 200 Ok';
            $response['body'] = json_encode($result);
            return $response;
        }

        public function get_all_user() {
            $result = $this->UserModel->get_all_user();
            $response['status_code_header'] = 'HTTP/1.1 200 Ok';
            $response['body'] = json_encode($result);
            return $response;
        }

        public function login_user_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            if(isset($input['password'])) {
                if(isset($input['username'])) {
                    try {
                        $result = $this->UserModel->get_login_with_username($input['username'], $input['password']);
                        $auth = new UserAuth($result);
                        $token = $auth->get_token();

                        // cookie header
                        header("Set-Cookie:jwt=$token;path=/luxwatchesapi; HttpOnly");
                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $token = array("token" => $token);
                        $response['body'] = json_encode($result);

                    } catch (\Throwable $th) {
                        $response['status_code_header'] = "HTTP/1.1 403 Forbidden";
                        $response['body'] = "{Error:" . $th->getMessage() . " }";
                    }
                }
                else {
                    $response['status_code_header'] = "HTTP/1.1 403 Forbidden";
                    $response['body'] = "{Error: 'Feild should be filled' }";
                }
            }
            else {
                $response['status_code_header'] = "HTTP/1.1 403 Forbidden";
                $response['body'] = "{Error: 'Feild should be filled' }";
            }
            
            return $response;
        }

        public function logout_user_from_request() {
            header("Set-Cookie:jwt=$token;path=/luxwatchesapi; HttpOnly");
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = "logout";
            
            return $response;
        }
 
        public function update_user_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->UserModel->update_user($input, $id);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;

        }

        public function delete_user_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->UserModel->delete_user($id);
            $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
            $response['body'] = null;
            return $response;
        }
    }

?>